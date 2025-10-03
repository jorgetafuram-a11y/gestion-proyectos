@extends('layouts.app')

@section('title', 'Editar proyecto')

@section('content')
  <h1>Editar proyecto</h1>
  <form action="{{ route('projects.update', $project) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input class="form-control" name="title" value="{{ old('title',$project->title) }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea class="form-control" name="description">{{ old('description',$project->description) }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select class="form-select" name="status" required>
        <option value="en_curso" {{ old('status',$project->status)=='en_curso' ? 'selected' : '' }}>En curso</option>
        <option value="finalizado" {{ old('status',$project->status)=='finalizado' ? 'selected' : '' }}>Finalizado</option>
        <option value="archivado" {{ old('status',$project->status)=='archivado' ? 'selected' : '' }}>Archivado</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha inicio</label>
      <input type="date" class="form-control" name="start_date" value="{{ old('start_date',$project->start_date) }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Fecha fin</label>
      <input type="date" class="form-control" name="end_date" value="{{ old('end_date',$project->end_date) }}">
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancelar</a>
  </form>
@endsection
