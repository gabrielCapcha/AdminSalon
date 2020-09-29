<!-- Laravel App -->
<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.lightSliderResponsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/bootstrap-toggle/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
<script>
    //Document Ready
    var optionPad;
    var newUserForm;
    var setPadNumber;
    var loadProducts;
    var typePayments;
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
    var pickCustomerSubsidiary;
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
        var buttonVd_ = true;
        var idNewSale = 0;
        var priceLists = [];
        var amountValue = 0;
        var amountValue_ = 0;
        var paymentAmount = 0;
        var quantityValue = 0;
        var paymentAmounts = [];
        var exchangeAmount = 0;
        var generalDiscount = 0;
        var promoDiscount__ = 0;
        var destinySubsidiary = 0;
        var destinySubsidiaryObject = null;
        var genericCustomer = JSON.parse(document.getElementById("genericCustomer").value);
        var companyLoginData = JSON.parse(document.getElementById("companyLoginData").value);
        var promotionsData = JSON.parse(document.getElementById('promotionsData').value);
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
        data.customer = genericCustomer;
        data.padOption = 0;
        data.symbolCode = 'S/ ';
        data.customerId = genericCustomer.id;
        data.priceListId = 0;
        data.rowClickedId = 0;
        data.typePayments = [{"id": 1, "type": "number", "name": "EFECTIVO", "htmlId": "cashInputValue", "selected": true}];
        data.buttonCategory = 0;
        data.selectedProducts = [];
        data.suppliedCustomer = {};
        //INTERVALS
        //functions
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
                var servicePercentValue = parseFloat(((amountValue-generalDiscount-promoDiscount__)*0.7633333) * (parseFloat(servicePercent)/100)).toFixed(2);
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
            document.getElementById("inputSearchClient").value    = genericCustomer.name + " " + genericCustomer.lastname;
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
            if (genericCustomer.name == null) {
                genericCustomer.name = genericCustomer.rz_social;
                genericCustomer.lastname = '';
            }
            document.getElementById("inputSearchClient").value = genericCustomer.name + " " + genericCustomer.lastname;
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
            exchangeAmount = parseFloat(document.getElementById('cashInputExchange').value).toFixed(2);
            //LOGICA DE PORCENTAJE
            var typeGeneralDiscount = document.getElementById('typeGeneralDiscount').value;
            generalDiscount = parseFloat(document.getElementById('generalDiscount').value).toFixed(2);
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
            paymentAmounts.forEach(element => {
                paymentAmount = paymentAmount + parseFloat(element.value);
                var exchangeAmount___ = 0;
                if (element.id == 1) {
                    exchangeAmount___ = exchangeAmount;
                }
                if (element.value != 0) {
                    if (element.id == 6) {
                        var paymentElement = {
                            "amount": (parseFloat(element.value) - parseFloat(exchangeAmount___)).toFixed(2),
                            "exchange": exchangeAmount___,
                            "name": element.name,
                            "sal_type_payments_id": element.id,
                            "operation_number": element.operation_number
                        };
                    } else {
                        var paymentElement = {
                            "amount": (parseFloat(element.value) - parseFloat(exchangeAmount___)).toFixed(2),
                            "exchange": exchangeAmount___,
                            "name": element.name,
                            "sal_type_payments_id": element.id
                        };
                    }
                }
                if (paymentElement) {
                    payments.push(paymentElement);
                }
            });
            if (payments.length == 0) {
                payments.push({
                    "amount": 0.00,
                    "exchange": 0.00,
                    "name": "EFECTIVO",
                    "sal_type_payments_id": 1
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
            var services___    = parseFloat(generalService.value).toFixed(2);
            
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

            var typeDocumentId = 1;

            switch (typeDocumentCode) {
                case 'BLT':
                    typeDocumentId = 2;
                    break;
                case 'FAC':
                    typeDocumentId = 3;
                    break;
                case 'NVT':
                    typeDocumentId = 1;
                    break;            
                default:
                    typeDocumentId = 1;
                    break;
            }
            
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
                            "quotationTypeDocument": typeDocumentId,
                            "destinySubsidiary": destinySubsidiaryObject,
                        }
                    ],
                    "discount": parseFloat(generalDiscount),
                    "promo_discount": parseFloat(promoDiscount__),
                    "isCustomer": false,
                    "items_": selectedProductsToSale,
                    "sal_sale_states_id": "3",
                    "sal_type_payments_id": "1",
                    "transaction": true,
                    "payment_amount": paymentAmount,
                    "exchange_amount": exchangeAmount,
                    "type_document_code": 'COT',
                    "type_document_name": 'COTIZACIÓN',
                    "sale_order": saleOrder,
                    "remission_guide": remissionGuide,
                    "advertisement": advertisement,
                    "commentary": saleCommentary,
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
                console.log("No se puede imprimir la venta");
            }
        }
        function salesList() {
            location = "/quotations";
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
                console.log("No se puede enviar correo a un cliente genérico.");
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
                var rowClicked = document.getElementById('row_' + product.id);
                if (rowClicked != null) {
                    rowClicked.style.backgroundColor = "#9daeb8";   
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
                        text_ = text_ +  '<li class="form-control '+ class_ +'">' + element.name + ' - ' + element.description + ' - <strong>DESCUENTO: ' + parseFloat(element.promoDiscountValue).toFixed(2) + '</strong></li>';
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
        pickCustomerSubsidiary = function() {
            document.getElementById('rowsCustomerSubsidiaries').innerHTML = '';
            var button = document.getElementById('pickCustomerSubsidiary');
            button.disabled = true;
            $.ajax({
                method: "GET",
                url: "/api/customer-subsidiary/" + data.customer.id,
                context: document.body,
                statusCode: {
                    500: function() {
                        button.disabled = false;
                        alert('No se encontraron sucursales para este cliente');
                    },
                    404: function() {
                        button.disabled = false;
                        alert('No se encontraron sucursales para este cliente');
                    },
                    403: function() {
                        button.disabled = false;
                        alert('No se encontraron sucursales para este cliente');
                    },
                    400: function() {
                        button.disabled = false;
                        alert('No se encontraron sucursales para este cliente');
                    },
                }
            }).done(function(response) {
                button.disabled = false;
                document.getElementById('customerSubsidiaryText').value = "SUCURSALES DEL CLIENTE: " + data.customer.rz_social;
                if (data.customer.rz_social == null) {
                    document.getElementById('customerSubsidiaryText').value = "SUCURSALES DEL CLIENTE: " + data.customer.name + ' ' + data.customer.lastname;
                }
                // CARGA DE SUCURSALES
                var rowsCustomerSubsidiaries = document.getElementById('rowsCustomerSubsidiaries');
                response.forEach(element => {
                    if (destinySubsidiary != 0) {
                        var btnCustomerSubsidiary_ = document.getElementById('btnCustomerSubsidiary_' + destinySubsidiary);
                        if (btnCustomerSubsidiary_ != null) {
                            btnCustomerSubsidiary_.style.backgroundColor = "#337ab7";
                        }
                    }
                    var btn = document.createElement("BUTTON");
                    btn.onclick = function() {
                        if (destinySubsidiary != 0) {
                            document.getElementById('btnCustomerSubsidiary_' + destinySubsidiary).style.backgroundColor = "#fff";
                        }
                        destinySubsidiary = element.id;
                        destinySubsidiaryObject = element;
                        document.getElementById('btnCustomerSubsidiary_' + destinySubsidiary).style.backgroundColor = "#337ab7"; 
                    };
                    btn.setAttribute("class", "form-control");
                    btn.setAttribute("id", "btnCustomerSubsidiary_" + element.id);
                    btn.style.width = '100%';
                    btn.style.padding = '5px';
                    btn.style.margin = '5px';
                    var t = document.createTextNode(element.province +  ' - ' + element.district + ' - ' + element.address);
                    btn.appendChild(t);
                    rowsCustomerSubsidiaries.appendChild(btn);
                });
                $('#modal-customer-subsidiary').modal({ backdrop: 'static', keyboard: false });
            });
        }
        newSettingsForm = function() {
            document.getElementById('sale_order').value = saleOrder;
            document.getElementById('advertisement').value = advertisement;
            document.getElementById('remission_guide').value = remissionGuide;
            document.getElementById('commentary').value = saleCommentary;
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
            pResume.innerHTML = '<b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);
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
                            var buttonHeadClass_ = '<div align="center" class="info-box-custom-responsive" id="infoBoxProduct_' + response[i].id + '">';
                            if (response[i].stock < 1) {
                                buttonHeadClass_ = '<div align="center" class="info-box-custom-cancel-responsive" id="infoBoxProduct_' + response[i].id + '>';
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
                                '       <img src="' + urlImage + '" style="height:50px; width:50px;">'+
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
                        productsDivList.style.display = "block";
                        $('#productsDivList').append(element);
                        if (condition_) {
                            var x_ = document.getElementById("infoBoxProduct_" + response[i].id);
                            if (x_ != null) {
                                x_.style.pointerEvents   = "none";
                                x_.style.backgroundColor = "#9daeb8";
                                var infoBoxProductFunction_ = document.getElementById('infoBoxProductFunction_'  + response[i].id);
                                if (infoBoxProductFunction_ != null) {
                                    infoBoxProductFunction_.onclick = function() { clearSelectedProduct(product.id); }
                                }
                            }
                        }
                    }
                });
            }
        }
        showQuotation = function() {
            $('#modal-quotation').modal({ backdrop: 'static', keyboard: false });
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
            if (data.selectedProducts.length == 0) {
                document.getElementById('totalResumeAmount').innerHTML = 'AGREGUE PRODUCTOS A LA VENTA';
                document.getElementById('tBodyTableProductsSummary').innerHTML = '';
                document.getElementById('saleErrorMessage').innerHTML = 'Usted no tiene productos por vender.';
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
                            '<td>' + element.price + '</td><td>' + element.quantity + '</td>' + '<td>' + (parseFloat(element.quantity)*parseFloat(element.price)).toFixed(2) + '</td>';
                        xTable.appendChild(tr); 
                        amountValue = amountValue + (element.price*element.quantity);   
                    }
                });
                
                amountValue = amountValue - generalDiscount - promoDiscount__;
                amountValue_ = amountValue;

                var generalService = document.getElementById('generalService');
                if (servicePercent > 0) {
                    var servicePercentValue = parseFloat(((amountValue_)*0.7633333) * (parseFloat(servicePercent)/100)).toFixed(2);
                    generalService.value = servicePercentValue;    
                } else {
                    var servicePercentValue = 0.00;
                    generalService.value = servicePercentValue;
                }
                
                pResume.innerHTML = 'Convertir cotización a: <b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue_).toFixed(2);
                if (data.customer.ruc == undefined) {
                    document.getElementById('clientName').innerHTML = data.customer.name + ', ' + data.customer.lastname + ' - DNI: ' + data.customer.dni;   
                } else {
                    document.getElementById('clientName').innerHTML = data.customer.name + ', ' + data.customer.lastname + ' - RUC: ' + data.customer.ruc + ' - DNI: ' + data.customer.dni;
                }
                if (typeDocumentCode != 'NVT') {
                    // HERE finalStepPrevSubtotal
                    document.getElementById('finalStepPrevSubtotal').innerHTML = 'SUBTOTAL: ' + data.symbolCode + ' ' + (parseFloat(amountValue_)/1.18).toFixed(2);
                    // HERE finalStepPrevIgv
                    document.getElementById('finalStepPrevIgv').innerHTML = 'IGV: ' + data.symbolCode + ' ' + (parseFloat(amountValue_) - (parseFloat(amountValue_)/1.18)).toFixed(2);
                }
                // HERE finalStepPrevTotal
                document.getElementById('finalStepPrevTotal').innerHTML = 'TOTAL: ' + data.symbolCode + ' ' + parseFloat(amountValue_).toFixed(2);
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
                        initialCash = parseFloat(amountValue_).toFixed(2);
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
        addSelectedProduct = function (product) {
            var xTable = document.getElementById('tBodyTableSelectedProducts');
            var tr = document.createElement('tr');
            product = data.products[product];
            product.quantity = 1;
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
                tr.setAttribute("style", "font-size:10px;");
                tr.innerHTML ='<td class="static-table-td" onClick="showProductDetail('+ product.id +')"><strong style="cursor:pointer;">' + product.code + '</strong></td>' +
                    '</td><td class="static-table-td">' + product.name + '</td>' +
                    '<td class="static-table-td-input"><input type="number" id="priceProduct_' + product.id + '" value="' + product.price + '" readonly></td>' + 
                    '<td class="static-table-td-input"><input type="number" onClick="this.select();" id="quantityProduct_' + product.id + '" value=1></td>' +
                    '<td class="static-table-td"><div class="input-group input-group-sm"><span class="input-group-btn"><button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
                xTable.insertBefore(tr, xTable.firstChild);
                var x = document.getElementById("infoBoxProduct_" + product.id);
                if (x != null) {
                    // x.style.pointerEvents   = "none";
                    x.style.backgroundColor = "#9daeb8";   
                }
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
                if (rowClicked != null) {
                    rowClicked.style.backgroundColor = "#9daeb8";   
                }
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
        var searchProductBarCode = document.getElementById('searchProductBarCode');
        searchProductBarCode.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                $.ajax({
                    url: "/api/products-search/" + searchProductBarCode.value + "?priceListId=" + data.priceListId,
                    context: document.body,
                    statusCode: {
                        404: function() {
                            alert("No se encontraron productos. Verifique si este cuenta con stock.");
                        }
                    }
                }).done(function(response) {
                    product = response[0];
                    if (product != undefined) {
                        if (product.stock > 0) {
                            if (data.selectedProducts[product.id] != undefined) {
                                var quantity = document.getElementById("quantityProduct_" + product.id).value;
                                quantity++;
                                if (data.selectedProducts[product.id].stock < quantity) {
                                    data.selectedProducts[product.id].quantity = data.selectedProducts[product.id].stock;
                                    alert("El stock actual es menor que la cantidad ingresada.");
                                } else {
                                    data.selectedProducts[product.id].quantity = quantity;
                                    var quantityWSP = quantityUniversalPromo(data.selectedProducts[product.id]);
                                    document.getElementById("quantityProduct_" + product.id).value = quantity;
                                    if (document.getElementById('quantityProduct_' + product.id).value >= quantityWSP) {
                                        data.selectedProducts[product.id].price = data.selectedProducts[product.id].wholeSalePrice;
                                        document.getElementById('priceProduct_' + product.id).value = data.selectedProducts[product.id].price;
                                    }
                                }
                            } else {
                                product.quantity = 1;
                                data.products[product.id] = product;
                                data.selectedProducts[product.id] = product;
                                addSelectedProduct(product.id);
                            }
                        } else {
                            alert('Producto: ' + product.name + ' (CODIGO: ' + product.code + ') no cuenta con stock para la venta.');
                        }
                    } else {
                        alert("No se encontraron productos. Verifique si este cuenta con stock");
                    }
                });
                document.getElementById('searchProductBarCode').value = "";
            }
            // setInterval();
        });
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
            pResume.innerHTML = 'Convertir cotización a: <b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);

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
                document.getElementById('cashInputExchange').value = parseFloat(exchange).toFixed(2);
            } else {
                document.getElementById('cashInputExchange').value = 0;
            }

            generalDiscount = generalDiscount__;
            
            if (typeDocumentCode != 'NVT') {
                // HERE finalStepPrevSubtotal
                document.getElementById('finalStepPrevSubtotal').innerHTML = 'SUBTOTAL: ' + data.symbolCode + ' ' + (parseFloat(amountValue)/1.18).toFixed(2);
                // HERE finalStepPrevIgv
                document.getElementById('finalStepPrevIgv').innerHTML = 'IGV: ' + data.symbolCode + ' ' + (parseFloat(amountValue) - (parseFloat(amountValue)/1.18)).toFixed(2);
            }
            // HERE finalStepPrevTotal
            document.getElementById('finalStepPrevTotal').innerHTML = 'TOTAL: ' + data.symbolCode + ' ' + amountValue.toFixed(2);
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
            pResume.innerHTML = 'Convertir cotización a: <b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);

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
                    a.setAttribute("class", "autocomplete-items-payments");
                    this.parentNode.appendChild(a);
                    mainheaderSearchBar.style.height = "1px";
                    mainheaderSearchBar.style.zIndex = "2";
                    if (val.length > 2) {
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
                var x = document.getElementsByClassName("autocomplete-items-payments");
                for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        function autocompleteForProducts(inp) {
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
                    a.setAttribute("class", "autocomplete-items-payments");
                    this.parentNode.appendChild(a);
                    mainheaderSearchBar.style.height = "1px";
                    mainheaderSearchBar.style.zIndex = "2";
                    //LLAMADA AL SERVICIO
                    $.ajax({
                        url: "/api/products-for-sale/" + val + "?&priceListId=" + data.priceListId,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron productos. Verifique si este cuenta con stock");
                            }
                        }
                    }).done(function(response) {
                        if (response.length == 0) {
                            inp.value = "";
                            alert("No se encontraron productos. Verifique si este cuenta con stock");
                        } else {
                            for (i = 0; i < response.length; i++) {
                                var nameLastname = response[i].name + ' - ' + response[i].code + ' - ' + response[i].autoBarcode + ' <b>MARCA: ' + response[i].brandName + ' (STOCK: ' + response[i].stock + ')</b>';
                                b = document.createElement("DIV");
                                b.setAttribute('class', 'form-control-autocomplete');
                                b.innerHTML += nameLastname;
                                b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                if (response[i].stock > 0) {
                                    b.style.background = '#ffffff';
                                    b.style.cursor = 'pointer';
                                    b.addEventListener("click", function(e) {
                                        var iterator = this.getElementsByTagName("input")[0].value;
                                        inp.value = "";
                                        product = response[iterator];
                                        if (product != undefined) {
                                            if (data.selectedProducts[product.id] != undefined) {
                                                var quantity = document.getElementById("quantityProduct_" + product.id).value;
                                                quantity++;
                                                if (data.selectedProducts[product.id].stock < quantity) {
                                                    data.selectedProducts[product.id].quantity = data.selectedProducts[product.id].stock;
                                                    alert("El stock actual es menor que la cantidad ingresada.");
                                                } else {
                                                    data.selectedProducts[product.id].quantity = quantity;
                                                    var quantityWSP = quantityUniversalPromo(data.selectedProducts[product.id]);
                                                    document.getElementById("quantityProduct_" + product.id).value = quantity;
                                                    if (document.getElementById('quantityProduct_' + product.id).value >= quantityWSP) {
                                                        data.selectedProducts[product.id].price = data.selectedProducts[product.id].wholeSalePrice;
                                                        document.getElementById('priceProduct_' + product.id).value = data.selectedProducts[product.id].price;
                                                    }
                                                }
                                            } else {
                                                product.quantity = 1;
                                                data.products[product.id] = product;
                                                data.selectedProducts[product.id] = product;
                                                addSelectedProduct(product.id);
                                            }
                                        } else {
                                            alert("No se encontraron productos. Verifique si este cuenta con stock");
                                        }
                                        closeAllLists();
                                    });
                                } else {
                                    b.style.background = '#eee';
                                    b.style.cursor = 'no-drop';
                                }
                                a.appendChild(b);
                                var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
                            }                            
                        }
                    });
                }
            });
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items-payments");
                for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        autocompleteForClients(document.getElementById('inputSearchClient'));
        autocompleteForProducts(document.getElementById('searchProduct'));
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>