@extends('layouts.admin')

@section('content')
<h2>Dabar aptarnaujama:</h2>
<?php use Carbon\Carbon;?>
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
                    <form method="POST" action="/clients/delete/{{ $client->id }}">
                        @csrf
                        <button type="submit"><img src="images/delete.jpg" width="20px"></button>
                    </form>
                    <form method="POST" action="/clients/completed/{{ $client->id }}">
                        @csrf
                        @method('UPDATE')
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
<h2>Klientai, kurie vis dar laukia eilėje pas jus:</h2>
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
            <div style="display: flex">
                <form method="POST" action="/clients/delete/{{ $client->id }}">
                    @csrf
                    <button type="submit"><img src="images/delete.jpg" width="20px"></button>
                </form>
                <form method="POST" action="/clients/completed/{{ $client->id }}">
                    @csrf
                    @method('UPDATE')
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
            <td>-</td>
        </tr>
      @endforelse
    </tbody>
  </table>

@endsection