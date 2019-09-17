<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $guarded = [];
    
    protected $dates = ['created_at', 'updated_at', 'estimated_visit_time'];
}
