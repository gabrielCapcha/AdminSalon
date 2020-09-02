<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Admin Salon</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="AdminLte/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLte/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notificaciones</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 nuevos mensajes
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
        </div>
      </li>
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          {{ csrf_field() }}
          <button class="btn btn-danger">Cerrar sesión</button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="AdminLte/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <div class="brand-text font-weight-light">
        <div>Margoth Anaya</div>
        <div style="text-align: center;">Coiffure</div>
      </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="AdminLte/img/avatar3.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $jsonResponse->user->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link">
                  <i class="#"></i>
                  <p>Reporte de comisiones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                  <i class="#"></i>
                  <p>Reporte de ventas</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money"></i>
              <p>
                Ventas
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="product" class="nav-link">
              <i class="nav-icon fas fa-money"></i>
              <p>
                Productos
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <h1 style="padding-left: 20px" class="m-0 text-dark">{{ $jsonResponse->tittle }}</h1>
        @if (isset($jsonResponse->products))
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered table-hover dataTable dtr-inline">
            <thead>
              <tr role="row">
                <th class="sorting_asc">Nombre</th>
                <th class="sorting_asc">Código</th>
                <th class="sorting_asc">Precio</th>
                <th class="sorting_asc">Fecha de ingreso</th>
              </tr>
            </thead>
            <tbody>
              @foreach($jsonResponse->products as $product)
                <tr>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->code }}</td>
                  <td>{{ $product->price }}</td>
                  <td>{{ $product->register_date }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
      </div>
    @endif
    </div>
    <!-- Main content -->
    <div class="content">
    @yield('content')
    
    </div>

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a>AdminCOIFFURE</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="AdminLte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="AdminLte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="AdminLte/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="AdminLte/plugins/chart.js/Chart.min.js"></script>
<script src="AdminLte/js/demo.js"></script>
<script src="AdminLte/js/pages/dashboard3.js"></script>
</body>
</html>
