@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Registrarse</h2>
    <form method="POST" action="{{ route('register.post') }}">
      @csrf
      <div class="mb-3"><label class="form-label">Nombre</label><input name="name" class="form-control" value="{{ old('name') }}"></div>
      <div class="mb-3"><label class="form-label">Email</label><input name="email" class="form-control" value="{{ old('email') }}"></div>
      <div class="mb-3"><label class="form-label">Contraseña</label><input name="password" type="password" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Confirmar Contraseña</label><input name="password_confirmation" type="password" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Vincular estudiante (opcional)</label><select name="student_id" class="form-select"><option value="">-- Ninguno --</option>@foreach(App\Models\Student::all() as $st)<option value="{{ $st->id }}">{{ $st->name }} ({{ $st->email }})</option>@endforeach</select></div>
      <button class="btn btn-primary">Registrar</button>
    </form>
  </div>
</div>
@endsection
