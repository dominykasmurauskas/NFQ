<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use Faker\Generator as Faker;
use Carbon\Carbon;
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
            'service' => 'required',
            'email' => 'required'
        ]);
        $attributes['ticket'] = $faker->unique()->numberBetween($min = $attributes['service'] * 100, $max = (($attributes['service'] + 1) * 100) - 1);
        $client = Client::where('estimated_visit_time', '>', Carbon::now())->where('service', $attributes['service'])->where('completed_at', false)->orderByDesc('estimated_visit_time')->first();
        if($client != null) {
            $attributes['estimated_visit_time'] = $client->estimated_visit_time->addMinutes(20);
        }
        else {
            $attributes['estimated_visit_time'] = Carbon::now()->addMinutes(20);
        }
        Client::create($attributes);
        session()->flash('ticket', 'Užregistruota sėkmingai. Jūsų bilietėlio nr.: ' . $attributes['ticket']);
        
        return redirect('/');
    }
    
    public function timeleft(Client $client)
    {
        # code...
        $client = Client::where('ticket', request('ticket'))->first();
        if($client != null)
        {
            $estimated = Carbon::parse($client['estimated_visit_time']);
        } else {
            session()->flash('timeleft', 'Bilietėlis neegzistuoja');
            return redirect('/');
        }
        $now = Carbon::now();
        if($estimated > $now)
        {
            session()->flash('timeleft', 'Jums liko ' . $estimated->diffInMinutes($now) . ' min.');
        } else {
            session()->flash('timeleft', 'Jūsų laikas jau praėjo.');
        }
            
        return redirect('/');
    }
    
    public function update(Client $client)
    {
        $client['completed_at'] = Carbon::now();
        $client->save();
        return redirect('admin');
    }
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect('admin');
    }
    
}
