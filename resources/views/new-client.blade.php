@extends('layouts.public')

@section('content')
<div>
  <form method="POST" action="/client-register" class="col-lg-4 col-md-6 col-sm-12" style="margin: 0 auto; margin-top: 15%">
    @csrf
    <h3 style="text-align: left; color: white; margin-bottom: 10%">Naujo kliento registracija</h3>
      <div class="form-group">
        <label for="name" style="color: white;">Jūsų vardas: </label>
        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Vardenis Pavardenis" required>
      </div>
      <div class="form-group">
        <label for="email" style="color: white;">Jūsų el. paštas: </label>
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Vardenis@pastas.lt" required>
      </div>
      <div class="form-group">
        <label for="service" style="color: white;">Paslaugos nr.: </label>
        <select class="form-control" name="service">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
      </div>
      <button type="submit" class="btn btn-dark" style="float: right;">Registruotis</button>
</form>
</div>


@endsection