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
        
        $lastTicket = Client::where('completed_at', null)->where('service', $attributes['service'])->orderByDesc('ticket')->first();
        if($lastTicket != null)
        {
            $attributes['ticket'] = $lastTicket['ticket'] + 1;
        } else {
            $attributes['ticket'] = $attributes['service'] * 100;
        }
        
        
        $clients = Client::where('service', $attributes['service'])->where('completed_at', null)->orderByDesc('estimated_visit_time')->get();
        if($clients->count() >= 1) {
            $attributes['estimated_visit_time'] = $clients->first()->estimated_visit_time->addMinutes(20);
        }
        else {
            $attributes['estimated_visit_time'] = Carbon::now();
        }
        
        
        $attributes['special_key'] = str_random(20);
        $client = Client::create($attributes);
        
        
        session()->flash('ticket', 'Registracija sėkminga. Jūsų bilietėlio nr.: ' . $attributes['ticket']);
        
        return redirect('/client/' . $client->special_key );
    }
    
    public function timeleft(Client $client)
    {
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
        $client['served_by'] = auth()->user()->id;
        $client->save();
        
        $clients = Client::where('completed_at', null)->where('service', $client->service)->orderBy('estimated_visit_time')->get();
        foreach($clients as $index=>$client)
        {
            $client['estimated_visit_time'] = Carbon::now()->subSeconds(5)->addMinutes(20 * $index);
            $client->save();
        }
        return redirect('admin');
    }
    public function destroy(Client $client)
    {
        $clients = Client::where('completed_at', null)->where('service', $client->service)->orderBy('estimated_visit_time')->get();
        $client->delete();
        return redirect('admin');
    }
    
    public function show($key)
    {
        $client = Client::where('special_key', $key)->firstOrFail();
        
        return view('client', compact('client'));   
    }
    public function cancel($id)
    {
        $client = Client::findOrFail(['id' => $id])->first();
        $client->delete();
        return redirect('/');
        # code...
    }
    
    public function delay($id)
    {
        $client = Client::findOrFail(['id' => $id])->first();
        $clients = Client::where('estimated_visit_time', '=', $client->estimated_visit_time->addMinutes(20))->where('completed_at', null)->where('service', $client['service'])->get();
        if($clients->count() < 1)
        {
            session()->flash('delay', 'Jūsų vizitas negali būti pavėlintas, nes esate paskutinis eilėje laukiantis klientas.');
            
            return back();
        } else {
            $secondClient = $clients->first();
            $copiedTime = $secondClient->estimated_visit_time;
            $secondClient['estimated_visit_time'] = $client->estimated_visit_time;
            $secondClient->save();
            $client['estimated_visit_time'] = $copiedTime;
            $client->save();
            
            session()->flash('delay', 'Jūsų vizitas buvo pavėlintas. ');
            
            return back();
        }
        # code...
    }
    
}
