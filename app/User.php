<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'service_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function averageVisit()
    {
        //find all clients who have been served by this client
        $clients = $this->hasMany(Client::class, 'served_by')->get();
        //sum all visit durations
        $sum = $clients->sum(function ($client) {
            return $client->visitDurationInMinutes();
        });
        //check how many clients served
        if($clients->count() <= 0)
        {
            // return 0
            return 0;
        } else {
            //return the average
            return round(($sum / $clients->count()), 2);
        }
    }
    
    public function clientsServed() 
    {
        //check how mnay clients served
        $clients = $this->hasMany(Client::class, 'served_by')->get();
        return $clients->count();
    }
    
    public function updateServedClients()
    {
        //update user statistics
        return $this->served_clients = $this->served_clients + 1;
    }
    
    public function groupVisitsByDays() {
        //query on the database to group clients by day
        $groups = DB::table('clients')
                    ->where('served_by', '=', $this->id)
                    ->select(DB::raw('DATE(completed_at) as date'), 
                            DB::raw('count(*) as clients'))
                    ->groupBy('date')
                    ->limit(30)
                    ->get();
        return $groups;

    }
    public function groupVisitsByHours() {
        $groups = DB::table('clients')
                ->where('served_by', '=', $this->id)
                ->limit(30)
                ->select(DB::raw('hour(completed_at) as hour'), DB::raw('COUNT(id) as clients'))
                ->groupBy(DB::raw('hour'))
                ->get();
        return $groups;

    }
}
