@extends('layouts.public')

@section('content')
<form method="POST" action="/client-register" class="col-lg-3 col-md-6 col-sm-12" style="margin: 0 auto; margin-top: 20%">
    @csrf
    <p style="text-align: right; font-size: 12px; color: white">Naujo kliento registracija</p>
    <div class="form-group">
        <label for="name" style="color: white;">Jūsų vardas: </label>
        <input type="text" class="form-control" name="name" placeholder="Vardenis Pavardenis" required>
      </div>
      <div class="form-group">
        <label for="service" style="color: white;">Paslauga: </label>
        <select class="form-control" name="service">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Registruotis</button>
</form>

@endsection