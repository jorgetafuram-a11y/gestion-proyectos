@extends('layouts.app')
@section('content')
<h2>{{ $student->name }}</h2>
<p>{{ $student->email }}</p>
<h3>Proyectos asignados</h3>
@if($student->projects->isEmpty())
  <p>No hay proyectos asignados.</p>
@else
  <ul>@foreach($student->projects as $p)<li>{{ $p->title }} - <em>{{ $p->pivot->role }}</em></li>@endforeach</ul>
@endif
@endsection
