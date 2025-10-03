@extends('layouts.app')

@section('content')
 <h1>Proyectos</h1>
  <a href="{{ route('projects.create') }}">Crear proyecto</a>
  <table class="table">
  <thead><tr><th>Titulo</th><th>Estado</th><th>Estudiantes asignados</th><th>Acciones</th></tr></thead>
  <tbody>
    @foreach($projects as $p)
      <tr>
        <td>{{ $p->title }}</td>
        <td>{{ $p->status }}</td>
        <td>
          @if($p->students->isEmpty())
            <em>No hay estudiantes</em>
          @else
            <ul class="list-unstyled">
              @foreach($p->students as $s)
                <li>{{ $s->name }} <small class="text-muted">({{ $s->pivot->role }})</small></li>
              @endforeach
            </ul>
          @endif
        </td>
        <td>
          <a class="btn btn-sm btn-primary" href="{{ route('projects.show',$p) }}">Ver</a>
          <a class="btn btn-sm btn-secondary" href="{{ route('projects.edit',$p) }}">Editar</a>
          <a class="btn btn-sm btn-success" href="{{ route('projects.assign.form', $p) }}">Asignar estudiantes</a>
          @auth
            @if(Auth::user()->is_admin)
              <form action="{{ route('projects.destroy', $p) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar proyecto?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            @endif
          @endauth
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
{{ $projects->links() }}
@endsection
