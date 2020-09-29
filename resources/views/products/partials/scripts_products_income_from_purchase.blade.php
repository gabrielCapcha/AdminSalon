<!-- REQUIRED JS SCRIPTS -->
<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>

<script>
    var saveInventory;
    var goToProducts;
    var clearSelectedProduct;
    $(document).ready(function() {
        var inventoryData = $('#inventoryData').DataTable({
            'scrollX': true,
            'paging'      : false,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : false,
            'info'        : false,
            'autoWidth'   : true,
            // "scrollY": "300px",
            // "scrollCollapse": true,
            "language": {
                "zeroRecords": " "
            },
            "dom": 'Bfrtip',
            "buttons": [
                'excel', 'pdf'
            ],
            "bDestroy": true
        });
        $('#createdAtDate').datepicker('setDate', 'now');
        //Initialize variables
        var supplierId = 0;
        var pTotalCost = 0;
        var allotments = [];
        var allotmentSelected = [];
        var serials = [];
        var serialsById = [];
        var data = {};
        var count = 0;
        var productAllotmentId = 0;
        var productSerialId = 0;
        var purchaseItems = document.getElementById('purchaseItems');
        purchaseItems = JSON.parse(purchaseItems.value);
        data.products = [];
        purchaseItems.forEach(element => {
            // product assignment
            element.product.purchaseDetailId = element.id;
            data.products.push(element.product);
            // allotments
            if (element.product.allotment_type == 2) {
                allotmentSelected.push(element.product.id);
            }
        });
        data.selectedProducts = data.products;
        
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
                    saveButton = document.getElementById('saveButton');
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'PRESIONE AQUÍ PARA VALIDAR INGRESO <br> <b>PRECIO COSTO TOTAL: S/ ' + calculatePTotalCost() + '</b>';
                    saveButton.onclick = function() { validateIncome(); }
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
                        url: "/api/products-search-for-inventory/" + val + "?noWarehouse=true&tropics=true",
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
        function autocompleteForSuppliers(inp) {
            var currentFocus;
            var mainheaderSearchBar = document.getElementById('mainheaderSearchBarSupplier');
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
                        url: "/api/suppliers?searchInput=" + val,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron proveedores.");
                            }
                        }
                    }).done(function(response) {
                        response = response.data;
                        if (response.length == 0) {
                            inp.value = "";
                            alert("No se encontraron proveedores.");
                        } else {
                            for (i = 0; i < response.length; i++) {
                                if (response[i].flag_type_person == 2) {
                                    var nameLastname = response[i].ruc + ' - ' + response[i].rz_social;                                    
                                } else {
                                    var nameLastname = response[i].dni + ' - ' + response[i].name + ' ' + response[i].lastname;
                                }
                                b = document.createElement("DIV");
                                b.setAttribute('class', 'form-control-autocomplete');
                                b.style.background = '#ffffff';
                                b.style.cursor = 'pointer';
                                b.innerHTML += nameLastname;
                                b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                b.addEventListener("click", function(e) {
                                    var iterator = this.getElementsByTagName("input")[0].value;
                                    inp.value = "";
                                    supplier = response[iterator];
                                    if (supplier != undefined) {
                                        supplierId = supplier.id;
                                        document.getElementById('supplierId').value = nameLastname;
                                    } else {
                                        alert("No se encontraron proveedores.");
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
            tr.setAttribute('id', 'tr_' + id);
            var unitName = 'UNIDAD';
            if (data.products[id].unitName != undefined) {
                unitName = data.products[id].unitName;
            } else {
                callUnitName(data.products[id].unitId);
            }
            var tdText_ = '<td style="vertical-align: middle;">' + data.products[id].name + '</td>' + 
                '<td style="vertical-align: middle;">' + data.products[id].brandName + '</td>' + 
                '<td style="vertical-align: middle;">' + data.products[id].autoBarcode + '</td>' + 
                '<td style="vertical-align: middle;">' + data.products[id].code + '</td>' + 
                '<td style="vertical-align: middle;">' + unitName + '</td>' + 
                '<td style="vertical-align: middle;" id="tdActualStock_' + id + '">' + getActualStock(id) + '</td>' + 
                '<td style="vertical-align: middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="quantity_' + id + '" type="number" value="1" /></td>' +
                '<td style="vertical-align: middle;"><input class="form-control" onClick="this.select();" id="location_' + id + '" type="text" value="" placeholder="¿Ub.física?" style="width:100%;"/></td>' +
                '<td style="vertical-align: middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="minStock_' + id + '" type="number" value="0" /></td>' +
                '<td style="vertical-align: middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="priceCost_' + id + '" type="number" value="0.00" step="0.1"/></td>';
                if (data.products[id].allotmentType == 1) {
                    allotmentSelected.push(id);
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button style="padding-left: 4px; padding-right: 4px;" type="button" onclick="openAllotmentModal(' + id + ');" class="btn btn-primary btn-flat"><i class="fa fa-cubes"></i></button>' + 
                    '<span> </span><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat" style="padding-left: 8px; padding-right: 8px;"><i class="fa fa-trash"></i></button></td>';    
                } else if (data.products[id].allotmentType == 2) {
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button style="padding-left: 4px; padding-right: 4px;" type="button" onclick="openSerialModal(' + id + ');" class="btn btn-success btn-flat"><i class="fa fa-key"></i></button>' + 
                    '<span> </span><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat" style="padding-left: 8px; padding-right: 8px;"><i class="fa fa-trash"></i></button></td>';
                } else {
                    tdText_ = tdText_ + '<td style="vertical-align: middle;"><button type="button" onclick="clearSelectedProduct(' + id + ');" class="btn btn-danger btn-flat" style="padding-left: 8px; padding-right: 8px;"><i class="fa fa-trash"></i></button></td>';    
                }
                
            tr.innerHTML = tdText_;
            tBodyData.insertBefore(tr, tBodyData.firstChild);
        }
        function getActualStock(id) {
            var stock = 0.00;
            if (data.products[id] != undefined) {
                if (data.products[id].tropics != null) {
                    data.products[id].tropics.forEach(elementTropic => {
                        var warehouseId_ = document.getElementById('warehouseId');
                        if (warehouseId_ != null) {
                            if (elementTropic.warehouse_id == warehouseId_.value) {
                                stock = elementTropic.stock;
                            }                            
                        }
                    });
                }
            }
            return stock;            
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
        callStockProducts = function() {
            var stock = 0.00;
            data.products.forEach(element => {
                var tdActualStock_ = document.getElementById('tdActualStock_' + element.id);
                if (tdActualStock_ != null) {
                    if (data.products[element.id].tropics != null) {
                        data.products[element.id].tropics.forEach(elementTropic => {
                            var warehouseId_ = document.getElementById('warehouseId');
                            if (warehouseId_ != null) {
                                if (elementTropic.warehouse_id == warehouseId_.value) {
                                    stock = elementTropic.stock;
                                }                            
                            }
                        });
                    }
                    tdActualStock_.innerHTML = stock;
                }
            });

        }
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
        openSerialModal = function(productId) {
            var btnSerialSubmit = document.getElementById('btnSerialSubmit');
            if (btnSerialSubmit != null) {
                btnSerialSubmit.innerHTML = 'VALIDAR';
                btnSerialSubmit.disabled = false; 
                btnSerialSubmit.onclick = function() { validateSerialSubmit(); };
            }
            productSerialId = productId;
            document.getElementById('productSerialDetail').innerHTML = "Asignación de Series: " + data.products[productId].code + ' - ' + data.products[productId].name;
            var quantity = document.getElementById('quantity_' + productId);
            if (quantity != null) {
                if (quantity.value != '') {
                    if (parseInt(quantity.value) > 0) {
                        var tableSerialResumeBody = document.getElementById('tableSerialResumeBody');
                        tableSerialResumeBody.innerHTML = '';
                        for (let index = 0; index < parseInt(quantity.value); index++) {
                            if (serialsById[productId] != undefined) {
                                if (serialsById[productId][index] != undefined) {
                                    var selected1 = '';
                                    var selected2 = '';
                                    var selected3 = '';
                                    switch (serialsById[productId][index].typeWarranty) {
                                        case "1":
                                            selected1 = 'selected';
                                            break;
                                        case "2":
                                            selected2 = 'selected';
                                            break;
                                        case "3":
                                            selected3 = 'selected';
                                            break;                                    
                                        default:
                                            break;
                                    }
                                    var tr = document.createElement('tr');
                                    tr.setAttribute('id', 'trSerial_' + index);
                                    tr.innerHTML = '<td><input onClick="this.select();" type="text" class="form-control" maxlength="100" id="serialSerial_' + index + '" placeholder="Ingrese código SERIAL" value="' + serialsById[productId][index].serial + '"></td>' +
                                        '<td><input onClick="this.select();" type="text" class="form-control" maxlength="100" id="serialImei_' + index + '" placeholder="Ingrese código IMEI" value="' + serialsById[productId][index].imei + '"></td>' + 
                                        '<td><select id="serialTypeWarranty_' + index + '" class="form-control"><option '+ selected1 +' value="1">DÍAS</option><option '+ selected2 +' value="2">MESES</option><option '+ selected3 +' value="3">AÑOS</option></select></td>' + 
                                        '<td><input onClick="this.select();" type="number" class="form-control" style="width: 100%;" maxlength="5" id="serialWarranty_' + index + '" placeholder="Ingrese cantidad" value="' + serialsById[productId][index].warranty + '"></td>';
                                    tableSerialResumeBody.insertBefore(tr, tableSerialResumeBody.nextSibling);                                    
                                } else {
                                    var tr = document.createElement('tr');
                                    tr.setAttribute('id', 'trSerial_' + index);
                                    tr.innerHTML = '<td><input onClick="this.select();" type="text" class="form-control" maxlength="100" id="serialSerial_' + index + '" placeholder="Ingrese código SERIAL"></td>' +
                                        '<td><input onClick="this.select();" type="text" class="form-control" maxlength="100" id="serialImei_' + index + '" placeholder="Ingrese código IMEI"></td>' + 
                                        '<td><select id="serialTypeWarranty_' + index + '" class="form-control"><option value="1">DÍAS</option><option value="2">MESES</option><option value="3">AÑOS</option></select></td>' + 
                                        '<td><input onClick="this.select();" type="number" class="form-control" style="width: 100%;" maxlength="5" id="serialWarranty_' + index + '" placeholder="Ingrese cantidad"></td>';
                                    tableSerialResumeBody.insertBefore(tr, tableSerialResumeBody.nextSibling);
                                }
                            } else {
                                var tr = document.createElement('tr');
                                tr.setAttribute('id', 'trSerial_' + index);
                                tr.innerHTML = '<td><input onClick="this.select();" type="text" class="form-control" maxlength="100" id="serialSerial_' + index + '" placeholder="Ingrese código SERIAL"></td>' +
                                    '<td><input onClick="this.select();" type="text" class="form-control" maxlength="100" id="serialImei_' + index + '" placeholder="Ingrese código IMEI"></td>' + 
                                    '<td><select id="serialTypeWarranty_' + index + '" class="form-control"><option value="1">DÍAS</option><option value="2">MESES</option><option value="3">AÑOS</option></select></td>' + 
                                    '<td><input onClick="this.select();" type="number" class="form-control" style="width: 100%;" maxlength="5" id="serialWarranty_' + index + '" placeholder="Ingrese cantidad"></td>';
                                tableSerialResumeBody.insertBefore(tr, tableSerialResumeBody.nextSibling);
                            }
                        }
                    } else {
                        alert("No se puede cargar la cantidad. Por favor, verifique la información ingresada.");
                    }
                } else {
                    alert("No se puede cargar la cantidad. Por favor, verifique la información ingresada.");    
                }
            } else {
                alert("No se puede cargar la cantidad. Por favor, verifique la información ingresada.");
            }

            $('#modal-serial').modal({ backdrop: 'static', keyboard: false });
        }
        validateSerialSubmit = function() {
            var btnSerialSubmit = document.getElementById('btnSerialSubmit');
            if (btnSerialSubmit != null) {
                btnSerialSubmit.innerHTML = 'Procesando...';
                btnSerialSubmit.disabled = true;
                // validation
                var quantity = document.getElementById('quantity_' + productSerialId);
                if (quantity != null) {
                    if (quantity.value != '') {
                        if (parseInt(quantity.value) > 0) {
                            var tableSerialResumeBody = document.getElementById('tableSerialResumeBody');
                            var count_ = 0;
                            serialsById[productSerialId] = [];
                            serials = serials.filter(function( obj ) {
                                return obj.productId !== productSerialId;
                            });
                            for (let index = 0; index < parseInt(quantity.value); index++) {
                                var status = true;
                                var serialObject = {};
                                var serialSerial_ = document.getElementById('serialSerial_' + index);
                                if (serialSerial_ != null) {
                                    if (serialSerial_.value != '') {
                                        serialObject.serial = serialSerial_.value;
                                    } else {
                                        status = false;
                                    }
                                } else {
                                    status = false;
                                }
                                var serialImei_ = document.getElementById('serialImei_' + index);
                                if (serialImei_ != null) {
                                    serialObject.imei = serialImei_.value;
                                } else {
                                    status = false;
                                }
                                var serialTypeWarranty_ = document.getElementById('serialTypeWarranty_' + index);
                                if (serialTypeWarranty_ != null) {
                                    if (serialTypeWarranty_.value != '') {
                                        serialObject.typeWarranty = serialTypeWarranty_.value;
                                    } else {
                                        status = false;
                                    }
                                } else {
                                    status = false;
                                }
                                var serialWarranty_ = document.getElementById('serialWarranty_' + index);
                                if (serialWarranty_ != null) {
                                    if (serialWarranty_.value != '') {
                                        serialObject.warranty = serialWarranty_.value;
                                    } else {
                                        status = false;
                                    }
                                } else {
                                    status = false;
                                }
                                if (status) {
                                    serialObject.productId = productSerialId;
                                    serialObject.warehouseId = document.getElementById('warehouseId').value;
                                    serials.push(serialObject);
                                    count_++;
                                    if (serialsById[productSerialId] == undefined) {
                                        serialsById[productSerialId] = [];                                        
                                    }
                                    serialsById[productSerialId].push(serialObject);
                                }
                            }
                            if (count_ == parseInt(quantity.value)) {
                                btnSerialSubmit.innerHTML = 'Validación correcta. GUARDAR PROCESO';
                                btnSerialSubmit.disabled = false;
                                btnSerialSubmit.onclick = function() { serialSubmit(); }
                            } else {
                                btnSerialSubmit.innerHTML = 'Validación incorrecta. VOLVER A INTENTAR';
                                btnSerialSubmit.disabled = false;
                            }
                        } else {
                            alert("No se puede cargar la cantidad. Por favor, verifique la información ingresada.");
                        }
                    } else {
                        alert("No se puede cargar la cantidad. Por favor, verifique la información ingresada.");    
                    }
                } else {
                    alert("No se puede cargar la cantidad. Por favor, verifique la información ingresada.");
                }
            }
        }
        serialSubmit = function() {
            $('#modal-serial').modal('toggle');
        }
        clearSelectedProduct = function(productId) {
            var allotmentSelected_ = [];
            // borrar allotmentSelected
            allotmentSelected.forEach(element => {
                if (element != productId) {
                    allotmentSelected_.push(element);
                }
            });
            allotmentSelected = allotmentSelected_;
            // borrar producto
            var selectedProducts_ = [];
            data.selectedProducts.forEach(element => {
                if (element.id != productId) {
                    selectedProducts_[element.id] = element;
                }
            });
            data.selectedProducts = selectedProducts_;
            document.getElementById("tr_" + productId).remove();
            // borrar allotments
            var allotments_ = [];
            allotments.forEach(element => {
                if (element.productId == productId) {
                    var trAllotment = document.getElementById('trAllotment_' + element.count);
                    if (trAllotment) {
                        trAllotment.remove();
                    }
                    element.productId = null;
                    element.quantity = 0;
                } else {
                    allotments_.push(element);
                }
            });
            allotments = allotments_;
            saveButton = document.getElementById('saveButton');
            saveButton.disabled = false;
            saveButton.innerHTML = 'PRESIONE AQUÍ PARA VALIDAR INGRESO <br> <b>PRECIO COSTO TOTAL: S/ ' + calculatePTotalCost() + '</b>';
            saveButton.onclick = function() { validateIncome(); }
        }
        validateIncome = function() {
            var saveButton = document.getElementById('saveButton');
            if (saveButton != null) {
                if (allotments.length < allotmentSelected.length) {
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'INFORMACIÓN DE LOTES INCORRECTA. VOLVER A VALIDAR <br><b>PRECIO COSTO TOTAL: S/ ' + calculatePTotalCost() + '</b>';
                } else {
                    saveButton.disabled = true;
                    saveButton.innerHTML = ('Procesando ...').toUpperCase();
                    if (data.selectedProducts.length > 0) {
                        // SERIAL VALIDATION
                        var serialValidation = true;
                        pTotalCost = calculatePTotalCost();
                        if (!serialValidation) {
                            saveButton.disabled = false;
                            saveButton.innerHTML = ('La información ingresada en sus series es incorrecta. Volver a validar').toUpperCase();
                        } else {
                            saveButton.disabled = false;
                            blockAllPTotalCost(true);
                            saveButton.innerHTML = 'VALIDACIÓN CORRECTA. PRESIONE AQUÍ PARA GUARDAR EL INGRESO <br> <b>PRECIO COSTO TOTAL: S/ ' + calculatePTotalCost() + '</b>';
                            saveButton.onclick = function() { saveInventory(); }
                        }
                    } else {
                        saveButton.disabled = false;
                        saveButton.innerHTML = ('Usted no ha ingresado productos. Volver a validar').toUpperCase();
                    }
                }
            }
        }
        function blockAllPTotalCost(blockValue) {
            data.selectedProducts.forEach(element => {
                var pCost = document.getElementById('priceUnitCost_' + element.id);
                if (pCost != null) {
                    pCost.readOnly = blockValue;
                }
                var quantity_ = document.getElementById('quantity_' + element.id);
                if (quantity_ != null) {
                    quantity_.readOnly = blockValue;
                }
                var btnClearSelectedProduct_ = document.getElementById('btnClearSelectedProduct_' + element.id);
                if (btnClearSelectedProduct_ != null) {
                    btnClearSelectedProduct_.disabled = blockValue;
                }
            });
        }
        function calculatePTotalCost() {
            pTotalCost = 0;
            data.selectedProducts.forEach(element => {
                var pCost = document.getElementById('priceUnitCost_' + element.id);
                var quantity___ = document.getElementById('quantity_' + element.id);
                if (pCost != null && quantity___ != null) {
                    pTotalCost = pTotalCost + parseFloat(pCost.value)*parseFloat(quantity___.value);
                }
                if (element.allotmentType == 2) {
                    if (serialsById[element.id] == undefined) {
                        serialValidation = false;
                    } else {
                        var quantity___ = document.getElementById('quantity_' + element.id);
                        if (quantity___ != null) { 
                            if (parseInt(quantity___.value) != serialsById[element.id].length) {
                                serialValidation = false;
                            }   
                        } else {
                            serialValidation = false;
                        }
                    }
                }
            });
            return pTotalCost.toFixed(2);
        }
        saveInventory = function (){
            document.getElementById('saveButton').disabled = true;
            //logic and transaction
            var warehouseId = document.getElementById('warehouseId').value;            
            var purchaseSerie = document.getElementById('purchaseSerie').value;
            var purchaseNumber = document.getElementById('purchaseNumber').value;
            //symbolics
            var warehouseText = $("#warehouseId option:selected").text();
            var dataSend = {
                'warehouseId' : warehouseId,
                'details' : [],
                'allotments': allotments,
                'serials': serials,
                'supplierId': supplierId,
                'purchaseSerie': purchaseSerie,
                'purchaseNumber': purchaseNumber,
                'fromPurchase': document.getElementById('purchaseId').value,
            };
            data.products.forEach(element => {
                var objElement = {
                    'productId' : element.id,
                    'quantity' : 0,
                    'location' : null,
                    'minStock' : 0,
                    'priceList': [],
                    'priceCost' : 0,
                    'brandId'   : element.brand_id,
                    'purchaseDetailId': element.purchaseDetailId
                };
                var inputQuantity = document.getElementById('quantity_' + element.id);
                if (inputQuantity != null) {
                    objElement.quantity = inputQuantity.value;
                }
                var inputLocation = document.getElementById('location_' + element.id);
                if (inputLocation != null) {
                    objElement.location = inputLocation.value;
                }
                var inputMinStock = document.getElementById('minStock_' + element.id);
                if (inputMinStock != null) {
                    objElement.minStock = inputMinStock.value;
                }
                var inputPriceCost = document.getElementById('priceUnitCost_' + element.id);
                if (inputPriceCost != null) {
                    objElement.priceCost = parseFloat(inputPriceCost.value);
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
                    if (wholeSalePrice_ == null) {
                        wholeSalePrice_ = element.price;
                    }
                    data.priceLists.forEach(elementPriceList => {
                        var objPriceList = {
                            "id": elementPriceList.id,
                            "price": element.price,
                            "quantity": 1,
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
                url: "/api/transfer-movement",
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
                var productsResume = document.getElementById('productsResume');
                productsResume.innerHTML = '<br><p class="form-control">Se realizó el ingreso de ' + (response.details.length) + ' productos al almacén/tienda ' + warehouseText+ '.';
                //openModal
                $("#modal-resume").modal({backdrop: 'static', keyboard: false});
            });
        }
        goToPurchases = function(){
            location = "/purchases";
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
        //Auto callbacks
        autocompleteForProducts(document.getElementById('searchProduct'));
        autocompleteForSuppliers(document.getElementById('supplierId'));
        //listeners
        var searchProductAutoBarCode = document.getElementById('searchProductAutoBarCode');
        searchProductAutoBarCode.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                saveButton = document.getElementById('saveButton');
                saveButton.disabled = false;
                saveButton.innerHTML = 'PRESIONE AQUÍ PARA VALIDAR INGRESO <br> <b>PRECIO COSTO TOTAL: S/ ' + calculatePTotalCost() + '</b>';
                saveButton.onclick = function() { validateIncome(); }
                $.ajax({
                    url: "/api/products-search/" + searchProductAutoBarCode.value + "?noWarehouse=true&tropics=true",
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
