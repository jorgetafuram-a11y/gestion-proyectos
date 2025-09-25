@extends('layouts.app')
@section('content')
<h2>Asignar estudiantes a: {{ $project->title }}</h2>

<form action="{{ route('projects.assign', $project) }}" method="POST">
  @csrf
  <table>
    <thead><tr><th>Seleccionar</th><th>Nombre</th><th>Role</th></tr></thead>
    <tbody>
      @foreach($students as $s)
        <tr>
          <td><input type="checkbox" name="students[{{ $s->id }}]" value="miembro"
            {{ $project->students->contains($s->id) ? 'checked' : '' }}></td>
          <td>{{ $s->name }} ({{ $s->email }})</td>
          <td><input type="text" name="roles[{{ $s->id }}]" placeholder="lider/miembro"></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <button>Guardar asignaciones</button>
</form>
@endsection
