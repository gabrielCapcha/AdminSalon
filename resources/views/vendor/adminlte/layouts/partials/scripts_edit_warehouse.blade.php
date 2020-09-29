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
            var jsonResponse = document.getElementById('jsonResponse').value;
            jsonResponse = JSON.parse(jsonResponse);
            var warehouseName = document.getElementById('warehouseName');
            warehouseName.style.borderColor = '#ccc';
            // var warehouseCode = document.getElementById('warehouseCode');
            // warehouseCode.style.borderColor = '#ccc';
            var warehouseAddress = document.getElementById('warehouseAddress');
            warehouseAddress.style.borderColor = '#ccc';
            var warehouseRuc = document.getElementById('warehouseRuc');
            warehouseRuc.style.borderColor = '#ccc';
            var warehouseRZSocial = document.getElementById('warehouseRZSocial');
            warehouseRZSocial.style.borderColor = '#ccc';
            var adminCheckbox = document.getElementById('adminCheckbox');
            var flagShowCompanyInfo = document.getElementById('flagShowCompanyInfo');
            var flagShowNoStockProducts = document.getElementById('flagShowNoStockProducts');
            var flagShowProductsRecipies = document.getElementById('flagShowProductsRecipies');
            var feStatus = document.getElementById('feStatus');
            var warehouseEmail = document.getElementById('warehouseEmail');
            var warehousePhone = document.getElementById('warehousePhone');
            var warehouseDeliveryAddress = document.getElementById('warehouseDeliveryAddress');
            var warehouseUbigeo = document.getElementById('warehouseUbigeo');
            var warehouseDistrict = document.getElementById('warehouseDistrict');
            var warehouseProvince = document.getElementById('warehouseProvince');
            var warehouseDepartment = document.getElementById('warehouseDepartment');
            var warehouseImage = document.getElementById('warehouseImage');
            var warehouseGrayImage = document.getElementById('warehouseGrayImage');
            var warehouseFeEmisor = document.getElementById('warehouseFeEmisor');
            var warehousePrintMessage = document.getElementById('warehousePrintMessage');
            var flagPdfDiscount = document.getElementById('flagPdfDiscount');
            var flagPdfUnitName = document.getElementById('flagPdfUnitName');

            var validation = true;
            if (!warehouseName.checkValidity()) {
                warehouseName.style.borderColor = "red";
                validation = false;
            }
            if (!warehouseRZSocial.checkValidity()) {
                warehouseRZSocial.style.borderColor = "red";
                validation = false;
            }
            if (!warehouseRuc.checkValidity()) {
                warehouseRuc.style.borderColor = "red";
                validation = false;
            }
            if (!warehouseAddress.checkValidity()) {
                warehouseAddress.style.borderColor = "red";
                validation = false;
            }
            
            if (validation) {
                $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
                var button = document.getElementById('button');
                button.disabled = true;
                dataSend = {};
                dataSend.name = warehouseName.value.toUpperCase();
                // dataSend.code = warehouseCode.value.toUpperCase();
                dataSend.address = warehouseAddress.value.toUpperCase();
                dataSend.ruc = warehouseRuc.value;
                dataSend.isMain = 0;
                dataSend.feStatus = 1;
                dataSend.flagShowCompanyInfo = 0;
                dataSend.flagShowNoStockProducts = 0;
                dataSend.flagShowProductsRecipies = 0;
                dataSend.email = warehouseEmail.value.toUpperCase();
                dataSend.phone = warehousePhone.value;
                dataSend.deliveryAddress = warehouseDeliveryAddress.value.toUpperCase();
                dataSend.ubigeo = warehouseUbigeo.value;
                dataSend.district = warehouseDistrict.value.toUpperCase();
                dataSend.province = warehouseProvince.value.toUpperCase();
                dataSend.department = warehouseDepartment.value.toUpperCase();
                dataSend.urlImage = data.urlImage;
                dataSend.urlImageGray = data.urlImageGray;
                dataSend.rzSocial = warehouseRZSocial.value.toUpperCase();
                dataSend.feEmisor = warehouseFeEmisor.value;
                dataSend.printMessage = warehousePrintMessage.value.toUpperCase();
                dataSend.flagPdfDiscount = flagPdfDiscount.value;
                dataSend.flagPdfUnitName = flagPdfUnitName.value;

                if (adminCheckbox.checked) {
                    dataSend.isMain = 1;
                }
                if (flagShowCompanyInfo.checked) {
                    dataSend.flagShowCompanyInfo = 1;
                }
                if (flagShowNoStockProducts.checked) {
                    dataSend.flagShowNoStockProducts = 1;
                }
                if (flagShowProductsRecipies.checked) {
                    dataSend.flagShowProductsRecipies = 1;
                }
                if (feStatus.checked) {
                    dataSend.feStatus = 2;
                }
                $.ajax({
                    method: "PATCH",
                    url: "/api/warehouses/" + jsonResponse.id,
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        // 500: function() {
                        //     alert('No se pudo registrar la nueva tienda. Verifique la información ingresada e inténtelo nuevamente.');
                        // },
                        400: function() {
                            alert('No se pudo actualizar. Verifique la información ingresada e inténtelo nuevamente.');    
                            $('#modal-on-load').modal('toggle');
                            button.disabled = false;
                        },
                    }
                }).done(function(response) {
                    // console.log(response);
                    alert('Datos actualizados correctamente');    
                    $('#modal-on-load').modal('toggle');
                    data = {};
                    dataSend = {};
                    location = "/warehouses";
                });
            }
        }
        function getBase64(file, fileType, typeVar = 1) {
            var reader = new FileReader();
            var button = document.getElementById('button');
            button.disabled = true;
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
                    console.log(response);
                    if (typeVar == 1) {
                        data.urlImage = response.data[0];
                    } else if (typeVar == 2) {
                        data.urlImageGray = response.data[0];
                    }
                    button.disabled = false;
                });
            };
            reader.onerror = function (error) {
                button.disabled = false;
            };
        }
        var warehouseImage = document.getElementById('warehouseImage');
        warehouseImage.addEventListener('change', function() {
            var fileName = warehouseImage.files[0].name;
            var fileSize = warehouseImage.files[0].size;
            var fileType = warehouseImage.files[0].type;
            var fileModifiedDate = warehouseImage.files[0].lastModifiedDate;
            getBase64(warehouseImage.files[0], fileType, 1);
        });
        var warehouseGrayImage = document.getElementById('warehouseGrayImage');
        warehouseGrayImage.addEventListener('change', function() {
            var fileName = warehouseGrayImage.files[0].name;
            var fileSize = warehouseGrayImage.files[0].size;
            var fileType = warehouseGrayImage.files[0].type;
            var fileModifiedDate = warehouseGrayImage.files[0].lastModifiedDate;
            getBase64(warehouseGrayImage.files[0], fileType, 2);
        });
    });
</script>