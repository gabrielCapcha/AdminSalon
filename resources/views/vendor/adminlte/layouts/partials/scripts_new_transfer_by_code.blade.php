<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script> -->

<script>
    var saveInventory;
    var goToProducts;
    var clearSelectedProduct;
    $(document).ready(function() {
        // var saleIndexTable = $('#inventoryData').DataTable({
        //     "scrollX": true,
        //     "processing": false,
        //     language : {
        //     "zeroRecords": " ",
        //     "infoEmpty": " ",             
        //          },
        //     "lengthChange": false,
        //     "serverSide": false,
        //     "bPaginate": false,
        //     "ordering": false,
        //     "searching": false,
        //     "responsive": true
                     
        // });
        //Initialize variables
        var allotments = [];
        var serials = {};
        var serialsById = [];
        var serialProductId = 0;
        var data = {};
        var count = 0;
        var productAllotmentId = 0;
        var productSerialId = 0;
        data.products = [];
        data.selectedProducts = [];
        //PriceLists value
        var priceLists = document.getElementById('priceLists');
        data.priceLists = JSON.parse(priceLists.value);
        priceLists.value = '';
        var featureTable  = $('#tableAllotmentResume').DataTable({
            "processing": false,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "serverSide": false,
            "bPaginate": false,
            "ordering": false,
            "searching": false,
            "responsive": true
        });
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
                    mainheaderSearchBar.style.height = "50px";
                    //LLAMADA AL SERVICIO
                    $.ajax({
                        url: "/api/products-for-sale/" + val,
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
                                            }
                                        } else {
                                            data.products[product.id] = product;
                                            data.selectedProducts[product.id] = product;
                                            addSelectedProduct(product.id);
                                            //call childs
                                            // callChildsOfSelectedProduct(product.id);
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
        function addSelectedProduct(id) {
            var tBodyData = document.getElementById('tBodyData');
            var tr = document.createElement('tr');
            tr.setAttribute('id', 'tr_' + id);
            var tdText_ = '<td style="vertical-align: middle;">' + data.products[id].name + '</td>' + 
                '<td style="vertical-align: middle;">' + data.products[id].brandName + '</td>' + 
                '<td style="vertical-align: middle;">' + data.products[id].autoBarcode + '</td>' + 
                '<td style="vertical-align: middle;">' + data.products[id].code + '</td>' + 
                '<td style="vertical-align: middle;">' + data.products[id].stock + '</td>' + 
                '<td style="vertical-align: middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="quantity_' + id + '" type="number" value="1" step="0.1" /></td>';
                if (data.products[id].allotmentType == 1) {
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button style="padding-left: 8px; padding-right: 8px;" type="button" onclick="openAllotmentModal(' + id + ');" class="btn btn-primary btn-flat"><i class="fa fa-cubes"></i></button>' + 
                    '<span> </span><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></td>';    
                } else if (data.products[id].allotmentType == 2) {
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button style="padding-left: 8px; padding-right: 8px;" type="button" onclick="openSerialModal(' + id + ');" class="btn btn-success btn-flat"><i class="fa fa-key"></i></button>' + 
                    '<span> </span><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></td>';
                } else {
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button></td>';    
                }
                
            tr.innerHTML = tdText_;
            tBodyData.insertBefore(tr, tBodyData.nextSibling);
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
        openAllotmentModal = function(productId) {
            productAllotmentId = productId;
            document.getElementById('productAllotmentDetail').innerHTML = data.products[productId].code + ' - ' + data.products[productId].name;
            $('#modal-allotment').modal({ backdrop: 'static', keyboard: false });
        }
        allotmentSubmit = function() {
            allotments.forEach(element => {
                var quantity = document.getElementById('quantity_' + element.productId);
                if (quantity) {
                    quantity.value = 0;
                }
            });
            allotments.forEach(element => {
                var quantity = document.getElementById('quantity_' + element.productId);
                if (quantity) {
                    var quantityValue = parseFloat(quantity.value);
                    quantityValue = quantityValue + parseFloat(element.quantity);
                    quantity.value = quantityValue;
                    quantity.readOnly = true;
                }
            });
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
                            document.getElementById('quantity_' + serialProductId).readOnly = true;
                            btnSerialSubmit.onclick = function() { $('#modal-serial').modal('toggle');}
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
        serialSubmit = function() {
            $('#modal-serial').modal('toggle');
        }
        clearSelectedProduct = function(productId) {
            delete(data.selectedProducts[productId]);
            document.getElementById("tr_" + productId).remove();
            allotments.forEach(element => {
                if (element.productId == productId) {
                    var trAllotment = document.getElementById('trAllotment_' + element.count);
                    if (trAllotment) {
                        trAllotment.remove();
                    }
                    element.productId = null;
                    element.quantity = 0;
                }
            });
        }
        validateTransfer = function() {
            var saveButton = document.getElementById('saveButton');
            var warehouseId = document.getElementById('warehouseId');
            if (saveButton != null && warehouseId != null) {
                if (warehouseId.value == 0) {
                    saveButton.disabled = false;
                    saveButton.innerHTML = ('ESCOGA UNA TIENDA. Volver a validar').toUpperCase();
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
                                saveButton.innerHTML = ('Validación correcta. Guardar TRANSFERENCIA').toUpperCase();
                                saveButton.onclick = function() {  saveTransferPrev(); }
                            }
                        }
                    } else {
                        saveButton.disabled = false;
                        saveButton.innerHTML = ('Usted no ha ingresado productos. Volver a validar').toUpperCase();
                    }
                }
            }
        }
        changeValidateTransfer = function(){
            var saveButton = document.getElementById('saveButton');
            saveButton.disabled = false;
            saveButton.innerHTML = 'VALIDAR TRANSFERENCIA';
            saveButton.onclick = function() {  validateTransfer(); }
        }
        saveInventory = function (){
            document.getElementById('saveButton').disabled = true;
            //logic and transaction
            var warehouseId = document.getElementById('warehouseId').value;
                //symbolics
                var warehouseText = $("#warehouseId option:selected").text();
            var dataSend = {
                'warehouseId' : warehouseId,
                'details' : [],
                'allotments': allotments,
                'serials': serials,
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
                    objElement.quantity = inputQuantity.value;
                }
                //priceList logic
                if (element.priceList != null) {
                    objElement.priceList = element.priceList;
                    objElement.priceListLogic = false;
                } else {
                    objElement.priceListLogic = true;
                    var wholeSalePrice_ = element.whole_sale_price;
                    if (wholeSalePrice_ == null) {
                        wholeSalePrice_ = element.wholeSalePrice;
                    }
                    data.priceLists.forEach(elementPriceList => {
                        var objPriceList = {
                            "id": elementPriceList.id,
                            "price": element.price,
                            "quantity": element.quantity,
                            "wholeSalePrice": wholeSalePrice_
                        };
                        objElement.priceList.push(objPriceList);
                    });
                }

                dataSend.details.push(objElement);
            });
            //Api call
            $.ajax({
                method: "POST",
                url: "/api/new-transfer-movement",
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        document.getElementById('saveButton').disabled = false;
                        alert("No se pudo registrar el TRANSFERENCIA.");
                    }
                }
            }).done(function(response) {
                //message
                var productsResume = document.getElementById('productsResume');
                productsResume.innerHTML = '<br><p class="form-control">Se realizó el TRANSFERENCIA de x productos al almacén/tienda ' + warehouseText + '.';
                //openModal
                $("#modal-resume").modal({backdrop: 'static', keyboard: false});
            });
        }
        goToProducts = function (){
            location = "/incomes-history";
        }
        goToAllotments = function() {
            location = "/allotments";
        }
        goToSerials = function() {
            location = "/serials";
        }
        goToKardex = function () {
            location = '/kardex';
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
        openSerialModal = function (productId) {
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
        saveTransferPrev = function () {
            var warehouseDestiny = document.getElementById('warehouseId').value;
            if (warehouseDestiny != 0) {
                var tBodyDataPrev = document.getElementById('tBodyDataPrev');
                var count = 0;
                var sumQuantity = 0;
                var table = $('#transferDataPrev').DataTable();
                table.destroy();
                $("#tBodyDataPrev tr").remove(); 
                data.selectedProducts.forEach(element => {
                    // if (element.condition) {
                        var tr = document.createElement('tr');
                        var description = 'SIN DESCRIPCIÓN';
                        if (element.description != null) {
                            description = element.description;
                        }
                        tr.setAttribute('id', 'tr_' + element.productId);
                            var tdText_ = '<td>' + element.name + '</td><td>' + element.code + '</td>' + 
                                '<td>' + element.autoBarcode + '</td><td>' + description + '</td><td>' + element.quantity + '</td>';
                        tr.innerHTML = tdText_;
                        tBodyDataPrev.insertBefore(tr, tBodyDataPrev.nextSibling);
                        count++;
                        sumQuantity = sumQuantity + parseInt(element.quantity);
                    // }
                });

                $('#transferDataPrev').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
                    'dom': 'Bfrtip',
                    'buttons': [],
                    'order'       : [[ 0, "desc" ]],
                    'info'        : true,
                    'autoWidth'   : true,
                    "language": {
                        "url": "/js/languages/datatables/es.json"
                    },
                    "bDestroy": true,
                });
                //change header
                var headerResumePrev = document.getElementById('headerResumePrev');
                var warehouseText = $("#warehouseDestiny option:selected").text();
                headerResumePrev.innerHTML = "Destino: " + warehouseText + ' - Productos seleccionados: ' + count + ' - Mercadería a entregar: ' + sumQuantity;
                //open modal
                $("#modal-resume-prev").modal({backdrop: 'static', keyboard: false});
            } else {
                alert('Seleccione un almacén de destino para continuar.');
            }
        }
        saveTransfer = function () {
            document.getElementById('saveButton').disabled = true;
            var warehouseDestiny = document.getElementById('warehouseId').value;
            if (warehouseDestiny != 0) {
                dataSend = {
                    "warehouseOriginId": 0,
                    "warehouseSourceId": warehouseDestiny,
                    "subsidiaryId": 0,
                    "details": [],
                    "serials": serialsById,
                    "allotments": allotments
                };
                //logic
                data.selectedProducts.forEach(element => {
                    // if (element.condition) {
                        var objElement = {
                            "brandId" : element.brandId,
                            "quantity" : element.quantity,
                            "productId" : element.id,
                            "productName" : element.name,
                        }
                        dataSend.details.push(objElement);
                    // }
                });
            } else {
                alert('Seleccione un almacén de destino para continuar.');
            }
            //Api call
            $.ajax({
                method: "POST",
                url: "/api/new-transfer-movement",
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        document.getElementById('saveButton').disabled = false;
                        alert("No se pudo registrar el ingreso.");
                    }
                }
            }).done(function(response) {
                //message
                var warehouseText = $("#warehouseDestiny option:selected").text();
                var productsResume = document.getElementById('productsResume');
                productsResume.innerHTML = '<br><p class="form-control">Se realizó el ingreso de ' + (dataSend.details.length) + ' productos al almacén/tienda ' + warehouseText + '.';
                //openModal
                $("#modal-resume-prev").hide();
                $("#modal-resume").modal({backdrop: 'static', keyboard: false});
            });
        }
        //Auto callbacks
        autocompleteForProducts(document.getElementById('searchProduct'));
        
        //listeners
        var searchProductAutoBarCode = document.getElementById('searchProductAutoBarCode');
        searchProductAutoBarCode.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {                
                $.ajax({
                    url: "/api/products-search/" + searchProductAutoBarCode.value,
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
                            }
                        } else {
                            data.products[product.id] = product;
                            data.selectedProducts[product.id] = product;
                            addSelectedProduct(product.id);
                            //call childs
                            // callChildsOfSelectedProduct(product.id);
                        }
                    } else {
                        alert("No se encontró el producto");
                    }
                });
                document.getElementById('searchProductAutoBarCode').value = "";
            }
        });
        
        // Allotments
        var allotmentCode_0 = document.getElementById('allotmentCode_0');
        allotmentCode_0.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                var object = {};
                //VALIDATE IDS
                var allotmentCode_0 = document.getElementById('allotmentCode_0');
                if (allotmentCode_0 && allotmentCode_0.value != '') {
                    var allotmentQuantity_0 = document.getElementById('allotmentQuantity_0');
                    if (allotmentQuantity_0 && allotmentQuantity_0.value != '') {
                        // var allotmentExpirationDate_0 = document.getElementById('allotmentExpirationDate_0');
                        // if (allotmentExpirationDate_0 && allotmentExpirationDate_0.value != '') {
                            count++;
                            object.productId = productAllotmentId;
                            object.count = count;
                            object.code = document.getElementById('allotmentCode_0').value;
                            object.quantity = document.getElementById('allotmentQuantity_0').value;
                            object.expirationDate = document.getElementById('allotmentExpirationDate_0').value;
                            object.description = document.getElementById('productAllotmentDetail').textContent;
                            allotments.push(object);
                            //ADD OBJECT
                            var xTable = document.getElementById('tableAllotmentResumeBody');
                            var tr = document.createElement('tr');
                            tr.setAttribute('id', 'trAllotment_' + count);
                            tr.innerHTML = '<td>' + document.getElementById('productAllotmentDetail').textContent + '</td>' + 
                                        '<td>' + object.code.toUpperCase() + '</td>' + 
                                        '<td>' + object.quantity.toUpperCase() + '</td>' +
                                        '<td>' + object.expirationDate.toUpperCase() + '</td>';
                            xTable.insertBefore(tr, xTable.nextSibling);
                            document.getElementById('allotmentCode_0').value = "";
                            document.getElementById('allotmentQuantity_0').value = "";
                            document.getElementById('allotmentExpirationDate_0').value = "";
                            allotmentCode_0.focus();
                            allotmentCode_0.style.borderColor = "#ccc";
                            allotmentQuantity_0.style.borderColor = "#ccc";
                            allotmentExpirationDate_0.style.borderColor = "#ccc";
                        // } else {
                        //     allotmentExpirationDate_0.style.borderColor = "red";
                        // }
                    } else {
                        allotmentQuantity_0.style.borderColor = "red";
                    }
                } else {
                    allotmentCode_0.style.borderColor = "red";
                }
            }
        });
        
        var allotmentQuantity_0 = document.getElementById('allotmentQuantity_0');
        allotmentQuantity_0.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                var object = {};
                //VALIDATE IDS
                var allotmentCode_0 = document.getElementById('allotmentCode_0');
                if (allotmentCode_0 && allotmentCode_0.value != '') {
                    var allotmentQuantity_0 = document.getElementById('allotmentQuantity_0');
                    if (allotmentQuantity_0 && allotmentQuantity_0.value != '') {
                        // var allotmentExpirationDate_0 = document.getElementById('allotmentExpirationDate_0');
                        // if (allotmentExpirationDate_0 && allotmentExpirationDate_0.value != '') {
                            count++;
                            object.productId = productAllotmentId;
                            object.count = count;
                            object.code = document.getElementById('allotmentCode_0').value;
                            object.quantity = document.getElementById('allotmentQuantity_0').value;
                            object.expirationDate = document.getElementById('allotmentExpirationDate_0').value;
                            object.description = document.getElementById('productAllotmentDetail').textContent;
                            allotments.push(object);
                            //ADD OBJECT
                            var xTable = document.getElementById('tableAllotmentResumeBody');
                            var tr = document.createElement('tr');
                            tr.setAttribute('id', 'trAllotment_' + count);
                            tr.innerHTML = '<td>' + document.getElementById('productAllotmentDetail').textContent + '</td>' + 
                                        '<td>' + object.code.toUpperCase() + '</td>' + 
                                        '<td>' + object.quantity.toUpperCase() + '</td>' +
                                        '<td>' + object.expirationDate.toUpperCase() + '</td>';
                            xTable.insertBefore(tr, xTable.nextSibling);
                            document.getElementById('allotmentCode_0').value = "";
                            document.getElementById('allotmentQuantity_0').value = "";
                            document.getElementById('allotmentExpirationDate_0').value = "";
                            allotmentCode_0.focus();
                            allotmentCode_0.style.borderColor = "#ccc";
                            allotmentQuantity_0.style.borderColor = "#ccc";
                            allotmentExpirationDate_0.style.borderColor = "#ccc";
                        // } else {
                        //     allotmentExpirationDate_0.style.borderColor = "red";
                        // }
                    } else {
                        allotmentQuantity_0.style.borderColor = "red";
                    }
                } else {
                    allotmentCode_0.style.borderColor = "red";
                }
            }
        });
        
        var allotmentExpirationDate_0 = document.getElementById('allotmentExpirationDate_0');
        allotmentExpirationDate_0.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                var object = {};
                //VALIDATE IDS
                var allotmentCode_0 = document.getElementById('allotmentCode_0');
                if (allotmentCode_0 && allotmentCode_0.value != '') {
                    var allotmentQuantity_0 = document.getElementById('allotmentQuantity_0');
                    if (allotmentQuantity_0 && allotmentQuantity_0.value != '') {
                        // var allotmentExpirationDate_0 = document.getElementById('allotmentExpirationDate_0');
                        // if (allotmentExpirationDate_0 && allotmentExpirationDate_0.value != '') {
                            count++;
                            object.productId = productAllotmentId;
                            object.count = count;
                            object.code = document.getElementById('allotmentCode_0').value;
                            object.quantity = document.getElementById('allotmentQuantity_0').value;
                            object.expirationDate = document.getElementById('allotmentExpirationDate_0').value;
                            object.description = document.getElementById('productAllotmentDetail').textContent;
                            allotments.push(object);
                            //ADD OBJECT
                            var xTable = document.getElementById('tableAllotmentResumeBody');
                            var tr = document.createElement('tr');
                            tr.setAttribute('id', 'trAllotment_' + count);
                            tr.innerHTML = '<td>' + document.getElementById('productAllotmentDetail').textContent + '</td>' + 
                                        '<td>' + object.code.toUpperCase() + '</td>' + 
                                        '<td>' + object.quantity.toUpperCase() + '</td>' +
                                        '<td>' + object.expirationDate.toUpperCase() + '</td>';
                            xTable.insertBefore(tr, xTable.nextSibling);
                            document.getElementById('allotmentCode_0').value = "";
                            document.getElementById('allotmentQuantity_0').value = "";
                            document.getElementById('allotmentExpirationDate_0').value = "";
                            allotmentCode_0.focus();
                            allotmentCode_0.style.borderColor = "#ccc";
                            allotmentQuantity_0.style.borderColor = "#ccc";
                            allotmentExpirationDate_0.style.borderColor = "#ccc";
                        // } else {
                        //     allotmentExpirationDate_0.style.borderColor = "red";
                        // }
                    } else {
                        allotmentQuantity_0.style.borderColor = "red";
                    }
                } else {
                    allotmentCode_0.style.borderColor = "red";
                }
            }
        });
    });
</script>
