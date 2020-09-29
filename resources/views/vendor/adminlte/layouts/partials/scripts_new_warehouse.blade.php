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
        formValidation = function () {
            var warehouseName = document.getElementById('warehouseName');
            warehouseName.style.borderColor = '#ccc';            
            var warehouseCode = document.getElementById('warehouseCode');
            warehouseCode.style.borderColor = '#ccc';
            var warehouseAdress = document.getElementById('warehouseAdress');
            warehouseAdress.style.borderColor = '#ccc';
            var warehouseRuc = document.getElementById('warehouseRuc');
            warehouseRuc.style.borderColor = '#ccc';

            var validation = true;
            if (!warehouseName.checkValidity()) {
                warehouseName.style.borderColor = "red";
                validation = false;
            }
            if (!warehouseCode.checkValidity()) {
                warehouseCode.style.borderColor = "red";
                validation = false;
            }
            if (!warehouseAdress.checkValidity()) {
                warehouseAdress.style.borderColor = "red";
                validation = false;
            }
            
            if (validation) {
                var button = document.getElementById('button');
                button.disabled = true;
                dataSend = {};
                dataSend.name = warehouseName.value.toUpperCase();
                dataSend.code = warehouseCode.value.toUpperCase();
                dataSend.address = warehouseAdress.value.toUpperCase();
                dataSend.ruc = warehouseRuc.value;
                dataSend.is_main = 0;
                var adminCheckbox = document.getElementById('adminCheckbox');
                if (adminCheckbox.checked) {
                    dataSend.is_main = 1;
                }
                $.ajax({
                    method: "POST",
                    url: "/api/warehouses",
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        // 500: function() {
                        //     alert('No se pudo registrar la nueva tienda. Verifique la información ingresada e inténtelo nuevamente.');
                        // },
                        400: function() {
                            alert('No se pudo registrar la nueva tienda. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                    }
                }).done(function(response) {
                    data = {};
                    dataSend = {};
                    location = "/warehouses";
                });
            }
        }
    });
</script>