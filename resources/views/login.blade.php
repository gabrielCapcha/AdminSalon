<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="AdminLte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="AdminLte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLte/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page" background="AdminLte/img/coiffure.jpg">
<div class="register-box">
  <div class="card">
    <div class="card-body register-card-body">
    <div class="register-logo">
    <a><b>Admin</b>COIFFURE</a>
  </div>
      <p class="login-box-msg">Iniciar sesión</p>
      <form action="login" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
          <div class="input-group mb-3">
            <input id="email" type="email" name="email" class="form-control" placeholder="Correo" required="required" 
            oninvalid="this.setCustomValidity('Ingrese Correo')" oninput="this.setCustomValidity('')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group mb-3">
            <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña" required="required" 
            oninvalid="this.setCustomValidity('Ingrese contraseña')" oninput="this.setCustomValidity('')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
      </form>
      <a href="#" class="text-center">Olvidé mi contraseña</a>
    </div>
  </div>
</div>
<!-- Modals -->
<div class="modal fade show" id="modal-login">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"></div>
        <div class="modal-body"></div>
      </div>
  </div>
</div>
<!-- jQuery -->
<script src="AdminLte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="AdminLte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLte/js/adminlte.min.js"></script>
<script>
    $(document).ready(function() {
      checkData = function () {
        
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        console.log("email",email);
        console.log("pass",password);
        if (email == '' && password == '') {
          $('#modal-login').modal({ backdrop: 'static', keyboard: false });
        }
      }
    });
</script>
</body>
</html>
