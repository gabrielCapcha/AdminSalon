<!-- Laravel App -->
<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.lightSlider.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/bootstrap-toggle/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
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
    var salesList;
    var salesReport;
    var setPadNumberOption1;
    var setPadNumberOption2;
    var setPadNumberOption3;
    var clearSelectedProduct;
    var updateSelectedProduct;
    var pickCustomerSubsidiary;
    var clearAllSelectedProduct;
    var countItemKey = 0;
    var destinySubsidiary = 0;
    var destinySubsidiaryObject = null;
    var creditPayment = false;
    var isQuotation = document.getElementById('isQuotation').value;
    $(document).ready(function() {
        //Initialize slider
            $("#demo").lightSlider({
                loop:true,
                keyPress:true
            });
        //Initialize variables
            var amountQuotes= 0;
            var initialCreditPayment = 0;
            var fixedVar = 4;
            var data = {};
            var subcategories = {};
            var parentSubcategory = 0;
            var sal_sale_documents_id = null;
            var detailCommentaryId = 0;
            var priceValidation = true;
            var allotments = [];
            var allotmentSelected = [];
            var allotmentProductId = 0;
            var cashManagementExchangeValue = 0;
            var cashManagement = false;
            var intervalPriceList = true;
            var buttonVd_ = true;
            var documentClientValidation = true;
            var idNewSale = 0;
            var feRuc = null;
            var ticket = null;
            var serie = null;
            var number = null;
            var s3Pdf = null;
            var serialProductId = 0;
            var priceLists = [];
            var amountValue = 0;
            var amountValue_ = 0;
            var amountValueCurrency = [];
            var paymentAmount = 0;
            var quantityValue = 0;
            var paymentAmounts = [];
            var exchangeAmount = 0;
            var generalDiscount = 0;
            var promoDiscount__ = 0;
            var opExoneradas = 0;
            var opInafectas = 0;
            var opGratuitas = 0;
            var opIcbper = 0;
            var taxesUp = 1.18;
            var taxesDown = 0.18;
            var taxesServices = 0.7633333;
            var taxIcbper = 0.2;
            var opBag = 0;
            var saleResponse = null;
            var genericCustomer = JSON.parse(document.getElementById("genericCustomer").value);
            var companyLoginData = JSON.parse(document.getElementById("companyLoginData").value);
            var promotionsData = JSON.parse(document.getElementById('promotionsData').value);
            var userObject = JSON.parse(document.getElementById('userObject').value);
            var userList = JSON.parse(document.getElementById('listOfUsers').value);
            var servicePercent = document.getElementById('servicePercentValue').value;
            var typePaymentNames = {
                1 : { "name": "EFECTIVO", "type": "number", "htmlId": "cashInputValue", "selected": true, "additionalBox": false, "readOnly": false, "exchange": true },
                2 : { "name": "VISA", "type": "number", "htmlId": "visaInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                3 : { "name": "MASTERCARD", "type": "number", "htmlId": "mastercardInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                6 : { "name": "DEPÓSITO", "type": "number", "htmlId": "depositInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                8 : { "name": "CRÉDITO", "type": "text", "htmlId": "creditInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                // 9 : { "name": "LETRAS", "type": "text", "htmlId": "letterInputValue", "selected": false, "additionalBox": true, "readOnly": false, "exchange": false },
                10 : { "name": "IZIPAY", "type": "number", "htmlId": "izipayInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                // 11 : { "name": "UBER EATS", "type": "number", "htmlId": "ubereatsInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                12 : { "name": "GLOVO", "type": "number", "htmlId": "glovoInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                13 : { "name": "RAPPI", "type": "number", "htmlId": "rappiInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                14 : { "name": "VENDEMAS", "type": "number", "htmlId": "vendemasInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                //NUEVOS PAGOS AÑADIDOS 28/06
                15 : { "name": "LUKITA", "type": "number", "htmlId": "lukitaInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                16 : { "name": "YAPE", "type": "number", "htmlId": "yapeInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                17 : { "name": "TUNKI", "type": "number", "htmlId": "tunkiInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                18 : { "name": "AMERICAN EXPRESS", "type": "number", "htmlId": "americanExpressInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
                19 : { "name": "PLIM", "type": "number", "htmlId": "plimInputValue", "selected": false, "additionalBox": false, "readOnly": false, "exchange": false },
            };
            var typeDocumentNames = {
                1 : { "name": "BOLETA", "code": "BLT", "htmlClass":"warning" },
                2 : { "name": "FACTURA", "code": "FAC", "htmlClass":"danger" },
                5 : { "name": "PRECUENTA", "code": "NVT", "htmlClass":"info" },
                6 : { "name": "COTIZACIÓN", "code": "COT", "htmlClass":"info" },
            };
            var typeDocumentCode = null;
            var typeDocumentName = null;
            var universalPromoValue = companyLoginData.universal_promo;
            var universalPromoBoolean = false;
            var saleOrder = '';
            var advertisement = '';
            var remissionGuide = '';
            var saleCommentary = '';
            var saleCommentaryExt = '';
        //Data variables
            data.sale = {};
            data.products = [];
            data.currency = companyLoginData.currency;
            data.symbolCode = getCurrencySymbolCode(data.currency);
            data.customer = genericCustomer;
            data.padOption = 0;
            data.customerId = genericCustomer.id;
            data.priceListId = 0;
            data.rowClickedId = 0;
            data.typePayments = [{"id": 1, "type": "number", "name": "EFECTIVO", "htmlId": "cashInputValue", "selected": true}];
            data.buttonCategory = 0;
            data.selectedProducts = [];
            data.serials = [];
            data.suppliedCustomer = {};
            data.creditPayment = null;
        // update initial params
            var typeCurrency = document.getElementById('typeCurrency');
            if (typeCurrency != null) {
                typeCurrency.value = data.currency;
            }
        // functions
            function WebSocketPrinter(options) {
                var defaults = {
                    url: "ws://127.0.0.1:12212/printer",
                    onConnect: function () {
                    },
                    onDisconnect: function () {
                    },
                    onUpdate: function () {
                    },
                };

                var settings = Object.assign({}, defaults, options);
                var websocket;
                var connected = false;

                var onMessage = function (evt) {
                    settings.onUpdate(evt.data);
                };

                var onConnect = function () {
                    connected = true;
                    settings.onConnect();
                };

                var onDisconnect = function () {
                    connected = false;
                    settings.onDisconnect();
                    reconnect();
                };

                var connect = function () {
                    websocket = new WebSocket(settings.url);
                    websocket.onopen = onConnect;
                    websocket.onclose = onDisconnect;
                    websocket.onmessage = onMessage;
                };

                var reconnect = function () {
                    connect();
                };

                this.submit = function (data) {
                    if (Array.isArray(data)) {
                        data.forEach(function (element) {
                            websocket.send(JSON.stringify(element));
                        });
                    } else {
                        websocket.send(JSON.stringify(data));
                    }
                };

                this.isConnected = function () {
                    return connected;
                };

                connect();
            }
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
            function setInterval() {
                amountValue = 0;
                quantityValue = 0;
                universalPromoBoolean = false;
                data.selectedProducts.forEach(element => {
                    if (element.quantity > 0) {
                        if (element.taxExemptionReasonCode != 7152) {
                            amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                        }
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
                    var servicePercentValue = parseFloat(((amountValue-generalDiscount-promoDiscount__)*taxesServices) * (parseFloat(servicePercent)/100));
                    generalService.value = servicePercentValue;
                } else {
                    var servicePercentValue = 0.00;
                    generalService.value = servicePercentValue;
                }
                if (buttonVd_) {
                    if (typeDocumentCode == 'BLT') {
                        if (data.customer.dni == '88888888' && ((amountValue - generalDiscount - promoDiscount__) >= 700)) {
                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                            documentClientValidation = false;
                            var saleErrorMessage = document.getElementById('saleErrorMessage');
                            saleErrorMessage.innerHTML = 'Monto mayor o igual a 700 soles. Ingrese DNI';
                        } 
                        // else if (data.customer.dni == null) {
                        //     document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        //     documentClientValidation = false;
                        //     var saleErrorMessage = document.getElementById('saleErrorMessage');
                        //     saleErrorMessage.innerHTML = 'Ingrese cliente DNI';
                        // } else if (data.customer.dni.length < 8) {
                        //     document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        //     documentClientValidation = false;
                        //     var saleErrorMessage = document.getElementById('saleErrorMessage');
                        //     saleErrorMessage.innerHTML = 'Ingrese cliente DNI';
                        // } 
                        else {
                            documentClientValidation = true;
                            var saleErrorMessage = document.getElementById('saleErrorMessage');
                            saleErrorMessage.innerHTML = 'VALIDE SU OPERACIÓN';
                            document.getElementById('saleErrorMessage').className = 'btn btn-warning pull-center';
                        }
                    }
                    if (typeDocumentCode == 'FAC') {
                        if (data.customer.ruc == '88888888888') {
                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                            documentClientValidation = false;
                            var saleErrorMessage = document.getElementById('saleErrorMessage');
                            saleErrorMessage.innerHTML = 'Tipo de documento FACTURA. Ingrese RUC';
                        } else if (data.customer.ruc == null) {
                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                            documentClientValidation = false;
                            var saleErrorMessage = document.getElementById('saleErrorMessage');
                            saleErrorMessage.innerHTML = 'Tipo de documento FACTURA. Ingrese RUC';
                        } else if (data.customer.ruc.length < 11) {
                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                            documentClientValidation = false;
                            var saleErrorMessage = document.getElementById('saleErrorMessage');
                            saleErrorMessage.innerHTML = 'Tipo de documento FACTURA. Ingrese RUC';
                        } else {
                            documentClientValidation = true;
                            var saleErrorMessage = document.getElementById('saleErrorMessage');
                            saleErrorMessage.innerHTML = 'VALIDE SU OPERACIÓN';
                            document.getElementById('saleErrorMessage').className = 'btn btn-warning pull-center';
                        }                
                    }
                    if (typeDocumentCode == 'NVT') {
                        var saleErrorMessage = document.getElementById('saleErrorMessage');
                        saleErrorMessage.innerHTML = 'VALIDE SU OPERACIÓN';
                        document.getElementById('saleErrorMessage').className = 'btn btn-warning pull-center';
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
                                    '<div class="form-group"><label for="rzSocial">RAZÓN SOCIAL</label>' +
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
                                    document.getElementById('searchNewClientSunat').value = "";
                                    var buttonSaveNewClient = document.getElementById('saveNewClient');
                                    buttonSaveNewClient.disabled = false;
                                    clientDataResponse.innerHTML = "";
                                    var form = document.createElement('form');
                                    form.innerHTML ='<div class="box-body col-md-6">' +
                                        '<div class="form-group">' +
                                        '<label for="clientDni">DNI</label>' +
                                        '<input type="text" class="form-control" id="clientDni" placeholder="Ingrese DNI" value="' + searchClientSunat + '"></div>' +
                                        '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                                        '<input type="text" class="form-control" id="clientNames" placeholder="Ingrese NOMBRES" value=""></div>' +
                                        '<div class="form-group"><label for="clientFirstLastname">APELLIDO PATERNO</label>' + 
                                        '<input type="text" class="form-control" id="clientFirstLastname" placeholder="Ingrese APELLIDO PATERNO" value=""></div>' +
                                        '<div class="form-group"><label for="clientSecondLastname">APELLIDO MATERNO</label>' +
                                        '<input type="text" class="form-control" id="clientSecondLastname" placeholder="Ingrese APELLIDO MATERNO" value=""></div>' +
                                        '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                        '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div>' +
                                        '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                        '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                                        '<div class="form-group"><label for="clientAddress">DIRECCIÓN</label>' +
                                        '<input type="text" class="form-control" id="clientAddress" maxlength=200 placeholder="Ingrese DIRECCIÓN" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">DISTRITO</label>' +
                                        '<input type="text" class="form-control" id="clientDistrict" maxlength=100 placeholder="Ingrese DISTRITO" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">PROVINCIA</label>' +
                                        '<input type="text" class="form-control" id="clientProvince" maxlength=100 placeholder="Ingrese PROVINCIA" value=""></div>'+
                                        '<div class="form-group"><label for="clientDepartment">DEPARTAMENTO</label>' +
                                        '<input type="text" class="form-control" id="clientDepartment" maxlength=100 placeholder="Ingrese DEPARTAMENTO" value=""></div></div>'+
                                        '<div class="box-body col-md-6" align=center><div class="form-group"><label for="clientDetail">DETALLE</label>'+
                                        '<input type="text" class="form-control" id="clientDetail" placeholder="Ingrese DETALLE" value=""></div></div>';
                                    clientDataResponse.appendChild(form);
                                    data.newCustomer = {};
                                    data.newCustomer.typeCustomer = 1;
                                    alert("No se encontraron registros en la RENIEC.");
                                },
                                500: function () {
                                    x.style.display = "none";
                                    document.getElementById('searchNewClientSunat').value = "";
                                    var buttonSaveNewClient = document.getElementById('saveNewClient');
                                    buttonSaveNewClient.disabled = false;
                                    clientDataResponse.innerHTML = "";
                                    var form = document.createElement('form');
                                    form.innerHTML ='<div class="box-body col-md-6">' +
                                        '<div class="form-group">' +
                                        '<label for="clientDni">DNI</label>' +
                                        '<input type="text" class="form-control" id="clientDni" placeholder="Ingrese DNI" value="' + searchClientSunat + '"></div>' +
                                        '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                                        '<input type="text" class="form-control" id="clientNames" placeholder="Ingrese NOMBRES" value=""></div>' +
                                        '<div class="form-group"><label for="clientFirstLastname">APELLIDO PATERNO</label>' + 
                                        '<input type="text" class="form-control" id="clientFirstLastname" placeholder="Ingrese APELLIDO PATERNO" value=""></div>' +
                                        '<div class="form-group"><label for="clientSecondLastname">APELLIDO MATERNO</label>' +
                                        '<input type="text" class="form-control" id="clientSecondLastname" placeholder="Ingrese APELLIDO MATERNO" value=""></div>' +
                                        '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                        '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div>' +
                                        '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                        '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                                        '<div class="form-group"><label for="clientAddress">DIRECCIÓN</label>' +
                                        '<input type="text" class="form-control" id="clientAddress" maxlength=200 placeholder="Ingrese DIRECCIÓN" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">DISTRITO</label>' +
                                        '<input type="text" class="form-control" id="clientDistrict" maxlength=100 placeholder="Ingrese DISTRITO" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">PROVINCIA</label>' +
                                        '<input type="text" class="form-control" id="clientProvince" maxlength=100 placeholder="Ingrese PROVINCIA" value=""></div>'+
                                        '<div class="form-group"><label for="clientDepartment">DEPARTAMENTO</label>' +
                                        '<input type="text" class="form-control" id="clientDepartment" maxlength=100 placeholder="Ingrese DEPARTAMENTO" value=""></div></div>'+
                                        '<div class="box-body col-md-6" align=center><div class="form-group"><label for="clientDetail">DETALLE</label>'+
                                        '<input type="text" class="form-control" id="clientDetail" placeholder="Ingrese DETALLE" value=""></div></div>';
                                    clientDataResponse.appendChild(form);
                                    data.newCustomer = {};
                                    data.newCustomer.typeCustomer = 1;
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
                                    document.getElementById('searchNewClientSunat').value = "";
                                    var buttonSaveNewClient = document.getElementById('saveNewClient');
                                    buttonSaveNewClient.disabled = false;
                                    clientDataResponse.innerHTML = "";
                                    var form = document.createElement('form');
                                    form.innerHTML ='<div class="box-body col-md-6">' +
                                        '<div class="form-group">' +
                                        '<label for="nombre_comercial">NOMBRE COMERCIAL</label>' +
                                        '<input type="text" class="form-control" id="nombre_comercial" placeholder="Ingrese NOMBRE COMERCIAL" value=""></div>' +
                                        '<div class="form-group"><label for="rz_socialS">RAZÓN SOCIAL</label>' +
                                        '<input type="text" class="form-control" id="rz_socialS" placeholder="Ingrese NOMBRES" value=""></div>' +
                                        '<div class="form-group"><label for="clientFirstLastname">TIPO DE CONTRIBUYENTE</label>' + 
                                        '<input type="text" class="form-control" id="clientFirstLastname" placeholder="Ingrese TIPO DE CONTRIBUYENTE" value=""></div>' +
                                        '<div class="form-group"><label for="clientSecondLastname">RUC</label>' +
                                        '<input type="text" class="form-control" id="clientSecondLastname" placeholder="Ingrese RUC" value="' + searchClientSunat + '"></div>' +
                                        '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                        '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div>' +
                                        '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                        '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                                        '<div class="form-group"><label for="clientAddress">DIRECCIÓN</label>' +
                                        '<input type="text" class="form-control" id="clientAddress" maxlength=200 placeholder="Ingrese DIRECCIÓN" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">DISTRITO</label>' +
                                        '<input type="text" class="form-control" id="clientDistrict" maxlength=100 placeholder="Ingrese DISTRITO" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">PROVINCIA</label>' +
                                        '<input type="text" class="form-control" id="clientProvince" maxlength=100 placeholder="Ingrese PROVINCIA" value=""></div>'+
                                        '<div class="form-group"><label for="clientDepartment">DEPARTAMENTO</label>' +
                                        '<input type="text" class="form-control" id="clientDepartment" maxlength=100 placeholder="Ingrese DEPARTAMENTO" value=""></div>'+
                                        '</div>';
                                    clientDataResponse.appendChild(form);
                                    data.newCustomer = {};
                                    data.newCustomer.typeCustomer = 2;
                                    data.newCustomer.name = '';
                                    data.newCustomer.lastname = '';
                                    data.newCustomer.dni = null;
                                    data.newCustomer.ruc = searchClientSunat;
                                    alert("No se encontraron registros en la SUNAT.");
                                },
                                500: function () {
                                    x.style.display = "none";
                                    document.getElementById('searchNewClientSunat').value = "";
                                    var buttonSaveNewClient = document.getElementById('saveNewClient');
                                    buttonSaveNewClient.disabled = false;
                                    clientDataResponse.innerHTML = "";
                                    var form = document.createElement('form');
                                    form.innerHTML ='<div class="box-body col-md-6">' +
                                        '<div class="form-group">' +
                                        '<label for="nombre_comercial">NOMBRE COMERCIAL</label>' +
                                        '<input type="text" class="form-control" id="nombre_comercial" placeholder="Ingrese NOMBRE COMERCIAL" value=""></div>' +
                                        '<div class="form-group"><label for="rz_socialS">RAZÓN SOCIAL</label>' +
                                        '<input type="text" class="form-control" id="rz_socialS" placeholder="Ingrese NOMBRES" value=""></div>' +
                                        '<div class="form-group"><label for="clientFirstLastname">TIPO DE CONTRIBUYENTE</label>' + 
                                        '<input type="text" class="form-control" id="clientFirstLastname" placeholder="Ingrese TIPO DE CONTRIBUYENTE" value=""></div>' +
                                        '<div class="form-group"><label for="clientSecondLastname">RUC</label>' +
                                        '<input type="text" class="form-control" id="clientSecondLastname" placeholder="Ingrese RUC" value="' + searchClientSunat + '"></div>' +
                                        '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                        '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div>' +
                                        '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                        '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                                        '<div class="form-group"><label for="clientAddress">DIRECCIÓN</label>' +
                                        '<input type="text" class="form-control" id="clientAddress" maxlength=200 placeholder="Ingrese DIRECCIÓN" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">DISTRITO</label>' +
                                        '<input type="text" class="form-control" id="clientDistrict" maxlength=100 placeholder="Ingrese DISTRITO" value=""></div>'+
                                        '<div class="form-group"><label for="clientDistrict">PROVINCIA</label>' +
                                        '<input type="text" class="form-control" id="clientProvince" maxlength=100 placeholder="Ingrese PROVINCIA" value=""></div>'+
                                        '<div class="form-group"><label for="clientDepartment">DEPARTAMENTO</label>' +
                                        '<input type="text" class="form-control" id="clientDepartment" maxlength=100 placeholder="Ingrese DEPARTAMENTO" value=""></div>'+
                                        '</div>';
                                    clientDataResponse.appendChild(form);
                                    data.newCustomer = {};
                                    data.newCustomer.typeCustomer = 2;
                                    data.newCustomer.name = '';
                                    data.newCustomer.lastname = '';
                                    data.newCustomer.dni = null;
                                    data.newCustomer.ruc = searchClientSunat;
                                    alert("Hubo problemas para consultar el documento en SUNAT. Ingrese los datos manualmente para registrar cliente.");
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
                                    '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div>' +
                                    '<div class="form-group"><label for="clientContact">CONTACTO</label>'+
                                    '<input type="text" class="form-control" id="clientContact" maxlength=100 placeholder="Ingrese CONTACTO" value=""></div></div>' +
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

                if (data.customer.typeCustomer != 2) {
                    document.getElementById("inputSearchClient").value = data.customer.name + ' ' + data.customer.lastname;
                } else {
                    document.getElementById("inputSearchClient").value = data.customer.rz_social;
                }
            }
            function saveNewClient() {
                var button = document.getElementById('saveNewClient');
                if (data.newCustomer != undefined) {
                    var nombre_comercial = document.getElementById("nombre_comercial");
                    if (nombre_comercial != null) {
                        data.newCustomer.nombre_comercial = nombre_comercial.value;
                    } else {
                        data.newCustomer.nombre_comercial = null;
                    }
                    var rz_socialS = document.getElementById("rz_socialS");
                    if (rz_socialS != null) {
                        data.newCustomer.nombre = rz_socialS.value;
                    } else {
                        data.newCustomer.nombre = null;
                    }
                    if (parseInt(data.newCustomer.typeCustomer) === 1) {
                        data.newCustomer.dni = document.getElementById("clientDni").value;
                        data.newCustomer.nombres = document.getElementById("clientNames").value;
                        data.newCustomer.apellidoPaterno = document.getElementById("clientFirstLastname").value;
                        data.newCustomer.apellidoMaterno = document.getElementById("clientSecondLastname").value;
                    }
                    if (document.getElementById("clientContact") != null) {
                        data.newCustomer.contact = document.getElementById("clientContact").value;
                    }
                    data.newCustomer.phone = document.getElementById("clientPhone").value;
                    data.newCustomer.email = document.getElementById("clientEmail").value;
                    data.newCustomer.address = document.getElementById("clientAddress").value;
                    if (data.newCustomer.direccion == '-' || data.newCustomer.direccion == null || data.newCustomer.direccion == "") {
                        data.newCustomer.direccion = data.newCustomer.address;
                    }
                    if (data.newCustomer.domicilio == '-' || data.newCustomer.domicilio == null || data.newCustomer.domicilio == "") {
                        data.newCustomer.domicilio = data.newCustomer.address;
                    }
                    data.newCustomer.district = document.getElementById("clientDistrict").value;
                    data.newCustomer.province = document.getElementById("clientProvince").value;
                    data.newCustomer.department = document.getElementById("clientDepartment").value;
                    if (data.newCustomer.dni == '-') {
                        data.newCustomer.dni = null;
                    }
                    if (data.newCustomer.nombre == null) {
                        data.newCustomer.nombre = data.newCustomer.name;
                    }
                    $.ajax({
                        method: "POST",
                        url: "/api/customer",
                        context: document.body,
                        data: data.newCustomer,
                        statusCode: {
                            400: function() {
                                button.disabled = false;
                                alert("Hubo un error en el registro. Es posible que los datos no sean los correctos.");
                            }
                        }
                    }).done(function(response) {
                        button.disabled = false;
                        data.customer = response;
                        data.customerId = response.id;
                        if (response.flag_type_person != 2) {
                            document.getElementById("inputSearchClient").value = response.name + " " + response.lastname;                            
                        } else {
                            document.getElementById("inputSearchClient").value = response.rz_social;
                        }
                        $('#dismissNewClient').trigger('click');
                    });
                }
            }
            // finishNewSale function
            function finishNewSale() {
                document.getElementById('sendSaleEmailAddress').value = data.customer.email;
                if (document.getElementById('quotationTypeDocument') != undefined) {
                    var quotationTypeDocument = document.getElementById('quotationTypeDocument').value;
                }
                //LLAMADA AL LOADING
                document.getElementById('generalDiscount').readOnly = false;
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
                        element.currency = data.currency;
                        selectedProductsToSale.push(element);
                    }
                });
                var allotments_ = [];
                allotments.forEach(element => {
                    if (element.quantityClosed) {
                        element.forEach(elementDetails => {
                            if (elementDetails.quantityClosed > 0) {
                                allotments_.push(elementDetails);
                            }
                        });
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
                                "amount": (parseFloat(element.value) - parseFloat(exchangeAmount___)),
                                "exchange": exchangeAmount___,
                                "name": element.name,
                                "sal_type_payments_id": element.id,
                                "operation_number": element.operation_number,
                                "currency": data.currency
                            };
                        } else {
                            var paymentElement = {
                                "amount": (parseFloat(element.value) - parseFloat(exchangeAmount___)),
                                "exchange": exchangeAmount___,
                                "name": element.name,
                                "sal_type_payments_id": element.id,
                                "currency": data.currency
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
                        "sal_type_payments_id": 1,
                        "currency": data.currency
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
                if (initialCreditPayment > 0) {
                    payments = [];
                    payments.push({
                        "amount": (parseFloat(amountValue_) - parseFloat(initialCreditPayment)),
                        "exchange": 0.00,
                        "name": "CRÉDITO",
                        "sal_type_payments_id": 8,
                        "currency": data.currency
                    });
                    payments.push({
                        "amount": initialCreditPayment,
                        "exchange": 0.00,
                        "name": "EFECTIVO",
                        "sal_type_payments_id": 1,
                        "currency": data.currency
                    });
                }
                payments.forEach(element => {
                    if (element.amount < 0) {
                        saleValidation = false;
                        alert("No se puede concretar la venta. El monto ingresado es mayor a la venta.");
                    }
                });
                // var valueAmount___ = amountValue_ - generalDiscount;
                var services___    = parseFloat(generalService.value);
                
                if (services___ > 0) {
                    var valueAmountTaxes = getPartialAmount();
                    var subTotal___    = valueAmountTaxes * taxesServices;
                    var taxes___       = subTotal___ * taxesDown;
                } else {
                    var valueAmountTaxes = getPartialAmount();
                    var subTotal___    = valueAmountTaxes/taxesUp;
                    var taxes___       = (valueAmountTaxes - subTotal___);
                }

                if (amountValue_ <= 0) {
                    amountValue_ = 0;
                    exchangeAmount = 0;
                    payments.forEach(element => {
                        element.amount = 0;
                        element.exchange = 0;
                    });
                }

                var newUserAssignment = document.getElementById('new_user_assignment');
                newUserAssignment = newUserAssignment.value;

                var serials = [];
                data.serials.forEach(elementDataSerials => {
                    elementDataSerials.forEach(elementDataSerialsIndividual => {
                        serials.push(elementDataSerialsIndividual)
                    });
                });

                if (cashManagement) {
                    payments = payments.filter(function( obj ) {
                        return obj.sal_type_payments_id !== 1;
                    });
                    payments.push({
                        "amount": parseFloat(document.getElementById('cashManagementInputPEN').value),
                        "exchange": cashManagementExchangeValue,
                        "name": "EFECTIVO",
                        "sal_type_payments_id": 1,
                        "currency": data.currency
                    });
                    payments.push({
                        "amount": parseFloat(document.getElementById('cashManagementInputUSD').value),
                        "exchange": 0.00,
                        "name": "EFECTIVO",
                        "sal_type_payments_id": 1,
                        "currency": 'USD'
                    });
                    exchangeAmount = cashManagementExchangeValue;
                }
                
                if (parseInt(companyLoginData.user_id) == 2414) {
                    if (parseInt(newUserAssignment) == 0) {
                        saleValidation = false;
                    }
                }
                
                if (saleValidation) {
                    var commentaryEXT = document.getElementById('commentaryEXT');
                    var commentaryST = document.getElementById('commentaryST');
                    if (commentaryST != null) {
                        saleCommentary = commentaryST.value;
                    }
                    if (commentaryEXT != null) {
                        saleCommentaryExt = commentaryEXT.value;
                    }
                    data.sale = {
                        "userId" : newUserAssignment,
                        "app_id" : userObject.roles_config[0].apps_id,
                        // "exchange_rate": document.getElementById('generalCurrencyConvertionRv').value,
                        "exchange_rate": 1,
                        "amount": amountValue_,
                        "subtotal": subTotal___,
                        "taxes": taxes___,
                        "op_exoneradas": opExoneradas,
                        "op_inafectas": opInafectas,
                        "op_gratuitas": opGratuitas,
                        "op_icbper": opIcbper,
                        "op_bag": opBag,
                        "services": services___,
                        "currency": data.currency,
                        "symbol_code": data.symbolCode,
                        "customer_flag_type_person": 0,
                        "customer_id": data.customerId,
                        "customer_dni": data.customer.dni,
                        "customer_ruc": data.customer.ruc,
                        "data_client": [
                            {
                                "current_customer": false,
                                "customer_id": data.customerId,
                                "interest": 0,
                                "name": (data.customer.name + " " + data.customer.lastname),
                                "dni": data.customer.dni,
                                "ruc": data.customer.ruc,
                                "payments": payments,
                                "quota_payment_id": 0,
                                "quote_number": 0,
                                "timing": 0,
                                "serials": serials,
                                "destinySubsidiary": destinySubsidiaryObject,
                                "quotationTypeDocument": quotationTypeDocument
                            }
                        ],
                        "discount": parseFloat(generalDiscount),
                        "promo_discount": parseFloat(promoDiscount__),
                        "isCustomer": false,
                        "items_": selectedProductsToSale,
                        "sal_sale_states_id": "3",
                        "sal_type_payments_id": creditPayment == true ? "8" : "1",
                        "transaction": true,
                        "payment_amount": paymentAmount,
                        "exchange_amount": exchangeAmount,
                        "type_document_code": typeDocumentCode,
                        "type_document_name": typeDocumentName,
                        "sale_order": saleOrder,
                        "remission_guide": remissionGuide,
                        "advertisement": advertisement,
                        "commentary": saleCommentary,
                        "commentary_extra": saleCommentaryExt,
                        "sale_terminal_id": document.getElementById('sale_terminal_id').value,
                        "allotments": allotments_,
                        "sal_sale_documents_id": sal_sale_documents_id,
                        "company_ruc": document.getElementById('company_ruc').value,
                        "creditPayment": data.creditPayment,
                    };
                    if (typeDocumentCode == 'COT') {
                        data.sale.noUpdateKardex = true;
                        data.sale.flag_stock_discount = 0;
                    }
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
                        saleResponse = response;
                        idNewSale = response.id;
                        feRuc = response.fe_ruc;
                        ticket = response.ticket;
                        serie = response.serie;
                        number = response.number;
                        s3Pdf = response.s3_pdf
                        $('#modal-on-load').modal('hide');
                        $('#modal-final-step').modal({ backdrop: 'static', keyboard: false });
                    });
                } else {
                    $('#modal-on-load').modal('hide');
                    alert("Por favor, configure los datos adicionales de la venta");
                    $('#modal-new-settings').modal({ backdrop: 'static', keyboard: false });
                }
            }
            function printSalePdf() {
                if (idNewSale != 0 && idNewSale != undefined) {
                    if (printService.isConnected()) {
                        var message = getHexRawPrint(saleResponse);
                        printService.submit({
                            'type': 'RECEIPT',
                            'raw_content': message,
                        });
                    } else {
                        window.open('/api/print-sale-pdf-by-id/' + idNewSale);
                    }
                } else {
                    alert("Hubo un error con su conexión. Diríjase al listado de ventas para imprimir el ticket");
                }
            }
            function printSalePdfA4() {
                if (s3Pdf != null) {
                    window.open(s3Pdf);
                } else {
                    if (idNewSale != 0 && idNewSale != undefined) {
                        window.open('https://sm-soft.tumi-soft.com/web/fe-document-pdf/' + idNewSale);
                    } else {
                        alert("Hubo un error con su conexión. Diríjase al listado de ventas para imprimir el formato A4");
                    }
                }
            }
            salesList = function(type = 1) {
                var url = "#";
                switch (type) {
                    case 1:
                        url = "/sales";
                        break;
                    case 2:
                        url = "/quotations";
                        break;
                    default:
                        break;
                }
                location = url;
            }
            salesReport = function() {
                location = "/report-sales";
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
                data.customer.email = document.getElementById('sendSaleEmailAddress').value;
                if (data.customer.email == 'cliente@generico.com' || 
                    data.customer.email == 'CLIENTE@GENERICO.COM') {
                    alert("NO ES POSIBLE USAR ESA DIRECCION DE CORREO ELECTRÓNICO");
                } else {
                    var sendSaleEmail = document.getElementById('sendSaleEmail');
                        sendSaleEmail.className = 'btn btn-warning';
                        sendSaleEmail.innerHTML = 'ENVIANDO CORREO...';
                        sendSaleEmail.disabled = true;
                    $.ajax({
                        url: '/api/send-email/' + data.customer.email + '/' + idNewSale,
                        context: document.body,
                        statusCode: {
                            400: function() {
                                var sendSaleEmail = document.getElementById('sendSaleEmail');
                                sendSaleEmail.className = 'btn btn-danger';
                                sendSaleEmail.innerHTML = 'ERROR EN ENVIO';
                                sendSaleEmail.disabled = true;
                            }
                        }
                    }).done(function(response) {
                        var sendSaleEmail = document.getElementById('sendSaleEmail');
                        sendSaleEmail.className = 'btn btn-success';
                        sendSaleEmail.innerHTML = 'CORREO ENVIADO';
                        sendSaleEmail.disabled = true;
                    });
                }
            }
            function callProductsListeners(product){
                document.getElementById('row_' + product.id).addEventListener("click", function() {
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
                        data.padOption = 0;
                    }
                    data.rowClickedId = product.id;
                    //REFACTOR_NEW
                    // setInterval();
                });
                document.getElementById('priceProduct_' + product.id).addEventListener("keyup", function(event) {
                    event.preventDefault();
                    if (document.getElementById('priceProduct_' + product.id).value < 0) {
                        document.getElementById('priceProduct_' + product.id).value = data.selectedProducts[product.id].originalPrice;
                    }
                });
                document.getElementById('partialDiscount_' + product.id).addEventListener("keyup", function(event) {
                    event.preventDefault();
                    var quantityWSP = quantityUniversalPromo(data.selectedProducts[product.id]);
                    if (document.getElementById('quantityProduct_' + product.id).value >= quantityWSP) {
                        data.selectedProducts[product.id].price = data.selectedProducts[product.id].wholeSalePrice;
                    } else {
                        data.selectedProducts[product.id].price = data.selectedProducts[product.id].originalPrice;
                    }
                    var discount = document.getElementById('partialDiscount_' + product.id);
                    var amountValue__ = parseFloat(discount.value);
                    console.log("vamos a ver", amountValue__);
                    if (data.padOption == 3) {
                        amountValue__ = (data.selectedProducts[product.id].price * (parseFloat(discount.value)/100));
                    }
                    if (amountValue__ > data.selectedProducts[product.id].price) {
                        if (document.getElementById('quantityProduct_' + product.id).value >= quantityWSP) {
                            discount.value = data.selectedProducts[product.id].wholeSalePrice;
                            data.selectedProducts[product.id].partialDiscount = data.selectedProducts[product.id].wholeSalePrice;
                            data.selectedProducts[product.id].price = 0;
                            document.getElementById('priceProduct_' + product.id).value = 0;
                        } else {
                            discount.value = data.selectedProducts[product.id].originalPrice;
                            data.selectedProducts[product.id].partialDiscount = data.selectedProducts[product.id].originalPrice;
                            data.selectedProducts[product.id].price = 0;
                            document.getElementById('priceProduct_' + product.id).value = 0;
                        }
                    } else if (isNaN(amountValue__) || amountValue__ < 0) {
                        if (document.getElementById('quantityProduct_' + product.id).value >= quantityWSP) {
                            data.selectedProducts[product.id].price = data.selectedProducts[product.id].wholeSalePrice;
                        } else {
                            data.selectedProducts[product.id].price = data.selectedProducts[product.id].originalPrice;
                        }
                        data.selectedProducts[product.id].partialDiscount = 0;
                        discount.value = 0;
                        document.getElementById('priceProduct_' + product.id).value = data.selectedProducts[product.id].price;
                    } else {
                        if (document.getElementById('quantityProduct_' + product.id).value >= quantityWSP) {
                            data.selectedProducts[product.id].price = data.selectedProducts[product.id].wholeSalePrice - amountValue__;
                        } else {
                            data.selectedProducts[product.id].price = data.selectedProducts[product.id].originalPrice - amountValue__;
                        }
                        data.selectedProducts[product.id].partialDiscount = amountValue__;
                        document.getElementById('priceProduct_' + product.id).value = data.selectedProducts[product.id].price;
                    }
                    //REFACTOR_NEW
                    // setInterval();
                });
                document.getElementById('quantityProduct_' + product.id).addEventListener("keyup", function(event) {
                    event.preventDefault();
                    var quantityProduct__ = parseFloat(document.getElementById('quantityProduct_' + product.id).value);
                    isQuotation = document.getElementById('isQuotation').value;
/*                     if (document.getElementById('quantityProduct_' + product.id).value == 0) {
                        document.getElementById('quantityProduct_' + product.id).value = 1;
                    } */
                    if (data.selectedProducts[product.id].stock < document.getElementById('quantityProduct_' + product.id).value && product.type != 2 && isQuotation !== 'COT') {
                        data.selectedProducts[product.id].quantity = data.selectedProducts[product.id].stock;
                        document.getElementById('quantityProduct_' + product.id).value = data.selectedProducts[product.id].stock;
                        alert("El stock actual es menor que la cantidad ingresada.");
                    } else if (isNaN(quantityProduct__) || quantityProduct__ < 0) {
                        document.getElementById('quantityProduct_' + product.id).value = 1;
                        data.selectedProducts[product.id].quantity = 1;
                        quantityValue = 0;
                        universalPromoBoolean = false;
                        data.selectedProducts.forEach(element => {
                            if (element.quantity > 0) {
                                if (element.taxExemptionReasonCode != 7152) {
                                    amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                                }
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
                                if (element.taxExemptionReasonCode != 7152) {
                                    amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                                }
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
                var exchange = paymentAmount - amountValue_ - generalDiscount_ - promoDiscount__;
                exchange = exchange.toFixed(2);
                if (isNaN(paymentAmount) || paymentAmount < (parseFloat(amountValue_) - generalDiscount_ - promoDiscount__)) {
                    var saleErrorMessage = document.getElementById('saleErrorMessage');
                    saleErrorMessage.innerHTML = 'Monto de ingreso menor a la venta.';
                    buttonVd_ = false;
                    saleErrorMessage.className = 'btn btn-danger pull-center';
                    document.getElementById('btnFinishNewSale').innerHTML = 'VALIDAR';
                    document.getElementById('btnFinishNewSale').onclick = function() { validateSale() };
                } else {
                    var saleErrorMessage = document.getElementById('saleErrorMessage');
                    saleErrorMessage.innerHTML = 'VALIDE SU OPERACIÓN';
                    buttonVd_ = true;
                    saleErrorMessage.className = 'btn btn-warning pull-center';document.getElementById('btnFinishNewSale').innerHTML = 'VALIDAR';
                    document.getElementById('btnFinishNewSale').onclick = function() { validateSale() };
                }
                if (exchange > 0) {
                    document.getElementById('cashInputExchange').value = parseFloat(exchange);
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
            var printService = new WebSocketPrinter();
            now = function() {
                var date = new Date();
                var aaaa = date.getFullYear();
                var gg = date.getDate();
                var mm = (date.getMonth() + 1);

                if (gg < 10)
                    gg = "0" + gg;

                if (mm < 10)
                    mm = "0" + mm;

                var cur_day = aaaa + "-" + mm + "-" + gg;

                var hours = date.getHours()
                var minutes = date.getMinutes()
                var seconds = date.getSeconds();

                if (hours < 10)
                    hours = "0" + hours;

                if (minutes < 10)
                    minutes = "0" + minutes;

                if (seconds < 10)
                    seconds = "0" + seconds;

                return cur_day + " " + hours + ":" + minutes + ":" + seconds;
            }
            getHexRawPrint = function(sale) {
                var type_document_name_plus = '';
                var type_payment_name = "";
                switch (parseInt(sale.sal_type_payments_id)) {
                    case 1:
                        type_payment_name = "PAGO CON DINERO EN EFECTIVO";
                    break;
                    case 2:
                        type_payment_name = "PAGO CON TARJETA VISA";
                    break;
                    case 3:
                        type_payment_name = "PAGO CON TARJETA MASTERCARD/AMERICAN EXPRESS";
                    break;
                    case 4:
                        type_payment_name = "PAGO A CUOTAS";
                    break;
                    case 5:
                        type_payment_name = "PAGO MIXTO";
                    break;
                    case 6:
                        type_payment_name = "PAGO POR DEPÓSITO BANCARIO";
                    break;
                    case 7:
                        type_payment_name = "PAGO POR CHEQUE FINANCIERO O DE GERENCIA";
                    break;
                    case 8:
                        type_payment_name = "PAGO A CRÉDITO";
                    break;
                    case 9:
                        type_payment_name = "PAGO A LETRAS";
                    break;
                    case 10:
                        type_payment_name = "PAGO POR IZIPAY";
                    break;
                    case 11:
                        type_payment_name = "PAGO POR UBER EATS";
                    break;
                    case 12:
                        type_payment_name = "PAGO POR GLOVO";
                    break;
                    case 13:
                        type_payment_name = "PAGO POR RAPPI";
                    break;
                    case 14:
                        type_payment_name = "PAGO POR VENDEMAS";
                    break;
                    case 15:
                        type_payment_name = "PAGO POR LUKITA";
                    break;
                    case 16:
                        type_payment_name = "PAGO POR YAPE";
                    break;
                    case 17:
                        type_payment_name = "PAGO POR TUNKI";
                    break;
                    case 18:
                        type_payment_name = "PAGO POR AMERICAN EXPRESS";
                    break;
                    case 19:
                        type_payment_name = "PAGO POR PLIM";
                    break;
                    default:
                        break;
                }
                switch (sale.sal_type_document_id) {
                    case 1:
                        type_document_name_plus = 'BOLETA DE VENTA ELECTR\xd3NICA';
                        break;
                    case 2:
                        type_document_name_plus = 'FACTURA ELECTR\xd3NICA';
                    case 5:
                        type_document_name_plus = 'NOTA DE VENTA';
                    break;
                    default:
                        break;
                }
                sale.customer_document_name = "DOC: ";
                sale.customer_document_number = sale.data_client[0].dni;
                var customer_name = sale.data_client[0].name;
                switch (sale.customer_flag_type_person) {
                    case 1:
                        sale.customer_document_name = "DNI: ";
                        break;
                    case 2:
                        sale.customer_document_name = "RUC: ";
                        sale.customer_document_number = sale.data_client[0].ruc;
                        break;
                    default:
                        break;
                }
                //Create ESP/POS commands for sample label
                var todayDate = now();
                var leftAlign = '\x1B' + '\x61' + '\x30';
                var rightAlign = '\x1B' + '\x61' + '\x32';
                var centerAlign = '\x1B' + '\x40' + '\x1B' + '\x61' + '\x31';
                var boldOn = '\x1B' + '\x45' + '\x0D';
                var boldOff = '\x1B' + '\x45' + '\x0A';
                var smallText = '\x1B' + '\x4D' + '\x31';
                var normalText = '\x1B' + '\x4D' + '\x30';
                // ISO-8859-1
                var cmds = '' + '\x0A';
                cmds += '------------------------------------------------' + '\x0A' +
                    centerAlign + // center align
                    type_document_name_plus + '\x0A' +                   // line break
                    leftAlign + // left align
                    // HEADER
                    '------------------------------------------------' + '\x0A' +
                    centerAlign + // center align
                    userObject.company_name + '\x0A' +                   // line break
                    userObject.company_rzsocial + '\x0A' +                   // line break
                    userObject.company_ruc + '\x0A' +                   // line break
                    userObject.company_address + '\x0A' +                   // line break
                    userObject.company_code.replace(/!/g, '-') + '\x0A' +                   // line break
                    'Suc: ' + userObject.war_warehouses_name + '\x0A' +                   // line break
                    'Fecha de venta: ' + sale.created_at + '\x0A' +                   // line break
                    'Fecha actual: ' + todayDate + '\x0A' +                   // line break
                    boldOn + // bold on
                    sale.ticket + '\x0A' +                   // line break
                    boldOff + // bold off
                    leftAlign + // left align
                    '------------------------------------------------' + '\x0A' +
                    // CUSTOMER
                    centerAlign + // center align
                    sale.customer_document_name + sale.customer_document_number + '\x0A' +                   // line break
                    customer_name + '\x0A' +                   // line break
                    leftAlign + // left align
                    // ITEMS DETAILS
                    '------------------------------------------------' + '\x0A' +
                    'Descripción           Cant    P.Unid    P.Total' + '\x0A' +
                    '------------------------------------------------' + '\x0A';
                    sale.items.forEach(element => {
                        var description = element.code + ' - ' + element.name + ' (' + element.description + ') \x0A';
                        var quantity = ("                          " + parseFloat(element.quantity).toFixed(2)).slice(-26);
                        var unitPrice = ("          " + parseFloat(element.price).toFixed(2)).slice(-10);
                        var totalPrice = ("            " + parseFloat(element.quantity*element.price).toFixed(2)).slice(-12);
                        cmds += leftAlign;
                        cmds += description;
                        cmds += rightAlign;
                        cmds += quantity;
                        cmds += unitPrice;
                        cmds += totalPrice;
                    });
                    // SALE DETAILS
                    cmds += '------------------------------------------------' + '\x0A';
                    cmds += leftAlign;
                    cmds += '           Subtotal           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.subtotal).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '         Op.Gravada           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.subtotal).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '       Op.Exonerada           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.op_exoneradas).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '        Op.Inafecta           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.op_inafectas).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '        Op.Gratuita           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.op_gratuitas).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '             ICBPER           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat((sale.op_icbper != undefined) ? sale.op_icbper : 0).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '           IGV(18%)           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.taxes).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '              Total           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.amount).toFixed(2)).slice(-12) + '\x0A';
                    cmds += '------------------------------------------------' + '\x0A';
                    cmds += leftAlign;
                    cmds += '               Pago           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.amount + sale.exchange_amount).toFixed(2)).slice(-12) + '\x0A';
                    cmds += leftAlign;
                    cmds += '             Vuelto           ';
                    cmds += rightAlign;
                    cmds += ("     " + getCurrencySymbolCode(data.currency)).slice(-4);
                    cmds += ("               " + parseFloat(sale.exchange_amount).toFixed(2)).slice(-12) + '\x0A';
                    cmds += '------------------------------------------------' + '\x0A';
                    cmds += centerAlign;
                    cmds += type_payment_name + '\x0A';
                    cmds += '------------------------------------------------' + '\x0A';
                    cmds += 'Representación impresa de una:' + '\x0A';
                    cmds += boldOn + type_document_name_plus + boldOff + '\x0A';
                    cmds += 'Consulte su comprobante en:' + '\x0A';
                    cmds += 'https://consulta-fe.tumi-soft.com' + '\x0A';
                    cmds += '------------------------------------------------' + '\x0A';
                    cmds += 'Atendido por: ' + userObject.name + ' ' + userObject.lastname + '\x0A';
                    cmds += boldOn + ((userObject.warehouses_print_message != null) ? userObject.warehouses_print_message : userObject.print_message) + boldOff + '\x0A';
                    cmds += 'Gracias por su compra' + '\x0A' + '\x0A';
                    cmds += smallText + 'Powered by' + boldOn + ' www.tumi-soft.com' + boldOff + normalText + '\x0A';
                    // PAYMENTS DETAIL
                    cmds += '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A';
                    cmds += '\x1B' + '\x69';          // cut paper (old syntax)
                cmds = window.btoa(unescape(encodeURIComponent( cmds )));
                return cmds;
            }
            validateCredit = function () {
                $('#modal-new-credit').modal('toggle');
                alert("Crédito válido");
            }
            callChangeCurrency = function() {
                data.currency = typeCurrency.value;
                data.symbolCode = getCurrencySymbolCode(data.currency);
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
                if (product.minPrice == null) {
                    document.getElementById('productMinPrice').innerHTML = 'SIN DEFINIR';
                } else {
                    document.getElementById('productMinPrice').innerHTML = getCurrencySymbolCode(data.currency) + product.minPrice;
                }
                if (product.maxPrice == null) {
                    document.getElementById('productMaxPrice').innerHTML = 'SIN DEFINIR';
                } else {
                    document.getElementById('productMaxPrice').innerHTML = getCurrencySymbolCode(data.currency) + product.maxPrice;
                }
                if (product.urlImage != null) {
                    document.getElementById('productDetailImage').src = product.urlImage;
                } else {
                    document.getElementById('productDetailImage').src = '/img/new_ic_logo_short.png';
                }
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
                        if (priceList.minPrice == undefined) {
                            priceList.minPrice = 'SIN DATOS';
                        }
                        if (priceList.maxPrice == undefined) {
                            priceList.maxPrice = 'SIN DATOS';
                        }
                        productDetailStockPriceListTBody_ = productDetailStockPriceListTBody_ + 
                        '<tr>'+
                            '<td> '+ element.name +' </td>'+
                            '<td> '+ location +' </td>'+
                            '<td> '+ element.stock +' </td>'+
                            '<td> '+ priceList.price +' </td>'+
                            '<td> '+ priceList.quantity +' </td>'+
                            '<td> '+ priceList.wholeSalePrice +' </td>'+
                            '<td> '+ priceList.minPrice +' </td>'+
                            '<td> '+ priceList.maxPrice +' </td>'+
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
                document.getElementById('commentary_extra').value = saleCommentaryExt;
                $('#modal-new-settings').modal({ backdrop: 'static', keyboard: false });
            }
            saveNewSettings = function() {
                saleOrder = document.getElementById('sale_order').value;
                advertisement = document.getElementById('advertisement').value;
                remissionGuide = document.getElementById('remission_guide').value;
                saleCommentary = document.getElementById('commentary').value;
                saleCommentaryExt = document.getElementById('commentary_extra').value;
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
                if (id == 0) {
                    id = document.getElementById('typeDocument').value;
                }
                var element = typeDocumentNames[parseInt(id)];
                typeDocumentCode = element.code;
                typeDocumentName = element.name;
                var pResume = document.getElementById('totalResumeAmount');
                pResume.innerHTML = '<b>' + typeDocumentName + ': </b> ' + data.symbolCode + ' ' + parseFloat(amountValue);
                // var buttonTypeDocument = document.getElementById('buttonTypeDocument');
                // buttonTypeDocument.innerHTML = typeDocumentName.substring(0,1);
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
                            if (element.taxExemptionReasonCode != 7152) {
                                amountValue = parseFloat(amountValue) + parseFloat(element.price*element.quantity);
                            }
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
            loadProductsSubcategory = function() {
                loadProducts(parentSubcategory);
            }
            loadProducts = function(id, subcategories_ = null) {
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
                        url: "/api/products-list?priceListId=" + data.priceListId + "&categoryId=" + selectedCategories + '&subCategories=' + Object.keys(subcategories),
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
                                if ((response[i].type == 1 && response[i].stock < 1) || response[i].flag_operation == 1) {
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
                                    '       <img src="' + urlImage + '" style="height:100px; width:120px;">'+
                                    '   </div>';
                                if ((response[i].type == 1 && response[i].stock < 1) || response[i].flag_operation == 1) {
                                    element = element + 
                                    '   <div class="container-custom>'+
                                    '       <hr style="margin-top:5px;margin-bottom:0px;">' + 
                                    '       <h5 style="font-size:12px; font-weight:bold; max-width: 120px;">' + response[i].name + '</h5>' +
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
                                    if (userObject.roles_config[0].apps_id == 6) {
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
                                    } else {
                                        element = element + 
                                        '   <div class="container-custom" id="infoBoxProductFunction_' + response[i].id + '" onclick="addSelectedProduct(' + response[i].id + ');">'+
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
                            } else {
                                var buttonHeadClass_ = '<div align="center" class="info-box-custom" id="infoBoxProduct_' + response[i].id + '">';
                                if ((response[i].type == 1 && response[i].stock < 1) || response[i].flag_operation == 1) {
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
                                    '       <img src="' + urlImage + '" style="height:100px; width:120px;">'+
                                    '   </div>';
                                if ((response[i].type == 1 && response[i].stock < 1) || response[i].flag_operation == 1) {
                                    if (isQuotation != 'COT') {
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
                                        element = element + 
                                        '   <div class="container-custom" id="infoBoxProductFunction_' + response[i].id + '" onclick="addSelectedProduct(' + response[i].id + ');">'+
                                        '       <hr style="margin-top:5px;margin-bottom:0px;">' + 
                                        '       <h5 style="font-size:12px; font-weight:bold; max-width: 120px;">' + response[i].name + '</h5>'+
                                        '       <h5 style="font-size:12px; font-weight:bold; margin-bottom:5px;">' + getCurrencySymbolCode(data.currency) + ' ' + response[i].price + '</h5>' +
                                        '       <h5 style="font-size:12px; font-weight:bold; margin-top:5px;">(Stock: ' + response[i].stock + ')</h5>' +
                                        '       <p style="font-size:8px; max-width: 120px;">' + description__ + '</p>'+
                                        '   </div>'+
                                        '</div>'+
                                        '</div>';
                                    } 
                                } else {
                                    var stock = response[i].stock;
                                    if (response[i].type == 2) {
                                        stock = '-';
                                    }
                                    if (userObject.roles_config[0].apps_id == 6) {
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
                                    } else {
                                        element = element + 
                                        '   <div class="container-custom" id="infoBoxProductFunction_' + response[i].id + '" onclick="addSelectedProduct(' + response[i].id + ');">'+
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
            //CREDIT PAYMENT MODULE
            validateCreditPayment = function () {
                var numberQuotes = document.getElementById("numberQuotes");
                var quoteValue = document.getElementById("quote-value");
                var creditTypeSelector = document.getElementById("credit-type-selector");
                var paymentDate = document.getElementById("payment-date");
                var creditTypeInitialQuote = document.getElementById("credit-type-initial-quote");
                var creditAmount = document.getElementById("credit-amount");

                if (amountValue_ <= 0 ){
                    alert('Operación fallida, por favor escoja un producto');
                } else {
                    if (creditTypeInitialQuote.value == 2) {
                    creditAmount.value = amountValue_/numberQuotes.value;
                    amountQuotes = amountQuotes - creditAmount.value
                    quoteValue.value = amountQuotes/numberQuotes.value;
                    quoteValue.value = parseFloat(quoteValue.value).toFixed(2);
                    initialCreditPayment = creditAmount.value;
                    } else if (creditTypeInitialQuote.value == 1) {
                        amountQuotes = amountQuotes - creditAmount.value
                        quoteValue.value = parseFloat(amountQuotes/numberQuotes.value).toFixed(2);
                        initialCreditPayment = creditAmount.value;
                    } else {
                        quoteValue.value = amountValue_/numberQuotes.value;
                    }
                    document.getElementById("saveCreditPayment").disabled = false;
                }

            }
            onChangeCreditTypeInitialQuote = function () {
                var initialQuote = document.getElementById("credit-type-initial-quote");
                var creditAmount = document.getElementById("credit-amount");
                if (initialQuote.value == 0) {
                    creditAmount.readOnly = true;
                    creditAmount.value = 0;
                } else if (initialQuote.value == 1) {
                    creditAmount.readOnly = false;
                } else {
                    creditAmount.readOnly = true;
                }
            }

            creditPaymentModal = function () {
                $('#modal-credit-payment').modal({backdrop: 'static', keyboard: false});
                secondStepOfSale(true);
                var divHeader = document.getElementById("amount");
                var headerInner = '<strong>Monto: </strong>' + amountValue_;
                divHeader.innerHTML = headerInner;
            }
            saveCreditPayment = function () {
                data.creditPayment.quotes = document.getElementById("numberQuotes").value;
                data.creditPayment.quoteValue = document.getElementById("quote-value").value;
                data.creditPayment.typeCredit = document.getElementById("credit-type-selector").value;
                data.creditPayment.datePayment = document.getElementById("payment-date").value;
                data.creditPayment.initialQuote = document.getElementById("credit-type-initial-quote").value;
                data.creditPayment.initalAmount = document.getElementById("credit-amount").value;
                console.log("credito", data.creditPayment)
            }
            typePayments = function(id) {
                if (id == 8) {
                    var paymentButton = document.getElementById("typePayment_" + id);
                    if (creditPayment == false) {
                        data.typePayments = [];
                        data.creditPayment = {};
                        secondStepOfSale(true);
                        amountQuotes = amountValue_;
                        //$('#modal-credit-payment').modal({backdrop: 'static', keyboard: false});
                        creditPaymentModal();
                        var creditPaymentButton = document.getElementById("creditPaymentConf");
                        if (creditPaymentButton != undefined) {
                            creditPaymentButton.setAttribute("style", "");;
                        } else {
                            creditPaymentButton = document.createElement("button");
                            creditPaymentButton.setAttribute("id", "creditPaymentConf");
                            creditPaymentButton.setAttribute("title", "Configurar pago a crédito");
                            creditPaymentButton.setAttribute("onClick", "creditPaymentModal();");
                            creditPaymentButton.innerHTML = '<i class="fa fa-pencil-square-o"></i>';
                            document.getElementById('optionButtons').appendChild(creditPaymentButton);
                        }
                        data.typePayments.push({
                            "id": id,
                            "name": typePaymentNames[id].name,
                            "htmlId": typePaymentNames[id].htmlId,
                            "selected": true,
                            "additionalBox": typePaymentNames[id].additionalBox,
                            "readOnly": typePaymentNames[id].readOnly,
                        });
                        //Pongo por defecto el pago en efectivo como deshabilitado
                        var cashPayment = document.getElementById("typePayment_1");
                        cashPayment.className = 'payment-1-unselected';
                        //Activo el pago a credito
                        paymentButton.className = 'payment-' + id + '-selected';
                        creditPayment = true;
                        //desactivo todos los demas tipos de pago
                        for (let index = 1; index < 20; index++) {
                            var disablePayment = document.getElementById("typePayment_" + index);
                            if (disablePayment != undefined && index != 8) {
                                disablePayment.className = 'payment-' + index + '-unselected';
                                disablePayment.setAttribute('onclick','');
                                
                            }
                        }
                    } else {
                        data.typePayments = [];
                        data.creditPayment = null;
                        var creditPaymentButton = document.getElementById("creditPaymentConf");
                        if (creditPaymentButton != undefined) {
                            creditPaymentButton.style.display = "none";
                        }
                        //desactivo el pago a credito
                        creditPayment = false;
                        paymentButton.className = 'payment-' + id + '-unselected';
                        //activo todos los tipos de pago
                        for (let index = 1; index < 20; index++) {
                            var enablePayment = document.getElementById("typePayment_" + index);
                            if (enablePayment != undefined) {
                                enablePayment.setAttribute('onclick','typePayments(' + index + ')');
                            }
                        }
                        //Pongo por defecto el pago efectivo
                        var cashPayment = document.getElementById("typePayment_1");
                        cashPayment.className = 'payment-1-selected';
                        //agrego al arreglo el pago efectivo
                        data.typePayments.push({
                            "id": 1,
                            "name": typePaymentNames[1].name,
                            "htmlId": typePaymentNames[1].htmlId,
                            "selected": true,
                            "additionalBox": typePaymentNames[1].additionalBox,
                            "readOnly": typePaymentNames[1].readOnly,
                        });
                    }
                } else {
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
                console.log("pagos",data.typePayments);
            }
            editDetailCommentary = function (productId) {
                detailCommentaryId = productId;
                var commentValidation = false;
                var commentValue_ = null;
                data.selectedProducts.forEach(element => {
                    if (element.id == productId) {
                        if (element.commentary == undefined) {
                            element.commentary = null;
                            commentValue_ = '(' + element.code + ') ' + element.name + ' - ' + element.description;
                        } else {
                            commentValue_ = element.commentary;
                        }
                        commentValidation = true;
                    }
                });
                if (commentValidation) {
                    // ABRIR MODAL
                    document.getElementById('detailCommentary').value = commentValue_;
                    $('#modal-detail-commentary').modal({backdrop: 'static', keyboard: false});
                } else {
                    alert("No se pudo editar. Por favor, comuníquese con soporte.");
                }
            }
            getPartialAmount = function() {
                var amountI = parseFloat(amountValue_) - parseFloat(opExoneradas) - parseFloat(opInafectas) - parseFloat(opGratuitas) - parseFloat(opIcbper) - parseFloat(opBag);
                if (amountI < 0) {
                    return 0;
                } else {
                    return amountI;
                }
            }
            closeDetailCommentary = function() {
                $('#modal-detail-commentary').modal('toggle');
            }
            detailCommentarySubmit = function() {
                if (detailCommentaryId != 0) {
                    data.selectedProducts.forEach(element => {
                        if (element.id == detailCommentaryId) {
                            element.commentary = document.getElementById('detailCommentary').value;
                        }
                    });
                    $('#modal-detail-commentary').modal('toggle');
                }
            }
            secondStepOfSale = function (creditPayment = false) {
                var commentaryST = document.getElementById('commentaryST');
                var commentaryEXT = document.getElementById('commentaryEXT');
                if (commentaryST != null) {
                    commentaryST.value = saleCommentary;
                }
                if (commentaryEXT != null) {
                    commentaryEXT.value = saleCommentaryExt;
                }
                if (saleJson != null) {
                    var typeDocumentId = saleJson.typeDocumentId;
                    var typeDocument = typeDocumentNames[parseInt(typeDocumentId)];
                    typeDocumentCode = typeDocument.code;
                    typeDocumentName = typeDocument.name;
                } else {
                    var typeDocumentId = document.getElementById('typeDocument');
                    if (typeDocumentId != null) {
                        var typeDocument = typeDocumentNames[parseInt(typeDocumentId.value)];
                        typeDocumentCode = typeDocument.code;
                        typeDocumentName = typeDocument.name;
                    }
                }
                document.getElementById('btnFinishNewSale').innerHTML = "VALIDAR";
                document.getElementById('btnFinishNewSale').onclick = function() { validateSale() };
                document.getElementById('labelTotalAmount').innerHTML = 'TOTAL A PAGAR: ' + data.symbolCode + ' 0.00';
                document.getElementById('finalStepPrevSubtotal').innerHTML = '<b>OP.GRAVADAS: ' + data.symbolCode + ' 0.00</b>';
                document.getElementById('finalStepPrevExoneradas').innerHTML = '<b>OP.EXONERADAS: ' + data.symbolCode + ' 0.00</b>';
                document.getElementById('finalStepPrevInafectas').innerHTML = '<b>OP.INAFECTAS: ' + data.symbolCode + ' 0.00</b>';
                document.getElementById('finalStepPrevIcbper').innerHTML = '<b>OP.ICBPER: ' + data.symbolCode + ' ' + ' 0.00</b>';
                document.getElementById('finalStepPrevBag').innerHTML = '<b>PRECIO BOLSAS: ' + data.symbolCode + ' ' + ' 0.00</b>';
                document.getElementById('finalStepPrevGratuitas').innerHTML = '<b>OP.GRATUITAS: ' + data.symbolCode + ' 0.00</b>';
                document.getElementById('finalStepPrevIgv').innerHTML = '<b>IGV: ' + data.symbolCode + ' 0.00</b>';
                document.getElementById('finalStepPrevTotal').innerHTML = '<b>TOTAL: ' + data.symbolCode + ' 0.00</b>';
                document.getElementById('generalDiscount').readOnly = false;
                // document.getElementById('generalCurrencyConvertionRv').value = "1.00";
                opExoneradas = 0;
                opInafectas = 0;
                opGratuitas = 0;
                opIcbper = 0;
                opBag = 0;
                $('#drprojecttype').val(data.currency);
                if (creditPayment == false) {
                    $('#modal-second-step').modal({backdrop: 'static', keyboard: false});
                }
                if (data.selectedProducts.length == 0) {
                    document.getElementById('totalResumeAmount').innerHTML = 'AGREGUE PRODUCTOS A LA VENTA';
                    document.getElementById('tBodyTableProductsSummary').innerHTML = '';
                    document.getElementById('saleErrorMessage').innerHTML = 'Usted no tiene productos por vender';
                    document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                } else {
                    var serialValidation = true;
                    priceValidation = true;
                    var priceValidationIds = [];
                    var itemsCount = 0
                    data.selectedProducts.forEach(element => {
                        itemsCount++;
                        var priceInput_ = document.getElementById("priceProduct_" + element.id);
                        if (priceInput_ != null) {
                            element.price = parseFloat(priceInput_.value);
                            if (element.minPrice != null && element.maxPrice != null) {
                                if ((parseFloat(element.price) < parseFloat(element.minPrice)) || 
                                    (parseFloat(element.price) > parseFloat(element.maxPrice))) {
                                    priceValidation = false;
                                    priceValidationIds.push(element.id);
                                }
                            }
                        }
                        if (isQuotation == 'COT') {
                            serialValidation = true;
                        } else {
                            if (element.allotmentType == 2) {
                                if (data.serials[element.id] == undefined) {
                                    serialValidation = false;
                                } else {
                                    if (element.quantity != data.serials[element.id].length) {
                                        serialValidation = false;
                                    }
                                }
                            }
                        }
                        if (element.taxExemptionReasonCode == 20) {
                            opExoneradas = opExoneradas + parseFloat(element.quantity*element.price);
                        } else if (element.taxExemptionReasonCode == 30) {
                            opInafectas = opInafectas + parseFloat(element.quantity*element.price);
                        } else if (element.taxExemptionReasonCode == 21) {
                            opGratuitas = opGratuitas + parseFloat(element.quantity*element.price);
                        } else if (element.taxExemptionReasonCode == 7152) {
                            opIcbper = opIcbper + parseFloat(element.quantity*taxIcbper);
                            opBag = opBag + parseFloat(element.quantity*element.price);
                        }
                    });
                    if (serialValidation) {
                        var productDetailsLabel = document.getElementById('productDetailsLabel');
                        if (productDetailsLabel != null) {
                            productDetailsLabel.innerHTML = "DETALLE DE PRODUCTOS " + "<strong>(Items: " + itemsCount + ")</strong>"
                        }
                        setInterval();
                        var pResume = document.getElementById('totalResumeAmount');
                        var pResumeText_ = '';
                        if (data.customer.flag_type_person != undefined) {
                            if (data.customer.flag_type_person != 2) {
                                pResumeText_ = '<b>' + typeDocumentName + '</b><br>' + data.customer.name + ', ' + data.customer.lastname + ' - DNI: ' + data.customer.dni;   
                            } else {
                                pResumeText_ = '<b>' + typeDocumentName + '</b><br>' + data.customer.rz_social + ' - RUC: ' + data.customer.ruc;
                            }   
                        } else {
                            pResumeText_ = '<b>' + typeDocumentName + '</b><br>' + data.customer.name + ', ' + data.customer.lastname + ' - RUC: ' + data.customer.ruc + ' - DNI: ' + data.customer.dni;
                        }
                        pResume.innerHTML = pResumeText_;
                        var xTable = document.getElementById('tBodyTableProductsSummary');
                        xTable.innerHTML = "";
                        amountValue = 0;
                        exchangeAmount = 0;
                        generalDiscount = 0;
                        document.getElementById('cashInputExchange').value = exchangeAmount;
                        document.getElementById('generalDiscount').value = generalDiscount;
                        amountValueCurrency = [];
                        var totalProductsCount = 0;
                        data.selectedProducts.forEach(element => {
                            if (element.quantity > 0) {
                                totalProductsCount++;
                                var tr = document.createElement('tr');
                                tr.setAttribute("style", "font-size:10px;");
                                var indexOf_ = priceValidationIds.indexOf(element.id);
                                if (indexOf_ > -1) {
                                    tr.setAttribute("style", "background:#d43f3a;");
                                }
                                tr.innerHTML ='<td>' + element.code + '</td><td>' + element.name + '</td>' +
                                    '<td>' + element.price + '</td><td>' + element.quantity + '</td>' + '<td><button type="button" onClick="editDetailCommentary(' + element.id + ');"><i class="fa fa-fw fa-pencil" style="cursor:pointer;"></i></button></td>';
                                xTable.appendChild(tr);
                                var elementCurrency = element.currency;
                                if (elementCurrency == null) {
                                    elementCurrency = data.currency;
                                }
                                if (amountValueCurrency[elementCurrency] == undefined) {
                                    amountValueCurrency[elementCurrency] = {
                                        currency: elementCurrency,
                                        amount: 0.00,
                                    };
                                }
                                amountValueCurrency[elementCurrency].amount = parseFloat(amountValueCurrency[elementCurrency].amount) + parseFloat(element.price*element.quantity);
                            }
                        });
                        if (totalProductsCount == 0) {
                            document.getElementById('totalResumeAmount').innerHTML = 'AGREGUE PRODUCTOS A LA VENTA';
                            document.getElementById('saleErrorMessage').innerHTML = 'Usted no tiene productos por vender';
                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                            document.getElementById('btnFinishNewSale').disabled = true;
                        } else {
                            document.getElementById('btnFinishNewSale').disabled = false;
                                var amountValueCurrencyCount = 0;
                                var amountValueCurrencyCurrency = data.currency;
                                for (var elementValueCurrency in amountValueCurrency) {
                                    amountValue = parseFloat(amountValueCurrency[elementValueCurrency].amount);
                                    amountValueCurrencyCurrency = elementValueCurrency;
                                    amountValueCurrencyCount++;
                                }
                                if (amountValueCurrencyCount == 1) {
                                    amountValue = amountValue - generalDiscount - promoDiscount__  - opBag;
                                    amountValue_ = (amountValue + parseFloat(opIcbper) + parseFloat(opBag)).toFixed(2);
                                    // PAYMENTS MANAGEMENT
                                    paymentsManagement(amountValue_);
                                    document.getElementById('labelTotalAmount').innerHTML = 'TOTAL A PAGAR: ' + data.symbolCode + ' ' + (parseFloat(amountValue_)).toFixed(2);
                                    if (typeDocumentCode != 'NVT') {
                                        var partialAmount = getPartialAmount();
                                        document.getElementById('finalStepPrevExoneradas').innerHTML = '<b>OP.EXONERADAS: ' + data.symbolCode + ' ' + (parseFloat(opExoneradas)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevInafectas').innerHTML = '<b>OP.INAFECTAS: ' + data.symbolCode + ' ' + (parseFloat(opInafectas)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevIcbper').innerHTML = '<b>OP.ICBPER: ' + data.symbolCode + ' ' + (parseFloat(opIcbper)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevBag').innerHTML = '<b>PRECIO BOLSAS: ' + data.symbolCode + ' ' + (parseFloat(opBag)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevGratuitas').innerHTML = '<b>OP.GRATUITAS: ' + data.symbolCode + ' ' + (parseFloat(opGratuitas)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevSubtotal').innerHTML = '<b>OP.GRAVADAS: ' + data.symbolCode + ' ' + ((parseFloat(partialAmount)/taxesUp)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevIgv').innerHTML = '<b>IGV: ' + data.symbolCode + ' ' + (parseFloat(partialAmount) - (parseFloat(partialAmount)/taxesUp)).toFixed(2) + '</b>';
                                    } else {
                                        document.getElementById('finalStepPrevIcbper').innerHTML = '<b>OP.ICBPER: ' + data.symbolCode + ' ' + (parseFloat(opIcbper)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevBag').innerHTML = '<b>PRECIO BOLSAS: ' + data.symbolCode + ' ' + (parseFloat(opBag)).toFixed(2) + '</b>';
                                    }
                                    // HERE finalStepPrevTotal
                                    document.getElementById('finalStepPrevTotal').innerHTML = '<b>TOTAL: ' + data.symbolCode + ' ' + (parseFloat(amountValue_)).toFixed(2) + '</b>';
                                } else {
                                    amountValue = 0;
                                    document.getElementById('generalDiscount').readonly = true;
                                    document.getElementById('saleErrorMessage').innerHTML = 'Por favor, organize sus precios';
                                    document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                                }
                        }
                    } else {
                        document.getElementById('totalResumeAmount').innerHTML = 'LAS SERIES NO ESTAN COMPLETAS';
                        document.getElementById('tBodyTableProductsSummary').innerHTML = '';
                        document.getElementById('saleErrorMessage').innerHTML = 'USTED NECESITA INGRESAR TODAS LAS SERIES NECESARIAS';
                        document.getElementById('btnFinishNewSale').innerHTML = 'REGRESAR';
                        document.getElementById('btnFinishNewSale').onclick = function() { $('#modal-second-step').modal('toggle'); };
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                    }
                }
            }
            cashPaymentManagement = function() {
                // ERASE
                document.getElementById('saveCashPaymentManagement').innerHTML = 'VALIDAR';
                document.getElementById('saveCashPaymentManagement').onclick = function() { validateCashPaymentManagement() };
                document.getElementById('cashManagementInputPEN').value = '0.00';
                document.getElementById('cashManagementInputUSD').value = '0.00';
                document.getElementById('cashManagementInputPEN').readOnly = false;
                document.getElementById('cashManagementInputUSD').readOnly = false;
                document.getElementById('cashManagementExchange').innerHTML = getCurrencySymbolCode(data.currency) + ' 0.00';
                document.getElementById('cashManagementTotal').innerHTML = getCurrencySymbolCode(data.currency) + ' 0.00';
                document.getElementById('tdMultCurTotal_PEN').innerHTML = getCurrencySymbolCode(data.currency) + ' 0.00';
                document.getElementById('tdMultCurTotal_USD').innerHTML = getCurrencySymbolCode(data.currency) + ' 0.00';
                document.getElementById('tdMultCurTotal').innerHTML = "TOTAL A PAGAR: <strong>" + data.symbolCode + ' ' + (amountValue_ - generalDiscount) + '</strong>';
                switch (data.currency) {
                    case data.currency:
                        // CONVERTION
                        document.getElementById('tdMultCurConvertion_PEN').innerHTML = "1.00";
                        document.getElementById('tdMultCurConvertion_USD').innerHTML = parseFloat(document.getElementById('generalCurrencyConvertionRv').value);
                        break;
                    case 'USD':
                        // CONVERTION
                        document.getElementById('tdMultCurConvertion_USD').innerHTML = "1.00";
                        document.getElementById('tdMultCurConvertion_PEN').innerHTML = parseFloat(document.getElementById('generalCurrencyConvertionRv').value);
                        break;
                    default:
                        break;
                }
                $('#modal-cash-management').modal({ backdrop: 'static', keyboard: false });
            }
            creditPaymentManagement = function() {
                openNewCustomerCredit();
            }
            openNewCustomerCredit = function() {
                var editCustomer = data.customer;
                var customerName = editCustomer.name + " " + editCustomer.lastname;
                if (editCustomer.flag_type_person == 2) {
                    customerName = editCustomer.rz_social;
                }
                var creditCurrency = document.getElementById('creditCurrency');
                if (creditCurrency != null) {
                    creditCurrency.disabled = true;
                    creditCurrency.value = data.currency;
                }
                document.getElementById('titleModalCredit').innerHTML = "LISTA DE CRÉDITOS DEL CLIENTE: " + "<b>" + customerName + "</b><br><b>CRÉDITO A APLICAR: " + getCurrencySymbolCode(data.currency) + " " + document.getElementById('creditInputValue').value + "</b>";
                var tableCredit = $('#creditTable').DataTable();
                tableCredit.destroy();
                var __currency__ = data.currency;
                $('#creditTable').DataTable({
                    "scrollX": true,
                    "scrollY": "250px",
                    "processing": true,
                    "orderCellsTop": true,
                    "fixedHeader": true,
                    "lengthChange": false,
                    "info": false,
                    "language": {
                        "url": "/js/languages/datatables/es.json"
                    },
                    "serverSide": false,
                    "paging": true,
                    'order' : [[ 0, "desc" ]],
                    "ordering": true,
                    "searching": false,
                    "ajax": function(data, callback, settings) {
                        $.get('/api/customers-credit-by-id/' + editCustomer.id + '?flag_active=1&currency=' + __currency__, {
                            limit: data.length,
                            offset: data.start,
                            searchInput: $('#searchInput').val(),
                            }, function(res) {
                                arrayCredits = [];
                                res.forEach(element => {
                                    arrayCredits[element.id] = element;
                                });     
                                callback({
                                    recordsTotal: res.length,
                                    recordsFiltered: res.length,
                                    data: res
                                });
                            });
                    },
                    "columns"    : [
                        {'data': function (data) {
                            return data.name;
                        }},
                        {'data': function (data) {
                            return getCurrencySymbolCode(data.currency) + ' ' + parseFloat(data.amount).toFixed(2);
                        }},
                        {'data': function (data) {
                            return getCurrencySymbolCode(data.currency) + ' ' + parseFloat(data.debt).toFixed(2);
                        }},
                        {'data': function (data) {
                            return getCurrencySymbolCode(data.currency) + ' ' + (parseFloat(data.amount) - parseFloat(data.debt)).toFixed(2);
                        }},
                        {'data': function (data) {
                            return '<input class="form-control" type="number" step="0.1" placeholder="Max. '+ 
                            (parseFloat(data.amount) - parseFloat(data.debt)).toFixed(2) + '" max="' + 
                            (parseFloat(data.amount) - parseFloat(data.debt)).toFixed(2) + '" />';
                        }},
                    ],
                    "destroy": true,
                });
                $('#modal-new-credit').modal({ backdrop: 'static', keyboard: false });
            }
            newCreditSubmit = function() {
                var button = document.getElementById('btnNewCreditSubmit');
                if (button != null) {
                    button.disabled = true;
                    button.innerHTML = 'Procesando registro...';
                    button.className = 'btn btn-warning';
                    var creditDetail = document.getElementById('creditDetail').value;
                    if (creditDetail == '') {
                        creditDetail = 'SIN INFORMACIÓN';
                    }
                    var dataSend = {
                        "currency": document.getElementById('creditCurrency').value,
                        "com_customers_id": data.customer.id,
                        "name": creditDetail.toUpperCase(),
                        "amount": document.getElementById('creditAmount').value,
                        "days": document.getElementById('creditPeriod').value,
                    };
                    // WEBSERVICE
                    $.ajax({
                        method: "POST",
                        url: "/api/new-customer-credit",
                        context: document.body,
                        data: dataSend,
                        statusCode: {
                            400: function() {
                                button.disabled = false;
                                button.innerHTML = 'GUARDAR';
                                button.className = 'btn btn-success';
                                alert("No se pudo crear el crédito");
                            },
                            500: function() {
                                button.disabled = false;
                                button.innerHTML = 'GUARDAR';
                                button.className = 'btn btn-success';
                                alert("No se pudo crear el crédito");
                            },
                        }
                    }).done(function(response) {
                        document.getElementById('creditCurrency').value = data.currency;
                        document.getElementById('creditDetail').value = "";
                        document.getElementById('creditAmount').value = "";
                        document.getElementById('creditPeriod').value = "";
                        var tableCredit = $('#creditTable').DataTable();
                        tableCredit.ajax.reload();
                        button.disabled = false;
                        button.innerHTML = 'GUARDAR';
                        button.className = 'btn btn-success';
                    });
                } else {
                    alert('No se puede continuar con el registro');
                }
            }
            validateCashPaymentManagement = function() {
                validateSale();
                cashManagement = false;
                cashManagementExchangeValue = 0.00;
                var btnSaveCashPaymentManagement = document.getElementById('saveCashPaymentManagement');
                var cashManagementTotal = document.getElementById('cashManagementTotal');
                var cashManagementTotal_ = 0.00;
                if (btnSaveCashPaymentManagement != null) {
                    var cashManagementExchange = document.getElementById('cashManagementExchange');
                    switch (data.currency) {
                        case data.currency:
                            cashManagementTotal_ = (parseFloat(document.getElementById('cashManagementInputPEN').value) + (parseFloat(document.getElementById('cashManagementInputUSD').value)*parseFloat(document.getElementById('generalCurrencyConvertionRv').value)));
                            cashManagementExchangeValue = (amountValue_ - generalDiscount) - cashManagementTotal_;
                            cashManagementExchange.innerHTML = getCurrencySymbolCode(data.currency) + ' ' + parseFloat(cashManagementExchangeValue);
                            // TOTAL
                            document.getElementById('tdMultCurTotal_USD').innerHTML = getCurrencySymbolCode(data.currency) + ' ' + (parseFloat(document.getElementById('cashManagementInputUSD').value)*parseFloat(document.getElementById('generalCurrencyConvertionRv').value));
                            document.getElementById('tdMultCurTotal_PEN').innerHTML = getCurrencySymbolCode(data.currency) + ' ' + parseFloat(document.getElementById('cashManagementInputPEN').value);
                            break;
                        case 'USD':
                            cashManagementTotal_ = (parseFloat(document.getElementById('cashManagementInputUSD').value) + (parseFloat(document.getElementById('cashManagementInputPEN').value)/parseFloat(document.getElementById('generalCurrencyConvertionRv').value)));
                            cashManagementExchangeValue = (amountValue_ - generalDiscount) - cashManagementTotal_;
                            cashManagementTotal_ = parseFloat(cashManagementTotal_*parseFloat(document.getElementById('generalCurrencyConvertionRv').value));
                            cashManagementExchangeValue = parseFloat(cashManagementExchangeValue*parseFloat(document.getElementById('generalCurrencyConvertionRv').value));
                            cashManagementExchange.innerHTML = getCurrencySymbolCode(data.currency) + ' ' + parseFloat(cashManagementExchangeValue);
                            // TOTAL
                            document.getElementById('tdMultCurTotal_USD').innerHTML = '$ ' + parseFloat(document.getElementById('cashManagementInputUSD').value);
                            document.getElementById('tdMultCurTotal_PEN').innerHTML = '$ ' + (parseFloat(document.getElementById('cashManagementInputPEN').value)/parseFloat(document.getElementById('generalCurrencyConvertionRv').value));
                            break;
                        default:
                            break;
                    }
                    cashManagementTotal.innerHTML = getCurrencySymbolCode(data.currency) + ' ' + cashManagementTotal_;
                    if (cashManagementExchangeValue <= 0) {
                        cashManagementExchangeValue = cashManagementExchangeValue*-1;
                        cashManagementExchange.innerHTML = getCurrencySymbolCode(data.currency) + ' ' + cashManagementExchangeValue;
                        cashManagement = true;
                        document.getElementById('cashManagementInputUSD').readOnly = true;
                        document.getElementById('cashManagementInputPEN').readOnly = true;
                        btnSaveCashPaymentManagement.onclick = function() { saveCashPaymentManagement() };
                        btnSaveCashPaymentManagement.innerHTML = 'VALIDACIÓN CORRECTA. FINALIZAR VENTA';                        
                    } else {
                        cashManagementExchange.innerHTML = getCurrencySymbolCode(data.currency) + ' 0.00';
                        btnSaveCashPaymentManagement.innerHTML = 'VALIDACIÓN INCORRECTA. VOLVER A INTENTAR';
                    }
                } else {
                    btnSaveCashPaymentManagement.innerHTML = 'HUBO UN ERROR EN LA VALIDACIÓN';
                }
            }
            saveCashPaymentManagement = function() {
                $('#modal-second-step').modal('toggle');
                $('#modal-cash-management').modal('toggle');
                finishNewSale();
            }
            paymentsManagement = function (amountValue_) {
                // PAYMENTS MANAGEMENT
                var generalService = document.getElementById('generalService');
                    if (servicePercent > 0) {
                        var servicePercentValue = parseFloat(((amountValue_)*taxesServices) * (parseFloat(servicePercent)/100));
                        generalService.value = servicePercentValue;
                    } else {
                        var servicePercentValue = 0.00;
                        generalService.value = servicePercentValue;
                    }
                    var paymentTable = document.getElementById('tBodyTablePaymentSummary');
                    paymentTable.innerHTML = "";
                    var tr = document.createElement('tr');
                    var td = '';
                    var countInitialCash = 0;
                    if (data.typePayments.length == 0) {
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                    }
                    data.typePayments.forEach(element => {
                        var initialCash = 0;
                        if (countInitialCash == 0 && (data.typePayments.length == 1)) {
                            initialCash = parseFloat(amountValue_);
                        } else {
                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        }
                        var readOnly = '';
                        if (element.readOnly) {
                            readOnly = 'readonly';
                        }
                        if (element.additionalBox) {
                            td = td + '<tr><td style="vertical-align: middle;" width="50%">' + element.name + '</td><td style="vertical-align: middle;"><input onClick="this.select();" type="' + element.type + '" step=".01"  id="' + element.htmlId + '" style="width: 100px;" maxlength="10" class="form-control" value="' + initialCash + '" ' + readOnly + '/></td></tr>' +
                                '<tr><td style="vertical-align: middle;" width="50%">CÓDIGO</td><td style="vertical-align: middle;"><input type="text" id="' + element.htmlId + 'Box" style="width: 100px;" maxlength="100" class="form-control" value="" placeholder="#Operación" /></td></tr>';
                        } else {
                            if (element.htmlId == 'cashInputValue') {
                                td = td + '<tr><td style="vertical-align: middle;" width="50%">' + element.name + '<span> </span><i style="cursor:pointer;" id="iCashPaymentManagement" class="fa fa-pencil"></i></td><td style="vertical-align: middle;"><input onClick="this.select();" type="' + element.type + '" step=".01" id="' + element.htmlId + '" style="width: 100px;" maxlength="10" class="form-control" value="' + initialCash + '" ' + readOnly + '/></td></tr>';
                            } else if (element.htmlId == 'creditInputValue') {
                                td = td + '<tr><td style="vertical-align: middle;" width="50%">' + element.name + '<span> </span><i style="cursor:pointer;" id="iCreditPaymentManagement" class="fa fa-pencil" onClick="creditPaymentManagement();"></i></td><td style="vertical-align: middle;"><input onClick="this.select();" type="' + element.type + '" step=".01" id="' + element.htmlId + '" style="width: 100px;" maxlength="10" class="form-control" value="' + initialCash + '" ' + readOnly + '/></td></tr>';
                            } else {
                                td = td + '<tr><td style="vertical-align: middle;" width="50%">' + element.name + '</td><td style="vertical-align: middle;"><input onClick="this.select();" type="' + element.type + '" step=".01" id="' + element.htmlId + '" style="width: 100px;" maxlength="10" class="form-control" value="' + initialCash + '" ' + readOnly + '/></td></tr>';
                            }
                        }
                        element.value = initialCash;
                        paymentAmounts[element.id] = element;
                        countInitialCash++;
                    });
                    paymentTable.innerHTML = td;
                    //Listener
                    data.typePayments.forEach(element => {
                        // KEYUP
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
                $('#modal-select-employee').modal({backdrop: 'static', keyboard: false});
                for(i = 0; i < userList.length; i++) {
                    var element = '<div  align="center" class="info-box-custom" id="employeeCard_' + userList[i].id + '">' + 
                                    '<div class="card-custom" onclick="addSelectedProduct(' + product + ',' + false + ',' + userList[i].id  + ')">' +
                                        '<img src="/img/new_ic_logo_short.png" style="height:100px; width:120px;">' +
                                        '<div>' +
                                            '<hr style="margin-top:5px;margin-bottom:0px;">' + userList[i].name + '<br>' + userList[i].lastname +
                                        '</div>' +
                                    '</div>' +
                                '</div>';

                    $('#employeeListChar').append(element);
                    document.getElementById('employeeCancel').value = product;
                }
            }
            removeEmployeeModal = function (deleteList = false) {
                element = '<div class="row" id="employeeListChar"></div>';
                if (deleteList == true) {
                    var productId = document.getElementById('employeeCancel').value;
                    clearSelectedProduct(productId);
                }
                $('#employeeListChar').replaceWith(element);
            }
            
            addSelectedProduct = function (product, quantityLegal = false, employeeId= null) {
                var employee = document.getElementById('employeeCard_' + employeeId);
                if (employee !== null) {
                    employee.style.backgroundColor = 'rgb(157, 174, 184)';
                }
                var xTable = document.getElementById('tBodyTableSelectedProducts');
                var tr = document.createElement('tr');
                product = data.products[product];
                var readOnly_ = '';
                if (!quantityLegal) {
                    product.quantity = 1;
                    readOnly_ = 'readonly';
                }
                if (userObject.roles_config[0].apps_id == 6) {
                    data.selectedProducts[countItemKey] = {...product, createdBy : employeeId};
                } else {
                    data.selectedProducts[product.id] = product;
                }
                    tr.setAttribute("id", "row_" + product.id);
                    tr.setAttribute("style", "font-size:10px;");
                    var editProductPrice = '';
                    if (parseInt(companyLoginData.flag_update_price) == 0) {
                        editProductPrice = 'readonly';
                    }
                    var trinnerHTML_ = '<td class="static-table-td" onClick="showProductDetail('+ product.id +')"><strong style="cursor:pointer;">' + product.code + '</strong></td>' +
                        '</td><td class="static-table-td">' + product.name + '</td>' +
                        '<td class="static-table-td-input"><input type="number" ' + editProductPrice + ' min="0" id="priceProduct_' + product.id + '" value="' + product.price + '" onClick="this.select();"></td>' + 
                        '<td class="static-table-td-input" style="padding-left: 0px;"><i style="color: #ffffff;" id="partialDiscountSymbol_' + product.id + '">' + getCurrencySymbolCode(data.currency) + ' </i><input type="number" onClick="this.select();" id="partialDiscount_' + product.id + '" value=0></td>' +
                        '<td class="static-table-td-input"><input type="number" onClick="this.select();" id="quantityProduct_' + product.id + '" value=' + product.quantity + '></td>';
                    if (product.allotmentType == 2) {
                        trinnerHTML_ = trinnerHTML_ + '<td class="static-table-td"><div class="input-group input-group-sm"><span class="input-group-btn">' +
                        '<button type="button" onclick="openSerialModal(' + product.id + ');" class="btn btn-success btn-flat"><i class="fa fa-key"></i></button>' +
                        '<button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
                    } else if (product.allotmentType == 1) {
                        if (allotmentSelected[product.id] == undefined) {
                            allotmentSelected.push(product.id);
                        }
                        trinnerHTML_ = trinnerHTML_ + '<td class="static-table-td-grm"><div class="input-group input-group-sm"><span class="input-group-btn">' + 
                        '<button type="button" style="padding-left: 8px; padding-right: 8px;" onclick="allotmentsSelectedProduct(' + product.id + ');" class="btn btn-primary btn-flat"><i class="fa fa-cubes"></i></button><span> </span>'+
                        '<button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';   
                    } else {
                        trinnerHTML_ = trinnerHTML_ + '<td class="static-table-td"><div class="input-group input-group-sm"><span class="input-group-btn"><button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
                    }
                    tr.innerHTML = trinnerHTML_;
                    xTable.insertBefore(tr, xTable.firstChild);
                    var x = document.getElementById("infoBoxProduct_" + product.id);
                    if (x != null) {
                        // x.style.pointerEvents   = "none";
                        x.style.backgroundColor = "#9daeb8";
                        data.padOption = 0;
                    }
                    var infoBoxProductFunction_ = document.getElementById('infoBoxProductFunction_' + product.id);
                    if (infoBoxProductFunction_ != null) {
                        infoBoxProductFunction_.onclick = function() { clearSelectedProduct(product.id); }
                    }            
                    //Prev Selected
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
                        data.padOption = 0;
                    }
                    data.rowClickedId = product.id;
                    //Listeners
                    callProductsListeners(product);
                    if (userObject.roles_config[0].apps_id == 6) {
                        countItemKey++;
                    } 
                    
            }
            subCategoryModal = function(categoryId) {
                document.getElementById("btnSubCategoryModal").onclick = function() {};
                parentSubcategory = categoryId;
                document.getElementById('rowSubCategories').innerHTML = '';
                $.ajax({
                    method: "GET",
                    url: "/api/categories?parentCategory=" + categoryId,
                    context: document.body,
                    statusCode: {
                        500: function() {
                            document.getElementById("btnSubCategoryModal").onclick = function() { subCategoryModal(categoryId); };
                            alert('No se encontraron subcategorías');
                        },
                        404: function() {
                            document.getElementById("btnSubCategoryModal").onclick = function() { subCategoryModal(categoryId); };
                            alert('No se encontraron subcategorías');
                        },
                        403: function() {
                            document.getElementById("btnSubCategoryModal").onclick = function() { subCategoryModal(categoryId); };
                            alert('No se encontraron subcategorías');
                        },
                        400: function() {
                            document.getElementById("btnSubCategoryModal").onclick = function() { subCategoryModal(categoryId); };
                            alert('No se encontraron subcategorías');
                        },
                    }
                }).done(function(response) {
                    document.getElementById('rowSubCategories').innerHTML = '';
                    if (response.length > 0) {
                        // document.getElementById('subCategoryModalText').innerHTML = "SUBCATEGORÍAS DISPONIBLES DE " + $('#productCategory').text();
                        // CARGA DE SUCURSALES
                        var rowSubCategories = document.getElementById('rowSubCategories');
                        response.forEach(element => {
                            var btn = document.createElement("BUTTON");
                            btn.onclick = function() {
                                if (subcategories[element.id] != undefined) {
                                    delete subcategories[element.id];
                                    document.getElementById('btnSubCategory_' + element.id).style.backgroundColor = "#ffffff"; 
                                    document.getElementById('btnSubCategory_' + element.id).style.color = "#000000"; 
                                } else {
                                    document.getElementById('btnSubCategory_' + element.id).style.backgroundColor = "#337ab7"; 
                                    document.getElementById('btnSubCategory_' + element.id).style.color = "#ffffff"; 
                                    subcategories[element.id] = element;
                                }
                            };
                            btn.setAttribute("class", "form-control");
                            btn.setAttribute("id", "btnSubCategory_" + element.id);
                            btn.style.width = '100%';
                            btn.style.padding = '5px';
                            btn.style.margin = '5px';
                            var t = document.createTextNode(element.name);
                            btn.appendChild(t);
                            rowSubCategories.appendChild(btn);
                            // APPLY COLOR
                            if (subcategories[element.id] != undefined) {
                                document.getElementById('btnSubCategory_' + element.id).style.backgroundColor = "#337ab7"; 
                                document.getElementById('btnSubCategory_' + element.id).style.color = "#ffffff"; 
                            }
                        });
                        $('#modal-subcategories').modal({ backdrop: 'static', keyboard: false });
                        document.getElementById("btnSubCategoryModal").onclick = function() { subCategoryModal(categoryId); };
                    } else {
                        alert("No se encontraron subcategorías");
                        document.getElementById("btnSubCategoryModal").onclick = function() { subCategoryModal(categoryId); };
                    }
                });
            }
            allotmentsSelectedProduct = function (productId) {
                allotmentProductId = productId;
                if (data.products[allotmentProductId]) {
                    document.getElementById('allotmentModalTitle').innerHTML = 'Lotes disponibles del producto: ' + data.products[allotmentProductId].code;                
                    $('#modal-allotment').modal({ backdrop: 'static', keyboard: false });
                    // DATATABLE
                    var table = $('#tableAllotmentProduct').DataTable();
                    table.destroy();
                    table = $('#tableAllotmentProduct').DataTable({
                        // "scrollX": true,
                        "processing": true,
                        "orderCellsTop": true,
                        "order" : [[ 0, "desc" ]],
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
                                $.get('/api/search-allotment-by-product-id/' + allotmentProductId, {
                                    limit: data.length,
                                    offset: data.start,
                                    }, function(res) {
                                        allotments[allotmentProductId] = res;
                                        callback({
                                            recordsTotal: res.length,
                                            recordsFiltered: res.length,
                                            data: res
                                        });
                                    });
                        },
                        "columns" : [
                            { "data": "description" },
                            { "data": "code" },
                            { "data": "quantity" },
                            { "data": function (data) {
                                return parseFloat(data.quantity) - parseFloat(data.quantity_dispatch);
                            }},
                            { "data": function (data) {
                                return '<input type="number" id="quantityAllotment_' + data.allotmentDetailId + '" value="0.00" onClick="this.select();"/>'
                            }},
                            { "data": "expiration_date" },
                        ],
                        "responsive": true,
                        "bDestroy": true,
                    });
                } else {
                    alert('Error en carga de producto');
                }
            }
            allotmentValidation = function () {
                if (allotmentProductId != 0) {
                    var validation = false;
                    var quantityAllotmentTotal = 0;
                    allotments[allotmentProductId].forEach(element => {
                        var quantityAllotment = document.getElementById('quantityAllotment_' + element.allotmentDetailId);
                        if (quantityAllotment != null) {
                            element.quantityClosed = parseFloat(quantityAllotment.value);
                            quantityAllotmentTotal = quantityAllotmentTotal + parseFloat(quantityAllotment.value);
                        }
                    });
                    console.log(data.products[allotmentProductId].quantity, quantityAllotmentTotal);
                    if (parseFloat(data.products[allotmentProductId].quantity) === quantityAllotmentTotal) {
                        console.log("Cantidades iguales");
                        if (parseFloat(quantityAllotmentTotal) > 0) {
                            allotments[allotmentProductId].quantityClosed = true;
                        } else {
                            validation = true;
                        }
                    } else { /*if (parseFloat(data.products[allotmentProductId].quantity) < quantityAllotmentTotal) */
                        console.log("Cantidades diferentes");
                        if (parseFloat(quantityAllotmentTotal) > 0) {
                            allotments[allotmentProductId].quantityClosed = true;
                            data.products[allotmentProductId].quantity = quantityAllotmentTotal;
                            document.getElementById('quantityProduct_' + allotmentProductId).value = quantityAllotmentTotal;
                        } else {
                            validation = true;
                        }
                    }
                    //  else {
                    //     validation = true;
                    // }
                    document.getElementById('allotmentButtonSubmit').disabled = validation;
                    if (validation) {
                        alert('Validación incorrecta. Las cantidades no fueron aceptadas.');
                    } else {
                        alert('Validación correcta. Presione el botón GUARDAR.');
                    }
                }
            }
            openSerialModal = function (productId) {
                // SERIALS
                serialProductId = productId;
                document.getElementById('productSerialDetail').innerHTML = 'Asignación de series del producto: ' +
                    data.selectedProducts[productId].code + ' - ' + data.selectedProducts[productId].name;
                var tableSerialResume = $('#tableSerialResume').DataTable();
                tableSerialResume.destroy();
                var serials = data.serials;
                var tableSerialResume = $('#tableSerialResume').DataTable({
                    "processing": false,
                    "lengthChange": false,
                    "language": {
                        "url": "/js/languages/datatables/es.json"
                    },
                    "serverSide": false,
                    "bPaginate": true,
                    "ordering": false,
                    "searching": true,
                    "ajax": function(data, callback, settings) {
                        $.get('/api/serials-by-product/' + productId, {
                            limit: data.length,
                            offset: data.start,
                            }, function(res) {
                                callback({
                                    recordsTotal: res.length,
                                    recordsFiltered: res.length,
                                    data: res
                                });
                            });
                    },
                    "columns"    : [
                        {'data': function(data) {
                            var checked = '';
                            if (serials[productId] != undefined) {
                                var index = serials[productId].indexOf(data.id);
                                if (index > -1) {
                                    checked = 'checked';
                                }
                            }
                            return '<input ' + checked + ' id="checkboxSerial_' + data.id + '_' + productId + '" onChange="checkboxSerial(' + data.id + ', ' + productId + ');" type="checkbox">';
                        }},
                        {'data': 'serial'},
                        {'data': 'imei'},
                    ],
                    "responsive": true,
                    "bDestroy": true
                });

                var btnSerialSubmit = document.getElementById('btnSerialSubmit');
                if (btnSerialSubmit != null) {
                    btnSerialSubmit.innerHTML = 'VALIDAR';
                    btnSerialSubmit.onclick = function() { validateSerialSubmit(); };
                }
                $('#modal-serial').modal({ backdrop: 'static', keyboard: false });
            }
            checkboxSerial = function (serialId, productId) {
                if (document.getElementById('checkboxSerial_'+serialId+'_'+productId).checked) {
                    if (data.serials[productId] == undefined) {
                        data.serials[productId] = [];
                    }
                    if (data.serials[productId][serialId] == undefined) {
                        data.serials[productId].push(serialId);
                    }
                } else {
                    var index = data.serials[productId].indexOf(serialId);
                    if (index > -1) {
                        data.serials[productId].splice(index, 1);
                    }
                }
            }
            validateSerialSubmit = function () {
                if (serialProductId != 0) {
                    var btnSerialSubmit = document.getElementById('btnSerialSubmit');
                    if (btnSerialSubmit != null) {
                        btnSerialSubmit.disabled = true;
                        btnSerialSubmit.innerHTML = 'PROCESANDO...';
                        // VALIDATION
                        var quantitySerialValidation_ = document.getElementById('quantityProduct_' + serialProductId);
                        if (quantitySerialValidation_ != null) {
                            quantitySerialValidation_ = parseInt(quantitySerialValidation_.value);
                            if (quantitySerialValidation_ == data.serials[serialProductId].length) {
                                btnSerialSubmit.disabled = false;
                                btnSerialSubmit.innerHTML = 'VALIDACIÓN CORRECTA. GUARDAR';
                                btnSerialSubmit.onclick = function() { $('#modal-serial').modal('toggle'); }
                            } else {
                                btnSerialSubmit.disabled = false;
                                btnSerialSubmit.innerHTML = 'VALIDACIÓN INCORRECTA, LAS CANTIDADES SON DIFERENTES. VUELVA A INTENTAR';
                            }
                        }
                    }
                } else {
                    alert("No se puede validar la operación");
                }
            }
            clearSelectedProduct = function (productId) {
                console.log("ok")
                var infoBoxProductFunction_ = document.getElementById('infoBoxProductFunction_' + productId);
                if (infoBoxProductFunction_ != null) {
                    infoBoxProductFunction_.onclick = function() { 
                        if (userObject.roles_config[0].apps_id == 6) {
                            selectEmployee(productId);
                        } else {
                            addSelectedProduct(productId);
                        }  
                    }
                }
                do {
                    var selectedElement = document.getElementById("row_" + productId);
                    if (selectedElement !== null) {
                        selectedElement.remove();
                    }
                } while (selectedElement !== null);
                
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
                var allotmentSelected_ = [];
                allotmentSelected.forEach(element => {
                    if (element != productId) {
                        allotmentSelected_.push(element);
                    }
                });
                allotmentSelected = allotmentSelected_;
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
                    '<div class="form-group"><label for="clientNames">TIPO DE DOCUMENTO</label>' +
                    '<select class="form-control" id="feCustomerTypeDocument">' +
                        '<option value="01">DNI</option>' +
                        '<option selected value="04">CARNET DE EXTRANJERIA</option>' +
                        '<option value="07">PASAPORTE</option>' +
                        '<option value="00">SIN DOCUMENTO</option>' +
                    '</select></div>' +
                    '<div class="form-group"><label for="clientNames">NÚMERO DE DOCUMENTO</label>' +
                    '<input type="text" class="form-control" id="clientSimpleDocument" required placeholder="Ingrese DOCUMENTO" value=""></div>' +
                    '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                    '<input type="text" class="form-control" id="clientSimpleNames" required placeholder="Ingrese NOMBRES" value=""></div>' +
                    '<div class="form-group"><label for="clientFirstLastname">APELLIDO PATERNO</label>' + 
                    '<input type="text" class="form-control" id="clientSimpleFirstLastname" required placeholder="Ingrese APELLIDO PATERNO" value=""></div>' +
                    '<div class="form-group"><label for="clientSecondLastname">APELLIDO MATERNO</label>' +
                    '<input type="text" class="form-control" id="clientSimpleSecondLastname" required placeholder="Ingrese APELLIDO MATERNO" value=""></div></div>' +
                    '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                    '<input type="text" class="form-control" id="clientSimplePhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                    '<div class="form-group"><label for="clientSimpleEmail">CORREO ELECTRÓNICO</label>' +
                    '<input type="text" class="form-control" id="clientSimpleEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div>'+
                    '<div class="form-group"><label for="clientSimpleAddress">DIRECCIÓN</label>' +
                    '<input type="text" class="form-control" id="clientSimpleAddress" maxlength=100 placeholder="Ingrese DIRECCIÓN" value=""></div>'+
                    '<div class="form-group"><label for="clientSimpleDescription">DESCRIPCIÓN</label>' +
                    '<textarea type="text" class="form-control" id="clientSimpleDescription" maxlength=100 placeholder="Ingrese DESCRIPCIÓN"</textarea>';
                clientDataResponse.appendChild(form);
            }
            genericClient = function() {
                genericCustomer = JSON.parse(document.getElementById("genericCustomer").value);
                data.customer   = genericCustomer;
                data.customerId = genericCustomer.id;
                document.getElementById("inputSearchClient").value = genericCustomer.name + " " + genericCustomer.lastname;
            }
            saveNewSimpleClient = function () {
                var validation = true;
                var clientSimpleNames = document.getElementById('clientSimpleNames');
                var clientSimpleFirstLastname = document.getElementById('clientSimpleFirstLastname');
                var clientSimpleSecondLastname = document.getElementById('clientSimpleSecondLastname');
                var clientSimplePhone = document.getElementById('clientSimplePhone');
                var clientSimpleEmail = document.getElementById('clientSimpleEmail');
                var clientSimpleDocument = document.getElementById('clientSimpleDocument');
                var clientSimpleAddress = document.getElementById('clientSimpleAddress');
                var clientSimpleDescription = document.getElementById('clientSimpleDescription');
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
                    var feCustomerTypeDocument = document.getElementById('feCustomerTypeDocument');
                    if (feCustomerTypeDocument != null) {
                        switch (feCustomerTypeDocument.value) {
                            case '00':
                                var dataSend = {
                                    "name" : clientSimpleNames.value.toUpperCase(),
                                    "lastname" : clientSimpleFirstLastname.value.toUpperCase() + ' ' + clientSimpleSecondLastname.value.toUpperCase(),
                                    "phone" : clientSimplePhone.value,
                                    "email" : clientSimpleEmail.value,
                                    "address": clientSimpleAddress.value,
                                    "creation_type": 2,
                                    "description": clientSimpleDescription.value,
                                    "flag_type_person": 1,
                                };
                                break;
                            case '01':
                                var dataSend = {
                                    "dni" : clientSimpleDocument.value,
                                    "name" : clientSimpleNames.value.toUpperCase(),
                                    "lastname" : clientSimpleFirstLastname.value.toUpperCase() + ' ' + clientSimpleSecondLastname.value.toUpperCase(),
                                    "phone" : clientSimplePhone.value,
                                    "email" : clientSimpleEmail.value,
                                    "address": clientSimpleAddress.value,
                                    "description": clientSimpleDescription.value,
                                    "flag_type_person": 1,
                                };
                                break;
                            case '04':
                                var dataSend = {
                                    "dni" : clientSimpleDocument.value,
                                    "name" : clientSimpleNames.value.toUpperCase(),
                                    "lastname" : clientSimpleFirstLastname.value.toUpperCase() + ' ' + clientSimpleSecondLastname.value.toUpperCase(),
                                    "phone" : clientSimplePhone.value,
                                    "email" : clientSimpleEmail.value,
                                    "address": clientSimpleAddress.value,
                                    "description": clientSimpleDescription.value,
                                    "flag_type_person": 3,
                                };
                                break;
                            case '07':
                                var dataSend = {
                                    "dni" : clientSimpleDocument.value,
                                    "name" : clientSimpleNames.value.toUpperCase(),
                                    "lastname" : clientSimpleFirstLastname.value.toUpperCase() + ' ' + clientSimpleSecondLastname.value.toUpperCase(),
                                    "phone" : clientSimplePhone.value,
                                    "email" : clientSimpleEmail.value,
                                    "address": clientSimpleAddress.value,
                                    "description": clientSimpleDescription.value,
                                    "flag_type_person": 4,
                                };
                                break;
                            default:
                                var dataSend = {
                                    "name" : clientSimpleNames.value.toUpperCase(),
                                    "lastname" : clientSimpleFirstLastname.value.toUpperCase() + ' ' + clientSimpleSecondLastname.value.toUpperCase(),
                                    "phone" : clientSimplePhone.value,
                                    "email" : clientSimpleEmail.value,
                                    "address": clientSimpleAddress.value,
                                    "description": clientSimpleDescription.value,
                                    "creation_type": 2,
                                    "flag_type_person": 1,
                                };
                                break;
                        }
                    }
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
            validateSale = function () {
                var correctPrice = true;
                data.selectedProducts.forEach(element => {
                    if (element.price == 0) {
                        correctPrice = false;
                    }
                });
                // if (correctPrice == false && typeDocumentCode == 'FAC') {
                //     document.getElementById('saleErrorMessage').innerHTML = 'LOS MONTOS NO SON ADECUADOS. VOLVER A VALIDAR';
                //     document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                // } else {
                    if (!priceValidation && (companyLoginData.company_id == 533 || companyLoginData.company_id == 615)) {
                        document.getElementById('saleErrorMessage').innerHTML = 'PRECIOS FUERA DE RANGO MÍNIMO-MÁXIMO';
                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                    } else {
                        if ((allotments.length < allotmentSelected.length) && typeDocumentCode != "COT") {
                            document.getElementById('saleErrorMessage').innerHTML = 'INFORMACIÓN DE LOTES INCORRECTA';
                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                        } else {
                            var typeGeneralDiscount = document.getElementById('typeGeneralDiscount');
                            if (typeGeneralDiscount != null) {
                                var generalDiscountInput = document.getElementById('generalDiscount');
                                if (generalDiscountInput != null) {
                                    setInterval();
                                    amountValue_ = parseFloat(amountValue_);
                                    paymentAmount = 0;
                                    paymentAmounts.forEach(element => {
                                        paymentAmount = paymentAmount + parseFloat(element.value);
                                    });
                                    switch (typeGeneralDiscount.value) {
                                        case "0":
                                        // here amount
                                            amountValue_ = amountValue_ - parseFloat(generalDiscountInput.value);
                                            generalDiscount = parseFloat(generalDiscountInput.value);
                                            break;
                                        case "1":
                                            amountValue_ = amountValue_ - (amountValue_*parseFloat(generalDiscountInput.value)/100);
                                            generalDiscount = amountValue_*parseFloat(generalDiscountInput.value)/100;
                                            break;
                                        default:
                                            break;
                                    }
                                    document.getElementById('labelTotalAmount').innerHTML = 'TOTAL A PAGAR: ' + data.symbolCode + ' ' + (amountValue_).toFixed(fixedVar);
                                    if (typeDocumentCode != 'NVT') {
                                        var partialAmount = getPartialAmount();
                                        document.getElementById('finalStepPrevExoneradas').innerHTML = '<b>OP.EXONERADAS: ' + data.symbolCode + ' ' + (parseFloat(opExoneradas)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevInafectas').innerHTML = '<b>OP.INAFECTAS: ' + data.symbolCode + ' ' + (parseFloat(opInafectas)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevIcbper').innerHTML = '<b>OP.ICBPER: ' + data.symbolCode + ' ' + (parseFloat(opIcbper)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevBag').innerHTML = '<b>PRECIO BOLSAS: ' + data.symbolCode + ' ' + (parseFloat(opBag)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevGratuitas').innerHTML = '<b>OP.GRATUITAS: ' + data.symbolCode + ' ' + (parseFloat(opGratuitas)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevSubtotal').innerHTML = '<b>OP.GRAVADAS: ' + data.symbolCode + ' ' + ((parseFloat(partialAmount)/taxesUp)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevIgv').innerHTML = '<b>IGV: ' + data.symbolCode + ' ' + (parseFloat(partialAmount) - (parseFloat(partialAmount)/taxesUp)).toFixed(2) + '</b>';
                                    } else {
                                        document.getElementById('finalStepPrevIcbper').innerHTML = '<b>OP.ICBPER: ' + data.symbolCode + ' ' + (parseFloat(opIcbper)).toFixed(2) + '</b>';
                                        document.getElementById('finalStepPrevBag').innerHTML = '<b>PRECIO BOLSAS: ' + data.symbolCode + ' ' + (parseFloat(opBag)).toFixed(2) + '</b>';
                                    }
                                    // HERE finalStepPrevTotal
                                    document.getElementById('finalStepPrevTotal').innerHTML = '<b>TOTAL: ' + data.symbolCode + ' ' + (amountValue_).toFixed(2) + '</b>';
                                    exchangeAmount = paymentAmount - amountValue_;
                                    if (documentClientValidation) {
                                        if (exchangeAmount >= 0 && (paymentAmount > 0 || amountValue_ == 0)) {
                                            document.getElementById('cashInputExchange').value = (exchangeAmount);
                                            document.getElementById('generalDiscount').readOnly = true;
                                            // boton validar que se convierta
                                            var iCashPaymentManagement = document.getElementById('iCashPaymentManagement');
                                            if (iCashPaymentManagement != null) {
                                                iCashPaymentManagement.onclick = function() { cashPaymentManagement() };
                                            }
                                            document.getElementById('saleErrorMessage').innerHTML = 'VALIDACIÓN CORRECTA. TERMINE SU VENTA';
                                            document.getElementById('saleErrorMessage').className = 'btn btn-success pull-center';
                                            document.getElementById('btnFinishNewSale').innerHTML = 'FINALIZAR';
                                            document.getElementById('btnFinishNewSale').onclick = function() { finishNewSale() };
                                        } else {
                                            document.getElementById('cashInputExchange').value = "0.00";
                                            // boton validar que se convierta
                                            document.getElementById('saleErrorMessage').innerHTML = 'LOS MONTOS NO SON ADECUADOS. VOLVER A VALIDAR';
                                            document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                                        }                            
                                    } else {
                                        // boton validar que se convierta
                                        document.getElementById('saleErrorMessage').innerHTML = 'INGRESE UN CLIENTE VÁLIDO';
                                        document.getElementById('saleErrorMessage').className = 'btn btn-danger pull-center';
                                    }
                                }
                            }
                        }
                    }
                // }
                
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
                                    // data.selectedProducts[product.id] = product;
                                    if (userObject.roles_config[0].apps_id == 6) {
                                        selectEmployee(product.id);
                                    } else {
                                        addSelectedProduct(product.id);
                                    }
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
        //OnClick elements
            $("#priceList").click(priceList);
            $("#salesList").click(salesList);
            $("#salesReport").click(salesReport);
            $("#printSalePdf").click(printSalePdf);
            $("#printSalePdfA4").click(printSalePdfA4);
            $("#saveNewClient").click(saveNewClient);
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
                                    if ((response[i].stock > 0 || response[i].type == 2 || isQuotation == 'COT') && response[i].flag_operation != 1) {
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
                                                    if (data.selectedProducts[product.id].stock < quantity && product.type != 2) {
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
                                                    // data.selectedProducts[product.id] = product;
                                                    if (userObject.roles_config[0].apps_id == 6) {
                                                        selectEmployee(product.id);
                                                    } else {
                                                        addSelectedProduct(product.id);
                                                    }
                                                }
                                            } else {
                                                alert("No se encontraron productos. Verifique si este cuenta con stock");
                                            }
                                            closeAllLists();
                                        });
                                    } else {
                                        b.style.background = '#eee';
                                        b.style.cursor = 'pointer';
                                        b.addEventListener("click", function(e) {
                                            var iterator = this.getElementsByTagName("input")[0].value;
                                            product = response[iterator];
                                            if (product != undefined) {
                                                data.products[product.id] = product;
                                                showProductDetail(product.id);
                                            }
                                        });
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
            // FIRST STEPS
            var saleJson = document.getElementById('saleJson');
            if (saleJson != null) {
                // document.getElementById('searchProduct').disabled = true;
                // document.getElementById('searchProductBarCode').disabled = true;
                saleJson = JSON.parse(saleJson.value);
                sal_sale_documents_id = saleJson.saleId;
                if (saleJson.items != undefined) {
                    saleJson.items.forEach(element => {
                        element.id = element.war_products_id;
                        if (data.products[element.war_products_id] != undefined) {
                            if (data.selectedProducts[element.war_products_id] != undefined) {
                                element.quantity = parseFloat(element.quantity) + parseFloat(data.selectedProducts[element.war_products_id].quantity);
                                data.products[element.war_products_id] = element;
                                data.selectedProducts[element.war_products_id] = element;
                            }
                        } else {
                            data.products[element.war_products_id] = element;
                            data.selectedProducts[element.war_products_id] = element;
                        }
                        addSelectedProduct(element.war_products_id, true);
                    });
                }
                document.getElementById('typeDocument').value = saleJson.typeDocumentId;
            }
            autocompleteForClients(document.getElementById('inputSearchClient'));
            autocompleteForProducts(document.getElementById('searchProduct'));
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>