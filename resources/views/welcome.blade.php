@extends('layouts.public')

@section('content')
<div class="col-lg-3 col-md-6 col-sm-12" style="margin: 0 auto; margin-top: 20%">
    <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Vardas</th>
            <th scope="col">Paslauga</th>
          </tr>
        </thead>
        <tbody>
          @forelse($clients as $index=>$client)
             <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $client->name}}</td>
                <td>{{ $client->service }}</td>
             </tr>
          @empty
            <tr>
                <th scope="row">-</th>
                <td>-</td>
                <td>-</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <a style="float: right" href="/client-register"><button type="button" class="btn btn-dark" style="border: 1px solid white">Registracija</button></a>
</div>
@endsection