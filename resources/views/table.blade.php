<?php use Carbon\Carbon;?>
<table class="table" id="data">
    <thead>
      <tr>
        <th scope="col">Nr.</th>
        <th scope="col">Vardas</th>
        <th scope="col">Paslauga</th>
        <th scope="col">Numatytas laikas</th>
        <th scope="col">Liko laiko (val:min)</th>
      </tr>
    </thead>
    <tbody>
      @forelse($clients as $index=>$client)
         <tr>
            <td>{{ $client->ticket }}</td>
            <td>{{ $client->name}}</td>
            <td>{{ $client->service }}</td>
            <td>{{ $client->estimated_visit_time }}</td>
            <td>{{ $client->timeleft() }}</td>
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