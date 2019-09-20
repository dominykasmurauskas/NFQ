@extends('layouts.public')

@section('content')
<meta http-equiv="refresh" content="5">
    <div style="margin-top: 10%">
      @if(session('ticket'))
      <div>{{ session('ticket') }}</div> 
      @endif
      <h4 style="margin-bottom: 5%">Jūsų vizito informacija: </h4>
    </div>
    
    <table class="table" id="data">
        <thead>
          <tr>
            <th scope="col">Nr.</th>
            <th scope="col">Vardas</th>
            <th scope="col">Paslauga</th>
            <th scope="col">Numatytas laikas</th>
            @if(!$client->completed_at)
                <th scope="col">Liko laiko</th>
            @endif
          </tr>
        </thead>
        <tbody>
             <tr>
                <td>{{ $client->ticket }}</td>
                <td>{{ $client->name}}</td>
                <td>{{ $client->service }}</td>
                <td>{{ $client->estimated_visit_time }}</td>
                @if(!$client->completed_at)
                <td>{{ $client->timeleft() }}</td>
            @endif
             </tr>
        </tbody>
      </table>
      @if(session('delay'))
        <p>{{ session('delay') }}</p>
      @endif
      <p style="margin-top: 10%">Galimi veiksmai: </p>
      <ul>
        <li><a href="/"><button class="btn">Peržiūrėti bendrą švieslentę</button></a></li>
        <li><a href="/statistika"><button class="btn">Peržiūrėti statistiką</button></a></li>
        <li>
          <form method="POST" action="/clients/{{ $client->id }}/delay">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn">Pavėlinti vizitą</button>
          </form>
        </li>
        <li>
        <form method="POST" action="/clients/{{ $client->id }}/cancel">
            @csrf
            <button type="submit" class="btn">Atšaukti vizitą</button>
          </form>
        </li>
      </ul>
      <style>
        .btn {
          background: none !important;
          border: none !important;
        }
        .btn:hover {
          text-decoration: underline !important;
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
      </style>
@endsection