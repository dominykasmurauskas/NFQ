<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        $clients = $this->hasMany(Client::class, 'served_by')->get();
        $sum = $clients->sum(function ($client) {
            return $client->visitDurationInMinutes();
        });
        if($clients->count() <= 0)
        {
            return 0;
        } else {
            return round(($sum / 60 / $clients->count()), 2);
        }
    }
    
    public function clientsServed() 
    {
        $clients = $this->hasMany(Client::class, 'served_by')->get();
        return $clients->count();
    }
}
