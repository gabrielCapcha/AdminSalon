<!-- Laravel App -->
<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.lightSlider.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script>
    //Document Ready
    var optionPad;
    var newUserForm;
    var setPadNumber;
    var loadProducts;
    var typePayments;
    var clearPadNumber;
    var changePriceList;
    var clearPadNumber1;
    var clearPadNumber2;
    var clearPadNumber3;
    var newSettingsForm;
    var saveNewSettings;
    var secondStepOfSale;
    var openTypeDocument;
    var addSelectedProduct;
    var changeTypeDocument;
    var saveNewSimpleClient;
    var setPadNumberOption1;
    var setPadNumberOption2;
    var setPadNumberOption3;
    var clearSelectedProduct;
    var updateSelectedProduct;
    var clearAllSelectedProduct;
    var newSaleButtonN;
    $(document).ready(function() {
        //Initialize slider
        $("#demo").lightSlider({
            loop:true,
            keyPress:true
        });
        //Initialize variables
        var data = {};
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
        var countItemKey = 0;
        var userList = JSON.parse(document.getElementById('listOfUsers').value);
        var genericCustomer = JSON.parse(document.getElementById("genericCustomer").value);
        var companyLoginData = JSON.parse(document.getElementById("companyLoginData").value);
        var typePaymentNames = {
                1 : { "name": "EFECTIVO", "type": "number", "htmlId": "cashInputValue", "selected": true, "additionalBox": false, "readOnly": false, "exchange": true },
                2 : { "name": "VISA", "type": "number", "htmlId": "visaInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                3 : { "name": "MASTERCARD", "type": "number", "htmlId": "mastercardInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                6 : { "name": "DEPÓSITO", "type": "number", "htmlId": "depositInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                8 : { "name": "CRÉDITO", "type": "text", "htmlId": "creditInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                // 9 : { "name": "LETRAS", "type": "text", "htmlId": "letterInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                10 : { "name": "IZIPAY", "type": "number", "htmlId": "izipayInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                11 : { "name": "UBER EATS", "type": "number", "htmlId": "ubereatsInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                12 : { "name": "GLOVO", "type": "number", "htmlId": "glovoInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                13 : { "name": "RAPPI", "type": "number", "htmlId": "rappiInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                14 : { "name": "VENDEMAS", "type": "number", "htmlId": "vendemasInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
        };
        var typeDocumentNames = {
            1 : { "name": "BOLETA", "code": "BLT", "htmlClass":"warning" },
            2 : { "name": "FACTURA", "code": "FAC", "htmlClass":"danger" },
            5 : { "name": "PRECUENTA", "code": "NVT", "htmlClass":"info" },
        };
        var typeDocumentCode = document.getElementById('typeDoc').value;
        var typeDocumentName = document.getElementById('typeDocName').value;
        var universalPromoValue = companyLoginData.universal_promo;
        var universalPromoBoolean = false;
        //malpartida
        var saleOrder = '';
        var advertisement = '';
        var remissionGuide = '';
        var saleCommentary = '';
        //call function
        // openTypeDocument();
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
        data.typePayments = [{"id": 1, "name": "EFECTIVO", "htmlId": "cashInputValue", "selected": true}];
        data.buttonCategory = 0;
        data.selectedProducts = [];
        data.suppliedCustomer = {};
        //INTERVALS
        //functions
        setInterval(function(){
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
            document.getElementById("buttonPaymentAmount").value = data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);
            if (buttonVd_) {
                if (typeDocumentCode == 'BLT') {
                    if (data.customer.dni == '88888888' && ((amountValue - generalDiscount) >= 700)) {
                        var finishNewSale = document.getElementById('finishNewSale');
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Monto mayor o igual a 700 soles. Ingrese DNI';
                    } else {
                        var finishNewSale = document.getElementById('finishNewSale');
                        finishNewSale.disabled = false;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Validación correcta.';
                    }
                }
                if (typeDocumentCode == 'FAC') {
                    if (data.customer.ruc == '88888888888' || (data.customer.ruc.length < 11)) {
                        var finishNewSale = document.getElementById('finishNewSale');
                        finishNewSale.disabled = true;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Tipo de documento FACTURA. Ingrese RUC';
                    } else {
                        var finishNewSale = document.getElementById('finishNewSale');
                        finishNewSale.disabled = false;
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'Validación correcta.';
                    }                
                }
            }
        }, 1000);

        function getCurrencySymbolCode(currency) {
            var symbolCode = 'S/ ';
            switch (currency) {
                case 'PEN':
                    symbolCode = 'S/ ';
                    break;
                case 'USD':
                    symbolCode = '$ ';
                    break;
                case 'EUR':
                    symbolCode = '€ ';
                    break;
                case 'JPY':
                    symbolCode = '¥ ';
                    break;
                default:
                    symbolCode = '$ ';
                    break;
            }
            return symbolCode;
        }
        function universalPromo() {
            data.selectedProducts.forEach(element => {
                if (element.flagUniversalPromo && universalPromoBoolean) {
                    element.price = element.wholeSalePrice - element.partialDiscount;
                    document.getElementById("priceProduct_" + element.id ).value = element.price;
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
        newSaleButtonN = function() {
            location.reload();
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
                            '<input type="text" class="form-control" id="clientSecondLastname" readonly placeholder="Ingrese APELLIDO MATERNO" value="' + response.apellidoMaterno + '"></div></div>' +
                            '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                            '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                            '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                            '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div></div>';
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
                                '<input type="text" class="form-control" id="clientSecondLastname" readonly placeholder="Ingrese RUC" value="' + searchClientSunat + '"></div></div>' +
                                '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                                '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div></div>';
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
            if (data.newCustomer != undefined) {
                data.newCustomer.phone = document.getElementById("clientPhone").value;
                data.newCustomer.email = document.getElementById("clientEmail").value;
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
                            alert("Hubo un error en el registro. Es posible que el cliente ya esté registrado.");
                        }
                    }
                }).done(function(response) {
                    data.customer = response;
                    data.customerId = response.id;
                    document.getElementById("inputSearchClient").value    = response.name + " " + response.lastname;
                    $('#dismissNewClient').trigger('click');
                });
            }
        }
        function finishNewSale() {
            var serie___ = document.getElementById('serie').value;
            var number___ = document.getElementById('number').value;

            if (serie___ == '' || number___ == '') {
                if (serie___ == '') {
                    alert('Por favor, ingrese una SERIE válida.');
                } else {
                    alert('Por favor, ingrese un NÚMERO CORRELATIVO válido.');
                }
                newSettingsForm();
            } else {
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
                if (valueAmount___ <= 0) {
                    amountValue = 0;
                    exchangeAmount = 0;
                    payments.forEach(element => {
                        element.amount = 0;
                        element.exchange = 0;
                    });
                }
                if (saleValidation) {
                    data.sale = {
                        "app_id" : 6,
                        "amount": valueAmount___,
                        "serie": serie___,
                        "number": number___,
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
                                "timing": 0
                            }
                        ],
                        "discount": parseFloat(generalDiscount),
                        "isCustomer": false,
                        "items_": selectedProductsToSale,
                        "sal_sale_states_id": "3",
                        "sal_type_payments_id": "1",
                        "subtotal": (valueAmount___/1.18),
                        "taxes": (valueAmount___ - valueAmount___/1.18),
                        "transaction": true,
                        "payment_amount": paymentAmount,
                        "exchange_amount": exchangeAmount,
                        "type_document_code": typeDocumentCode,
                        "type_document_name": typeDocumentName,
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
                                console.log(response);
                                $('#errorSale').trigger('click');
                            },
                            500: function(response) {
                                console.log(response);
                                $('#errorSale').trigger('click');
                            },
                        }
                    }).done(function(response) {
                        idNewSale = response.id;
                        $('#successSale').trigger('click');
                        $('*:not(#successSale)').click(function(e){
                            e.preventDefault();
                        });
                    });
                }
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
                    // console.log("Se envió el correo");
                });
            }
        }
        function callProductsListeners(product, employeeId, countItemKey){
            document.getElementById(`row_${product.id }${employeeId ? "_" + employeeId : "" }`).addEventListener("click", function() {
                document.getElementById('quantityButtonPad').style.backgroundColor = '#ffffff';
                document.getElementById('partialCashDiscountButtonPad').style.backgroundColor = '#ffffff';
                document.getElementById('partialPercentDiscountButtonPad').style.backgroundColor = '#ffffff';
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
                
            });
            document.getElementById('priceProduct_' + product.id + '_' + employeeId).addEventListener("keyup", function(event) {
                event.preventDefault();
                var priceInput_ = document.getElementById("priceProduct_" + product.id + '_' + employeeId);
                data.selectedProducts[countItemKey].price = priceInput_.value;
            });
            //document.getElementById("buttonPaymentAmount").value = data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);
            document.getElementById('partialDiscount_' + product.id + '_' + employeeId).addEventListener("keyup", function(event) {
                event.preventDefault();
                var quantityWSP = quantityUniversalPromo(data.selectedProducts[countItemKey]);
                if (document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value >= quantityWSP) {
                    data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].wholeSalePrice;
                } else {
                    data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].originalPrice;
                }
                var discount = document.getElementById('partialDiscount_' + product.id + '_' + employeeId);
                var amountValue__ = parseFloat(discount.value);
                if (data.padOption == 3) {
                    amountValue__ = (data.selectedProducts[countItemKey].price * (parseFloat(discount.value)/100));
                }
                if (amountValue__ > data.selectedProducts[countItemKey].price) {
                    if (document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value >= quantityWSP) {
                        discount.value = data.selectedProducts[countItemKey].wholeSalePrice;
                        data.selectedProducts[countItemKey].partialDiscount = data.selectedProducts[countItemKey].wholeSalePrice;
                        data.selectedProducts[countItemKey].price = 0;
                        document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = 0;
                    } else {
                        discount.value = data.selectedProducts[countItemKey].originalPrice;
                        data.selectedProducts[countItemKey].partialDiscount = data.selectedProducts[countItemKey].originalPrice;
                        data.selectedProducts[countItemKey].price = 0;
                        document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = 0;
                    }
                } else if (isNaN(amountValue__) || amountValue__ == 0 || amountValue__ < 0) {
                    if (document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value >= quantityWSP) {
                        data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].wholeSalePrice;
                    } else {
                        data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].originalPrice;
                    }
                    data.selectedProducts[countItemKey].partialDiscount = 0;
                    discount.value = 0;
                    document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = data.selectedProducts[countItemKey].price;
                } else {
                    if (document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value >= quantityWSP) {
                        data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].wholeSalePrice - amountValue__;
                    } else {
                        data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].originalPrice - amountValue__;
                    }
                    data.selectedProducts[countItemKey].partialDiscount = amountValue__;
                    document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = data.selectedProducts[countItemKey].price;
                }
                
            });
            document.getElementById('quantityProduct_' + product.id + '_' + employeeId).addEventListener("keyup", function(event) {
                event.preventDefault();
                var quantityProduct__ = parseFloat(document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value);
                if (data.selectedProducts[countItemKey].stock < document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value) {
                    data.selectedProducts[countItemKey].quantity = data.selectedProducts[countItemKey].stock;
                    document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value = data.selectedProducts[countItemKey].stock;
                    alert("El stock actual es menor que la cantidad ingresada.");
                } else if (isNaN(quantityProduct__) || quantityProduct__ == 0 || quantityProduct__ < 0) {
                    document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value = 1;
                    data.selectedProducts[countItemKey].quantity = 1;
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
                    if (data.selectedProducts[countItemKey].flagUniversalPromo) {
                        universalPromo();   
                    }
                } else {
                    data.selectedProducts[countItemKey].quantity = document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value;
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
                    var quantityWSP = quantityUniversalPromo(data.selectedProducts[countItemKey]);
                    if (document.getElementById('quantityProduct_' + product.id + '_' + employeeId).value >= quantityWSP) {
                        data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].wholeSalePrice - data.selectedProducts[countItemKey].partialDiscount;
                        document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = data.selectedProducts[countItemKey].price;
                    } else {
                        data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].originalPrice - data.selectedProducts[countItemKey].partialDiscount;
                        document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = data.selectedProducts[countItemKey].price;
                    }
                    if (data.selectedProducts[countItemKey].flagUniversalPromo) {
                        universalPromo();   
                    }
                }
                
            });
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
            var exchange = paymentAmount - (parseFloat(amountValue) - generalDiscount_);
            if (isNaN(paymentAmount) || paymentAmount < (parseFloat(amountValue) - generalDiscount_)) {
                var x__ = document.getElementById('finishNewSale');
                x__.disabled = true;
                var saleErrorMessage = document.getElementById('saleErrorMessage');
                saleErrorMessage.innerHTML = 'Monto de ingreso menor a la venta.';
                buttonVd_ = false;
            } else {
                var x__ = document.getElementById('finishNewSale');
                x__.disabled = false;
                var saleErrorMessage = document.getElementById('saleErrorMessage');
                saleErrorMessage.innerHTML = 'Validación correcta.';
                buttonVd_ = true;
            }
            if (exchange > 0) {
                document.getElementById('cashInputExchange').value = exchange;
            } else {
                document.getElementById('cashInputExchange').value = 0;
            }
        }
        //var functions
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
        }
        loadProducts = function(id) {
            document.getElementById("productsDivList").innerHTML = "";
            var selectedCategories = id;
            var x = document.getElementById("loadingDiv");
            var productsDivList = document.getElementById("productsDivList");
            if (data.buttonCategory != 0) {
                var btnCategoryOld = document.getElementById("buttonCategory-" + data.buttonCategory);
                btnCategoryOld.disabled = false;
                btnCategoryOld.style.backgroundColor = "#9daeb8";
            }
            data.buttonCategory = id;
            var btnCategoryNew = document.getElementById("buttonCategory-" + id);
            btnCategoryNew.disabled = true;
            btnCategoryNew.style.backgroundColor = "#ffffff";
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
                    // if (response[i].stock > 0) {
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
                            var buttonHeadClass_ = '<button type="button" align="center" class="info-box-custom-2" id="infoBoxProduct_' + response[i].id + '" onclick="selectEmployee( ' + response[i].id + ' );">';
                            if (response[i].stock < 1) {
                                buttonHeadClass_ = '<button type="button" align="center" class="info-box-custom-2-cancel" id="infoBoxProduct_' + response[i].id + '>';
                            }
                            var element =  buttonHeadClass_ +
                                '<div class="card-custom">'+
                                '   <img src="' + urlImage + '" alt="Avatar" style="width:100px; height: 100px;">'+
                                '   <div class="container-custom">'+
                                '       <h5 style="font-size:12px; font-weight:bold;">' + response[i].name + '</h5>'+
                                '       <p style="font-size:10px;">' + data.symbolCode + ' ' + response[i].price + ' <br>(Stock: ' + response[i].stock + ')</p>'+
                                '       <p style="font-size:8px;">' + response[i].description + '</p>'+
                                '   </div>'+
                                '</div>'+
                            '</button>';
                        } else {
                            var buttonHeadClass_ = '<button type="button" align="center" class="info-box-custom" id="infoBoxProduct_' + response[i].id + '">';
                            if (response[i].stock < 1) {
                                buttonHeadClass_ = '<button type="button" align="center" class="info-box-custom-cancel" id="infoBoxProduct_' + response[i].id + '>';
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
                                '       <img src="' + urlImage + '" style="height:100px; width:120px;">'+
                                '   </div>';
                            if ((response[i].type == 1 && response[i].stock < 1) || response[i].flag_operation == 1) {
                                element = element + 
                                    '   <div class="container-custom">'+
                                    '       <hr style="margin-top:5px;margin-bottom:0px;">' + 
                                    '       <h5 style="font-size:12px; font-weight:bold; max-width: 120px;">' + response[i].name + '</h5>'+
                                    '       <h5 style="font-size:12px; font-weight:bold; margin-bottom:5px;">' + getCurrencySymbolCode(data.currency) + ' ' + response[i].price + '</h5>' +
                                    '       <h5 style="font-size:12px; font-weight:bold; margin-top:5px;">(Stock: ' + response[i].stock + ')</h5>' +
                                    '       <p style="font-size:8px; max-width: 120px;">' + description__ + '</p>'+
                                    '   </div>'+
                                    '</div>'+
                                '</div>';
                            } else {
                                var stock = response[i].stock;
                                if (response[i].type == 2) {
                                    stock = '-';
                                }
                                element = element + 
                                    '   <div class="container-custom" id="infoBoxProductFunction_' + response[i].id + '" onclick="selectEmployee(' + response[i].id + ');">'+
                                    '       <hr style="margin-top:5px;margin-bottom:0px;">' + 
                                    '       <h5 style="font-size:12px; font-weight:bold; max-width: 120px;">' + response[i].name + '</h5>'+
                                    '       <h5 style="font-size:12px; font-weight:bold; margin-bottom:5px;">' + getCurrencySymbolCode(data.currency) + ' ' + response[i].price + '</h5>' +
                                    '       <h5 style="font-size:12px; font-weight:bold; margin-top:5px;">(Stock: ' + stock + ')</h5>' +
                                    '       <p style="font-size:8px; max-width: 120px;">' + description__ + '</p>'+
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
                            }
                        }
                    // }
                }
            });
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
            
            var xTable = document.getElementById('tBodyTableProductsSummary');
            xTable.innerHTML = "";
            var pResume = document.getElementById('totalResumeAmount');
            amountValue = 0;
            generalDiscount = 0;
            exchangeAmount = 0;
            document.getElementById('cashInputExchange').value = 0;
            document.getElementById('generalDiscount').value = 0;
            data.selectedProducts.forEach(element => {
                // var priceInput_ = document.getElementById("priceProduct_" + element.id + '_' + element.createdBy);
                // if (priceInput_ != null) {
                //     element.price = parseFloat(priceInput_.value);
                // }
                if (element.quantity > 0) {
                    var tr = document.createElement('tr');
                    tr.setAttribute("style", "font-size:10px;");
                    tr.innerHTML ='<td>' + element.code + '</td><td>' + element.name + '</td>' +
                        '<td>' + element.price + '</td><td>' + element.quantity + '</td>';
                    xTable.appendChild(tr); 
                    amountValue = amountValue + (element.price*element.quantity);   
                }
            });
            amountValue_ = amountValue;
            pResume.innerHTML = '<b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);
            if (data.customer.ruc == undefined) {
                document.getElementById('clientName').innerHTML = data.customer.name + ', ' + data.customer.lastname + ' - DNI: ' + data.customer.dni;   
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
            }
            data.typePayments.forEach(element => {
                var initialCash = 0;
                if (countInitialCash == 0 && (data.typePayments.length == 1)) {
                    initialCash = amountValue;
                    document.getElementById('finishNewSale').disabled = false;
                } else {
                    document.getElementById('finishNewSale').disabled = true;
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
        selectEmployee = function (product) {
            document.getElementById('preAddProductId').value = product;
            
            var element = '<div id="selector_' + product + '"><select  onchange="preAddEmployee()" style="text-align-last: center;" class="form-control" id="selectEmployee">'+
                            '<option selected value="0">Sin empleado a comisionar</option>'+
                            '@foreach ($jsonResponse->users as $employee)'+
                                '<option value="{{ $employee->id }}">{{ $employee->name }} {{ $employee->lastname }}</option>'+
                            '@endforeach'+
                        '</select></div>';
            $('#employeeSelector').append(element);
            $('#modal-select-employee').modal({backdrop: 'static', keyboard: false});
        }
        preAddEmployee = function () {
            var selectedEmployee = document.getElementById('selectEmployee').value;

            var selectedProduct = document.getElementById('preAddProductId').value;
            product = data.products[selectedProduct];

            var newArray = [];
            var element = document.createElement('div');
            element.setAttribute("id", "rowCommission_" +  selectedEmployee);
            element.setAttribute("style", "padding-bottom:10px;");
            element.setAttribute("class", "col-md-12");
            element.setAttribute("align", "center");
            userList.forEach(element_ => {
                if (element_.id == selectedEmployee) {
                    element.innerHTML ='<input type="hidden" value="' + selectedProduct + '" id="productValue_' + element_.id + '"></input>'+
                    '<div class="col-md-4">' + element_.name + ' ' + element_.lastname + '</div>' +
                    '<div class="col-md-4">' + product.name + '</div>'+
                    '<div class="col-md-4"> S/.' + product.price + '</div>';
                }
                newArray.push(element.id)
            });
            preProductIdList = newArray;
            if (selectedEmployee != 0) {
                $('#detailEmployee').append(element);
            }
        }

        addAllCommissions = function () {
            var removeElement;
            userList.forEach(element => {
                var addCommissionProduct = document.getElementById('rowCommission_' + element.id);
                if (addCommissionProduct != undefined) {
                    addCommissionProduct = document.getElementById('productValue_' + element.id).value;
                    addSelectedProduct(addCommissionProduct, element.id);
                    removeElement = document.getElementById('rowCommission_'+ element.id)
                    removeElement.remove();
                }
            });
            var preAddProduct = document.getElementById("preAddProductId").value;
            var selector = document.getElementById('selectEmployee');
            if (selector.value == 0) {
                addSelectedProduct(preAddProduct, parseInt(selector.value));
            }
            var removeSelector = document.getElementById('selector_'+ preAddProduct);
            removeSelector.remove();
        }
        removeEmployeeModal = function () {
            var removeElement;
            userList.forEach(element => {
                var removeElement = document.getElementById('rowCommission_'+ element.id)
                if (removeElement != undefined) {
                    removeElement.remove();
                }
            });
            var preAddProduct = document.getElementById("preAddProductId").value;
            var removeSelector = document.getElementById('selector_'+ preAddProduct);
            removeSelector.remove();
            $('#modal-select-employee').modal("hide");
        }
        addSelectedProduct = function (product, employeeId) {
            var xTable = document.getElementById('tBodyTableSelectedProducts');
            var tr = document.createElement('tr');
            product = data.products[product];
            product.quantity = 1;
            var rowEmployee;
            userList.forEach(element_ => {
                if (element_.id == employeeId) {
                    rowEmployee = element_;
                }
            });
            var quantityProduct__ = document.getElementById('quantityProduct_' + product.id);
            if (quantityProduct__ != null) {
                data.selectedProducts[countItemKey].quantity = parseFloat(data.selectedProducts[countItemKey].quantity) + parseFloat(product.quantity);
                data.selectedProducts[countItemKey] = {...product, createdBy : employeeId};
                quantityProduct__.value = data.selectedProducts[countItemKey].quantity;
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
                data.selectedProducts[countItemKey] = product;
                data.selectedProducts[countItemKey] = {...product, createdBy : employeeId};
                tr.setAttribute("id", `row_${product.id }${employeeId ? "_" + employeeId : "" }`);
                tr.setAttribute("style", "font-size:10px;");
                if (rowEmployee != undefined){
                    tr.innerHTML ='<td class="static-table-td">' + product.code + '</td>' +
                    '</td><td class="static-table-td">' + product.name + '-' + rowEmployee.name + ' ' + rowEmployee.lastname + '</td>' +
                    '<td class="static-table-td-input"><input type="number" id="priceProduct_' + product.id + '_' + employeeId + '" value="' + product.price + '"></td>' + 
                    '<td class="static-table-td-input" style="padding-left: 0px;"><i style="color: #ffffff;" id="partialDiscountSymbol_' + product.id + '">' + data.symbolCode + ' </i><input type="number" onClick="this.select();" id="' + `partialDiscount_${product.id }${employeeId ? "_" + employeeId : "" }` + '" value=0></td>' +
                    '<td class="static-table-td-input"><input type="number" onClick="this.select();" id="quantityProduct_' + product.id + '_' + employeeId + '" value=1></td>' +
                    '<td class="static-table-td"><div class="input-group input-group-sm"><span class="input-group-btn"><button type="button" onclick="clearSelectedProduct(' + product.id + ',' + employeeId + ',' + countItemKey + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
                } else {
                    tr.innerHTML ='<td class="static-table-td">' + product.code + '</td>' +
                    '</td><td class="static-table-td">' + product.name + '-' + '</td>' +
                    '<td class="static-table-td-input"><input type="number" id="priceProduct_' + product.id + '_' + employeeId + '" value="' + product.price + '"></td>' + 
                    '<td class="static-table-td-input" style="padding-left: 0px;"><i style="color: #ffffff;" id="partialDiscountSymbol_' + product.id + '">' + data.symbolCode + ' </i><input type="number" onClick="this.select();" id="partialDiscount_' + product.id + '_' + employeeId + '" value=0></td>' +
                    '<td class="static-table-td-input"><input type="number" onClick="this.select();" id="quantityProduct_' + product.id + '_' + employeeId + '" value=1></td>' +
                    '<td class="static-table-td"><div class="input-group input-group-sm"><span class="input-group-btn"><button type="button" onclick="clearSelectedProduct(' + product.id + ',' + employeeId + ',' + countItemKey + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
                }
                xTable.insertBefore(tr, xTable.firstChild);
                var x = document.getElementById("infoBoxProduct_" + product.id);
                if (x != null) {
                    x.style.pointerEvents   = "none";
                    x.style.backgroundColor = "#9daeb8";   
                }
                //Prev Selected
                document.getElementById('quantityButtonPad').style.backgroundColor = '#ffffff';
                document.getElementById('partialCashDiscountButtonPad').style.backgroundColor = '#ffffff';
                document.getElementById('partialPercentDiscountButtonPad').style.backgroundColor = '#ffffff';
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
                callProductsListeners(product, employeeId, countItemKey);
            }
            countItemKey++;
        }
        clearSelectedProduct = function (productId, employeeId, countItemKey) {
            data.selectedProducts[countItemKey].price = data.selectedProducts[countItemKey].originalPrice;
            data.selectedProducts[countItemKey].partialDiscount = 0;
            data.selectedProducts[countItemKey].quantity = 1;
            delete(data.selectedProducts[countItemKey]);
            var selectedElement = document.getElementById(`row_${productId}${employeeId ? "_" + employeeId : "" }`);
            if (selectedElement !== null) {
                selectedElement.remove();
            }
            var x = document.getElementById("infoBoxProduct_" + productId);
            var isSelected = false;
            var y = document.getElementById(("row_" + productId));
            userList.forEach(element => {
                var z = document.getElementById("row_" + productId + "_" + element.id);
                if (y != null || z != null) {
                    isSelected = true;
                }
            });
            if (isSelected == false) {
                x.style.pointerEvents   = "auto";
                x.style.backgroundColor = "#ffffff";
            }
            // quantityValue = 0;
            // data.selectedProducts.forEach(element => {
            //     if (element.quantity > 0) {
            //         if (element.flagUniversalPromo) {
            //             quantityValue = parseFloat(quantityValue) + parseFloat(element.quantity);
            //             if (quantityValue < universalPromoValue) {
            //                 universalPromoBoolean = false;
            //                 universalPromo();
            //             }
            //         }
            //     }
            // });
            
        }
        clearAllSelectedProduct = function () {
            data.rowClickedId = 0;
            data.padOption = 0;
            data.selectedProducts.forEach(element => {
                document.getElementById(`row_${element.id }${element.createdBy ? "_" + element.createdBy : "" }`).remove();
                    var x = document.getElementById("infoBoxProduct_" + element.id);
                    if (x != null) {
                        x.style.pointerEvents   = "auto";
                        x.style.backgroundColor = "#ffffff";   
                    }
            });
            data.selectedProducts = [];
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
                    url: "/api/products-search/" + searchProductBarCode.value,
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
                                        document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = data.selectedProducts[product.id].price;
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
                amountValue = amountValue - generalDiscount__;
            }
            var pResume = document.getElementById('totalResumeAmount');
            pResume.innerHTML = 'Total a pagar: ' + data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);

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
                amountValue = amountValue - generalDiscount__;
            }
            var pResume = document.getElementById('totalResumeAmount');
            pResume.innerHTML = 'Total a pagar: ' + data.symbolCode + ' ' + parseFloat(amountValue).toFixed(2);

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
                    a.setAttribute("class", "autocomplete-items");
                    this.parentNode.appendChild(a);
                    mainheaderSearchBar.style.height = "50px";
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
                var x = document.getElementsByClassName("autocomplete-items");
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
                    a.setAttribute("class", "autocomplete-items");
                    this.parentNode.appendChild(a);
                    mainheaderSearchBar.style.height = "50px";
                    //LLAMADA AL SERVICIO
                    $.ajax({
                        url: "/api/products-for-sale/" + val,
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
                                                        document.getElementById('priceProduct_' + product.id + '_' + employeeId).value = data.selectedProducts[product.id].price;
                                                    }
                                                }
                                            } else {
                                                product.quantity = 1;
                                                data.products[product.id] = product;
                                                selectEmployee(product.id);
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
                var x = document.getElementsByClassName("autocomplete-items");
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