<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="AdminLte/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLte/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <title>Admin Salon</title>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
      @include('admin.partials.header')
      <div class="content-wrapper">
          <h1 style="padding-left: 20px" class="m-0 text-dark">{{ $jsonResponse->tittle }}</h1>
          <div>
              @yield('main-content')
          </div>
      </div>
      @include('admin.partials.sidebar')
      <!-- Footer -->
      @include('admin.partials.footer')
    </div>
    @section('scripts')
      @include('Product.partials.scripts-product')
    @show
</body>
</html>
