@extends('layouts.app')
@section('content')
<h2>Restablecer contraseña</h2>
<form method="POST" action="{{ route('password.reset') }}">@csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <div class="mb-3"><label>Email</label><input name="email" class="form-control"></div>
  <div class="mb-3"><label>Contraseña nueva</label><input name="password" type="password" class="form-control"></div>
  <div class="mb-3"><label>Confirmar</label><input name="password_confirmation" type="password" class="form-control"></div>
  <button class="btn btn-primary">Restablecer</button>
</form>
@endsection
