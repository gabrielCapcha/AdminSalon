<!-- Laravel App -->
<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.lightSlider.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/bootstrap-toggle/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
<!-- Datatables -->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script><script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script>
    //Document Ready
    var optionPad;
    var newUserForm;
    var setPadNumber;
    var loadProducts;
    var typePayments;
    var searchSaleForm;
    var newSaleButtonN;
    var clearPadNumber;
    var changePriceList;
    var clearPadNumber1;
    var clearPadNumber2;
    var clearPadNumber3;
    var newSettingsForm;
    var saveNewSettings;
    var secondStepOfSale;
    var openTypeDocument;
    var showProductDetail;
    var promoChangePrices;
    var addSelectedProduct;
    var changeTypeDocument;
    var saveNewSimpleClient;
    var setPadNumberOption1;
    var setPadNumberOption2;
    var setPadNumberOption3;
    var clearSelectedProduct;
    var updateSelectedProduct;
    var clearAllSelectedProduct;
    $(document).ready(function() {
        //Initialize slider
        $("#demo").lightSlider({
            loop:true,
            keyPress:true
        });
        //Initialize variables
        var data = {};
        var intervalPriceList = true;
        var arraySales = [];
        var buttonVd_ = true;
        var idNewSale = 0;
        var priceLists = [];
        var amountValue = 0;
        var amountValue_ = 0;
        var paymentAmount = 0;
        var quantityValue = 0;
        var paymentAmounts = [];
        var typePaymentId = 1;
        var exchangeAmount = 0;
        var generalDiscount = 0;
        var promoDiscount__ = 0;
        var genericCustomer = JSON.parse(document.getElementById("genericCustomer").value);
        var companyLoginData = JSON.parse(document.getElementById("companyLoginData").value);
        var servicePercent = document.getElementById('servicePercentValue').value;
        var typePaymentNames = {
            1 : { "name": "EFECTIVO", "type": "number", "htmlId": "cashInputValue", "selected": true, "additionalBox": false, "readOnly": false, "exchange": true },
            2 : { "name": "VISA", "type": "number", "htmlId": "visaInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
            3 : { "name": "MASTERCARD", "type": "number", "htmlId": "mastercardInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
            6 : { "name": "DEPÓSITO", "type": "number", "htmlId": "depositInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
            8 : { "name": "CRÉDITO", "type": "text", "htmlId": "creditInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
            9 : { "name": "LETRAS", "type": "text", "htmlId": "letterInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
        };
        var typeDocumentNames = {
            1 : { "name": "BOLETA", "code": "BLT", "htmlClass":"warning" },
            2 : { "name": "FACTURA", "code": "FAC", "htmlClass":"danger" },
            5 : { "name": "PRECUENTA", "code": "NVT", "htmlClass":"info" },
        };
        var typeDocumentCode = 'NVT';
        var typeDocumentName = 'PRECUENTA';
        var universalPromoValue = companyLoginData.universal_promo;
        var universalPromoBoolean = false;
        var saleOrder = '';
        var advertisement = '';
        var remissionGuide = '';
        var saleCommentary = '';
        //Data variables
        data.sale = {};
        data.products = [];
        data.currency = 'PEN';
        data.customer = null;
        data.padOption = 0;
        data.symbolCode = 'S/ ';
        data.customerId = 0;
        data.priceListId = 0;
        data.rowClickedId = 0;
        data.typePayments = [{"id": 1, "name": "EFECTIVO", "htmlId": "cashInputValue", "selected": true}];
        data.buttonCategory = 0;
        data.selectedProducts = [];
        data.selectedQuotations = [];
        data.suppliedCustomer = {};
        //INTERVALS
        //Date range picker
        $('#dateRange').daterangepicker(
            {
                timeZone: 'America/Lima',
                locale: {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Ok",
                    "cancelLabel": "Cerrar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Perzon.",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                },
                maxDate: moment().subtract(0, 'days').endOf('day'),
        });
        //functions
        function format ( response ) {
            var tableBodyRowData = '<table class="table">' +
                '<thead>' +
                '<tr><th><input type="checkBox" onChange="searchQuotationCheckbox();" id="mainCheckBoxSearchQuotation_' + response.id + '"></th><th>Categoría</th><th>Nombre</th><th>Código</th><th>Cantidad</th><th>Convertido</th><th>Disponible</th></tr>' + 
                '</thead>' +
                '<tbody>';
            response.items.forEach(element => {
                var disabled = '';
                var readonly = '';
                if ((parseFloat(element.quantity) - parseFloat(element.converted)) <= 0) {
                    disabled = 'disabled';
                    readOnly = 'readonly';
                }
                tableBodyRowData = tableBodyRowData + 
                '<tr>' + 
                '<td><input ' + disabled + ' type="checkBox" id="checkBoxSearchQuotation_' + element.id + '" ></td>' +
                '<td>' + element.category_name + '</td>' +
                '<td>' + element.name + '</td>' +
                '<td>' + element.code + '</td>' +
                '<td>' + element.quantity + '</td>' +
                '<td>' + element.converted + '</td>' +
                '<td><input ' + readonly + ' style="width:25%;" onClick="this.select();" type="number" id="quantitySearchQuotation_' + element.id + '" value="' + (parseFloat(element.quantity) - parseFloat(element.converted)) + '" /></td>' + 
                '<tr>';
            });
            return tableBodyRowData + '</tbody></table>';
        }
        function setInterval() {
            amountValue = 0;
            quantityValue = 0;
            universalPromoBoolean = false;
            data.selectedProducts.forEach(element => {
                if (element.quantity > 0) {
                    amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                    if (element.flagUniversalPromo) {
                        quantityValue = parseFloat(quantityValue) + parseFloat(element.quantity);
                        if (quantityValue >= universalPromoValue) {
                            universalPromoBoolean = true;
                            universalPromo();
                        }
                    }
                }
            });

            var generalService = document.getElementById('generalService');
            if (servicePercent > 0) {
                var servicePercentValue = parseFloat(((amountValue-generalDiscount-promoDiscount__)*0.7633333) * (parseFloat(servicePercent)/100));
                generalService.value = servicePercentValue;    
            } else {
                var servicePercentValue = 0.00;
                generalService.value = servicePercentValue;
            }
            if (buttonVd_) {
                if (typeDocumentCode == 'BLT') {
                    if (data.customer.dni == '88888888' && ((amountValue - generalDiscount - promoDiscount__) >= 700)) {
                        var finishNewSale = document.getElementById('finishNewSale');
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Monto mayor o igual a 700 soles. Ingrese DNI';
                    } else if (data.customer.dni == null) {
                        var finishNewSale = document.getElementById('finishNewSale');
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Ingrese cliente DNI';
                    } else if (data.customer.dni.length < 8) {
                        var finishNewSale = document.getElementById('finishNewSale');
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Ingrese cliente DNI';
                    } else {
                        var finishNewSale = document.getElementById('finishNewSale');
                        finishNewSale.disabled = false;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Validación correcta.';
                        document.getElementById('saleErrorMessage').className = 'btn btn-success pull-center';
                    }
                }
                if (typeDocumentCode == 'FAC') {
                    if (data.customer.ruc == '88888888888') {
                        var finishNewSale = document.getElementById('finishNewSale');
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Tipo de documento FACTURA. Ingrese RUC';
                    } else if (data.customer.ruc == null) {
                        var finishNewSale = document.getElementById('finishNewSale');
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Tipo de documento FACTURA. Ingrese RUC';
                    } else if (data.customer.ruc.length < 11) {
                        var finishNewSale = document.getElementById('finishNewSale');
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Tipo de documento FACTURA. Ingrese RUC';
                    } else {
                        var finishNewSale = document.getElementById('finishNewSale');
                        finishNewSale.disabled = false;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Validación correcta.';
                        document.getElementById('saleErrorMessage').className = 'btn btn-success pull-center';
                    }                
                }
                if (typeDocumentCode == 'NVT') {
                    var finishNewSale = document.getElementById('finishNewSale');
                    finishNewSale.disabled = false;
                    var saleErrorMessage = document.getElementById('saleErrorMessage');
                    saleErrorMessage.innerHTML = 'Validación correcta.';
                    document.getElementById('saleErrorMessage').className = 'btn btn-success pull-center';
                }
            }
        }
        function universalPromo() {
            data.selectedProducts.forEach(element => {
                if (element.flagUniversalPromo && universalPromoBoolean) {
                    element.price = element.wholeSalePrice - element.partialDiscount;
                    document.getElementById("priceProduct_" + element.id).value = element.price;
                } else {
                    element.price = element.originalPrice - element.partialDiscount;
                    document.getElementById("priceProduct_" + element.id).value = element.price;
                }
            });
        }
        function quantityUniversalPromo(product) {
            var quantityWSP = product.quantityWSP;
            if (universalPromoBoolean) {
                if (product.flagUniversalPromo) {
                    quantityWSP = 1;
                }
            }
            return quantityWSP;
        }
        function genericClient() {
            genericCustomer = JSON.parse(document.getElementById("genericCustomer").value);
            data.customer   = genericCustomer;
            data.customerId = genericCustomer.id;
            document.getElementById("inputSearchClient2").value    = genericCustomer.name + " " + genericCustomer.lastname;
        }
        function newSaleButton() {
            location.reload();
        }
        function searchClientSunatButton() {
            var x = document.getElementById("loadingDivCustomer");
            var searchClientSunat = document.getElementById('searchClientSunat').value;
            var buttonSearchClient = document.getElementById('chooseClientOld');
            var clientDataResponse = document.getElementById("clientDataResponse");
            switch (searchClientSunat.length) {
                case 8:
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                    clientDataResponse.innerHTML = "";
                    $.ajax({
                        url: "/api/customer/by/dni/" + searchClientSunat,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                x.style.display = "none";
                                clientDataResponse.innerHTML = '<div align="center">No se encontró al cliente en la base de datos</div>';
                                buttonSearchClient.disabled = true;
                            }
                        }
                    }).done(function(response) {
                        x.style.display = "none";
                        document.getElementById('searchClientSunat').value = "";
                        buttonSearchClient.disabled = false;
                        clientDataResponse.innerHTML = "";
                        var form = document.createElement('form');
                        form.innerHTML ='<div class="box-body col-md-6">' +
                            '<div class="form-group">' +
                            '<label for="clientDni">DNI</label>' +
                            '<input type="text" class="form-control" id="clientDni" readonly placeholder="Ingrese DNI" value="' + response.dni + '"></div>' +
                            '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                            '<input type="text" class="form-control" id="clientNames" readonly placeholder="Ingrese NOMBRES" value="' + response.name + '"></div>' +
                            '<div class="form-group"><label for="clientFirstLastname">APELLIDOS</label>' + 
                            '<input type="text" class="form-control" id="clientFirstLastname" readonly placeholder="Ingrese APELLIDOS" value="' + response.lastname + '"></div></div>' +
                            '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                            '<input type="text" class="form-control" id="clientPhone" readonly maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value="' + response.phone + '"></div>' +
                            '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                            '<input type="text" class="form-control" id="clientEmail" readonly maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value="' + response.email + '"></div>' +
                            '</div></div>';
                        clientDataResponse.appendChild(form);
                        data.newCustomer = response;
                        data.newCustomer.typeCustomer = 1;
                    });
                    break;
                case 11:        
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                    $.ajax({
                        url: "/api/customer/by/ruc/" + searchClientSunat,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                x.style.display = "none";
                                clientDataResponse.innerHTML = '<div align="center">No se encontró al cliente en la base de datos</div>';
                                buttonSearchClient.disabled = true;
                            }
                        }
                    }).done(function(response) {
                            x.style.display = "none";
                            document.getElementById('searchClientSunat').value = "";
                            buttonSearchClient.disabled = false;
                            clientDataResponse.innerHTML = "";
                            var form = document.createElement('form');
                            var rz_social = response.rz_social;
                            if (rz_social == null) {
                                rz_social = "Sin especificar";
                            }
                            form.innerHTML ='<div class="box-body col-md-6">' +
                                '<div class="form-group">' +
                                '<label for="clientDni">RUC</label>' +
                                '<input type="text" class="form-control" id="clientRuc" readonly placeholder="Ingrese RUC" value="' + response.ruc + '"></div>' +
                                '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                                '<input type="text" class="form-control" id="clientNames" readonly placeholder="Ingrese NOMBRES" value="' + response.name + '"></div>' +
                                '<div class="form-group"><label for="clientFirstLastname">APELLIDOS</label>' + 
                                '<input type="text" class="form-control" id="clientFirstLastname" readonly placeholder="Ingrese APELLIDOS" value="' + response.lastname + '"></div></div>' +
                                '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                '<input type="text" class="form-control" id="clientPhone" readonly maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value="' + response.phone + '"></div>' +
                                '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                '<input type="text" class="form-control" id="clientEmail" readonly maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value="' + response.email + '"></div>' +
                                '<div class="form-group"><label for="clientEmail">RAZÓN SOCIAL</label>' +
                                '<input type="text" class="form-control" id="rzSocial" readonly maxlength=100 placeholder="Ingrese RAZÓN SOCIAL" value="' + rz_social + '"></div>' +
                                '</div></div>';
                            clientDataResponse.appendChild(form);
                            data.newCustomer = response;
                            data.newCustomer.typeCustomer = 2;
                            data.newCustomer.ruc = searchClientSunat;
                    });
                    break;
                default:
                    alert("DNI o RUC ingresado no son válidos.");
                    break;
            }
        }
        function searchNewClientSunatButton() {
            var x = document.getElementById("loadingDivNewCustomer");
            var searchClientSunat = document.getElementById('searchNewClientSunat').value;
            var clientDataResponse = document.getElementById("newClientDataResponse");
            switch (searchClientSunat.length) {
                case 8:
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                    var buttonSaveNewClient = document.getElementById('saveNewClient');
                    buttonSaveNewClient.disabled = true;
                    clientDataResponse.innerHTML = "";
                    $.ajax({
                        url: "/api/customer-in-sunat/by/dni/" + searchClientSunat,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                x.style.display = "none";
                                alert("No se encontraron registros en la RENIEC.");
                            },
                            500: function () {
                                x.style.display = "none";
                                alert("Hubo problemas al conectarse con RENIEC.");
                            }
                        }
                    }).done(function(response) {
                        x.style.display = "none";
                        document.getElementById('searchNewClientSunat').value = "";
                        var buttonSaveNewClient = document.getElementById('saveNewClient');
                        buttonSaveNewClient.disabled = false;
                        clientDataResponse.innerHTML = "";
                        var form = document.createElement('form');
                        form.innerHTML ='<div class="box-body col-md-6">' +
                            '<div class="form-group">' +
                            '<label for="clientDni">DNI</label>' +
                            '<input type="text" class="form-control" id="clientDni" readonly placeholder="Ingrese DNI" value="' + response.dni + '"></div>' +
                            '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                            '<input type="text" class="form-control" id="clientNames" readonly placeholder="Ingrese NOMBRES" value="' + response.nombres + '"></div>' +
                            '<div class="form-group"><label for="clientFirstLastname">APELLIDO PATERNO</label>' + 
                            '<input type="text" class="form-control" id="clientFirstLastname" readonly placeholder="Ingrese APELLIDO PATERNO" value="' + response.apellidoPaterno + '"></div>' +
                            '<div class="form-group"><label for="clientSecondLastname">APELLIDO MATERNO</label>' +
                            '<input type="text" class="form-control" id="clientSecondLastname" readonly placeholder="Ingrese APELLIDO MATERNO" value="' + response.apellidoMaterno + '"></div>' +
                            '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                            '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div>' +
                            '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                            '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                            '<div class="form-group"><label for="clientAddress">DIRECCIÓN</label>' +
                            '<input type="text" class="form-control" id="clientAddress" maxlength=200 placeholder="Ingrese DIRECCIÓN" value="' + response.domicilio + '"></div>'+
                            '<div class="form-group"><label for="clientDistrict">DISTRITO</label>' +
                            '<input type="text" class="form-control" id="clientDistrict" maxlength=100 placeholder="Ingrese DISTRITO" value=""></div>'+
                            '<div class="form-group"><label for="clientDistrict">PROVINCIA</label>' +
                            '<input type="text" class="form-control" id="clientProvince" maxlength=100 placeholder="Ingrese PROVINCIA" value=""></div>'+
                            '<div class="form-group"><label for="clientDepartment">DEPARTAMENTO</label>' +
                            '<input type="text" class="form-control" id="clientDepartment" maxlength=100 placeholder="Ingrese DEPARTAMENTO" value=""></div>'+
                            '</div>';
                        clientDataResponse.appendChild(form);
                        data.newCustomer = response;
                        data.newCustomer.typeCustomer = 1;
                    });
                    break;
                case 11:
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                    $.ajax({
                        url: "/api/customer-in-sunat/by/ruc/" + searchClientSunat,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                x.style.display = "none";
                                alert("No se encontraron registros en la SUNAT.");
                            },
                            500: function () {
                                x.style.display = "none";
                                alert("Hubo problemas al conectarse con SUNAT.");
                            }
                        }
                    }).done(function(response) {
                        if (response.condicion == "HABIDO") {
                            x.style.display = "none";
                            document.getElementById('searchNewClientSunat').value = "";
                            var buttonSaveNewClient = document.getElementById('saveNewClient');
                            buttonSaveNewClient.disabled = false;
                            clientDataResponse.innerHTML = "";
                            var form = document.createElement('form');
                            form.innerHTML ='<div class="box-body col-md-6">' +
                                '<div class="form-group">' +
                                '<label for="clientDni">DNI</label>' +
                                '<input type="text" class="form-control" id="clientDni" readonly placeholder="Ingrese DNI" value="' + response.dni + '"></div>' +
                                '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                                '<input type="text" class="form-control" id="clientNames" readonly placeholder="Ingrese NOMBRES" value="' + response.nombre + '"></div>' +
                                '<div class="form-group"><label for="clientFirstLastname">TIPO DE CONTRIBUYENTE</label>' + 
                                '<input type="text" class="form-control" id="clientFirstLastname" readonly placeholder="Ingrese TIPO DE CONTRIBUYENTE" value="' + response.tipo_contribuyente + '"></div>' +
                                '<div class="form-group"><label for="clientSecondLastname">RUC</label>' +
                                '<input type="text" class="form-control" id="clientSecondLastname" readonly placeholder="Ingrese RUC" value="' + searchClientSunat + '"></div>' +
                                '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div>' +
                                '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                                '<div class="form-group"><label for="clientAddress">DIRECCIÓN</label>' +
                                '<input type="text" class="form-control" id="clientAddress" maxlength=200 placeholder="Ingrese DIRECCIÓN" value="' + response.domicilio + '"></div>'+
                                '<div class="form-group"><label for="clientDistrict">DISTRITO</label>' +
                                '<input type="text" class="form-control" id="clientDistrict" maxlength=100 placeholder="Ingrese DISTRITO" value="' + response.distrito + '"></div>'+
                                '<div class="form-group"><label for="clientDistrict">PROVINCIA</label>' +
                                '<input type="text" class="form-control" id="clientProvince" maxlength=100 placeholder="Ingrese PROVINCIA" value="' + response.provincia + '"></div>'+
                                '<div class="form-group"><label for="clientDepartment">DEPARTAMENTO</label>' +
                                '<input type="text" class="form-control" id="clientDepartment" maxlength=100 placeholder="Ingrese DEPARTAMENTO" value="' + response.departamento + '"></div>'+
                                '</div>';
                            clientDataResponse.appendChild(form);
                            data.newCustomer = response;
                            data.newCustomer.typeCustomer = 2;
                            data.newCustomer.name = response.nombre;
                            data.newCustomer.lastname = '';
                            data.newCustomer.ruc = searchClientSunat;
                        } else {
                            x.style.display = "none";
                            alert("Ruc en condición NO HABIDO.");
                        }
                    });
                    break;
                default:
                    alert("DNI o RUC ingresado no son válidos.");
                    break;
            }
        }
        function chooseClient() {
            genericCustomer = data.newCustomer;
            data.customer   = genericCustomer;
            data.customerId = genericCustomer.id;
            console.log(genericCustomer);
            if (genericCustomer.name == null) {
                genericCustomer.name = genericCustomer.rz_social;
                genericCustomer.lastname = '';
            }
            document.getElementById("inputSearchClient").value = genericCustomer.name + " " + genericCustomer.lastname;
        }
        function chooseClient2() {
            genericCustomer = data.newCustomer;
            data.customer   = genericCustomer;
            data.customerId = genericCustomer.id;
            console.log(genericCustomer);
            if (genericCustomer.name == null) {
                genericCustomer.name = genericCustomer.rz_social;
                genericCustomer.lastname = '';
            }
            document.getElementById("inputSearchClient2").value = genericCustomer.name + " " + genericCustomer.lastname;
        }
        function saveNewClient() {
            var button = document.getElementById('saveNewClient');
            if (data.newCustomer != undefined) {
                data.newCustomer.phone = document.getElementById("clientPhone").value;
                data.newCustomer.email = document.getElementById("clientEmail").value;
                data.newCustomer.address = document.getElementById("clientAddress").value;
                data.newCustomer.district = document.getElementById("clientDistrict").value;
                data.newCustomer.province = document.getElementById("clientProvince").value;
                data.newCustomer.department = document.getElementById("clientDepartment").value;
                if (data.newCustomer.dni == '-') {
                    data.newCustomer.dni = null;
                }
                $.ajax({
                    method: "POST",
                    url: "/api/customer",
                    context: document.body,
                    data: data.newCustomer,
                    statusCode: {
                        400: function() {
                            button.disabled = false;
                            alert("Hubo un error en el registro. Es posible que el cliente ya esté registrado.");
                        }
                    }
                }).done(function(response) {
                    button.disabled = false;
                    data.customer = response;
                    data.customerId = response.id;
                    document.getElementById("inputSearchClient").value    = response.name + " " + response.lastname;
                    $('#dismissNewClient').trigger('click');
                });
            }
        }
        function finishNewSale() {
            //LLAMADA AL LOADING
            $('#modal-second-step').modal('toggle');
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            exchangeAmount = parseFloat(document.getElementById('cashInputExchange').value);
            //LOGICA DE PORCENTAJE
            var typeGeneralDiscount = document.getElementById('typeGeneralDiscount').value;
            generalDiscount = parseFloat(document.getElementById('generalDiscount').value);
            if (typeGeneralDiscount == 1) {
                generalDiscount = (amountValue/100)*generalDiscount;
            }                
            var selectedProductsToSale = [];
            data.selectedProducts.forEach(element => {
                if (element.quantity > 0) {
                    selectedProductsToSale.push(element);   
                }
            });
            var payments = [];
            var cashPayment = false;
            var saleValidation = true;
            paymentAmount = 0;
            if (payments.length == 0) {
                payments.push({
                    "amount": 0.00,
                    "exchange": 0.00,
                    "name": "EFECTIVO",
                    "sal_type_payments_id": typePaymentId
                });
                cashPayment = true;
            }
            payments.forEach(element => {
                if (element.sal_type_payments_id == 1) {
                    cashPayment = true;
                }
            });
            if (!cashPayment) {
                if (payments.length == 1 && (exchangeAmount > 0)) {
                    payments[0].amount = payments[0].amount - exchangeAmount;
                    paymentAmount = paymentAmount - exchangeAmount;
                    exchangeAmount = 0;
                } else if (payments.length > 1 && (exchangeAmount > 0)) {
                    saleValidation = false;
                    alert("No se puede concretar la venta. El monto ingresado es mayor a la venta.");
                }
            }
            payments.forEach(element => {
                if (element.amount < 0) {
                    saleValidation = false;
                    alert("No se puede concretar la venta. El monto ingresado es mayor a la venta.");
                }
            });
            var valueAmount___ = amountValue - generalDiscount;
            var services___    = parseFloat(generalService.value);
            
            if (services___ > 0) {
                var subTotal___    = valueAmount___ * 0.7633333;
                var taxes___       = subTotal___ * 0.18;
            } else {
                var subTotal___    = valueAmount___/1.18;
                var taxes___       = (valueAmount___ - subTotal___);
            }

            if (valueAmount___ <= 0) {
                amountValue = 0;
                exchangeAmount = 0;
                payments.forEach(element => {
                    element.amount = 0;
                    element.exchange = 0;
                });
            }

            var newUserAssignment = document.getElementById('new_user_assignment');
            newUserAssignment = newUserAssignment.value;
            
            if (saleValidation) {
                data.sale = {
                    "userId" : newUserAssignment,
                    "amount": valueAmount___,
                    "subtotal": subTotal___,
                    "taxes": taxes___,
                    "services": services___,
                    "currency": data.currency,
                    "symbol_code": data.symbolCode,
                    "customer_dni": data.customer.dni,
                    "customer_flag_type_person": 0,
                    "customer_id": data.customerId,
                    "customer_ruc": data.customer.ruc,
                    "data_client": [
                        {
                            "current_customer": false,
                            "customer_id": data.customerId,
                            "interest": 0,
                            "name": (data.customer.name + " " + data.customer.lastname),
                            "payments": payments,
                            "quota_payment_id": 0,
                            "quote_number": 0,
                            "timing": 0,
                            "quotationAffected": data.selectedQuotations,
                        }
                    ],
                    "discount": parseFloat(generalDiscount),
                    "promo_discount": parseFloat(promoDiscount__),
                    "isCustomer": false,
                    "items_": selectedProductsToSale,
                    "sal_sale_states_id": "10",
                    "sal_type_payments_id": typePaymentId,
                    "transaction": true,
                    "payment_amount": paymentAmount,
                    "exchange_amount": exchangeAmount,
                    "type_document_code": typeDocumentCode,
                    "type_document_name": typeDocumentName,
                    "sale_order": saleOrder,
                    "remission_guide": remissionGuide,
                    "advertisement": advertisement,
                    "commentary": saleCommentary,
                    "noUpdateKardex": false,
                    "flag_charged": 0,
                };
                $.ajax({
                    method: "POST",
                    url: "/api/new-sale",
                    context: document.body,
                    data: data.sale,
                    statusCode: {
                        400: function(response) {
                            $('#modal-on-load').modal('toggle');
                            $('#modal-error-step').modal({ backdrop: 'static', keyboard: false });
                        },
                        500: function(response) {
                            $('#modal-on-load').modal('toggle');
                            $('#modal-error-step').modal({ backdrop: 'static', keyboard: false });
                        },
                    }
                }).done(function(response) {
                    idNewSale = response.id;
                    $('#modal-on-load').modal('hide');
                    $('#modal-final-step').modal({ backdrop: 'static', keyboard: false });
                });
            }
        }
        function printSalePdf() {
            if (idNewSale != 0) {
                window.open('/api/print-sale-pdf-by-id/' + idNewSale);
            } else {
                alert("No se puede imprimir la venta");
            }
        }
        function salesList() {
            location = "/sales";
        }
        function priceList() {
            priceLists = [];
            var ulPriceList = document.getElementById("priceListUl");
            ulPriceList.innerHTML = '<div class="col-sm-12" align="center"><div class="box-header"><h3 class="box-title">Cargando ...</h3><i class="fa fa-refresh fa-spin"></i></div></div><br><br>';
            $.ajax({
                url: "/api/price-list",
                context: document.body
            }).done(function(response) {
                ulPriceList.innerHTML = "";
                response.forEach(element => {
                    var li = document.createElement('li');
                    li.innerHTML = '<button class="btn" onClick="changePriceList(' + element.id + ')">NOMBRE: ' + element.name + ' - MONEDA: ' + element.currency + ' (' + element.symbol_code + ')</button><br>';
                    ulPriceList.appendChild(li);
                    priceLists.push(element);
                });
            });
        }
        function sendSaleEmail() {
            if (data.customer.email == 'CLIENTE@GENERICO.COM') {
                alert("No se puede enviar correo a un cliente genérico.");
            } else {
                $.ajax({
                    url: '/api/send-email/' + data.customer.email + '/' + idNewSale,
                    context: document.body,
                    statusCode: {
                        400: function() {
                            var sendSaleEmail = document.getElementById('sendSaleEmail');
                            sendSaleEmail.className = 'btn btn-danger';
                            sendSaleEmail.innerHTML = 'Problema al enviar correo';
                            sendSaleEmail.disabled = true;
                        }
                    }
                }).done(function(response) {
                    var sendSaleEmail = document.getElementById('sendSaleEmail');
                    sendSaleEmail.className = 'btn btn-success';
                    sendSaleEmail.innerHTML = 'Se envió el correo';
                    sendSaleEmail.disabled = true;
                });
            }
        }
        function callProductsListeners(product){
            document.getElementById('row_' + product.id).addEventListener("click", function() {
                if (data.rowClickedId != 0) {
                    var oldRowClicked = document.getElementById('row_' + data.rowClickedId);
                    if (oldRowClicked != null) {
                        oldRowClicked.style.backgroundColor = '#2c3b41';        
                    }
                }
                data.rowClickedId = product.id;
                //REFACTOR_NEW
                // setInterval();                
            });
            document.getElementById('quantityProduct_' + product.id).addEventListener("keyup", function(event) {
                event.preventDefault();
                var quantityProduct__ = parseFloat(document.getElementById('quantityProduct_' + product.id).value);
                if (data.selectedProducts[product.id].stock < document.getElementById('quantityProduct_' + product.id).value) {
                    data.selectedProducts[product.id].quantity = data.selectedProducts[product.id].stock;
                    document.getElementById('quantityProduct_' + product.id).value = data.selectedProducts[product.id].stock;
                    alert("El stock actual es menor que la cantidad ingresada.");
                } else if (isNaN(quantityProduct__) || quantityProduct__ == 0 || quantityProduct__ < 0) {
                    document.getElementById('quantityProduct_' + product.id).value = 1;
                    data.selectedProducts[product.id].quantity = 1;
                    quantityValue = 0;
                    universalPromoBoolean = false;
                    data.selectedProducts.forEach(element => {
                        if (element.quantity > 0) {
                            amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                            if (element.flagUniversalPromo) {
                                quantityValue = parseFloat(quantityValue) + parseFloat(element.quantity);
                                if (quantityValue >= universalPromoValue) {
                                    universalPromoBoolean = true;
                                    universalPromo();
                                }   
                            }
                        }
                    });
                    if (data.selectedProducts[product.id].flagUniversalPromo) {
                        universalPromo();   
                    }
                } else {
                    data.selectedProducts[product.id].quantity = document.getElementById('quantityProduct_' + product.id).value;
                    quantityValue = 0;
                    universalPromoBoolean = false;
                    data.selectedProducts.forEach(element => {
                        if (element.quantity > 0) {
                            amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                            if (element.flagUniversalPromo) {
                                quantityValue = parseFloat(quantityValue) + parseFloat(element.quantity);
                                if (quantityValue >= universalPromoValue) {
                                    universalPromoBoolean = true;
                                    universalPromo();
                                }   
                            }
                        }
                    });
                    var quantityWSP = quantityUniversalPromo(data.selectedProducts[product.id]);
                    if (document.getElementById('quantityProduct_' + product.id).value >= quantityWSP) {
                        data.selectedProducts[product.id].price = data.selectedProducts[product.id].wholeSalePrice - data.selectedProducts[product.id].partialDiscount;
                        document.getElementById('priceProduct_' + product.id).value = data.selectedProducts[product.id].price;
                    } else {
                        data.selectedProducts[product.id].price = data.selectedProducts[product.id].originalPrice - data.selectedProducts[product.id].partialDiscount;
                        document.getElementById('priceProduct_' + product.id).value = data.selectedProducts[product.id].price;
                    }
                    if (data.selectedProducts[product.id].flagUniversalPromo) {
                        universalPromo();   
                    }
                }
                //REFACTOR_NEW
                // setInterval();                
            });
            //REFACTOR_NEW
            // setInterval();
        }
        function paymentReadjustment(paymentValue, paymentId) {
            paymentAmounts[paymentId].value = paymentValue;
            paymentAmount = 0;
            paymentAmounts.forEach(element => {
                paymentAmount = paymentAmount + parseFloat(element.value);
            });
            var generalDiscount_ = parseFloat(document.getElementById('generalDiscount').value);
            var typeGeneralDiscount = document.getElementById('typeGeneralDiscount').value;
            if (typeGeneralDiscount == 1) {
                generalDiscount_ = (amountValue_/100)*generalDiscount_;
            }
            var exchange = paymentAmount - (parseFloat(amountValue) - generalDiscount_ - promoDiscount__);
            if (isNaN(paymentAmount) || paymentAmount < (parseFloat(amountValue) - generalDiscount_ - promoDiscount__)) {
                var x__ = document.getElementById('finishNewSale');
                x__.disabled = true;
                var saleErrorMessage = document.getElementById('saleErrorMessage');
                saleErrorMessage.innerHTML = 'Monto de ingreso menor a la venta.';
                buttonVd_ = false;
                saleErrorMessage.className = 'btn btn-danger pull-center';
            } else {
                var x__ = document.getElementById('finishNewSale');
                x__.disabled = false;
                var saleErrorMessage = document.getElementById('saleErrorMessage');
                saleErrorMessage.innerHTML = 'Validación correcta.';
                buttonVd_ = true;
                saleErrorMessage.className = 'btn btn-success pull-center';
            }
            if (exchange > 0) {
                document.getElementById('cashInputExchange').value = exchange;
            } else {
                document.getElementById('cashInputExchange').value = 0;
            }
        }
        function applyPromotions() {
            //AVISO SPINNER
            document.getElementById('promotionLoadingTrue').style.display = 'block';
            document.getElementById('promotionLoadingFalse').style.display = 'none';
            //CARGAR PROMOCIONES
            var conditionClients    = false;
            var conditionWarehouse  = false;
            var conditionPromotions = false;
            //VERIFICAR ALMACENES
            promotionsData.forEach(element => {
                if (element.warehouses) {
                    element.warehouses.forEach(elementWarehouse => {
                        if (companyLoginData.warehouseId == elementWarehouse) {
                            conditionWarehouse = true;
                        }
                    });
                }
            });
            //VERIFICAR CLIENTES
                //REFACTORIZAR
            //CARGAR PRODUCTS
            if (conditionWarehouse) {
                intervalPriceList = false;
                data.selectedProducts.forEach(element => {
                    promotionsData.forEach(elementPromo => {
                        var promoDiscount = 0;
                        if (elementPromo.promotion.equal) {
                            if (elementPromo.promotion.quantity == element.quantity) {
                                //BRANDS
                                elementPromo.promotion.brands.forEach(elementBrand => {
                                    if (elementBrand == element.brandId) {
                                        promoDiscount = promoDiscount + parseFloat(elementPromo.discount);
                                    }
                                });
                                //CATEGORIES
                                elementPromo.promotion.categories.forEach(elementCategory => {
                                    if (elementCategory == element.categoryId) {
                                        promoDiscount = promoDiscount + parseFloat(elementPromo.discount);
                                    }
                                });
                                //PRODUCTS
                                elementPromo.promotion.products.forEach(elementProduct => {
                                    if (elementProduct == element.id) {
                                        promoDiscount = promoDiscount + parseFloat(elementPromo.discount);                                        
                                    }
                                });
                                //FEATURES
                                //REFACTORIZAR
                                // elementPromo.promotion.features.forEach(elementFeature => {
                                //     promoDiscount = promoDiscount + parseFloat(elementPromo.discount);
                                // });
                            }
                        } else {
                            if (elementPromo.promotion.quantity <= element.quantity) {
                                //BRANDS
                                elementPromo.promotion.brands.forEach(elementBrand => {
                                    if (elementBrand == element.brandId) {
                                        promoDiscount = promoDiscount + parseFloat(elementPromo.discount)*element.quantity;
                                    }
                                });
                                //CATEGORIES
                                elementPromo.promotion.categories.forEach(elementCategory => {
                                    if (elementCategory == element.categoryId) {
                                        promoDiscount = promoDiscount + parseFloat(elementPromo.discount)*element.quantity;
                                    }
                                });
                                //PRODUCTS
                                elementPromo.promotion.products.forEach(elementProduct => {
                                    if (elementProduct == element.id) {
                                        promoDiscount = promoDiscount + parseFloat(elementPromo.discount)*element.quantity;                                        
                                    }
                                });
                                //FEATURES
                                //REFACTORIZAR
                                // elementPromo.promotion.features.forEach(elementFeature => {
                                //     promoDiscount = promoDiscount + parseFloat(elementPromo.discount);
                                // });
                            }
                        }
                        if (elementPromo.promoDiscountValue) {
                            elementPromo.promoDiscountValue = parseFloat(elementPromo.promoDiscountValue) + parseFloat(promoDiscount);
                        } else {
                            elementPromo.promoDiscountValue = parseFloat(promoDiscount);
                        }
                        promoDiscount__ = parseFloat(promoDiscount__) + parseFloat(promoDiscount);
                    });
                    //LLAMAR A LAS PROMOCIONES Y APLICARLAS EN PRECIOS DE PRODUCTOS
                });
                document.getElementById('promotionDiscount').value = promoDiscount__;
                document.getElementById('promotionLoadingTrue').style.display = 'none';
                setInterval();
                //MENSAJE DE PROMOCIONES ACTIVADAS
                var promotionsActive = document.getElementById('promotionsActive');
                if (promotionsActive != null) {
                    var text_ = '';
                    promotionsData.forEach(element => {
                        var class_ = 'btn btn-danger';
                        if (element.promoDiscountValue != 0) {
                            class_ = 'btn btn-success';
                        }
                        text_ = text_ +  '<li class="form-control '+ class_ +'">' + element.name + ' - ' + element.description + ' - <strong>DESCUENTO: ' + parseFloat(element.promoDiscountValue) + '</strong></li>';
                    });
                    promotionsActive.innerHTML = text_;
                }
                $('#modal-promotions-active').modal({ backdrop: 'static', keyboard: false });
            } else {
                $('#toggle-two').prop('checked', 'false');
                $('#toggle-two').trigger('click');
                document.getElementById('promotionLoadingTrue').style.display = 'none';
                document.getElementById('messagePromotionsInactive').innerHTML = 'ESTA TIENDA NO CUENTA CON PROMOCIONES';
                $('#modal-promotions-inactive').modal({ backdrop: 'static', keyboard: false });
            }
        }
        function removePromotions() {
            //AVISO SPINNER
            document.getElementById('promotionDiscount').value = '0.00';
            document.getElementById('promotionLoadingTrue').style.display = 'none';
            document.getElementById('promotionLoadingFalse').style.display = 'block';
            intervalPriceList = true;
            //CARGAR PRODUCTS
            promotionsData.forEach(elementPromo => {
                //QUITAR A LAS PROMOCIONES
                elementPromo.promoDiscountValue = 0;
            });
            promoDiscount__ = 0;
            document.getElementById('promotionLoadingFalse').style.display = 'none';
            //MENSAJE DE PROMOCIONES DESACTIVADAS
            document.getElementById('messagePromotionsInactive').innerHTML = 'SE DESACTIVARON LAS PROMOCIONES';
            $('#modal-promotions-inactive').modal({ backdrop: 'static', keyboard: false });
        }
        //var functions
        searchQuotationCheckbox = function () {
            if (searchQuotationObj != null) {
                searchQuotationObj.forEach(elementObject => {
                    elementObject.items.forEach(element => {
                        var checkBoxSearchQuotation_ = document.getElementById('checkBoxSearchQuotation_' + element.id);
                        if (checkBoxSearchQuotation_ != null && checkBoxSearchQuotation_.disabled == false) {
                            document.getElementById('checkBoxSearchQuotation_' + element.id).checked = document.getElementById('mainCheckBoxSearchQuotation_' + elementObject.id).checked;                        
                        }
                    });
                });                
            }
        }
        saveSearchQuotationSubmit = function () {
            if (searchQuotationObj != null) {
                searchQuotationObj.forEach(elementObj => {
                    var selectedQuotation = {
                        id: elementObj.id,
                        ticket: elementObj.ticket,
                        createdAt: elementObj.created_at,
                        totalProducts: elementObj.items.length,
                        quotationProducts: []
                    };
                    elementObj.items.forEach(element => {
                        var checkBoxSearchQuotation_ = document.getElementById('checkBoxSearchQuotation_' + element.id);
                        if (checkBoxSearchQuotation_ != null && checkBoxSearchQuotation_.checked) {
                            var quantitySearchQuotationValue = document.getElementById('quantitySearchQuotation_' + element.id).value;
                            if (Number(quantitySearchQuotationValue) > 0) {
                                if (parseFloat(element.quantity) < quantitySearchQuotationValue) {
                                    quantitySearchQuotationValue = parseFloat(element.quantity);
                                }
                                // selectedQuotations
                                var productElement = element;
                                var selectedProductQuotation = {
                                    id: productElement.id,
                                    quantity: quantitySearchQuotationValue
                                };
                                selectedQuotation.quotationProducts.push(selectedProductQuotation);
                                // selectedProducts
                                productElement.quantity = quantitySearchQuotationValue;
                                productElement.id = productElement.war_products_id;
                                productElement.partialDiscount = 0;
                                data.products[productElement.war_products_id] = productElement;
                                addSelectedProduct(productElement.war_products_id, false);
                            }
                        }
                    });
                    if (selectedQuotation.quotationProducts.length > 0) {
                        data.selectedQuotations.push(selectedQuotation);                        
                    }
                });
            }
            var searchSaleFormBtn = document.getElementById('searchSaleForm');
            if (searchSaleFormBtn != null) {
                searchSaleFormBtn.disabled = true;
                // document.getElementById('inputSearchClient').value = '';
            }
            var table = $('#searchQuotationTable').DataTable();
            table.destroy();
            $('#modal-search-sale').modal('toggle');
        }
        searchSaleForm = function () {
            var genericCustomer_ = JSON.parse(document.getElementById("genericCustomer").value);
            $('#modal-search-sale').modal({ backdrop: 'static', keyboard: false });
            searchQuotationObj = null;
            var customerId__ = data.customerId;
            var table = $('#searchQuotationTable').DataTable();
            table.destroy();
            table = $('#searchQuotationTable').DataTable({
                // "scrollX": true,
                "processing": true,
                "orderCellsTop": true,
                "order" : [[ 5, "desc" ]],
                // "fixedHeader": true,
                "lengthChange": false,
                "language": {
                    "url": "/js/languages/datatables/es.json"
                },
                "serverSide": false,
                "paging": true,
                "ordering": true,
                "searching": true,
                "ajax": function(data, callback, settings) {
                        $.get('/api/search-document-by-date-range/COT?sal_sale_states_id=5&dateRange=' + $('#dateRange').val(), {
                            limit: data.length,
                            offset: data.start,
                            }, function(res) {
                                arraySales = [];
                                res.forEach(element => {
                                    arraySales[element.id] = element;
                                });
                                var searchQuotationDataDetailResponse = '<h3>Ventas al crédito disponibles: ' + res.length + '</h3>';
                                var searchQuotationDataDetail = document.getElementById('searchQuotationDataDetail');
                                searchQuotationDataDetail.innerHTML = searchQuotationDataDetailResponse;
                                searchQuotationObj = res;
                                callback({
                                    recordsTotal: res.length,
                                    recordsFiltered: res.length,
                                    data: res
                                });
                            });
                },
                "columns" : [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {'data':   function (data, type, dataToSet) {
                        var message = '';
                        if (data.customer_ruc != '' && data.customer_ruc != null) {
                            message = 'RUC: ' + data.customer_ruc;
                        } else {
                            message = 'DNI: ' + data.customer_dni;
                        }
                        var customerName = '';
                        if (data.customer_flag_type_person == 1) {
                            customerName = data.customer_name + ' ' + data.customer_lastname;
                        } else {
                            customerName = data.customer_rz_social;
                        }
                        arraySales[data.id].clientInfo = message + '<br><b>' + customerName + '</b>';
                        return message + '<br><b>' + customerName + '</b>';
                    }},
                    { "data": "ticket" },
                    { "data": function (data) {
                        return data.items.length;
                    }},
                    { "data": "currency" },
                    { "data": function (data) {
                        return parseFloat(data.amount);
                    }},
                    { "data": "created_at" }
                ],
                "responsive": true,
                "bDestroy": true,
            });

            // Add event listener for opening and closing details
            $('#searchQuotationTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );            
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    // row.child.hide();
                    // tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
        }
        showProductDetail = function (id) {
            document.getElementById('productDetailStockPriceListTBody').innerHTML = '';
            var product = data.products[id];
            document.getElementById('productDetailHeader').innerHTML = product.name;
            if (product.description == null) {
                document.getElementById('productDetailDescription').innerHTML = 'SIN DESCRIPCIÓN';
            } else {
                document.getElementById('productDetailDescription').innerHTML = product.description;
            }
            document.getElementById('productDetailCode').innerHTML = product.code;
            document.getElementById('productDetailAutoBarCode').innerHTML = product.autoBarcode;
            document.getElementById('productDetailCategory').innerHTML = product.categoryName;
            document.getElementById('productDetailModel').innerHTML = product.model;
            document.getElementById('productDetailBrand').innerHTML = product.brandName;
            $('#modal-product-detail').modal({ backdrop: 'static', keyboard: false });
            $.ajax({
                url: "/api/products/" + id + "/for-detail",
                context: document.body
            }).done(function(response) {
                // productDetailStockPriceListTBody
                var productDetailStockPriceListTBody_ = '';
                response.warehouses.forEach(element => {
                    if (element.price_list == null) {
                        var priceList = {
                            price: 0,
                            quantity: 0,
                            wholeSalePrice: 0,
                        };
                        var location = 'SIN DATOS';
                    } else {
                        if (data.priceListId != 0) {
                            priceList = element.price_list[data.priceListId];
                        } else {
                            var priceList = Object.keys(element.price_list)[0];
                            priceList = element.price_list[priceList];
                        }
                        var location = element.location;
                        if (location == null) {
                            location = 'SIN DATOS';
                        }
                    }
                    productDetailStockPriceListTBody_ = productDetailStockPriceListTBody_ + 
                    '<tr>'+
                        '<td> '+ element.name +' </td>'+
                        '<td> '+ location +' </td>'+
                        '<td> '+ element.stock +' </td>'+
                        '<td> '+ priceList.price +' </td>'+
                        '<td> '+ priceList.quantity +' </td>'+
                        '<td> '+ priceList.wholeSalePrice +' </td>'+
                    '</tr>';
                });
                document.getElementById('productDetailStockPriceListTBody').innerHTML = productDetailStockPriceListTBody_;
            });
        }
        promoChangePrices = function (checkbox) {
            if (checkbox.checked) {
                applyPromotions();
            } else {
                removePromotions();
            }
        }
        newSaleButtonN = function() {
            location.reload();
        }
        newSettingsForm = function() {
            document.getElementById('sale_order').value = saleOrder;
            document.getElementById('advertisement').value = advertisement;
            document.getElementById('remission_guide').value = remissionGuide;
            document.getElementById('commentary').value = saleCommentary;

            searchQuotationObj.forEach(element => {
                data.selectedQuotations.forEach(elementQ => {
                    if (element.id === elementQ.id) {
                        document.getElementById('remission_guide').value = element.ticket;
                        document.getElementById('sale_order').value = element.sale_order;
                        document.getElementById('new_user_assignment').value = element.user_id;
                    }
                });
            });
            $('#modal-new-settings').modal({ backdrop: 'static', keyboard: false });
        }
        saveNewSettings = function() {
            saleOrder = document.getElementById('sale_order').value;
            advertisement = document.getElementById('advertisement').value;
            remissionGuide = document.getElementById('remission_guide').value;
            saleCommentary = document.getElementById('commentary').value;
        }
        openTypeDocument = function() {
            var userTypePayments = companyLoginData.type_documents.split(',');
            if (userTypePayments.length == 1) {
                var element = typeDocumentNames[parseInt(userTypePayments[0])];
                typeDocumentCode = element.code;
                typeDocumentName = element.name;
            }
            if (userTypePayments.length > 1) {
                var typeDocumentsListText_ = '';
                userTypePayments.forEach(element => {
                    typeDocumentsListText_ = typeDocumentsListText_ + '<button style="margin:20px;" type="button" class="btn btn-'+ typeDocumentNames[element].htmlClass +'" onClick="changeTypeDocument('+ element +');" data-dismiss="modal">'+ typeDocumentNames[element].name +'</button>';
                });
                var typeDocumentsList = document.getElementById('typeDocumentsList');
                typeDocumentsList.innerHTML = typeDocumentsListText_;
                $("#modal-type-document").modal({backdrop: 'static', keyboard: false});
                $("#modal-type-document").appendTo("body");
            }
        }
        changeTypeDocument = function(id) {
            var element = typeDocumentNames[parseInt(id)];
            typeDocumentCode = element.code;
            typeDocumentName = element.name;
            var pResume = document.getElementById('totalResumeAmount');
            pResume.innerHTML = '<b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue);
            var buttonTypeDocument = document.getElementById('buttonTypeDocument');
            buttonTypeDocument.innerHTML = typeDocumentName.substring(0,1);
            setInterval();
        }
        changePriceList = function(id) {
            var object = null;
            priceLists.forEach(element => {
                if (element.id == id) {
                    object = element;
                }
            });
            if (object != null) {
                data.currency = object.currency;
                data.symbolCode = object.symbol_code;
                data.priceListId = object.id;
                $('#closePriceListModal').trigger('click');
                clearAllSelectedProduct();
                loadProducts(data.buttonCategory);
            } else {
                alet("Ocurrió un error en la lista de precios. Por favor, vuelva a intentar.");
            }
            
        }
        optionPad = function(option) {
            switch (option) {
                case 1:
                    clearPadNumberOption1();
                    data.padOption = 1;
                    if (data.rowClickedId != 0) {
                        document.getElementById('quantityProduct_' + data.rowClickedId).select();
                        document.getElementById('quantityButtonPad').style.backgroundColor = '#9daeb8';
                        document.getElementById('partialCashDiscountButtonPad').style.backgroundColor = '#ffffff';
                        document.getElementById('partialPercentDiscountButtonPad').style.backgroundColor = '#ffffff';
                    } else {
                        alert('Seleccione un producto de la tabla para editar.');
                    }
                    break;
                case 2:
                    clearPadNumberOption2();
                    data.padOption = 2;
                    if (data.rowClickedId != 0) {
                        document.getElementById('partialDiscount_' + data.rowClickedId).select();
                        document.getElementById('quantityButtonPad').style.backgroundColor = '#ffffff';
                        document.getElementById('partialCashDiscountButtonPad').style.backgroundColor = '#9daeb8';
                        document.getElementById('partialPercentDiscountButtonPad').style.backgroundColor = '#ffffff';
                        var symbol_ = document.getElementById('partialDiscountSymbol_' + data.rowClickedId);
                        symbol_.innerHTML = data.symbolCode;
                    } else {
                        alert('Seleccione un producto de la tabla para editar.');
                    }
                    break;
                case 3:
                    clearPadNumberOption3();
                    data.padOption = 3;
                    if (data.rowClickedId != 0) {
                        document.getElementById('partialDiscount_' + data.rowClickedId).select();
                        document.getElementById('quantityButtonPad').style.backgroundColor = '#ffffff';
                        document.getElementById('partialCashDiscountButtonPad').style.backgroundColor = '#ffffff';
                        document.getElementById('partialPercentDiscountButtonPad').style.backgroundColor = '#9daeb8';
                        var symbol_ = document.getElementById('partialDiscountSymbol_' + data.rowClickedId);
                        symbol_.innerHTML = "% ";
                    } else {
                        alert('Seleccione un producto de la tabla para editar.');
                    }
                    break;            
                default:
                    break;
            }
        }
        clearPadNumber = function() {
            switch (data.padOption) {
                case 1:
                    clearPadNumberOption1();
                    break;
                case 2:
                    clearPadNumberOption2();
                    break;
                case 3:
                    clearPadNumberOption3();
                    break;            
                default:
                    break;
            }
        }
        setPadNumber = function(char) {
            switch (data.padOption) {
                case 1:
                    setPadNumberOption1(char);
                    break;
                case 2:
                    setPadNumberOption2(char);
                    break;
                case 3:
                    setPadNumberOption3(char);
                    break;            
                default:
                    alert("Seleccione una opción de modificación.");
                    break;
            }
        }
        clearPadNumberOption1 = function() {
            if (data.rowClickedId != 0) {
                var input_ = document.getElementById('quantityProduct_' + data.rowClickedId);
                input_.value = '0';
                data.selectedProducts[data.rowClickedId].quantity = 0;
                quantityValue = 0;
                universalPromoBoolean = false;
                data.selectedProducts.forEach(element => {
                    if (element.quantity > 0) {
                        amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                        if (element.flagUniversalPromo) {
                            quantityValue = parseFloat(quantityValue) + parseFloat(element.quantity);
                            if (quantityValue >= universalPromoValue) {
                                universalPromoBoolean = true;
                                universalPromo();
                            }   
                        }
                    }
                });
                universalPromo();
            } else {
                alert('Seleccione un producto de la tabla para editar.');
            }
            //REFACTOR_NEW
            // setInterval();
        }
        clearPadNumberOption2 = function() {
            if (data.rowClickedId != 0) {
                var input_ = document.getElementById('partialDiscount_' + data.rowClickedId);
                input_.value = '0';
                data.selectedProducts[data.rowClickedId].partialDiscount = 0;
                var quantityWSP = quantityUniversalPromo(data.selectedProducts[data.rowClickedId]);
                if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                } else {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice;
                }
                document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
            } else {
                alert('Seleccione un producto de la tabla para editar.');
            }
            //REFACTOR_NEW
            // setInterval();
        }
        clearPadNumberOption3 = function() {
            if (data.rowClickedId != 0) {
                var input_ = document.getElementById('partialDiscount_' + data.rowClickedId);
                input_.value = '0';
                data.selectedProducts[data.rowClickedId].partialDiscount = 0;
                var quantityWSP = quantityUniversalPromo(data.selectedProducts[data.rowClickedId]);
                if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                } else {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice;
                }
                document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
            } else {
                alert('Seleccione un producto de la tabla para editar.');
            }
            //REFACTOR_NEW
            // setInterval();
        }
        setPadNumberOption1 = function(char) {
            if (data.rowClickedId != 0) {
                var input_ = document.getElementById('quantityProduct_' + data.rowClickedId);
                if (input_.value == '0') {
                    input_.value = char;    
                } else {
                    input_.value = input_.value + char;
                }
                var quantityProduct__ = parseFloat(document.getElementById('quantityProduct_' + data.rowClickedId).value);
                var quantityWSP = quantityUniversalPromo(data.selectedProducts[data.rowClickedId]);
                if (data.selectedProducts[data.rowClickedId].stock < document.getElementById('quantityProduct_' + data.rowClickedId).value) {
                    data.selectedProducts[data.rowClickedId].quantity = data.selectedProducts[data.rowClickedId].stock;
                    document.getElementById('quantityProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].stock;
                    alert("El stock actual es menor que la cantidad ingresada.");
                } else if (isNaN(quantityProduct__) || quantityProduct__ == 0 || quantityProduct__ < 0) {
                    data.selectedProducts[data.rowClickedId].quantity = 0;
                } else {
                    if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice - data.selectedProducts[data.rowClickedId].partialDiscount;
                        document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
                    } else {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice - data.selectedProducts[data.rowClickedId].partialDiscount;
                        document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
                    }
                    data.selectedProducts[data.rowClickedId].quantity = document.getElementById('quantityProduct_' + data.rowClickedId).value;
                }
                universalPromo();
            } else {
                alert('Seleccione un producto de la tabla para editar.');
            }
            //REFACTOR_NEW
            // setInterval();
        }
        setPadNumberOption2 = function(char) {
            if (data.rowClickedId != 0) {
                var input_ = document.getElementById('partialDiscount_' + data.rowClickedId);
                if (input_.value == '0') {
                    input_.value = char;    
                } else {
                    input_.value = input_.value + char;
                }
                var quantityWSP = quantityUniversalPromo(data.selectedProducts[data.rowClickedId]);
                //LOGIC                
                if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                } else {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice;
                }
                var discount = document.getElementById('partialDiscount_' + data.rowClickedId);
                var amountValue__ = parseFloat(discount.value);
                //MONTO DE DESCUENTO MAYOR AL PRECIO
                if (amountValue__ > data.selectedProducts[data.rowClickedId].price) {
                    if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                        discount.value = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                        data.selectedProducts[data.rowClickedId].partialDiscount = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                        data.selectedProducts[data.rowClickedId].price = 0;
                        document.getElementById('priceProduct_' + data.rowClickedId).value = 0;
                    } else {
                        discount.value = data.selectedProducts[data.rowClickedId].originalPrice;
                        data.selectedProducts[data.rowClickedId].partialDiscount = data.selectedProducts[data.rowClickedId].originalPrice;
                        data.selectedProducts[data.rowClickedId].price = 0;
                        document.getElementById('priceProduct_' + data.rowClickedId).value = 0;
                    }
                } 
                //MONTO DE DESCUENTO 0 O MENOR A 0
                else if (amountValue__ == 0 || amountValue__ < 0) {
                    if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                    } else {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice;
                    }
                    data.selectedProducts[data.rowClickedId].partialDiscount = 0;
                    discount.value = 0;
                    document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
                } 
                //MONTO DE DESCUENTO OPERATIVO Y VÁLIDO
                else {
                    if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice - amountValue__;
                    } else {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice - amountValue__;
                    }
                    data.selectedProducts[data.rowClickedId].partialDiscount = amountValue__;
                    document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
                }
            } else {
                alert('Seleccione un producto de la tabla para editar.');
            }
            //REFACTOR_NEW
            // setInterval();
        }
        setPadNumberOption3 = function(char) {
            if (data.rowClickedId != 0) {
                var input_ = document.getElementById('partialDiscount_' + data.rowClickedId);
                if (input_.value == '0') {
                    input_.value = char;    
                } else {
                    input_.value = input_.value + char;
                }
                var quantityWSP = quantityUniversalPromo(data.selectedProducts[data.rowClickedId]);
                //LOGIC
                if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                } else {
                    data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice;
                }
                var discount = document.getElementById('partialDiscount_' + data.rowClickedId);
                var amountValue__ = (data.selectedProducts[data.rowClickedId].price * (parseFloat(discount.value)/100));
                if (amountValue__ > data.selectedProducts[data.rowClickedId].price) {
                    if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                        discount.value = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                        data.selectedProducts[data.rowClickedId].partialDiscount = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                        data.selectedProducts[data.rowClickedId].price = 0;
                        document.getElementById('priceProduct_' + data.rowClickedId).value = 0;
                    } else {
                        discount.value = data.selectedProducts[data.rowClickedId].originalPrice;
                        data.selectedProducts[data.rowClickedId].partialDiscount = data.selectedProducts[data.rowClickedId].originalPrice;
                        data.selectedProducts[data.rowClickedId].price = 0;
                        document.getElementById('priceProduct_' + data.rowClickedId).value = 0;
                    }
                } else if (amountValue__ == 0 || amountValue__ < 0) {
                    if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice;
                    } else {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice;
                    }
                    data.selectedProducts[data.rowClickedId].partialDiscount = 0;
                    discount.value = 0;
                    document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
                } else {
                    if (document.getElementById('quantityProduct_' + data.rowClickedId).value >= quantityWSP) {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].wholeSalePrice - amountValue__;
                    } else {
                        data.selectedProducts[data.rowClickedId].price = data.selectedProducts[data.rowClickedId].originalPrice - amountValue__;
                    }
                    data.selectedProducts[data.rowClickedId].partialDiscount = amountValue__;
                    document.getElementById('priceProduct_' + data.rowClickedId).value = data.selectedProducts[data.rowClickedId].price;
                }
            } else {
                alert('Seleccione un producto de la tabla para editar.');
            }
            //REFACTOR_NEW
            // setInterval();
        }
        loadProducts = function(id) {
            document.getElementById("productsDivList").innerHTML = "";
            var selectedCategories = id;
            if (selectedCategories != 0) {
                var x = document.getElementById("loadingDiv");
                var productsDivList = document.getElementById("productsDivList");
                if (data.buttonCategory != 0) {
                    var btnCategoryOld = document.getElementById("buttonCategory-" + data.buttonCategory);
                    btnCategoryOld.disabled = false;
                    btnCategoryOld.style.backgroundColor = "#9daeb8";
                }
                data.buttonCategory = id;
                var btnCategoryNew = document.getElementById("buttonCategory-" + id);
                if (btnCategoryNew != null) {
                    btnCategoryNew.disabled = true;
                    btnCategoryNew.style.backgroundColor = "#ffffff";                
                }
                if (x.style.display === "none") {
                    productsDivList.style.display = "none";
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
                $.ajax({
                    url: "/api/products-list?priceListId=" + data.priceListId + "&categoryId=" + selectedCategories,
                    context: document.body
                }).done(function(response) {
                    x.style.display = "none";
                    data.products = [];
                    var onlyProductsSelectedIds = [];
                    data.selectedProducts.forEach(element => {
                        onlyProductsSelectedIds.push(element.id);
                    });
                    var count_ = response.length;
                    for(i = 0; i < response.length; i++) {
                        var id = response[i].id;
                        data.products[id] = response[i];
                        var description = response[i].description;
                        var urlImage = response[i].urlImage;
                        if (response[i].description == null || response[i].description == "") {
                            description = "SIN DESCRIPCIÓN";
                        }
                        if (response[i].urlImage == null) {
                            urlImage = "/img/new_ic_logo_short.png";
                        }
                        var condition_ = onlyProductsSelectedIds.includes(response[i].id);
                        if (count_ < 6) {
                            var buttonHeadClass_ = '<div align="center" class="info-box-custom-2" id="infoBoxProduct_' + response[i].id + '">';
                            if (response[i].stock < 1) {
                                buttonHeadClass_ = '<div align="center" class="info-box-custom-2-cancel" id="infoBoxProduct_' + response[i].id + '>';
                            }
                            var description__ = response[i].description;
                            if (description__ != null) {
                                description__ = description__.substring(0, 48);
                            } else {
                                description__ = 'SIN DESCRIPCIÓN';
                            }
                            var element = buttonHeadClass_ +
                                '<div class="card-custom">'+
                                '   <div onClick="showProductDetail('+ + response[i].id +')">'+
                                '       <img src="' + urlImage + '" style="height:100px; width:100px;">'+
                                '   </div>';
                            if (response[i].stock < 1) {
                                element = element + 
                                    '   <div class="container-custom">'+
                                    '       <h5 style="font-size:12px; font-weight:bold;">' + response[i].name + '</h5>'+
                                    '       <p style="font-size:10px;margin-bottom:5px">' + data.symbolCode + ' ' + response[i].price + ' <br>(Stock: ' + response[i].stock + ')</p>'+
                                    '       <p style="font-size:8px;">' + description__ + '</p>'+
                                    '   </div>'+
                                    '</div>'+
                                '</div>';
                            } else {
                                element = element + 
                                    '   <div class="container-custom" id="infoBoxProductFunction_' + response[i].id + '" onclick="addSelectedProduct( ' + response[i].id + ' );">'+
                                    '       <h5 style="font-size:12px; font-weight:bold;">' + response[i].name + '</h5>'+
                                    '       <p style="font-size:10px;margin-bottom:5px">' + data.symbolCode + ' ' + response[i].price + ' <br>(Stock: ' + response[i].stock + ')</p>'+
                                    '       <p style="font-size:8px;">' + description__ + '</p>'+
                                    '   </div>'+
                                    '</div>'+
                                '</div>';
                            }
                        } else {
                            var buttonHeadClass_ = '<div align="center" class="info-box-custom" id="infoBoxProduct_' + response[i].id + '">';
                            if (response[i].stock < 1) {
                                buttonHeadClass_ = '<div align="center" class="info-box-custom-cancel" id="infoBoxProduct_' + response[i].id + '>';
                            }
                            var description__ = response[i].description;
                            if (description__ != null) {
                                description__ = description__.substring(0, 48);
                            } else {
                                description__ = 'SIN DESCRIPCIÓN';
                            }
                            var element = buttonHeadClass_ +
                                '<div class="card-custom">'+
                                '   <div onClick="showProductDetail('+ + response[i].id +')">'+
                                '       <img src="' + urlImage + '" style="height:100px; width:100px;">'+
                                '   </div>';
                            if (response[i].stock < 1) {
                                element = element + 
                                    '   <div class="container-custom">'+
                                    '       <h5 style="font-size:12px; font-weight:bold;">' + response[i].name + '</h5>'+
                                    '       <p style="font-size:10px;margin-bottom:5px">' + data.symbolCode + ' ' + response[i].price + ' <br>(Stock: ' + response[i].stock + ')</p>'+
                                    '       <p style="font-size:8px;">' + description__ + '</p>'+
                                    '   </div>'+
                                    '</div>'+
                                '</div>';                                    
                            } else {
                                element = element + 
                                    '   <div class="container-custom" id="infoBoxProductFunction_' + response[i].id + '" onclick="addSelectedProduct( ' + response[i].id + ' );">'+
                                    '       <h5 style="font-size:12px; font-weight:bold;">' + response[i].name + '</h5>'+
                                    '       <p style="font-size:10px;margin-bottom:5px">' + data.symbolCode + ' ' + response[i].price + ' <br>(Stock: ' + response[i].stock + ')</p>'+
                                    '       <p style="font-size:8px;">' + description__ + '</p>'+
                                    '   </div>'+
                                    '</div>'+
                                '</div>';
                            }
                        }
                        productsDivList.style.display = "block";
                        $('#productsDivList').append(element);
                        if (condition_) {
                            var x_ = document.getElementById("infoBoxProduct_" + response[i].id);
                            if (x_ != null) {
                                x_.style.pointerEvents   = "none";
                                x_.style.backgroundColor = "#9daeb8";
                                var infoBoxProductFunction_ = document.getElementById('infoBoxProductFunction_'  + response[i].id);
                                if (infoBoxProductFunction_ != null) {
                                    infoBoxProductFunction_.onclick = function() { clearSelectedProduct(response[i].id); }   
                                }
                            }
                        }
                    }
                });
            }
        }
        typePayments = function(id) {
            var typePayments = [];
            var paymentButton = document.getElementById("typePayment_" + id);
            var conditionPayment = false;
            data.typePayments.forEach(element => {
                if (element.id == id) {
                    //unselected
                    conditionPayment = true;
                    paymentButton.className = 'payment-' + id + '-unselected';
                    element.value = 0;
                } else {
                    typePayments.push(element);
                }
            });
            if (!conditionPayment) {
                //selected
                paymentButton.className = 'payment-' + id + '-selected';
                typePayments.push({
                    "id": id,
                    "name": typePaymentNames[id].name,
                    "htmlId": typePaymentNames[id].htmlId,
                    "selected": true,
                    "additionalBox": typePaymentNames[id].additionalBox,
                    "readOnly": typePaymentNames[id].readOnly,
                });
            }
            data.typePayments = typePayments;
        }
        secondStepOfSale = function () {
            if (saleOrder == '') {
                searchQuotationObj.forEach(element => {
                data.selectedQuotations.forEach(elementQ => {
                        if (element.id === elementQ.id) {
                            if (element.data_client[0].quotationAffected != undefined) {
                                saleOrder = element.data_client[0].quotationAffected[0].saleOrder;                                
                            } else {
                                saleOrder = element.sale_order;
                            }
                            typePaymentId = element.sal_type_payments_id;
                        }
                    });
                });
            }
            if (data.selectedProducts.length == 0) {
                document.getElementById('totalResumeAmount').innerHTML = 'AGREGUE PRODUCTOS A LA VENTA';
                document.getElementById('tBodyTableProductsSummary').innerHTML = '';
                document.getElementById('saleErrorMessage').innerHTML = 'Usted no tiene productos por vender.';
                document.getElementById('finishNewSale').disabled = true;
                document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
            } else if (data.customer == null) {
                document.getElementById('totalResumeAmount').innerHTML = 'INGRESE UN CLIENTE VÁLIDO';
                document.getElementById('tBodyTableProductsSummary').innerHTML = '';
                document.getElementById('tBodyTableQuotationSummary').innerHTML = '';                
                document.getElementById('saleErrorMessage').innerHTML = 'Usted no ha ingresado un cliente válido.';
                document.getElementById('finishNewSale').disabled = true;
                document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
            } else {
                setInterval();
                var xTable = document.getElementById('tBodyTableProductsSummary');
                xTable.innerHTML = "";
                var pResume = document.getElementById('totalResumeAmount');
                amountValue = 0;
                exchangeAmount = 0;
                generalDiscount = 0;
                document.getElementById('cashInputExchange').value = exchangeAmount;
                document.getElementById('generalDiscount').value = generalDiscount;
                data.selectedProducts.forEach(element => {
                    if (element.quantity > 0) {
                        var tr = document.createElement('tr');
                        tr.setAttribute("style", "font-size:10px;");
                        tr.innerHTML ='<td>' + element.code + '</td><td>' + element.name + '</td>' +
                            '<td>' + element.price + '</td><td>' + element.quantity + '</td>';
                        xTable.appendChild(tr); 
                        amountValue = amountValue + (element.price*element.quantity);   
                    }
                });

                //tBodyTableQuotationSummary
                var xTableQ = document.getElementById('tBodyTableQuotationSummary');
                xTableQ.innerHTML = "";
                data.selectedQuotations.forEach(element => {
                    var tr = document.createElement('tr');
                    tr.setAttribute("style", "font-size:10px;");
                    tr.innerHTML ='<td>' + element.ticket + '</td><td>' + element.createdAt + '</td>' +
                        '<td>' + element.totalProducts + '</td>' + '<td>' + element.quotationProducts.length + '</td>';
                    xTableQ.appendChild(tr);
                });
                
                amountValue = amountValue - generalDiscount - promoDiscount__;
                amountValue_ = amountValue;

                var generalService = document.getElementById('generalService');
                if (servicePercent > 0) {
                    var servicePercentValue = parseFloat(((amountValue_)*0.7633333) * (parseFloat(servicePercent)/100));
                    generalService.value = servicePercentValue;    
                } else {
                    var servicePercentValue = 0.00;
                    generalService.value = servicePercentValue;
                }
                
                pResume.innerHTML = '<b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue_);
            
                if (typeDocumentCode != 'NVT') {
                    // HERE finalStepPrevSubtotal
                    document.getElementById('finalStepPrevSubtotal').innerHTML = 'SUBTOTAL: ' + data.symbolCode + ' ' + (parseFloat(amountValue_)/1.18);
                    // HERE finalStepPrevIgv
                    document.getElementById('finalStepPrevIgv').innerHTML = 'IGV: ' + data.symbolCode + ' ' + (parseFloat(amountValue_) - (parseFloat(amountValue_)/1.18));
                }
                // HERE finalStepPrevTotal
                document.getElementById('finalStepPrevTotal').innerHTML = 'TOTAL: ' + data.symbolCode + ' ' + parseFloat(amountValue_);

                if (data.customer.flag_type_person != undefined) {    
                    if (data.customer.flag_type_person == 1) {
                        document.getElementById('clientName').innerHTML = data.customer.name + ', ' + data.customer.lastname + ' - DNI: ' + data.customer.dni;   
                    } else {
                    document.getElementById('clientName').innerHTML = data.customer.name + ', ' + data.customer.lastname + ' - RUC: ' + data.customer.ruc;
                    }   
                } else {                    
                    document.getElementById('clientName').innerHTML = data.customer.name + ', ' + data.customer.lastname + ' - RUC: ' + data.customer.ruc + ' - DNI: ' + data.customer.dni;
                }
                
                var paymentTable = document.getElementById('tBodyTablePaymentSummary');
                paymentTable.innerHTML = "";
                var tr = document.createElement('tr');
                var td = '';
                var countInitialCash = 0;
                if (data.typePayments.length == 0) {
                    document.getElementById('finishNewSale').disabled = true;
                    document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                }
                data.typePayments.forEach(element => {
                    var initialCash = 0;
                    if (countInitialCash == 0 && (data.typePayments.length == 1)) {
                        initialCash = amountValue_;
                    } else {
                        document.getElementById('finishNewSale').disabled = true;
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                    }
                    var readOnly = '';
                    if (element.readOnly) {
                        readOnly = 'readonly';
                    }
                    if (element.additionalBox) {
                        td = td + '<tr><td width="50%">' + element.name + '</td><td><input onClick="this.select();" type="' + element.type + '" step=".01"  id="' + element.htmlId + '" style="width: 100px;" maxlength="10" class="form-control" value="' + initialCash + '" ' + readOnly + '/></td></tr>' +
                            '<tr><td width="50%">CÓDIGO</td><td><input type="text" id="' + element.htmlId + 'Box" style="width: 100px;" maxlength="100" class="form-control" value="" placeholder="#Operación" /></td></tr>';
                    } else {
                        td = td + '<tr><td width="50%">' + element.name + '</td><td><input onClick="this.select();" type="' + element.type + '" step=".01" id="' + element.htmlId + '" style="width: 100px;" maxlength="10" class="form-control" value="' + initialCash + '" ' + readOnly + '/></td></tr>';
                    }
                    element.value = initialCash;
                    paymentAmounts[element.id] = element;
                    countInitialCash++;
                });
                paymentTable.innerHTML = td;
                //Listener
                data.typePayments.forEach(element => {
                    document.getElementById(element.htmlId).addEventListener("keyup", function(event) {
                        event.preventDefault();
                        var paymentValue_ = parseFloat(document.getElementById(element.htmlId).value);
                        paymentReadjustment(paymentValue_, element.id);
                    });
                    if (element.additionalBox) {
                        document.getElementById(element.htmlId + 'Box').addEventListener("keyup", function(event) {
                            event.preventDefault();
                            var paymentValueBox_ = document.getElementById(element.htmlId + 'Box').value;
                            paymentAmounts[element.id].operation_number = paymentValueBox_;
                        });    
                    }
                });
            }
        }
        addSelectedProduct = function (product, qEditable = true) {
            var xTable = document.getElementById('tBodyTableSelectedProducts');
            var tr = document.createElement('tr');
            var readonly = 'readonly';
            product = data.products[product];
            if (qEditable) {
                product.quantity = 1;
                readonly = '';
            }
            var quantityProduct__ = document.getElementById('quantityProduct_' + product.id);
            if (quantityProduct__ != null) {
                data.selectedProducts[product.id].quantity = parseFloat(data.selectedProducts[product.id].quantity) + parseFloat(product.quantity);
                document.getElementById('quantityProduct_' + product.id).value = data.selectedProducts[product.id].quantity;
                if (data.rowClickedId != 0) {
                    var oldRowClicked = document.getElementById('row_' + data.rowClickedId);
                    if (oldRowClicked != null) {
                        oldRowClicked.style.backgroundColor = '#2c3b41';        
                    }
                }
                var rowClicked = document.getElementById('row_' + product.id);
                if (rowClicked != null) {
                    rowClicked.style.backgroundColor = "#9daeb8";   
                }
                data.rowClickedId = product.id;
            } else {
                data.selectedProducts[product.id] = product;
                tr.setAttribute("id", "row_" + product.id);
                // tr.setAttribute("style", "font-size:10px;");
                tr.innerHTML = '<td style="color: #ffffff; width:18%; border-top: 0px; vertical-align: middle;">' + arraySales[product.sal_sale_documents_id].clientInfo + '</td>' +
                    '<td style="color: #ffffff; width:18%; border-top: 0px; vertical-align: middle;" onClick="showProductDetail('+ product.id +')"><strong style="cursor:pointer;">' + product.code + '</strong></td>' +
                    '<td style="color: #ffffff; width:18%; border-top: 0px; vertical-align: middle;">' + product.name + '</td>' +
                    '<td style="color: #000000; width:18%; border-top: 0px; vertical-align: middle;"><input type="number" class="form-control" style="width:100%;" id="priceProduct_' + product.id + '" value="' + product.price + '" readonly></td>' + 
                    '<td style="color: #000000; width:18%; border-top: 0px; vertical-align: middle;"><input type="number" class="form-control" style="width:100%;" onClick="this.select();" id="quantityProduct_' + product.id + '" value="' + product.quantity + '" readonly></td>' +
                    '<td style="color: #ffffff; width:10%; border-top: 0px; vertical-align: middle;"><div class="input-group input-group-sm"><span class="input-group-btn"><button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
                xTable.insertBefore(tr, xTable.firstChild);
                var x = document.getElementById("infoBoxProduct_" + product.id);
                var infoBoxProductFunction_ = document.getElementById('infoBoxProductFunction_' + product.id);
                if (infoBoxProductFunction_ != null) {
                    infoBoxProductFunction_.onclick = function() { clearSelectedProduct(product.id); }
                }            
                //Prev Selected
                data.padOption = 0;
                if (data.rowClickedId != 0) {
                    var oldRowClicked = document.getElementById('row_' + data.rowClickedId);
                    if (oldRowClicked != null) {
                        oldRowClicked.style.backgroundColor = '#2c3b41';
                    }
                }
                var rowClicked = document.getElementById('row_' + product.id);
                data.rowClickedId = product.id;
                //Listeners
                callProductsListeners(product);
            }
        }
        clearSelectedProduct = function (productId) {
            var infoBoxProductFunction_ = document.getElementById('infoBoxProductFunction_' + productId);
            if (infoBoxProductFunction_ != null) {
                infoBoxProductFunction_.onclick = function() { addSelectedProduct(productId); }
            }
            document.getElementById("row_" + productId).remove();
            var x = document.getElementById("infoBoxProduct_" + productId);
            if (x != null) {
                x.style.pointerEvents   = "auto";
                x.style.backgroundColor = "#ffffff";   
            }
            //BORRAR DEL ARRAY
            var selectedProducts___ = data.selectedProducts;
            data.selectedProducts = [];
            selectedProducts___.forEach(element => {
                if (element.id !== productId) {
                    data.selectedProducts[element.id] = element;
                } else {
                    if (data.products[element.id] != undefined) {
                        data.products[element.id].price = parseFloat(data.products[element.id].originalPrice);
                        data.products[element.id].partialDiscount = 0;                        
                    }
                }
            });            
            data.selectedQuotations.forEach(element => {
                element.quotationProducts.forEach(elementQP => {
                    if (elementQP.warProductsId == Number(productId)) {
                        elementQP.id = null;
                        elementQP.quantity = 0;
                        elementQP.warProductsId = null;
                    }
                });
            });
            // setInterval();
        }
        clearAllSelectedProduct = function () {
            data.rowClickedId = 0;
            data.padOption = 0;            
            data.selectedProducts.forEach(element => {
                document.getElementById("row_" + element.id).remove();
                var x = document.getElementById("infoBoxProduct_" + element.id);
                if (x != null) {
                    x.style.pointerEvents   = "auto";
                    x.style.backgroundColor = "#ffffff";   
                }
            });
            data.selectedProducts = [];
            // setInterval();
        }
        updateSelectedProduct = function (productId) {
            alert("Detalle de producto " + productId);
        }
        newUserForm = function () {
            $('#modal-new-client-simple').modal({ backdrop: 'static', keyboard: false });
            var clientDataResponse = document.getElementById("newClientSimpleDataResponse");
            clientDataResponse.innerHTML = "";
            var form = document.createElement('form');
            form.innerHTML ='<div class="box-body col-md-6">' +
                '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                '<input type="text" class="form-control" id="clientSimpleNames" required placeholder="Ingrese NOMBRES" value=""></div>' +
                '<div class="form-group"><label for="clientFirstLastname">APELLIDO PATERNO</label>' + 
                '<input type="text" class="form-control" id="clientSimpleFirstLastname" required placeholder="Ingrese APELLIDO PATERNO" value=""></div>' +
                '<div class="form-group"><label for="clientSecondLastname">APELLIDO MATERNO</label>' +
                '<input type="text" class="form-control" id="clientSimpleSecondLastname" required placeholder="Ingrese APELLIDO MATERNO" value=""></div></div>' +
                '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                '<input type="text" class="form-control" id="clientSimplePhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                '<input type="text" class="form-control" id="clientSimpleEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div></div>';
            clientDataResponse.appendChild(form);
        }
        saveNewSimpleClient = function () {
            var validation = true;
            var clientSimpleNames = document.getElementById('clientSimpleNames');
            var clientSimpleFirstLastname = document.getElementById('clientSimpleFirstLastname');
            var clientSimpleSecondLastname = document.getElementById('clientSimpleSecondLastname');
            var clientSimplePhone = document.getElementById('clientSimplePhone');
            var clientSimpleEmail = document.getElementById('clientSimpleEmail');
            clientSimpleNames.style.borderColor = '#ccc';
            clientSimpleFirstLastname.style.borderColor = '#ccc';
            clientSimpleSecondLastname.style.borderColor = '#ccc';
            if(!clientSimpleNames.checkValidity()) {
                clientSimpleNames.style.borderColor = "red";
                validation = false;
            } 
            if(!clientSimpleFirstLastname.checkValidity()) {
                clientSimpleFirstLastname.style.borderColor = "red";
                validation = false;
            } 
            if(!clientSimpleSecondLastname.checkValidity()) {
                clientSimpleSecondLastname.style.borderColor = "red";
                validation = false;
            }
            if (validation) {
                var button = document.getElementById('saveNewSimpleClient');
                button.disabled = true;
                var dataSend = {
                    "name" : clientSimpleNames.value.toUpperCase(),
                    "lastname" : clientSimpleFirstLastname.value.toUpperCase() + ' ' + clientSimpleSecondLastname.value.toUpperCase(),
                    "phone" : clientSimplePhone.value,
                    "email" : clientSimpleEmail.value,
                    "creation_type": 2,
                    "flag_type_person": 1,
                };
                $.ajax({
                    method: "POST",
                    url: "/api/customer-simple",
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        500: function() {
                            button.disabled = false;
                            alert('No se pudo crear el nuevo cliente. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                        403: function() {
                            button.disabled = false;
                            alert('No se pudo crear el nuevo cliente. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                        400: function() {
                            button.disabled = false;
                            alert('No se pudo crear el nuevo cliente. Verifique la información ingresada e inténtelo nuevamente.');
                        },
                    }
                }).done(function(response) {
                    button.disabled = false;
                    data.newCustomer = response;
                    data.newCustomer.typeCustomer = response.flag_type_person;
                    chooseClient();
                    $('#modal-new-client-simple').modal('toggle');
                });
            }
        }
        //Listeners
        var generalDiscount_ = document.getElementById('generalDiscount');
        generalDiscount_.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (generalDiscount_.value == '') {
                generalDiscount_.value = 0;
            }
            if (parseFloat(generalDiscount_.value) < 0) {
                generalDiscount_.value = 0;
            }
            if (parseFloat(generalDiscount_.value) == 0) {
                amountValue = amountValue_;
            }
            //LOGICA DE PORCENTAJE
            var typeGeneralDiscount = document.getElementById('typeGeneralDiscount').value;
            var generalDiscount__ = parseFloat(generalDiscount_.value)
            if (typeGeneralDiscount == 1) {
                generalDiscount__ = (amountValue_/100)*generalDiscount__;
            }
            if (amountValue_ <= generalDiscount__) {
                if (typeGeneralDiscount == 0) {
                    generalDiscount_.value = amountValue_;   
                } else {
                    generalDiscount_.value = 100;
                }
                amountValue = 0;
            } else {
                amountValue = amountValue_;
                amountValue = amountValue - generalDiscount__ - promoDiscount__;
            }
            var pResume = document.getElementById('totalResumeAmount');
            pResume.innerHTML = 'Total a pagar: ' + data.symbolCode + ' ' + parseFloat(amountValue);

            exchangeAmount = 0;
            document.getElementById('cashInputExchange').value = 0;

            //EXCHANGE
            var paymentAmount__ = 0;
            paymentAmounts.forEach(element => {
                //UPDATE PRICE READONLY
                paymentAmount__ = paymentAmount__ + parseFloat(element.value);
                //UPDATE PRICE READONLY
            });
            var exchange = paymentAmount__ - amountValue;
            if (exchange > 0) {
                document.getElementById('cashInputExchange').value = exchange;
            } else {
                document.getElementById('cashInputExchange').value = 0;
            }

            generalDiscount = generalDiscount__;
            setInterval();
        });
        var typeGeneralDsct_ = document.getElementById('typeGeneralDiscount');
        typeGeneralDsct_.addEventListener("change", function(event) {
            event.preventDefault();
            if (generalDiscount_.value == '') {
                generalDiscount_.value = 0;
            }
            if (parseFloat(generalDiscount_.value) < 0) {
                generalDiscount_.value = 0;
            }
            if (parseFloat(generalDiscount_.value) == 0) {
                amountValue = amountValue_;
            }
            //LOGICA DE PORCENTAJE
            var typeGeneralDiscount = document.getElementById('typeGeneralDiscount').value;
            var generalDiscount__ = parseFloat(generalDiscount_.value)
            if (typeGeneralDiscount == 1) {
                generalDiscount__ = (amountValue_/100)*generalDiscount__;
            }
            if (amountValue_ <= generalDiscount__) {
                if (typeGeneralDiscount == 0) {
                    generalDiscount_.value = amountValue_;   
                } else {
                    generalDiscount_.value = 100;
                }
                amountValue = 0;
            } else {
                amountValue = amountValue_;
                amountValue = amountValue - generalDiscount__ - promoDiscount__;
            }
            var pResume = document.getElementById('totalResumeAmount');
            pResume.innerHTML = 'Total a pagar: ' + data.symbolCode + ' ' + parseFloat(amountValue);

            exchangeAmount = 0;
            document.getElementById('cashInputExchange').value = 0;

            //EXCHANGE
            var paymentAmount__ = 0;
            paymentAmounts.forEach(element => {
                paymentAmount__ = paymentAmount__ + parseFloat(element.value);
            });
            var exchange = paymentAmount__ - amountValue;
            if (exchange > 0) {
                document.getElementById('cashInputExchange').value = exchange;
            } else {
                document.getElementById('cashInputExchange').value = 0;
            }

            generalDiscount = generalDiscount__;
            setInterval();
        });
        //OnClick elements
        $("#priceList").click(priceList);
        $("#salesList").click(salesList);
        $("#printSalePdf").click(printSalePdf);
        $("#genericClient").click(genericClient);
        $("#saveNewClient").click(saveNewClient);
        $("#finishNewSale").click(finishNewSale);
        $("#newSaleButton").click(newSaleButton);
        $("#sendSaleEmail").click(sendSaleEmail);
        $("#chooseClientOld").click(chooseClient);
        $("#searchClientSunatButton").click(searchClientSunatButton);
        $("#searchNewClientSunatButton").click(searchNewClientSunatButton);

        //AUTOCOMPLETE LOGIC
        function autocompleteForClients(inp) {
            var currentFocus;
            var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items-total");
                    this.parentNode.appendChild(a);
                    if (val.length > 3) {
                        //LLAMADA AL SERVICIO
                        $.ajax({
                            url: "/api/customers?searchInput=" + val,
                            context: document.body,
                            statusCode: {
                                404: function() {
                                    alert("No se encontró al cliente. ¿Desea registrarlo?");
                                }
                            }
                        }).done(function(response) {
                            if (response.data.length == 0) {
                                var searchNewClientSunat = document.getElementById('searchNewClientSunat');
                                searchNewClientSunat.value = inp.value;
                                inp.value = "";
                                $('#newClient').trigger('click');
                            } else if (response.data.length == 1) {
                                inp.value = response.data[0].name + ' ' + response.data[0].lastname;
                                data.newCustomer = response.data[0];
                                data.newCustomer.typeCustomer = response.data[0].flag_type_person;
                                chooseClient();
                                closeAllLists();
                            } else {
                                for (i = 0; i < response.data.length; i++) {
                                    var nameLastname = response.data[i].name + ' ' + response.data[i].lastname + ' - ' + response.data[i].dni;
                                    if (response.data[i].flag_type_person == 2) {
                                        nameLastname = response.data[i].rz_social + ' - ' + response.data[i].ruc;
                                    }
                                    b = document.createElement("DIV");
                                    b.style.background = '#ffffff';
                                    b.setAttribute('class', 'form-control-autocomplete');
                                    b.style.cursor = 'pointer';
                                    b.innerHTML += nameLastname;
                                    b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                    b.addEventListener("click", function(e) {
                                        var iterator = this.getElementsByTagName("input")[0].value;
                                        inp.value = response.data[iterator].name + ' ' + response.data[iterator].lastname;
                                        data.newCustomer = response.data[iterator];
                                        data.newCustomer.typeCustomer = response.data[iterator].flag_type_person;
                                        chooseClient();
                                        closeAllLists();
                                    });
                                    a.appendChild(b);
                                }                            
                            }
                        });
                    }
                }
            });
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items-total");
                for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        function autocompleteForClients2(inp) {
            var currentFocus;
            var mainheaderSearchBar = document.getElementById('mainheaderSearchBar2');
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items-total");
                    this.parentNode.appendChild(a);
                    if (val.length > 3) {
                        //LLAMADA AL SERVICIO
                        $.ajax({
                            url: "/api/customers?searchInput=" + val,
                            context: document.body,
                            statusCode: {
                                404: function() {
                                    alert("No se encontró al cliente. ¿Desea registrarlo?");
                                }
                            }
                        }).done(function(response) {
                            if (response.data.length == 0) {
                                var searchNewClientSunat = document.getElementById('searchNewClientSunat');
                                searchNewClientSunat.value = inp.value;
                                inp.value = "";
                                $('#newClient').trigger('click');
                            } else if (response.data.length == 1) {
                                inp.value = response.data[0].name + ' ' + response.data[0].lastname;
                                data.newCustomer = response.data[0];
                                data.newCustomer.typeCustomer = response.data[0].flag_type_person;
                                chooseClient2();
                                closeAllLists();
                            } else {
                                for (i = 0; i < response.data.length; i++) {
                                    var nameLastname = response.data[i].name + ' ' + response.data[i].lastname + ' - ' + response.data[i].dni;
                                    if (response.data[i].flag_type_person == 2) {
                                        nameLastname = response.data[i].rz_social + ' - ' + response.data[i].ruc;
                                    }
                                    b = document.createElement("DIV");
                                    b.style.background = '#ffffff';
                                    b.setAttribute('class', 'form-control-autocomplete');
                                    b.style.cursor = 'pointer';
                                    b.innerHTML += nameLastname;
                                    b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                    b.addEventListener("click", function(e) {
                                        var iterator = this.getElementsByTagName("input")[0].value;
                                        inp.value = response.data[iterator].name + ' ' + response.data[iterator].lastname;
                                        data.newCustomer = response.data[iterator];
                                        data.newCustomer.typeCustomer = response.data[iterator].flag_type_person;
                                        chooseClient2();
                                        closeAllLists();
                                    });
                                    a.appendChild(b);
                                }                            
                            }
                        });
                    }
                }
            });
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items-total");
                for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        // autocompleteForClients(document.getElementById('inputSearchClient'));
        autocompleteForClients2(document.getElementById('inputSearchClient2'));
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>