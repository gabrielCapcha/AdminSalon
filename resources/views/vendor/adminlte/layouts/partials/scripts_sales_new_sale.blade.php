<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    //Primary variables
    var secondStepOfSale;
    var addSelectedProduct;
    var clearSelectedProduct;
    var updateSelectedProduct;

    //Document Ready
    $(document).ready(function() {
        //Initialize Select2 Elements
        $('.select2').select2();
        setTimeout(function() {
            $('#genericClient').trigger('click');
        }, 1);

        //Initialize variables
        var data = {};
        data.selectedProducts = [];
        data.customer = {};

        //Regular Functions
        function newClient() {
            if (data.newCustomer != undefined) {
                data.newCustomer.phone = document.getElementById("clientPhone").value;
                data.newCustomer.email = document.getElementById("clientEmail").value
                $.ajax({
                    method: "POST",
                    url: "/api/customer",
                    context: document.body,
                    data: data.newCustomer,
                    statusCode: {
                        400: function() {
                            alert("Hubo un error en el registro.");
                        }
                    }
                }).done(function(response) {
                    data.customer = response;
                    data.customerId = response.id;
                    document.getElementById("inputSearchClient").value    = response.name + ", " + response.lastname;
                    document.getElementById("inputSearchClient").readOnly = true;
                    $('#dismissNewClient').trigger('click');
                });   
            }
        }
        function clearClient() {
            document.getElementById("inputSearchClient").value    = "";
            document.getElementById("inputSearchClient").readOnly = false;
            data.customerId = undefined;
        }
        function searchClient() {
            var searchClient = document.getElementById("inputSearchClient").value;
            switch (searchClient.length) {
                case 8:
                    $.ajax({
                        url: "/api/customer/by/dni/" + searchClient,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron registros en su base de datos.");
                            }
                        }
                    }).done(function(response) {
                        data.customer = response;
                        data.customerId = response.id;
                        document.getElementById("inputSearchClient").value    = response.name + ", " + response.lastname;
                        document.getElementById("inputSearchClient").readOnly = true;
                    });
                    break;
                case 11:
                    $.ajax({
                        url: "/api/customer/by/ruc/" + searchClient,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron registros en su base de datos.");
                            }
                        }
                    }).done(function(response) {
                        data.customer = response;
                        data.customerId = response.id;
                        document.getElementById("inputSearchClient").value    = response.name + ", " + response.lastname;
                        document.getElementById("inputSearchClient").readOnly = true;
                    });
                    break;            
                default:
                    alert("DNI o RUC ingresado no son válidos.");
                    break;
            }
        }
        function genericClient() {
            var genericCustomer = JSON.parse(document.getElementById("genericCustomer").value);
            data.customer = genericCustomer;
            if (data.customerId == undefined) {
                data.customerId = genericCustomer.id;
                document.getElementById("inputSearchClient").value    = genericCustomer.name + ", " + genericCustomer.lastname;
                document.getElementById("inputSearchClient").readOnly = true;
            } else {
                alert("Ya se asignó un cliente genérico");
            }
        }
        function dismissNewClient() {
            var clientDataResponse = document.getElementById("clientDataResponse");
            clientDataResponse.innerHTML = "";
        }
        function productCategories() {
            document.getElementById("productsDivList").innerHTML = "";
            var selectedCategories = document.getElementById("productCategories").value;
            var x = document.getElementById("loadingDiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            $.ajax({
                url: "/api/products-list?categoryId=" + selectedCategories,
                context: document.body
            }).done(function(response) {
                x.style.display = "none";
                data.products = [];
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
                    var element = '<div class="col-md-6"><div class="info-box" id="infoBoxProduct_' + response[i].id + '" onclick="addSelectedProduct( ' + response[i].id + ' );"><div class="col-md-6"><span class="info-box-text">' + response[i].name + '</span><span class="info-box-number">' + response[i].stock + '</span><span class="info-box-number">S/ ' + response[i].price + '</span><span class="progress-description">' + description + '</span></div><div class="col-md-6"><span class="info-box-image"><img class="image-info-box" src="' + urlImage + '" height="50px" width="50px"></span></div></div></div>';
                    $('#productsDivList').append(element);
                }
            });
        }
        function searchClientSunatButton() {
            // clientDataResponse
            var x = document.getElementById("loadingDivCustomer");
            var searchClientSunat = document.getElementById('searchClientSunat').value;
            var clientDataResponse = document.getElementById("clientDataResponse");
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
                        document.getElementById('searchClientSunat').value = "";
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
                            document.getElementById('searchClientSunat').value = "";
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
                            data.newCustomer.ruc = searchClientSunat;
                        } else {
                            x.style.display = "none";
                            alert("Ruc en condición NO HABIDO");
                        }
                    });
                    break;
                default:
                    console.log(searchClientSunat.length);
                    alert("DNI o RUC ingresado no son válidos.");
                    break;
            }
        }
        function finishNewSale() {
            // $.ajax({
            //     url: "/sales",
            //     context: document.body,
            //     method: "POST",
            //     statusCode: {
            //         400: function() {
            //             alert("La venta no se pudo realizar.");
            //         }
            //     }
            // }).done(function(response) {
            // });
            var formSale = document.getElementById('formSale');
            formSale.submit();
        }

        //Primary functions
        secondStepOfSale = function () {
            var xTable = document.getElementById('tBodyTableProductsSummary');
            xTable.innerHTML = "";
            data.selectedProducts.forEach(element => {
                var tr = document.createElement('tr');
                tr.setAttribute("style", "font-size:10px;");
                tr.innerHTML ='<td>' + element.code + '</td><td>' + element.name + '</td>' +
                    '<td>' + element.price + '</td><td>' + element.quantity + '</td>';
                xTable.appendChild(tr); 
            });
            document.getElementById('clientName').innerHTML = data.customer.name + ', ' + data.customer.lastname + ' <br /> RUC: ' + data.customer.ruc + ' - DNI: ' + data.customer.dni;
            // var paymentTp = document.getElementById('paymentTp');
            var paymentTable = document.getElementById('tBodyTablePaymentSummary');
            paymentTable.innerHTML = "";
            $('#paymentTp option:selected').each(function() {
                var tr = document.createElement('tr');
                tr.innerHTML ='<td>' + $(this).text() + '</td><td><input type="text" maxlength="10" class="form-control" value="0" />' + 
                    '<td><input type="text" maxlength="10" class="form-control" value="0" /></td>';
                paymentTable.appendChild(tr);
            });
        }
        addSelectedProduct = function (product) {
            var xTable = document.getElementById('tBodyTableSelectedProducts');
            var tr = document.createElement('tr');
            product = data.products[product];
            product.quantity = 1;
            data.selectedProducts[product.id] = product;
            tr.setAttribute("id", "row_" + product.id);
            tr.setAttribute("style", "font-size:10px;");
            tr.innerHTML ='<td>' + product.code + '</td><td>' + product.name + '</td>' +
                 '<td><input id="priceProduct_' + product.id + '" size="5" value="' + product.price + '"></td>' + 
                 '<td><input id="quantityProduct_' + product.id + '" size="5" value=1></td>' +
                 '<td><div class="input-group input-group-sm"><span class="input-group-btn"></span><span class="input-group-btn"><button type="button" onclick="updateSelectedProduct(' + product.id + ');" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button></span><span class="input-group-btn"><button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
            xTable.appendChild(tr);
            var x = document.getElementById("infoBoxProduct_" + product.id);
            x.style.pointerEvents   = "none";
            x.style.backgroundColor = "#E8E8E8";
        }
        clearSelectedProduct = function (productId) {
            delete(data.selectedProducts[productId]);
            document.getElementById("row_" + productId).remove();
            var x = document.getElementById("infoBoxProduct_" + productId);
            x.style.pointerEvents   = "visible";
            x.style.backgroundColor = "#ffffff";
        }
        updateSelectedProduct = function (productId) {
            var price = document.getElementById("priceProduct_" + productId).value;
            var quantity = document.getElementById("quantityProduct_" + productId).value;
            data.selectedProducts[productId].price = price;
            if (data.selectedProducts[productId].stock < quantity) {
                data.selectedProducts[productId].quantity = data.selectedProducts[productId].stock;
                alert("El stock actual es menor que la cantidad ingresada");
            } else {
                data.selectedProducts[productId].quantity = quantity;
            }
        }

        //Listeners
        var searchProduct = document.getElementById('searchProduct');
        searchProduct.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                $.ajax({
                    url: "/api/products-search/" + searchProduct.value,
                    context: document.body,
                    statusCode: {
                        404: function() {
                            alert("No se encontraron productos.");
                        }
                    }
                }).done(function(response) {
                    var xTable = document.getElementById('tBodyTableSelectedProducts');
                    var tr = document.createElement('tr');
                    product = response[0];
                    product.quantity = 1;
                    data.selectedProducts[product.id] = product;
                    tr.setAttribute("id", "row_" + product.id);
                    tr.setAttribute("style", "font-size:10px;");
                    tr.innerHTML ='<td>' + product.code + '</td><td>' + product.name + '</td>' +
                        '<td><input id="priceProduct_' + product.id + '" size="5" value="' + product.price + '"></td>' + 
                        '<td><input id="quantityProduct_' + product.id + '" size="5" value=1></td>' +
                        '<td><div class="input-group input-group-sm"><span class="input-group-btn"></span><span class="input-group-btn"><button type="button" onclick="updateSelectedProduct(' + product.id + ');" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button></span><span class="input-group-btn"><button type="button" onclick="clearSelectedProduct(' + product.id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></span></div></td>';
                    xTable.appendChild(tr);
                    var x = document.getElementById("infoBoxProduct_" + product.id);
                    if (x !== undefined) {
                        x.style.pointerEvents   = "none";
                        x.style.backgroundColor = "#E8E8E8";                        
                    }
                });
            }
        });
        
        //OnClick and OnChange elements
        $("#clearClient").click(clearClient);
        $("#saveNewClient").click(newClient);
        $("#searchClient").click(searchClient);
        $("#genericClient").click(genericClient);
        $("#dismissNewClient").click(dismissNewClient);
        $("#productCategories").change(productCategories);
        $("#searchClientSunatButton").click(searchClientSunatButton);
        $("#finishNewSale").click(finishNewSale);
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>