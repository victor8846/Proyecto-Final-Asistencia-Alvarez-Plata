<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Panel - Instituto')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS AdminLTE -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


</head>
<body class="sidebar-mini layout-fixed" style="height: auto;">

<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Botón para colapsar menú -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link">Home</a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link">Contact</a></li>
    </ul>

    <!-- Parte derecha del navbar -->
    <ul class="navbar-nav ms-auto">
      <!-- Mensajes -->
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="far fa-comments"></i><span class="badge badge-danger navbar-badge">3</span></a>
      </li>
      <!-- Notificaciones -->
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="far fa-bell"></i><span class="badge badge-warning navbar-badge">15</span></a>
      </li>
      <!-- Usuario -->
      <li class="nav-item">
        <a class="nav-link" href="#">{{ Auth::user()->name ?? 'Invitado' }}</a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">SCAAPN</span>
    </a>
    <div class="sidebar">
      <!-- Menú lateral -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <!-- Ejemplo de más módulos -->
          <li class="nav-item">
            <a href="{{ route('asistencias.index') }}" class="nav-link">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>Asistencia</p>
            </a>
          </li>
              <li class="nav-item">
    <a href="{{ route('estudiantes.index') }}" class="nav-link">
        <i class="nav-icon fas fa-user-graduate"></i>
        <p>Estudiantes</p>
    </a>
</li>

    <li class="nav-item">
    <a href="{{ route('docentes.index') }}" class="nav-link">
        <i class="nav-icon fas fa-chalkboard-teacher"></i>
        <p>Docentes</p>
    </a>
</li>

<!-- Módulo de Asignación de Docentes -->
<li class="nav-item">
    <a href="{{ route('asignacion-docentes.index') }}" class="nav-link {{ request()->routeIs('asignacion-docentes.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chalkboard-teacher"></i>
        <p>Asignación de Docentes</p>
    </a>
</li>
<!-- Módulo de Carreras -->
<li class="nav-item">
    <a href="{{ route('carreras.index') }}" class="nav-link {{ request()->routeIs('carreras.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-graduation-cap"></i>
        <p>Carreras</p>
    </a>
</li>

<!-- Módulo de Materias -->
<li class="nav-item">
    <a href="{{ route('materias.index') }}" class="nav-link {{ request()->routeIs('materias.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book-open"></i>
        <p>Materias</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('cursos.index') }}" class="nav-link">
        <i class="nav-icon fas fa-chalkboard"></i>
        <p>Cursos</p>
    </a>
</li>
<!-- Módulo de Horario -->
<li class="nav-item">
    <a href="{{ route('horarios.index') }}" class="nav-link {{ request()->routeIs('horarios.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clock"></i>
        <p>Horario</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('reportes.estudiantes_por_carrera') }}" class="nav-link">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>Estudiantes por Carrera</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('aulas.index') }}" class="nav-link">
        <i class="nav-icon fas fa-door-open"></i>
        <p>Aulas</p>
    </a>
</li>
          <li class="nav-item">
            <a href="{{ route('reportes.index') }}" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Reportes</p>
            </a>
          </li>
          <li class="nav-item">
    <a href="{{ route('usuarios.index') }}" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>Usuarios</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link text-danger" onclick="logoutConfirm(event)">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p> Cerrar sesión </p>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>


          <!-- Agrega más módulos aquí -->
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="content-wrapper p-3">
    @yield('content')
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Instituto Álvarez Plata</strong> © {{ date('Y') }}
  </footer>
</div>

<!-- JS AdminLTE y dependencias -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('scripts')

<script>
function logoutConfirm(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se cerrará tu sesión actual.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}
</script>
<script>
    $(document).ready(function () {
        $('.nav-tabs a').click(function () {
            $(this).tab('show');
        });
    });
</script>


</body>
</html>
