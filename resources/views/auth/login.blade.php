@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" class="form-control" value="{{ old('email') }}">
        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control">
        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <button class="btn btn-primary">Entrar</button>
    </form>
  </div>
</div>
@endsection
