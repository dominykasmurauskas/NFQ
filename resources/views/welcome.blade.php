<?php use Carbon\Carbon;?>
@extends('layouts.public')

@section('content')



<div class="col-lg-6 offset-lg-3 col-sm-12" style="margin-top: 20%">
  <h2>Švieslentė</h2>
  <div style="margin: 0 auto; width: 100%">
    <p style="font-size: 10px">Paskutinį kartą atnaujinta: {{ Carbon::now() }}</p>
    @include('table')
      <div class="row" id="actions" style="margin-top: 10%">
        <form method="POST" class="form-inline float-left" action="/time-remaining">
          @csrf
          <div class="form-group mb-2">
            <input style="margin-right: 10px" class="form-control" type="text" name="ticket" placeholder="Įveskite savo bilietėlio nr." required>
          </div>
          <button type="submit" class="btn btn-dark mb-2" style="margin-right: 20px">Tikrinti savo laiką</button>
        </form>
        <a href="/client-register" style="position:relative; margin-left: auto"><button type="button" class="btn btn-dark">Registracija</button></a>

      </div>

      @if(session('timeleft'))
            <div style="margin-top: 2%">{{ session('timeleft') }}</div>
      @endif
    </div>
   
</div>
<style>
  #mainbar {
    width: 100%;
  }
  .btn.btn-dark {
    border: 1px solid white;
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
  #actions {
    vertical-align: middle !important;
  }
</style>
@endsection