@extends('layouts.public')

@section('content')
    <h1 class="text-center" style="margin-top: 10%; margin-bottom: 5%">STATISTIKA</h1>
    
    <h3>Daugiausiai klientų aptarnavę specialistai (max 5)</h3>
    <table class="table">
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Specialistas</th>
              <th scope="col">Paslauga</th>
              <th scope="col" width="15%">Vid. apsilankymo trukmė (min)</th>
              <th scope="col">Aptarnauta klientų</th>
              <th scope="col">Kontaktai</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $index=>$specialist)
               <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $specialist->name }}</td>
                  <td>{{ $specialist->service_id }}</td>  
                  <td>{{ $specialist->averageVisit() }}</td>
                  <td>{{ $specialist->clientsServed() }}</td>
                  <td>{{ $specialist->email }}</td>
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
    <style>
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