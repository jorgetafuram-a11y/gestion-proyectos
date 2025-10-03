@extends('layouts.app')
@section('content')
<h2>Estudiantes</h2>
@auth
  <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Crear Estudiante</a>
@endauth
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead class="table-dark"><tr><th>Nombre</th><th>Email</th><th>Programa</th></tr></thead>
    <tbody>
    @foreach($students as $s)
      <tr>
        <td><a href="{{ route('students.show', $s->id) }}">{{ $s->name }}</a></td>
        <td>{{ $s->email }}</td>
        <td>{{ $s->program }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
{{ $students->links() }}
@endsection
