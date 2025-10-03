@extends('layouts.app')
@section('content')
<h2>Crear usuario</h2>
<form method="POST" action="{{ route('admin.users.store') }}">
  @csrf
  <div class="mb-3"><label class="form-label">Nombre</label><input name="name" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Email</label><input name="email" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Password</label><input name="password" type="password" class="form-control"></div>
  <div class="form-check mb-3"><input type="checkbox" name="is_admin" value="1" class="form-check-input" id="is_admin"><label for="is_admin" class="form-check-label">Es admin</label></div>
  <button class="btn btn-primary">Crear</button>
</form>
@endsection
