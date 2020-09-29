<!-- REQUIRED JS SCRIPTS -->
<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script>
    var saveInventory;
    var goToProducts;
    var clearSelectedProduct;
    $(document).ready(function() {
        //Initialize variables
        var allotmentProductId = 0;
        var data = {};
        var serials = {};
        var allotments = [];
        var allotmentSelected = [];
        var serialsById = [];
        var count = 1;
        data.products = [];
        data.selectedProducts = [];
        //PriceLists value
        var priceLists = document.getElementById('priceLists');
        data.priceLists = JSON.parse(priceLists.value);
        priceLists.value = '';
        //Functions
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
                    mainheaderSearchBar.style.height = "10px";
                    mainheaderSearchBar.style.zIndex = "9";
                    //LLAMADA AL SERVICIO
                    $.ajax({
                        method: "GET",
                        url: "/api/products-for-sale/"+ val + "?&warehouseId=" + document.getElementById('warehouseId').value,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron productos.");
                            }
                        }
                    }).done(function(response) {
                        if (response.length == 0) {
                            inp.value = "";
                            alert("No se encontraron productos.");
                        } else {
                            for (i = 0; i < response.length; i++) {
                                var nameLastname = response[i].name + ' - ' + response[i].code;
                                b = document.createElement("DIV");
                                b.setAttribute('class', 'form-control-autocomplete');
                                b.style.background = '#ffffff';
                                b.style.cursor = 'pointer';
                                b.innerHTML += nameLastname;
                                b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                b.addEventListener("click", function(e) {
                                    var iterator = this.getElementsByTagName("input")[0].value;
                                    inp.value = "";
                                    product = response[iterator];
                                    if (product != undefined) {
                                        if (data.selectedProducts[product.id] != undefined) {
                                            var quantityHtml = document.getElementById('quantity_' + product.id);
                                            if (quantityHtml != null) {
                                                var quantity_ = parseFloat(quantityHtml.value);
                                                quantityHtml.value = quantity_ + 1;
                                                // trOrder
                                                var row = $("#tr_" + product.id);
                                                row.each(function() {
                                                    var $this=$(this);
                                                    $this.insertBefore($this.prevAll().last());
                                                });
                                            }
                                        } else {
                                            data.products[product.id] = product;
                                            data.selectedProducts[product.id] = product;
                                            addSelectedProduct(product.id);
                                        }
                                    } else {
                                        alert("No se encontraron productos.");
                                    }
                                    closeAllLists();
                                });
                                a.appendChild(b);
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
        function callUnitName(id) {
            return "UNIDAD NO ENCONTRADA";
        }
        function addSelectedProduct(id) {
            var tBodyData = document.getElementById('tBodyData');
            var tr = document.createElement('tr');
            var unitName = 'UNIDAD';
            if (data.products[id].unitName != undefined) {
                unitName = data.products[id].unitName;
            } else {
                callUnitName(data.products[id].unitId);
            }
            tr.setAttribute('id', 'tr_' + id);
            var tdText_ = '<td style="vertical-align:middle;">' + data.products[id].name + '</td>' +
                '<td style="vertical-align:middle;">' + data.products[id].brandName + '</td>' +
                '<td style="vertical-align:middle;">' + data.products[id].autoBarcode + '</td>' +
                '<td style="vertical-align:middle;">' + data.products[id].code + '</td>' + 
                '<td style="vertical-align: middle;">' + unitName + '</td>' + 
                '<td style="vertical-align:middle;">' + data.products[id].stock + '</td>' + 
                '<td style="vertical-align:middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="quantity_' + id + '" type="number" value="1" /></td>';
                if (data.products[id].allotmentType == 1) {
                    allotmentSelected.push(id);
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button style="padding-left: 8px; padding-right: 8px;" type="button" onclick="openAllotmentModal(' + id + ');" class="btn btn-primary btn-flat"><i class="fa fa-cubes"></i></button>' + 
                    '<span> </span><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></td>';    
                } else if (data.products[id].allotmentType == 2) {
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button style="padding-left: 8px; padding-right: 8px;" type="button" onclick="openSerialModal(' + id + ');" class="btn btn-success btn-flat"><i class="fa fa-key"></i></button>' + 
                    '<span> </span><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></td>';
                } else {
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></td>';    
                }
            tr.innerHTML = tdText_;
            tBodyData.insertBefore(tr, tBodyData.firstChild);
            // tBodyData.insertBefore(tr, tBodyData.nextSibling);
        }
        function callChildsOfSelectedProduct(id) {
            //LLAMADA AL SERVICIO
            $.ajax({
                url: "/api/child-products-for-inventory/" + id,
                context: document.body,
                statusCode: {
                    404: function() {
                        alert("No se encontraron productos.");
                    }
                }
            }).done(function(response) {
                response.forEach(element => {
                    data.products[element.id] = element;
                    data.selectedProducts[element.id] = element;
                    addSelectedProduct(element.id);                
                });
            });
        }
        //var functions
        openAllotmentModal = function (productId) {
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
                        if (parseFloat(quantityAllotment.value) > parseFloat(element.quantity)) {
                            validation = true;
                        } else {
                            if (parseFloat(data.products[allotmentProductId].stock) >= parseFloat(quantityAllotment.value)) {
                                element.quantityClosed = parseFloat(quantityAllotment.value);
                                quantityAllotmentTotal = quantityAllotmentTotal + parseFloat(quantityAllotment.value);
                            } else {
                                validation = true;
                            }
                        }
                    }
                });
                if (parseFloat(data.products[allotmentProductId].stock) >= quantityAllotmentTotal) {
                    if (parseFloat(quantityAllotmentTotal) > 0) {
                        allotments[allotmentProductId].quantityClosed = true;
                    } else {
                        validation = true;
                    }
                } else {
                    validation = true;
                }
                document.getElementById('allotmentButtonSubmit').disabled = validation;
                if (validation) {
                    alert('Validación incorrecta. Las cantidades no fueron aceptadas.');
                } else {
                    var quantityInput = document.getElementById('quantity_' + allotmentProductId);
                    if (quantityInput != null) {
                        quantityInput.value = quantityAllotmentTotal;
                        quantityInput.readOnly = true;
                    }
                }
            }
        }
        openSerialModal = function(productId) {
            // SERIALS
            serialProductId = productId;
            productSerialId = productId;
            document.getElementById('productSerialDetail').innerHTML = 'Asignación de series del producto: ' +
                data.selectedProducts[productId].code + ' - ' + data.selectedProducts[productId].name;
            var tableSerialResume = $('#tableSerialResume').DataTable();
            tableSerialResume.destroy();
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
                    $.get('/api/serials-by-product/' + productId + '?warehouseId=' + document.getElementById('warehouseId').value, {
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
        validateSerialSubmit = function () {
            if (serialProductId != 0) {
                var btnSerialSubmit = document.getElementById('btnSerialSubmit');
                if (btnSerialSubmit != null) {
                    btnSerialSubmit.disabled = true;
                    btnSerialSubmit.innerHTML = 'PROCESANDO...';
                    // VALIDATION
                    var quantitySerialValidation_ = document.getElementById('quantity_' + serialProductId);
                    if (quantitySerialValidation_ != null) {
                        quantitySerialValidation_ = parseInt(quantitySerialValidation_.value);
                        if (quantitySerialValidation_ == serials[serialProductId].length) {
                            btnSerialSubmit.disabled = false;
                            btnSerialSubmit.innerHTML = 'VALIDACIÓN CORRECTA. CONTINUAR';
                            btnSerialSubmit.onclick = function() { $('#modal-serial').modal('toggle');}
                        } else {
                            btnSerialSubmit.disabled = false;
                            btnSerialSubmit.innerHTML = 'VALIDACIÓN INCORRECTA, LAS CANTIDADES SON DIFERENTES. VUELVA A INTENTAR';
                        }
                    }
                }
                document.getElementById('warehouseId').disabled = true;
            } else {
                alert("No se puede validar la operación");
            }
        }
        serialSubmit = function() {
            $('#modal-serial').modal('toggle');
        }
        checkboxSerial = function (serialId, productId) {
            if (document.getElementById('checkboxSerial_'+serialId+'_'+productId).checked) {
                if (serials[productId] == undefined) {
                    serials[productId] = [];
                }
                if (serials[productId][serialId] == undefined) {
                    serials[productId].push(serialId);
                }
                // serialsById
                if (serialsById[serialId] == undefined) {
                    serialsById.push(serialId);
                }
            } else {
                var index = serials[productId].indexOf(serialId);
                if (index > -1) {
                    serials[productId].splice(index, 1);
                }
                // serialsById
                var indexSerialId = serialsById.indexOf(serialId);
                if (indexSerialId > -1) {
                    serialsById.splice(indexSerialId, 1);
                }
            }
        }
        clearSelectedProduct = function(productId) {
            var allotmentSelected_ = [];
            allotmentSelected.forEach(element => {
                if (element != productId) {
                    allotmentSelected_.push(element);
                }
            });
            allotmentSelected = allotmentSelected_;
            delete(data.selectedProducts[productId]);
            document.getElementById("tr_" + productId).remove();
        }
        validateInventory = function() {
            var saveButton = document.getElementById('saveButton');
            if (saveButton != null) {
                if (allotments.length < allotmentSelected.length) {
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'INFORMACIÓN DE LOTES INCORRECTA. VOLVER A VALIDAR';
                } else {
                    // REFACTORING
                    saveButton.disabled = true;
                    saveButton.innerHTML = ('Procesando ...').toUpperCase();
                    if (data.selectedProducts.length > 0) {
                        // SERIAL VALIDATION
                        var quantityStockValidation = true;
                        var serialValidation = true;
                        data.selectedProducts.forEach(element => {
                            var quantity = document.getElementById('quantity_' + element.id);
                            if (quantity != null) {
                                element.quantity = quantity.value;
                                if (parseFloat(element.quantity) > parseFloat(element.stock)) {
                                    quantityStockValidation = false;
                                    quantity.style.borderColor = "red";
                                    saveButton.disabled = false;
                                    saveButton.innerHTML = ('CANTIDAD NO DISPONIBLE. Volver a validar').toUpperCase();
                                } else {
                                    quantity.style.borderColor = '#ccc';
                                    if (element.allotmentType == 2) {
                                        if (serials[element.id] == undefined) {
                                            serialValidation = false;
                                        }
                                    }
                                }
                            } else {
                                serialValidation = false;                                
                            }
                        });
                        if (quantityStockValidation) {
                            if (!serialValidation) {
                                saveButton.disabled = false;
                                saveButton.innerHTML = ('La información ingresada en sus series es incorrecta. Volver a validar').toUpperCase();
                            } else {
                                saveButton.disabled = false;
                                saveButton.innerHTML = ('Validación correcta. GUARDAR SALIDA DE MERCADERÍA').toUpperCase();
                                saveButton.onclick = function() {  saveInventory(); }
                            }                            
                        }
                    } else {
                        saveButton.disabled = false;
                        saveButton.innerHTML = ('Usted no ha ingresado productos. Volver a validar').toUpperCase();
                    }
                }
            }
        }
        saveInventory = function (){
            document.getElementById('saveButton').disabled = true;
            //logic and transaction
            var warehouseId = document.getElementById('warehouseId').value;
            //symbolics
            var warehouseText = $("#warehouseId option:selected").text();
            allotments_ = [];
            allotments.forEach(element => {
                element.forEach(elementAllotment => {
                    allotments_.push(elementAllotment);
                });
            });
            var commentary = document.getElementById('commentary').value;
            if (commentary == '') {
                commentary = 'SALIDA DE MERCADERÍA';
            }
            var dataSend = {
                'warehouseId' : warehouseId,
                'documentCode': document.getElementById('typeKardexMovementId').value,
                'details' : [],
                'serialsOut' : serialsById,
                'allotments': allotments_,
                'userId': document.getElementById('userId').value,
                'commentary': commentary
            };
            data.products.forEach(element => {
                var objElement = {
                    'productId' : element.id,
                    'quantity' : 0,
                    'location' : null,
                    'minStock' : 0,
                    'priceList': [],
                };
                var inputQuantity = document.getElementById('quantity_' + element.id);
                if (inputQuantity != null) {
                    objElement.quantity = (inputQuantity.value*-1);
                }
                //priceList logic
                data.priceLists.forEach(elementPriceList => {
                    var objPriceList = {
                        "id": elementPriceList.id,
                        "price": element.price,
                        "quantity": 0,
                        "wholeSalePrice": element.price
                    };
                    objElement.priceList.push(objPriceList);
                });

                dataSend.details.push(objElement);
            });
            //Api call
            $.ajax({
                method: "POST",
                url: "/api/transfer-movement",
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        document.getElementById('saveButton').disabled = false;
                        alert("No se pudo registrar la salida.");
                    }
                }
            }).done(function(response) {
                //message
                var productsResume = document.getElementById('productsResume');
                productsResume.innerHTML = '<br><p class="form-control">Se realizó la salida de ' + (response.details.length) + ' productos al almacén/tienda ' + warehouseText + '.';
                //openModal
                $("#modal-resume").modal({backdrop: 'static', keyboard: false});
            });
        }
        allotmentSubmit = function () {

        }
        goToProducts = function (){
            location = "/incomes-history";
        }
        //Auto callbacks
        autocompleteForProducts(document.getElementById('searchProduct'));
        //listeners
        var searchProductAutoBarCode = document.getElementById('searchProductAutoBarCode');
        searchProductAutoBarCode.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                $.ajax({
                    url: "/api/products-search/" + searchProductAutoBarCode.value + "?warehouseId=" + document.getElementById('warehouseId').value,
                    context: document.body,
                    statusCode: {
                        404: function() {
                            alert("No se encontraron productos. Verifique si este cuenta con stock.");
                        }
                    }
                }).done(function(response) {
                    product = response[0];
                    if (product != undefined) {
                        if (data.selectedProducts[product.id] != undefined) {
                            var quantityHtml = document.getElementById('quantity_' + product.id);
                            if (quantityHtml != null) {
                                var quantity_ = parseFloat(quantityHtml.value);
                                quantityHtml.value = quantity_ + 1;
                                // trOrder
                                var row = $("#tr_" + product.id);
                                row.each(function() {
                                    var $this=$(this);
                                    $this.insertBefore($this.prevAll().last());
                                });
                            }
                        } else {
                            data.products[product.id] = product;
                            data.selectedProducts[product.id] = product;
                            addSelectedProduct(product.id);
                        }
                    } else {
                        alert("No se encontró el producto");
                    }
                });
                document.getElementById('searchProductAutoBarCode').value = "";
            }
        });
    });
</script>
