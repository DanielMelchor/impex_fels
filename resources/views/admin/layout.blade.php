<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Grupo | Amad </title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('assets/adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/adminlte/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
  <link rel="stylesheet" href="{{ asset('assets/bootstrap-4.5.2-dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bootstrap-sweetalert-master/dist/sweetalert.css') }}">
  <style type="text/css">
    .btn-reporte{
      background-color: #FF8D33 !important;
    }
    .btn-excel{
      background-color: #A5C890 !important;
    }
    .btn-config{
      background-color: #C8BA90 !important;
    }
    .btn-refactura{
      background-color: #C890A4 !important;
    }
    .btn-renumera{
      background-color: #8B9BC1 !important;
    }
    .btn-anular{
      background-color: #226D7C !important;
      color: white !important;
    }
  </style>
  @yield('css')
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
  <!-- wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
      <img src="{{ asset('assets/logos/logo-impex-blue.png') }}" style="height: 50px;">
      <div class="container">
        <a href="#" class="navbar-brand">
          <img src="{{ asset('assets/logos/grupo_amad.png') }}" alt="amad Logo" class="brand-image" style="opacity: .8">
          <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <!--<li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>-->
            <li class="nav-item">
              @if(auth()->user()->can('ver-grafica'))
                <a href="#" class="nav-link"><i class="fas fa-home"></i>Inicio</a>
              @endcan
            </li>
            <!--administracion -->
            <li class="nav-item dropdown">
              <a id="administracionSubMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-user-secret"></i> Administración</a>
              <ul aria-labelledby="administracionSubMenu" class="dropdown-menu border-0 shadow">
                @can('ver-empresa')
                <li><a href="{{ route('empresas') }}" class="nav-link">Empresas</a></li>
                @endcan
                @role('Administrador')
                <li><a href="{{ route('roles') }}" class="nav-link">Roles</a></li>
                @endrole
                @role('Administrador')
                <li><a href="{{ route('permisos') }}" class="nav-link">Permisos</a></li>
                @endrole
                @can('ver-usuario')
                <li><a href="{{ route('usuarios') }}" class="nav-link">Usuarios</a></li>
                @endcan
              </ul>
            </li>
            @can('ver-consulta')
            <li class="nav-item">
              <a href="{{ route('consulta_fel') }}" class="nav-link"><i class="fas fa-calendar-alt"></i> Consulta</a>
            </li>
            @endcan
            <!-- /administracion -->
            <!-- catalogos -->
            <!--<li class="nav-item dropdown">
              <a id="catalogosSubMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-cog"></i> Catálogos</a>
              <ul aria-labelledby="catalogosSubMenu" class="dropdown-menu border-0 shadow">
                <li><a href="{{ route('empresas') }}" class="dropdown-item">Empresas</a></li>
              </ul>
            </li>-->
            <!-- /catalogos -->
            <!-- Procesos -->
            <!--<li class="nav-item dropdown">
              <a id="catalogosSubMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-qrcode"></i> Procesos</a>
              <ul aria-labelledby="catalogosSubMenu" class="dropdown-menu border-0 shadow">
                <li><a href="#" class="dropdown-item">Consulta Fel</a></li>
              </ul>
            </li> -->
            <!-- procesos -->
            <!-- Reportes -->
            <!--<li class="nav-item dropdown">
              <a id="reportesSubMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-file-alt"></i> Reportes</a>
              <ul aria-labelledby="reportesSubMenu" class="dropdown-menu border-0 shadow">
              </ul>
            </li>-->
            <!-- Reportes -->

          </ul>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('contrasena') }}">Cambio de contraseña</a>
                <a class="dropdown-item" href="{{ route('salir') }}">Salir</a>
                <!--<a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>-->
                <!--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form> -->
            </div>
          </li>
        </ul>
      </div>

      </div>
    </nav>
  </div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.card -->
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <br>
            <h5>@yield('titulo') / @yield('subtitulo')</h5>
            <br>
            @yield('contenido')
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.4
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>
  <!-- jQuery -->
  <script src="{{ asset('assets/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('assets/popper.min.js') }}"></script>
  <script src="{{asset('assets/adminlte/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('assets/adminlte/js/adminlte.min.js')}}"></script>
  <script src="{{ asset('assets/bootstrap-4.5.2-dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/bootstrap-4.5.2-dist/js/bootstrap.min.js') }}"></script>
  <!--<script src="{{ asset('assets/alertifyjs/alertify.min.js') }}"></script>-->
  <script src="{{ asset('assets/bootstrap-sweetalert-master/dist/sweetalert.min.js') }}"></script>

  <script>
     var asset = '{{ asset('') }}'
  </script>
  @yield('js')

</body>
</html>