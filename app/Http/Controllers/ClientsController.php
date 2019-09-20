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
        //server-side validation
        $attributes = request()->validate([
            'name' => 'required', 
            'service' => 'required',
            'email' => 'required'
        ]);
        
        //get the last active ticked ID so that we can increment it
        $lastTicket = Client::where('completed_at', null)->where('service', $attributes['service'])
                            ->orderByDesc('ticket')->first();
        if($lastTicket != null)
        {
            $attributes['ticket'] = $lastTicket['ticket'] + 1;
        } else {
            //if not found, start with service_id . '00'
            $attributes['ticket'] = $attributes['service'] * 100; 
        }
        
        //check if there is anyone in the queue
        $clients = Client::where('service', $attributes['service'])->where('completed_at', null)
                            ->orderByDesc('estimated_visit_time')->first();
        
        //find all specialists who provide the chosen service and have any history
        //of other clients served
        $specialists = \App\User::where('service_id', $attributes['service'])
                            ->where('served_clients', '>', '0')->get();
        if($specialists->count() > 0)
        {
            //if we have any specialists, let's find average visit time
            $sum = 0;
            foreach($specialists as $specialist)
            {
                $sum += $specialist->averageVisit();
            }
            $averageWaitingTime = round($sum / $specialists->count(), 2);
        } else {
            //if no visits history found, take the default visit duration 
            //of 20 minutes
            $averageWaitingTime = 20;
        }
        
        //apply the visit duration
        if($clients->count() == 1) {
            $attributes['estimated_visit_time'] = $clients->estimated_visit_time
                            ->addMinutes($averageWaitingTime);
        }
        else {
            //if there is no one in the queue, you can visit the specialist 
            //right now
            $attributes['estimated_visit_time'] = Carbon::now();
        }
        
        //random key generated
        $attributes['special_key'] = str_random(20);
        $client = Client::create($attributes);
        
        //let's fire off an email
        
        
        session()->flash('ticket', 'Registracija sėkminga. Jūsų bilietėlio nr.: ' . 
                                    $attributes['ticket']);
        
        return redirect('/client/' . $client->special_key );
    }
    
    public function timeleft()
    {
        //let's find the first client in line
        $client = Client::where('ticket', request('ticket'))->first();
        if($client != null)
        {
            //get the estimated visit time
            $estimated = Carbon::parse($client['estimated_visit_time']);
        } else {
            //specified ticket was not found
            session()->flash('timeleft', 'Bilietėlis neegzistuoja');
            return redirect('/');
        }
        
        //calculate time difference
        $now = Carbon::now();
        if($estimated > $now)
        {
            session()->flash('timeleft', 'Jums liko ' . $estimated->diffInMinutes($now) . ' min.');
        } else {
            session()->flash('timeleft', 'Jūsų laikas jau praėjo.');
        }
            
        return redirect('/');
    }
    

    
    public function show($key)
    {
        //check if client with the specified key exists. If not - throw 404
        $client = Client::where('special_key', $key)->firstOrFail();
        
        return view('client', compact('client'));   
    }
    public function cancel($id)
    {
        //check if the id passed through the request is valid
        $client = Client::findOrFail(['id' => $id])->first();
        //check if the visit has not yet completed
        if($client->completed_at != null)
        {
            //if already completed, throw error and redirect back
            session()->flash('delay', 'Jūsų vizitas jau yra įvykęs.');
            return back();
        }
        //if previous condition was not met, delete from the database
        $client->delete();
        return redirect('/');
        # code...
    }
    
    public function delay($id)
    {
        //check if the ID passed through the URL is valid
        $client = Client::findOrFail(['id' => $id])->first();
        
        //find the the next client in line
        $secondClient = Client::where('ticket', $client->ticket + 1)
                        ->where('completed_at', null)->first();
        //check if the visit has not yet been completed
        if($client->completed_at != null)
        {
            session()->flash('delay', 'Jūsų vizitas jau yra įvykęs.');
            return back();
        }
        
        //if could not find the next client in line
        if($secondClient == null)
        {
            session()->flash('delay', 'Jūsų vizitas negali būti pavėlintas, nes esate ' . 
                                        'paskutinis eilėje laukiantis klientas.');
            
            return back();
        } else {
            //swap the estimated visit time values
            $copiedTime = $secondClient->estimated_visit_time;
            $secondClient['estimated_visit_time'] = $client->estimated_visit_time;
            $secondClient->save();
            $client['estimated_visit_time'] = $copiedTime;
            $client->save();
            
            //save success message in session
            session()->flash('delay', 'Jūsų vizitas buvo pavėlintas. ');
            
            return back();
        }
        # code...
    }
    
}
