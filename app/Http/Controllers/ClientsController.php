<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use Faker\Generator as Faker;
class ClientsController extends Controller
{
    //
    protected $client;
    
    public function create()
    {
        return view('new-client');
    }
    
    public function store(Faker $faker)
    {
        $attributes = request()->validate([
            'name' => 'required', 
            'service' => 'required'
        ]);
        $attributes['ticket'] = $faker->unique()->numberBetween($min = $attributes['service'] * 100, $max = (($attributes['service'] + 1) * 100) - 1);
        Client::create($attributes);
        
        return redirect('/');
    }
    
}
