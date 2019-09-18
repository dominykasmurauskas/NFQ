<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $guarded = [];
    
    protected $dates = ['created_at', 'updated_at', 'estimated_visit_time'];
    
    public function visitDuration()
    {
        $duration = (new Carbon($this->estimated_visit_time))->diff($this->estimated_visit_time)->format('%h:%I');
        return $duration;
    }
}
