@extends('layouts.app')
@section('content')
<h2>Crear Estudiante</h2>
@if($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="post" action="{{ route('students.store') }}">
  @csrf
  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input name="name" class="form-control" value="{{ old('name') }}" required />
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control" value="{{ old('email') }}" required />
  </div>
  <div class="mb-3">
    <label class="form-label">Programa</label>
    <input name="program" class="form-control" value="{{ old('program') }}" />
  </div>
  <button class="btn btn-primary">Crear</button>
</form>

@endsection
