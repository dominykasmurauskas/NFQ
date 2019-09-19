<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $guarded = [];
    
    protected $dates = ['created_at', 'updated_at', 'estimated_visit_time', 'completed_at'];
    
    public function visitDuration()
    {
        $duration = (new Carbon($this->estimated_visit_time))->diff($this->completed_at)->format('%h:%I');
        return $duration;
    }
    
    public function path() {
        return '/client/' . $this->special_key;
    }
    
    public function timeleft()
    {
        return (new Carbon($this->estimated_visit_time))->diff(Carbon::now())->format('%h:%I');
    }
    
}
