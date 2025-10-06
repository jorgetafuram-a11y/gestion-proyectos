@extends('layouts.app')

@section('title', 'Crear proyecto')

@section('content')
  <h1>Crear proyecto</h1>
  <form action="{{ route('projects.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">Título</label>
      <input class="form-control" name="title" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea class="form-control" name="description" required>{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select class="form-select" name="status" required>
        <option value="" disabled selected>Selecciona un estado</option>
        <option value="en_curso" {{ old('status')=='en_curso' ? 'selected' : '' }}>En curso</option>
        <option value="finalizado" {{ old('status')=='finalizado' ? 'selected' : '' }}>Finalizado</option>
        <option value="archivado" {{ old('status')=='archivado' ? 'selected' : '' }}>Archivado</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha inicio</label>
      <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha fin</label>
      <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}" required>
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
@endsection

