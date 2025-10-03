<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Gestión de proyectos')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
  <header class="bg-primary text-white py-2" id="main-header">
    <div class="container d-flex justify-content-between align-items-center">
      <div>
        <h1 class="h4 mb-0">Gestión de Proyectos</h1>
        <small id="header-sub" class="text-white-50">Sistema simple de asignaciones</small>
      </div>
      <div>
        <button class="btn btn-outline-light btn-sm d-md-none me-2" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">Menu</button>
        <button id="toggle-header" class="btn btn-light btn-sm">Cambiar header</button>
        @if (Route::has('login'))
          @auth
            <span class="me-2">{{ Auth::user()->name }}</span>
            @if(Auth::user()->student)
              <a href="{{ route('students.show', Auth::user()->student->id) }}" class="btn btn-outline-light btn-sm">Mis asignaciones</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf
              <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm ms-2">Registrarse</a>
            <a href="{{ route('password.request') }}" class="btn btn-outline-light btn-sm ms-2">Olvidé mi contraseña</a>
          @endauth
        @endif
      </div>
    </div>
  </header>

  <main class="container-fluid mt-4">
    {{-- session flashes are rendered as toasts via JS for a modern UX; keep an aria-live fallback for non-JS users --}}
    <div id="flash-fallback" aria-live="polite" class="visually-hidden">
      @if(session('success'))
        {{ session('success') }}
      @endif
      @if(session('error'))
        {{ session('error') }}
      @endif
    </div>

    <div class="row">
      <aside class="col-md-2 d-none d-md-block bg-light p-3">
        <nav class="nav flex-column">
          <a class="nav-link" href="{{ route('students.index') }}">Estudiantes</a>
          <a class="nav-link" href="{{ route('projects.index') }}">Proyectos</a>
          @auth
            @if(Auth::user()->is_admin)
              <a class="nav-link" href="{{ route('projects.create') }}">Crear proyecto</a>
            @endif
          @endauth
          @auth
            @if(Auth::user()->is_admin)
              <a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios (admin)</a>
            @endif
          @endauth
        </nav>
      </aside>
      <section class="col-md-10 p-3">
        @yield('content')
      </section>
    </div>
  </main>

  <!-- Offcanvas sidebar for mobile -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
      <h5 id="sidebarLabel">Menú</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
      <div class="offcanvas-body">
      <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('students.index') }}">Estudiantes</a>
        <a class="nav-link" href="{{ route('projects.index') }}">Proyectos</a>
        @auth
          @if(Auth::user()->is_admin)
            <a class="nav-link" href="{{ route('projects.create') }}">Crear proyecto</a>
          @endif
        @endauth
        @auth
          @if(Auth::user()->is_admin)
            <a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios (admin)</a>
          @endif
        @endauth
      </nav>
    </div>
  </div>

  <footer class="bg-dark text-white py-3 mt-4">
    <div class="container text-center">
      <small>Gestión Proyectos — &copy; {{ date('Y') }}</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Global toast container for JS-driven toasts -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
    <div id="global-toast-container"></div>
  </div>

  <script>
    // If there are session messages, render them as toasts for a modern UX
    document.addEventListener('DOMContentLoaded', function(){
      try{
        var container = document.getElementById('global-toast-container');
        if(!container || !window.bootstrap) return;
        @if(session('success'))
          var t = document.createElement('div');
          t.className = 'toast align-items-center text-bg-success border-0';
          t.setAttribute('role','alert'); t.setAttribute('aria-live','assertive'); t.setAttribute('aria-atomic','true');
          t.innerHTML = '<div class="d-flex"><div class="toast-body">{{ session('success') }}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button></div>';
          container.appendChild(t);
          var bt = new bootstrap.Toast(t, { delay: 3000 }); bt.show();
        @endif
        @if(session('error'))
          var t2 = document.createElement('div');
          t2.className = 'toast align-items-center text-bg-danger border-0';
          t2.setAttribute('role','alert'); t2.setAttribute('aria-live','assertive'); t2.setAttribute('aria-atomic','true');
          t2.innerHTML = '<div class="d-flex"><div class="toast-body">{{ session('error') }}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button></div>';
          container.appendChild(t2);
          var bt2 = new bootstrap.Toast(t2, { delay: 3000 }); bt2.show();
        @endif
      }catch(e){ /* silent fallback */ }
    });
  </script>
    <script>
      // toggle header content / style
      document.addEventListener('DOMContentLoaded', function(){
        var btn = document.getElementById('toggle-header');
        var header = document.getElementById('main-header');
        var sub = document.getElementById('header-sub');
        if(!btn || !header) return;
        btn.addEventListener('click', function(){
          if(sub.innerText === 'Sistema simple de asignaciones'){
            sub.innerText = 'Panel administrativo';
            header.classList.remove('bg-primary'); header.classList.add('bg-secondary');
          } else {
            sub.innerText = 'Sistema simple de asignaciones';
            header.classList.remove('bg-secondary'); header.classList.add('bg-primary');
          }
        });
      });
    </script>

  @stack('scripts')
</body>
</html>
