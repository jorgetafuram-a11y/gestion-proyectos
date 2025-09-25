@extends('layouts.app')

@section('content')
 <h1>Proyectos</h1>
  <a href="{{ route('projects.create') }}">Crear proyecto</a>
  <table>
  <thead><tr><th>Título</th><th>Estado</th><th>Acciones</th></tr></thead>
  <tbody>
    @foreach($projects as $p)
      <tr>
        <td>{{ $p->title }}</td>
        <td>{{ $p->status }}</td>
        <td>
          <a href="{{ route('projects.show',$p) }}">Ver</a>
          <a href="{{ route('projects.edit',$p) }}">Editar</a>
          <a href="{{ route('projects.assign.form', $p) }}">Asignar estudiantes</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ $projects->links() }}
@endsection
