@extends('layouts.admin')

@section('content')
<?php use Carbon\Carbon;?>
<h1 class="text-center" style="margin-top: 10px; margin-bottom: 10px">Specialisto puslapis</h1>
<p class="text-center">Sveiki, {{ auth()->user()->name }}! Šiame puslapyje matote klientus, kurie pasirinko {{ auth()->user()->service_id }} paslaugą.</p>
<div>
  <p class="h4">Dabar aptarnaujama:</p>
  <table class="table" id="data">
    <thead>
      <tr>
        <th scope="col">Nr.</th>
        <th scope="col">Vardas</th>
        <th scope="col">Paslauga</th>
        <th scope="col">Numatytas laikas</th>
        <th scope="col">Veiksmai</th>
      </tr>
    </thead>
    <tbody>
      @forelse($presentClients as $index=>$client)
         <tr>
            <td>{{ $client->ticket }}</td>
            <td>{{ $client->name}}</td>
            <td>{{ $client->service }}</td>
            <td>{{ $client->estimated_visit_time }}</td>
            <td>
                <div style="display: flex">
                  <form class="actions" method="POST" action="/clients/completed/{{ $client->id }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"><img src="images/checkmark.png" width="20px"></button>
                  </form>
                </div>
            </td>
         </tr>
      @empty
        <tr>
            <th scope="row">-</th>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div>
  <p class="h4">Klientai, kurie vis dar laukia eilėje pas jus:</p>
  <table class="table" id="data">
      <thead>
        <tr>
          <th scope="col">Nr.</th>
          <th scope="col">Vardas</th>
          <th scope="col">Paslauga</th>
          <th scope="col">Numatytas laikas</th>
          <th scope="col">Liko laiko (val:min)</th>
          <th scope="col">Veiksmai</th>
        </tr>
      </thead>
      <tbody>
        @forelse($waitingClients as $index=>$client)
           <tr>
              <td>{{ $client->ticket }}</td>
              <td>{{ $client->name}}</td>
              <td>{{ $client->service }}</td>
              <td>{{ $client->estimated_visit_time }}</td>
              <td>{{ (new Carbon($client->estimated_visit_time))->diff(Carbon::now())->format('%h:%I') }}</td>
              <td>
              <div class="actions" style="display: flex">
                <form method="POST" action="/clients/completed/{{ $client->id }}">
                  @csrf
                  @method('PATCH')
                  <button type="submit"><img src="images/checkmark.png" width="20px"></button>
                </form>
                <form method="POST" action="/clients/delete/{{ $client->id }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit"><img src="images/delete.jpg" width="20px"></button>
                </form>        
              </div>  
              </td>
           </tr>
        @empty
          <tr>
              <th scope="row">-</th>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
          </tr>
        @endforelse
      </tbody>
    </table>
</div>
<div>
  <p class="h4">Jau aptarnauti klientai</p>
  <table class="table" id="data">
    <thead>
      <tr>
        <th scope="col">Nr.</th>
        <th scope="col">Vardas</th>
        <th scope="col">Paslauga</th>
        <th scope="col">Numatytas laikas</th>
        <th scope="col">Aptarnautas</th>
        <th scope="col">Vizito trukmė</th>
        <th scope="col">Veiksmai</th>
      </tr>
    </thead>
    <tbody>
      @forelse($completedClients as $index=>$client)
         <tr>
            <td>{{ $client->ticket }}</td>
            <td>{{ $client->name}}</td>
            <td>{{ $client->service }}</td>
            <td>{{ $client->estimated_visit_time }}</td>
            <td>{{ $client->completed_at }}</td>
            <td>{{ $client->visitDuration() }}</td>
            <td>
            <div style="display: flex">
                <form class="actions" method="POST" action="/clients/delete/{{ $client->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><img src="images/delete.jpg" width="20px"></button>
                </form>
            </div>
            
            </td>
         </tr>
      @empty
        <tr>
            <th scope="row">-</th>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
<style>
  .h3 {
    margin-top: 5%;
    margin-bottom: 2%;
  }
  th {
    vertical-align: middle !important;
    font-weight: normal !important;
    text-align: center;
  }
  td {
    text-align: center;
    font-size: 16px;
    font-family: 'Josefin Slab', serif;
  }
  .actions {
    margin: 0 auto;
  }
</style>
@endsection