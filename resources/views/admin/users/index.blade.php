@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Usuarios</h2>
  <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">Crear usuario</a>
</div>
<table class="table">
  <thead><tr><th>Nombre</th><th>Email</th><th>Admin</th></tr></thead>
  <tbody>
    @foreach($users as $u)
      <tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->is_admin ? 'Sí' : 'No' }}</td></tr>
    @endforeach
  </tbody>
</table>
{{ $users->links() }}
@endsection
