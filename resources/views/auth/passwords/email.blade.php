@extends('layouts.app')
@section('content')
<h2>Recuperar contraseña</h2>
<form method="POST" action="{{ route('password.email') }}">@csrf
  <div class="mb-3"><label>Email</label><input name="email" class="form-control"></div>
  <button class="btn btn-primary">Enviar token</button>
</form>
@endsection
