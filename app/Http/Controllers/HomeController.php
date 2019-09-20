<?php

namespace App\Http\Controllers;
use App\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('IsAdmin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = null;
        //find clients who should be served at the moment
        $presentClients = Client::where('service', auth()->user()->service_id)
                            ->where('completed_at', null)
                            ->where('estimated_visit_time', '<', Carbon::now())
                            ->orderBy('estimated_visit_time')->get();
        //find clients who are in a queue for this specific service
        $waitingClients = Client::where('service', auth()->user()->service_id)
                            ->where('completed_at', null)
                            ->where('estimated_visit_time', '>', Carbon::now())
                            ->orderBy('estimated_visit_time')->get();
        //find clients that were served by current specialist                   
        $completedClients = Client::where('served_by', auth()->user()->id)
                            ->orderBy('estimated_visit_time')->get();

        return view('admin', compact('presentClients', 'waitingClients', 'completedClients'));
    }
    
    public function update(Client $client)
    {
        //provide completed meta data
        $client['completed_at'] = Carbon::now();
        $client['served_by'] = auth()->user()->id;
        $client->save();
        
        //re-calculate estimated visit time for the clients in queue
        $clients = Client::where('completed_at', null)->where('service', $client->service)
                        ->orderBy('estimated_visit_time')->get();
                        
        foreach($clients as $index=>$client)
        {
            $client['estimated_visit_time'] = Carbon::now()->subSeconds(5)
                                                    ->addMinutes(20 * $index);
            $client->save();
        }
        //update specialist's statistics
        $user = auth()->user();
        $user->updateServedClients();
        $user->save();
        return redirect('admin');
    }
    
    public function deleteCompleted()
    {
        //find all clients who have been served by current specialist
        $toDelete = \App\Client::where('served_by', auth()->user()->id);
        $howMany = $toDelete->count();
        $toDelete->delete(); //delete those clients
        //refresh specialist's statistics
        $user = auth()->user();
        $user->served_clients = $user->served_clients - $howMany;
        $user->save();
        //redirect to admin dashboard
        return redirect('admin');
    }
    public function destroy(Client $client)
    {
        //delete the client specified
        $client->delete();
        //refresh specialist's statistics
        $user = auth()->user();
        $user->served_clients = $user->served_clients - 1;
        $user->save();
        //redirect to admin dashboard
        return redirect('admin');
    }
}
