<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script>
    var formValidation;
    var deleteRow;
    $(document).ready(function() {
        var productAllotmentId = 0;
        var count = 0;
        var allotments = [];
        var allotmentSelected = [];
        var serials = [];
        var serialsById = [];
        var productSerialId = 0;
        var saleIndexTable = $('#table').DataTable({
            "scrollX": true,
            "scrollY": "275px",
            "processing": false,
            "language" : {
                "zeroRecords": " ",
                "infoEmpty": " ",
            },
            "lengthChange": false,
            "serverSide": false,
            "bPaginate": false,
            "ordering": false,
            "searching": false,
            "responsive": false
        });
        var data = {
            selectedProducts : []
        };
        var warehouseId = document.getElementById('warehouseId').value;
        var product = null;
        var table = null;
        function autocompleteForProducts(inp) {
            var currentFocus;
            var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    var a, b, i, val = this.value;
                    warehouseId = document.getElementById('warehouseId').value;
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
                        url: "/api/products-for-sale/" + val + '?&warehouseId=' + warehouseId,
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
                            if (response.length == 1) {
                                product = response[0];
                                var condition = true;
                                data.selectedProducts.forEach(elementSP => {
                                    if (elementSP.id == response[0].id) {
                                        condition = false;
                                    }
                                });
                                if (condition) {
                                    if (product != null) {
                                        data.selectedProducts.push(product);
                                        var allotmentTypeButton = '';
                                        if (product.allotmentType == 1) {
                                            // BOTÓN DE LOTES
                                            allotmentSelected.push(product.id);
                                            allotmentTypeButton = '<button type="button" onClick="openAllotmentModal(' + product.id + ')" class="btn btn-primary btn-xs"><i class="fa fa-cubes"></i></button><span> </span>';
                                        }
                                        // else if (product.allotmentType == 2) {
                                            // BOTÓN DE SERIES
                                        // }
                                        var inventoryTbodyId = document.getElementById('inventoryTbodyId');
                                        var tr = document.createElement('tr');
                                        tr.setAttribute("id", "row_" + product.id);
                                        tr.setAttribute("style", "font-size:10px;");
                                        tr.innerHTML ='<td>' + product.brandName + '</td>' +
                                            '<td>' + product.code + '</td>' +
                                            '<td>' + product.autoBarcode + '</td>' +
                                            '<td>' + product.name + '</td>' +
                                            '<td>' + product.description + '</td>' +
                                            '<td><input type="number" style="width:100%;" id="quantity_' + product.id + '" value="1" onClick="this.select();"/></td>' +
                                            '<td>' + product.stock + '</td>' +
                                            '<td>' + allotmentTypeButton + '<button type="button" onClick="deleteRow(' + product.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span></td>';
                                        inventoryTbodyId.insertBefore(tr, inventoryTbodyId.firstChild);
                                    }
                                    product = null;
                                    document.getElementById('nameProduct').focus();
                                    document.getElementById('nameProduct').value = '';
                                    document.getElementById('quantityProduct').value = '';
                                } else {
                                    var quantityId__ = document.getElementById('quantity_' + product.id);
                                    if (quantityId__ != null) {
                                        quantityId__.value = parseFloat(quantityId__.value) + 1;
                                    }
                                    // trOrder
                                    var row = $("#row_" + product.id);
                                    row.each(function() {
                                        var $this=$(this);
                                        $this.insertBefore($this.prevAll().last());
                                    });
                                    product = null;
                                    document.getElementById('nameProduct').focus();
                                    document.getElementById('nameProduct').value = '';
                                    document.getElementById('quantityProduct').value = '';
                                }
                                closeAllLists();
                            }
                            for (i = 0; i < response.length; i++) {
                                var condition = true;
                                // data.selectedProducts.forEach(elementSP => {
                                //     if (elementSP.id == response[i].id) {
                                //         condition = false;
                                //     }
                                // });
                                var nameLastname = response[i].name + ' - ' + response[i].code + ' - ' + response[i].autoBarcode + ' <b>MARCA: ' + response[i].brandName + ' (STOCK: ' + response[i].stock + ')</b>';
                                b = document.createElement("DIV");
                                b.setAttribute('class', 'form-control-autocomplete');
                                b.innerHTML += nameLastname;
                                b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                if (condition) {
                                    b.style.background = '#ffffff';
                                    b.style.cursor = 'pointer';
                                    b.addEventListener("click", function(e) {
                                        var iterator = this.getElementsByTagName("input")[0].value;
                                        inp.value = "";
                                        product = response[iterator];
                                        if (product != undefined) {
                                            var name___ = product.name + ' - ' + product.code + ' - ' + product.autoBarcode + ' (STOCK: ' + product.stock + ')';                                        
                                            document.getElementById('nameProduct').value = name___;
                                            document.getElementById('quantityProduct').focus();

                                        } else {
                                            alert("No se encontraron productos.");
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
        autocompleteForProducts(document.getElementById('nameProduct'));
        //var functions
        formValidation = function() {
            var saveButton = document.getElementById('button');
            if (saveButton != null) {
                var allotmentSelected_ = [];
                allotmentSelected.forEach(element => {
                    var quantityE_ = document.getElementById('quantity_' + element);
                    if (parseFloat(quantityE_.value) > 0) {
                        allotmentSelected_.push(element);
                    }
                });
                if (allotments.length < allotmentSelected_.length) {
                    saveButton.innerHTML = 'INFORMACIÓN DE LOTES INCORRECTA. VOLVER A VALIDAR';
                } else {
                    var button = document.getElementById('button');
                    var dataSend = {
                        'warehouseId' : warehouseId,
                        'type' : document.getElementById('selectInventoryType').value,
                        'details' : [],
                        'allotments': allotments,
                    };
                    data.selectedProducts.forEach(element => {
                        var quantityE = document.getElementById('quantity_' + element.id);
                        if (quantityE != null) {
                            // if (parseFloat(quantityE.value) > 0) {
                            dataSend.details.push({
                                "productId": element.id,
                                "computed": parseFloat(quantityE.value),
                                "reason": "Ingreso web",
                                "brandId": element.brandId
                            });
                            // }
                        }
                    });
                    button.disabled = true;
                    $.ajax({
                        method: "POST",
                        url: "/api/inventories",
                        context: document.body,
                        data: dataSend,
                        statusCode: {
                            500: function() {
                                button.disabled = false;
                                alert('No se pudo crear el inventario. Verifique la información ingresada e inténtelo nuevamente.');
                            },
                            403: function() {
                                button.disabled = false;
                                alert('No se pudo crear el inventario. Verifique la información ingresada e inténtelo nuevamente.');
                            },
                            400: function() {
                                button.disabled = false;
                                alert('No se pudo crear el inventario. Verifique la información ingresada e inténtelo nuevamente.');
                            },
                        }
                    }).done(function(response) {
                        // console.log(response);
                        // data = {};
                        location = "/inventories";
                    });
                }
            }
        }
        deleteRow = function(id) {
            console.log("BEGINNING", allotmentSelected, allotments);
            var allotmentSelected_ = [];
            // borrar allotmentSelected
            allotmentSelected.forEach(element => {
                if (element != id) {
                    allotmentSelected_.push(element);
                }
            });
            allotmentSelected = allotmentSelected_;
            var condition = [false, 0];
            data.selectedProducts.forEach(function(element, index) {
                if (element.id == id) {
                    condition = [true, index];
                }
            });
            if (condition[0]) {
                delete(data.selectedProducts[condition[1]]);
                document.getElementById("row_" + id).remove();
            }
            // borrar allotments
            var allotments_ = [];
            allotments.forEach(element => {
                if (element.productId == id) {
                    var trAllotment = document.getElementById('trAllotment_' + element.productId + '_' + element.count);
                    if (trAllotment != null) {
                        trAllotment.remove();
                    }
                    element.productId = null;
                    element.quantity = 0;
                } else {
                    allotments_.push(element);
                }
            });
            allotments = allotments_;
            console.log("ENDING", allotmentSelected, allotments);
        }
        openAllotmentModal = function(productId) {
            productAllotmentId = productId;
            var productAllotment = null;
            data.selectedProducts.forEach(element => {
                if (element.id == productAllotmentId) {
                    productAllotment = element;
                }
            });
            document.getElementById('productAllotmentDetail').innerHTML = productAllotment.code + ' - ' + productAllotment.name;
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
        //listeners
        var quantityProduct = document.getElementById('quantityProduct');
        quantityProduct.addEventListener('keyup', function(event) {
            event.preventDefault();
            if (event.keyCode == '13') {
                if (product != null) {
                    var condition = true;
                    data.selectedProducts.forEach(elementSP => {
                        if (elementSP.id == product.id) {
                            condition = false;
                        }
                    });
                    if (condition) {
                        var quantity____ = quantityProduct.value;
                        if (quantity____ == '' || parseFloat(quantity____) < 0) {
                            quantity____ = 0;
                        }
                        data.selectedProducts.push(product);
                        var inventoryTbodyId = document.getElementById('inventoryTbodyId');
                        var tr = document.createElement('tr');
                        var allotmentTypeButton = '';
                        if (product.allotmentType == 1) {
                            // BOTÓN DE LOTES
                            allotmentSelected.push(product.id);
                            allotmentTypeButton = '<button type="button" onClick="openAllotmentModal(' + product.id + ')" class="btn btn-primary btn-xs"><i class="fa fa-cubes"></i></button><span> </span>';
                        }
                        // else if (product.allotmentType == 2) {
                            // BOTÓN DE SERIES
                        // }
                        tr.setAttribute("id", "row_" + product.id);
                        tr.setAttribute("style", "font-size:10px;");
                        tr.innerHTML ='<td>' + product.brandName + '</td>' +
                            '<td>' + product.code + '</td>' +
                            '<td>' + product.autoBarcode + '</td>' +
                            '<td>' + product.name + '</td>' +
                            '<td>' + product.description + '</td>' +
                            '<td><input type="number" style="width:100%;" id="quantity_' + product.id + '" value="' + quantity____ + '" onClick="this.select();"/></td>' +
                            '<td>' + product.stock + '</td>' +
                            '<td>' + allotmentTypeButton + '<button type="button" onClick="deleteRow(' + product.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span></td>';
                        inventoryTbodyId.insertBefore(tr, inventoryTbodyId.firstChild);                        
                    } else {
                        var quantity____ = quantityProduct.value;
                        if (quantity____ == '' || parseFloat(quantity____) < 0) {
                            quantity____ = 0;
                        }
                        var quantityId__ = document.getElementById('quantity_' + product.id);
                        if (quantityId__ != null) {
                            quantityId__.value = parseFloat(quantityId__.value) + parseFloat(quantity____);
                        }                        
                        // trOrder
                        var row = $("#row_" + product.id);
                        row.each(function() {
                            var $this=$(this);
                            $this.insertBefore($this.prevAll().last());
                        });
                        product = null;
                        document.getElementById('nameProduct').focus();
                        document.getElementById('nameProduct').value = '';
                        document.getElementById('quantityProduct').value = '';
                        // alert('El producto ya fue seleccionado');
                    }
                }
                product = null;
                document.getElementById('nameProduct').focus();
                document.getElementById('nameProduct').value = '';
                document.getElementById('quantityProduct').value = '';
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
                        tr.setAttribute('id', 'trAllotment_' + productAllotmentId + '_' + productAllotmentId + '_' + count);
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
                        tr.setAttribute('id', 'trAllotment_' + productAllotmentId + '_' + count);
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
                        tr.setAttribute('id', 'trAllotment_' + productAllotmentId + '_' + count);
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