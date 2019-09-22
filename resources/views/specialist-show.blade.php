@extends('layouts.public')

@section('content')
<h2 style="margin-top: 10%" class="text-center">Detalesnė {{ $specialist->name }} statistika</h2>

<div class="row">
    <div class="col-sm-12 col-lg-6">
        <p style="margin-top: 10%">Paskutinių 30 dienų klientų aptarnavimo istorija</p>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Diena</th>
                    <th>Aptarnauta klientų</th>
                </tr>
            </thead>
            <tbody>
                @forelse($specialist->groupVisitsByDays() as $index=>$date)
                    <tr>
                        <th scope="row">{{ $index }}</th>
                        <td>{{$date->date}}</td>
                        <td>{{$date->clients}}</td>
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
    </div>
    <div class="col-sm-12 col-lg-6">
        <p style="margin-top: 10%">Klientų aptarnauta kiekvieną valandą (per pastarąsias 30 dienų):</p>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Valanda</th>
                    <th>Aptarnauta klientų</th>
                </tr>
            </thead>
            <tbody>
                @forelse($specialist->groupVisitsByHours() as $index=>$date)
                    <tr>
                        <th scope="row">{{ $index }}</th>
                        <td>{{$date->hour}}</td>
                        <td>{{$date->clients}}</td>
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
        
    </div>
</div>
<style>
</style>
@endsection