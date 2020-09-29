<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/iCheck/icheck.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
      
<script>
    //Inital var functions
    var formValidation;
    //Document Ready
    $(document).ready(function() {
        //initial vars
        var data = {};
        data.jsonResponseData = JSON.parse(document.getElementById("jsonResponseData").value);
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass   : 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
        //functions
        function getBase64(file, fileType) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                $.ajax({
                    method: "POST",
                    url: "https://sm-soft.tumi-soft.com/image/one-upload",
                    context: document.body,
                    data: {
                        type: fileType,
                        image: reader.result
                    }
                }).done(function(response) {
                    data.urlImage = response.data[0];
                });
            };
            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        }
        //var functions
        formValidation = function () {
            var userName = document.getElementById('userName');
            userName.style.borderColor = '#ccc';
            var userLastname = document.getElementById('userLastname');
            userLastname.style.borderColor = '#ccc';
            var userEmail = document.getElementById('userEmail');
            userEmail.style.borderColor = '#ccc';
            var userPassword = document.getElementById('userPassword');
            userPassword.style.borderColor = '#ccc';
            var confirmPassword = document.getElementById('confirmPassword');
            confirmPassword.style.borderColor = '#ccc';
            var userPhone = document.getElementById('userPhone');
            userPhone.style.borderColor = '#ccc';
            var warehouseId = document.getElementById('warehouseId');
            warehouseId.style.borderColor = '#ccc';
            var terminalId = document.getElementById('terminalId');
            terminalId.style.borderColor = '#ccc';
            var roleId = document.getElementById('roleId');
            roleId.style.borderColor = '#ccc';
            // var adminCheckbox = document.getElementById('adminCheckbox');
            // adminCheckbox.style.borderColor = '#ccc';
            var validation = true;
            if (!userName.checkValidity()) {
                userName.style.borderColor = "red";
                validation = false;
            }
            if (!userLastname.checkValidity()) {
                userLastname.style.borderColor = "red";
                validation = false;
            }
            if (!userEmail.checkValidity()) {
                userEmail.style.borderColor = "red";
                validation = false;
            }
            if (!userPassword.checkValidity()) {
                userPassword.style.borderColor = "red";
                validation = false;
            }
            if (!confirmPassword.checkValidity()) {
                confirmPassword.style.borderColor = "red";
                validation = false;
            }
            if (validation) {
                if (userPassword.value != confirmPassword.value) {
                    validation = false;
                    userPassword.style.borderColor = "red";
                    confirmPassword.style.borderColor = "red";
                }
            }
            if (validation) {
                var button = document.getElementById('button');
                button.disabled = true;
                dataSend = {};
                // dataSend.apps_id = 3;
                dataSend.name = userName.value.toUpperCase();
                dataSend.lastname = userLastname.value.toUpperCase();
                dataSend.email = userEmail.value;
                dataSend.password = userPassword.value;
                dataSend.confirmPassword = confirmPassword.value;
                dataSend.phone = userPhone.value;
                dataSend.war_warehouses_id = warehouseId.value;
                dataSend.sal_terminals_id = terminalId.value;
                dataSend.roles_id = roleId.value;
                dataSend.url_image = data.urlImage;
                dataSend.flag_admin = false;
                dataSend.code = document.getElementById('code').value;
                dataSend.floor = document.getElementById('floor').value;
                // if (adminCheckbox.checked) {
                //     dataSend.flag_admin = true;
                // }
                $.ajax({
                    method: "POST",
                    url: "/api/users",
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        500: function() {
                            alert('No se pudo registrar el nuevo usuario. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                        403: function() {
                            alert('No se pudo registrar el nuevo usuario. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                    }
                }).done(function(response) {
                    data = {};
                    dataSend = {};
                    // console.log(response);
                    location = "/users";
                });
            }
        }
        //Listeners
        var userImage = document.getElementById('userImage');
        userImage.addEventListener('change', function() {
            var fileName = userImage.files[0].name;
            var fileSize = userImage.files[0].size;
            var fileType = userImage.files[0].type;
            var fileModifiedDate = userImage.files[0].lastModifiedDate;
            // if (fileSize > maxImageSize) {
            //     alert("Imagen demasiado grande. Máximo permitido de 1Mb");
            // } else {
                getBase64(userImage.files[0], fileType);
            // }
        });
    });
</script>