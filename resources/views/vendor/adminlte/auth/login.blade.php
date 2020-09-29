<!DOCTYPE html>
<html>
<head>
	<meta name="author" content="Carlos Martijena">
	<title>AdminSoft</title>
	<link rel="icon" type="image/png" sizes="16x16" href="img/new-login/iso_300_soft.png">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/styleNewLogin.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Exo+2:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800&display=swap" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>
<body>
	<img class="wave" src="img/new-login/bg-home1.png">
	<div class="container">
		<div class="img">
			<img src="/img/new-login/4.png">
		</div>
		<div class="login-content">
			<form action="{{ url('/login') }}" method="post" class="cod-form">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<img src="img/new-login/iso_300_soft.png">
				<div>
					<img src="img/new-login/ADMINSOFT-150-20.png" alt="">
				</div>
				<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<!-- <h5>Usuario</h5> -->
           		   		<input type="email" class="input" name="email" id="email" autocomplete="off" maxlength="50" placeholder="Usuario">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<!-- <h5>Contraseña</h5> -->
						   <input type="password" id="password" class="input" maxlength="25" autocomplete="off" required="required" name="password" placeholder="Contraseña">  
						   <button type="button" id="btnToggle" class="toggle" required="required"><i id="eyeIcon" class="fa fa-eye"></i></button>
            	   </div>
            	</div>
            	<div>
					<input type="submit" class="logbtn" value="Ingresar">
				</div>	
				@if (count($errors) > 0)
                <div class="alert alert-danger" style="padding: 10px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <ul>{{ $error }}</ul>
                        @endforeach
                    </ul>
                </div>
            @endif
            </form>
        </div>
    </div>
    <script src="{{ asset('/js/jqueryNewLogin.js') }}" type="text/javascript"></script>
</body>
</html>