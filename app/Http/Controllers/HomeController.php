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
        $presentClients = Client::where('service', auth()->user()->service_id)->where('completed_at', null)->where('estimated_visit_time', '<', Carbon::now())->orderBy('estimated_visit_time')->get();
        $waitingClients = Client::where('service', auth()->user()->service_id)->where('completed_at', null)->where('estimated_visit_time', '>', Carbon::now())->orderBy('estimated_visit_time')->get();
        $completedClients = Client::where('service', auth()->user()->service_id)->whereNotNull('completed_at')->orderBy('estimated_visit_time')->get();

        return view('admin', compact('presentClients', 'waitingClients', 'completedClients'));
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
        $user = auth()->user();
        $user->updateServedClients();
        $user->save();
        return redirect('admin');
    }
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect('admin');
    }
}
