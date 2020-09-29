<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    var formValidation;
    var formValidationUpdate;
    $(document).ready(function() {
        //Date range picker
        var dateBirth = document.getElementById('userDateBirth');
        if (dateBirth == null || dateBirth == '') {
            $('#userDateBirth').datepicker('setDate', 'now');
        } else {
            dateBirth = dateBirth.value;
            if (dateBirth == null || dateBirth == '') {
                $('#userDateBirth').datepicker('setDate', 'now');
            } else {
                var myDate = new Date(dateBirth.substring(6,10), parseInt(dateBirth.substring(3,5)) - 1,dateBirth.substring(0,2));
                $('#userDateBirth').datepicker('setDate', myDate);
            }
        }
        //Listeners
        var bodyChange = document.getElementById('bodyChange');
        var flag_type_person = document.getElementById('flag_type_person');
        if (flag_type_person != null) {
            flag_type_person.addEventListener('change', function() {
                if (flag_type_person.value == 1) {
                    bodyChange.innerHTML = '<div class="box box-primary"><div class="box-body"><div class="form-group"><label for="typePersonId">TIPO DE DOCUMENTO</label><select id="typePersonId" name="typePersonId" class="form-control"><option value="1">DNI</option><option value="3">Carné Extranjeria</option><option value="4">Pasaporte</option></select></div>' +
                    '<div class="form-group"><label for="userDni">DNI</label><input class="form-control" id="userDni" type="number" style="width:100%;" name="userDni" placeholder="Ingrese dni de cliente" maxlength="250" required/></div><div class="form-group"><label for="userName">NOMBRES</label><input class="form-control" id="userName" name="userName" placeholder="Ingrese nombre del cliente" maxlength="250" required/></div><div class="form-group"><label for="userLastname">APELLIDOS</label><input class="form-control" id="userLastname" name="userLastname" placeholder="Ingrese apellidos del cliente" maxlength="250" required/></div><div class="form-group col-md-6" style="padding-left: 0px;"><label for="userEmail">CORREO</label><input class="form-control" id="userEmail" type="email" name="userEmail" placeholder="Ingrese correo" maxlength="250" required/></div><div class="form-group col-md-6" style="padding-right: 0px;"><label for="userPhone">TELÉFONO</label><input class="form-control" id="userPhone" type="text" name="userPhone" placeholder="Ingrese teléfono" maxlength="250" required/></div>' + 
                    '<div class="form-group"><label for="userDateBirth">FECHA DE NACIMIENTO</label><br><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control pull-right" id="userDateBirth"></div></div><div class="form-group"><label for="userAddress">DIRECCIÓN</label><input class="form-control" type="text" id="userAddress" name="userAddress" placeholder="Ingrese dirección" maxlength="250"></div> <div class="form-group"><label for="userDescription">DESCRIPCIÓN</label><textarea class="form-control" type="text" id="userDescription" name="userDescription" placeholder="Ingrese descripción de cliente" maxlength="250"></textarea></div> </div></div></div>';
                    $('#userDateBirth').datepicker('setDate', 'now');
                    sunatDniSearch();
                } else {
                    bodyChange.innerHTML = '<div class="box box-primary"><div class="box-body"><div class="form-group"><label for="userRuc">RUC</label><input class="form-control" id="userRuc" type="number" style="width:100%;" name="userRuc" placeholder="Ingrese ruc del cliente" maxlength="250" required/></div><div class="form-group"><label for="userRZSocial">RAZÓN SOCIAL</label><input class="form-control" id="userRZSocial" type="text" name="userRZSocial" placeholder="Ingrese razón social de cliente" maxlength="250" required/></div><div class="form-group"><label for="userRucAddress">DIRECCIÓN</label><input class="form-control" type="text" id="userRucAddress" name="userRucAddress" placeholder="Ingrese dirección" maxlength="250"></div>' +
                    '<div class="form-group col-md-6" style="padding-left: 0px;"><label for="userEmail">CORREO</label><input class="form-control" id="userEmail" type="email" name="userEmail" placeholder="Ingrese correo" maxlength="250" required/></div><div class="form-group col-md-6" style="padding-right: 0px;"><label for="userPhone">TELÉFONO</label><input class="form-control" id="userPhone" type="text" name="userPhone" placeholder="Ingrese teléfono" maxlength="250" required/></div>' + 
                    '<div class="form-group"><label for="userContact">CONTACTO</label><input class="form-control" id="userContact" type="text" name="userContact" placeholder="Ingrese contacto del cliente" maxlength="250" required/></div>' + 
                    '<div class="form-group"><label for="userWebsite">WEBSITE</label><input class="form-control" id="userWebsite" type="text" name="userWebsite" placeholder="Ingrese website del cliente" maxlength="250" required/></div>' + 
                    '<div class="form-group"><label for="userDescription">DESCRIPCIÓN</label><textarea class="form-control" type="text" id="userDescription" name="userDescription" placeholder="Ingrese descripción de cliente" maxlength="250"></textarea></div></div></div>';
                    sunatRucSearch();
                }
            });
        }
        sunatDniSearch();
        sunatRucSearch();

        //DNI Listener
        function sunatDniSearch() {
            var userDni = document.getElementById('userDni');
            if (userDni != null) {
                userDni.addEventListener('keyup', function(e) {
                    e.preventDefault();
                    if (e.keyCode == '13') {
                        if (userDni.value.length == 8) {
                            userDni.style.borderColor = "green";
                            $.ajax({
                                url: "/api/customer-in-sunat/by/dni/" + userDni.value,
                                context: document.body,
                                statusCode: {
                                    404: function() {
                                        alert("No se encontraron registros en la RENIEC.");
                                    },
                                    500: function () {
                                        x.style.display = "none";
                                        alert("Hubo problemas al conectarse con RENIEC.");
                                    }
                                }
                            }).done(function(response) {
                                document.getElementById('userName').value = response.nombres;
                                document.getElementById('userLastname').value = response.apellidoPaterno + ' ' + response.apellidoMaterno;
                                document.getElementById('userAddress').value = response.domicilio;
                            });
                        } else {
                            userDni.style.borderColor = "red";
                            console.log('DNI INVÁLIDO');
                        }
                    }
                });
            }
        }
        //RUC listener
        function sunatRucSearch() {
            var userRuc = document.getElementById('userRuc');
            if (userRuc != null) {
                userRuc.addEventListener('keyup', function(e) {
                    e.preventDefault();
                    if (e.keyCode == '13') {
                        if (userRuc.value.length == 11) {
                            userRuc.style.borderColor = "green";
                            console.log('BUSCAR RUC EN SUNAT');
                            $.ajax({
                                url: "/api/customer-in-sunat/by/ruc/" + userRuc.value,
                                context: document.body,
                                statusCode: {
                                    404: function() {
                                        alert("No se encontraron registros en la SUNAT.");
                                    },
                                    500: function () {
                                        x.style.display = "none";
                                        alert("Hubo problemas al conectarse con SUNAT.");
                                    }
                                }
                            }).done(function(response) {
                                document.getElementById('userRZSocial').value = response.nombre;
                                document.getElementById('userRucAddress').value = response.domicilio;
                            });
                        } else {
                            userRuc.style.borderColor = "red";
                            console.log('RUC INVÁLIDO');
                        }
                    }
                });
            }
        }

        //var functions
        formValidation = function() {
            // var inpObj = document.getElementById("amount");
            var button = document.getElementById("button");
            // if (!inpObj.checkValidity()) {
            //     inpObj.style.borderColor = "red";
            // } else {
                button.disabled = true;
                var dataSend = {};
                var flag_type_person = document.getElementById('flag_type_person').value;
                if (flag_type_person == 1) {
                    dataSend = {
                        employeeAssingId: document.getElementById('employeeAssingId').value,
                        dni : document.getElementById('userDni').value,
                        name : document.getElementById('userName').value,
                        lastname : document.getElementById('userLastname').value,
                        address : document.getElementById('userAddress').value,
                        email : document.getElementById('userEmail').value,
                        phone : document.getElementById('userPhone').value,
                        date_birth : document.getElementById('userDateBirth').value,
                        description : document.getElementById('userDescription').value,
                        flag_type_person : document.getElementById('typePersonId').value,
                    };
                } else {
                    dataSend = {
                        employeeAssingId: document.getElementById('employeeAssingId').value,
                        ruc : document.getElementById('userRuc').value,
                        rz_social : document.getElementById('userRZSocial').value,
                        address : document.getElementById('userRucAddress').value,
                        email : document.getElementById('userEmail').value,
                        phone : document.getElementById('userPhone').value,
                        contact : document.getElementById('userContact').value,
                        website_address : document.getElementById('userWebsite').value,
                        description : document.getElementById('userDescription').value,
                        flag_type_person : 2,
                    };
                }
                $.ajax({
                    method: "POST",
                    url: "/api/customer-simple",
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            button.disabled = false;
                            alert("Hubo un error en el registro. Es posible que el cliente ya esté registrado.");
                        }
                    }
                }).done(function(response) {
                    dataSend = {};
                    location = "/customers";
                });
        }

        formValidationUpdate = function(id, flag_type_person) {
            var button = document.getElementById("button");
                button.disabled = true;
                var dataSend = {};
                if (flag_type_person == 1) {
                    dataSend = {
                        employeeAssingId: document.getElementById('employeeAssingId').value,
                        dni : document.getElementById('userDni').value,
                        name : document.getElementById('userName').value,
                        lastname : document.getElementById('userLastname').value,
                        address : document.getElementById('userAddress').value,
                        district : document.getElementById('userDistrict').value,
                        email : document.getElementById('userEmail').value,
                        phone : document.getElementById('userPhone').value,
                        date_birth : document.getElementById('userDateBirth').value,
                        description : document.getElementById('userDescription').value,
                        flag_type_person : document.getElementById('typePersonId').value,
                    };
                } else {
                    dataSend = {
                        employeeAssingId: document.getElementById('employeeAssingId').value,
                        ruc : document.getElementById('userRuc').value,
                        rz_social : document.getElementById('userRZSocial').value,
                        address : document.getElementById('userRucAddress').value,
                        email : document.getElementById('userEmail').value,
                        phone : document.getElementById('userPhone').value,
                        contact : document.getElementById('userContact').value,
                        website_address : document.getElementById('userWebsite').value,
                        description : document.getElementById('userDescription').value,
                        flag_type_person : 2,
                    };
                }
                $.ajax({
                    method: "PATCH",
                    url: "/api/customer/" + id,
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            button.disabled = false;
                            alert("Hubo un error en el registro. Es posible que el cliente ya esté registrado.");
                        }
                    }
                }).done(function(response) {
                    dataSend = {};
                    location = "/customers";
                });
        }

        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    });
</script>