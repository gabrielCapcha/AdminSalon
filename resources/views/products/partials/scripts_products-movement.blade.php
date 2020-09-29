<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        var warehousesJson = JSON.parse(document.getElementById('warehousesJson').value);
        var selectedSerialProductId = 0;
        // start datatable
        $('#inventoryData').DataTable({
            "scrollX": true,
            "processing": false,
            "lengthChange": false,
            "order": [[ 1, "asc" ]],
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "serverSide": false,
            "paging": false,
            "ordering": true,
            "searching": true,
        });
        // CHANGES
        changeTdName = function(id) {
            var td = document.getElementById('tdName_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="text" value="' + td.textContent + '" id="name_' + id + '">' +
                    '<span> </span><button class="btn btn-info" onClick="updateName(' + id + ');" id="btnName_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        changeTdCurrency = function(id) {
            var td = document.getElementById('tdCurrency_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="text" value="' + td.textContent + '" id="currency_' + id + '" maxlength="10">' +
                    '<span> </span><button class="btn btn-info" onClick="updateCurrency(' + id + ');" id="btnCurrency_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        changeTdPCost = function(id) {
            var td = document.getElementById('tdPCost_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="text" value="' + td.textContent + '" id="pCost_' + id + '" maxlength="10">' +
                    '<span> </span><button class="btn btn-info" onClick="updatePCost(' + id + ');" id="btnPCost_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        changeTdGeneralPrice = function(id) {
            var td = document.getElementById('tdGeneralPrice_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="text" value="' + td.textContent + '" id="generalPrice_' + id + '" maxlength="10">' +
                    '<span> </span><button class="btn btn-info" onClick="updateGeneralPrice(' + id + ');" id="btnGeneralPrice_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        changeTdUnitPrice = function(id) {
            var td = document.getElementById('tdUnitPrice_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="text" value="' + td.textContent + '" id="unitPrice_' + id + '" maxlength="10">' +
                    '<span> </span><button class="btn btn-info" onClick="updateUnitPrice(' + id + ');" id="btnUnitPrice_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        changeTdWholeSaleQuantity = function(id) {
            var td = document.getElementById('tdWholeSaleQuantity_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="text" value="' + td.textContent + '" id="wholeSaleQuantity_' + id + '" maxlength="10">' +
                    '<span> </span><button class="btn btn-info" onClick="updateWholeSaleQuantity(' + id + ');" id="btnWholeSaleQuantity_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
            changeTdWholeSalePrice = function(id) {
                var td = document.getElementById('tdWholeSalePrice_' + id);
                if (td != null) {
                    td.onclick = function() {};
                    td.innerHTML = '<input onClick="this.select();" type="text" value="' + td.textContent + '" id="wholeSalePrice_' + id + '" maxlength="10">' +
                        '<span> </span><button class="btn btn-info" onClick="updateWholeSalePrice(' + id + ');" id="btnWholeSalePrice_' + id + '"><i class="fa fa-check"></i></button>';
                } else {
                    console.log("No existe td");
                }
            }
        changeTdMinPrice = function(id) {
            var td = document.getElementById('tdMinPrice_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="number" step="0.1" value="' + td.textContent + '" id="minPrice_' + id + '">' +
                    '<span> </span><button class="btn btn-info" onClick="updateMinPrice(' + id + ');" id="btnMinPrice_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        changeTdMaxPrice = function(id) {
            var td = document.getElementById('tdMaxPrice_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="number" step="0.1" value="' + td.textContent + '" id="maxPrice_' + id + '">' +
                    '<span> </span><button class="btn btn-info" onClick="updateMaxPrice(' + id + ');" id="btnMaxPrice_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        changeWPStock = function(id) {
            var td = document.getElementById('tdWPStock_' + id);
            if (td != null) {
                td.onclick = function() {};
                td.innerHTML = '<input onClick="this.select();" type="number" step="0.1" value="' + td.textContent + '" id="wPStock_' + id + '">' +
                    '<span> </span><button class="btn btn-info" onClick="updateWPStock(' + id + ');" id="btnWPStock_' + id + '"><i class="fa fa-check"></i></button>';
            } else {
                console.log("No existe td");
            }
        }
        // UPDATES
        updateWholeSalePrice = function(id) {
            var btnWholeSalePrice_ = document.getElementById('btnWholeSalePrice_' + id);
            if (btnWholeSalePrice_ != null) {
                btnWholeSalePrice_.disabled = true;
                btnWholeSalePrice_.className = 'btn btn-warning';
                btnWholeSalePrice_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        wholeSalePrice: document.getElementById('wholeSalePrice_' + id).value,
                        priceList: true,
                        onlyPriceLists: true,
                    },
                    statusCode: {
                        400: function() {
                            btnWholeSalePrice_.disabled = false;
                            btnWholeSalePrice_.className = 'btn btn-danger';
                            btnWholeSalePrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnWholeSalePrice_.disabled = false;
                            btnWholeSalePrice_.className = 'btn btn-danger';
                            btnWholeSalePrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnWholeSalePrice_.disabled = false;
                            btnWholeSalePrice_.className = 'btn btn-danger';
                            btnWholeSalePrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnWholeSalePrice_.disabled = false;
                    btnWholeSalePrice_.className = 'btn btn-success';
                    btnWholeSalePrice_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateWholeSaleQuantity = function(id) {
            var btnWholeSaleQuantity_ = document.getElementById('btnWholeSaleQuantity_' + id);
            if (btnWholeSaleQuantity_ != null) {
                btnWholeSaleQuantity_.disabled = true;
                btnWholeSaleQuantity_.className = 'btn btn-warning';
                btnWholeSaleQuantity_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        quantity: document.getElementById('wholeSaleQuantity_' + id).value,
                        priceList: true,
                        onlyPriceLists: true,
                    },
                    statusCode: {
                        400: function() {
                            btnWholeSaleQuantity_.disabled = false;
                            btnWholeSaleQuantity_.className = 'btn btn-danger';
                            btnWholeSaleQuantity_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnWholeSaleQuantity_.disabled = false;
                            btnWholeSaleQuantity_.className = 'btn btn-danger';
                            btnWholeSaleQuantity_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnWholeSaleQuantity_.disabled = false;
                            btnWholeSaleQuantity_.className = 'btn btn-danger';
                            btnWholeSaleQuantity_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnWholeSaleQuantity_.disabled = false;
                    btnWholeSaleQuantity_.className = 'btn btn-success';
                    btnWholeSaleQuantity_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateUnitPrice = function(id) {
            var btnUnitPrice_ = document.getElementById('btnUnitPrice_' + id);
            if (btnUnitPrice_ != null) {
                btnUnitPrice_.disabled = true;
                btnUnitPrice_.className = 'btn btn-warning';
                btnUnitPrice_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        price: document.getElementById('unitPrice_' + id).value,
                        priceList: true,
                        onlyPriceLists: true,
                    },
                    statusCode: {
                        400: function() {
                            btnUnitPrice_.disabled = false;
                            btnUnitPrice_.className = 'btn btn-danger';
                            btnUnitPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnUnitPrice_.disabled = false;
                            btnUnitPrice_.className = 'btn btn-danger';
                            btnUnitPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnUnitPrice_.disabled = false;
                            btnUnitPrice_.className = 'btn btn-danger';
                            btnUnitPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnUnitPrice_.disabled = false;
                    btnUnitPrice_.className = 'btn btn-success';
                    btnUnitPrice_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateGeneralPrice = function(id) {
            var btnGeneralPrice_ = document.getElementById('btnGeneralPrice_' + id);
            if (btnGeneralPrice_ != null) {
                btnGeneralPrice_.disabled = true;
                btnGeneralPrice_.className = 'btn btn-warning';
                btnGeneralPrice_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        price: document.getElementById('generalPrice_' + id).value,
                        priceList: true
                    },
                    statusCode: {
                        400: function() {
                            btnGeneralPrice_.disabled = false;
                            btnGeneralPrice_.className = 'btn btn-danger';
                            btnGeneralPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnGeneralPrice_.disabled = false;
                            btnGeneralPrice_.className = 'btn btn-danger';
                            btnGeneralPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnGeneralPrice_.disabled = false;
                            btnGeneralPrice_.className = 'btn btn-danger';
                            btnGeneralPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnGeneralPrice_.disabled = false;
                    btnGeneralPrice_.className = 'btn btn-success';
                    btnGeneralPrice_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updatePCost = function(id) {
            var btnPCost_ = document.getElementById('btnPCost_' + id);
            if (btnPCost_ != null) {
                btnPCost_.disabled = true;
                btnPCost_.className = 'btn btn-warning';
                btnPCost_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        price_cost: document.getElementById('pCost_' + id).value
                    },
                    statusCode: {
                        400: function() {
                            btnPCost_.disabled = false;
                            btnPCost_.className = 'btn btn-danger';
                            btnPCost_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnPCost_.disabled = false;
                            btnPCost_.className = 'btn btn-danger';
                            btnPCost_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnPCost_.disabled = false;
                            btnPCost_.className = 'btn btn-danger';
                            btnPCost_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnPCost_.disabled = false;
                    btnPCost_.className = 'btn btn-success';
                    btnPCost_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateMinPrice = function(id) {
            var btnMinPrice_ = document.getElementById('btnMinPrice_' + id);
            if (btnMinPrice_ != null) {
                btnMinPrice_.disabled = true;
                btnMinPrice_.className = 'btn btn-warning';
                btnMinPrice_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        min_price: document.getElementById('minPrice_' + id).value
                    },
                    statusCode: {
                        400: function() {
                            btnMinPrice_.disabled = false;
                            btnMinPrice_.className = 'btn btn-danger';
                            btnMinPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnMinPrice_.disabled = false;
                            btnMinPrice_.className = 'btn btn-danger';
                            btnMinPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnMinPrice_.disabled = false;
                            btnMinPrice_.className = 'btn btn-danger';
                            btnMinPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnMinPrice_.disabled = false;
                    btnMinPrice_.className = 'btn btn-success';
                    btnMinPrice_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateCurrency = function(id) {
            var btnCurrency_ = document.getElementById('btnCurrency_' + id);
            if (btnCurrency_ != null) {
                btnCurrency_.disabled = true;
                btnCurrency_.className = 'btn btn-warning';
                btnCurrency_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        currency: document.getElementById('currency_' + id).value
                    },
                    statusCode: {
                        400: function() {
                            btnCurrency_.disabled = false;
                            btnCurrency_.className = 'btn btn-danger';
                            btnCurrency_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnCurrency_.disabled = false;
                            btnCurrency_.className = 'btn btn-danger';
                            btnCurrency_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnCurrency_.disabled = false;
                            btnCurrency_.className = 'btn btn-danger';
                            btnCurrency_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnCurrency_.disabled = false;
                    btnCurrency_.className = 'btn btn-success';
                    btnCurrency_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateName = function(id) {
            var btnName_ = document.getElementById('btnName_' + id);
            if (btnName_ != null) {
                btnName_.disabled = true;
                btnName_.className = 'btn btn-warning';
                btnName_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        name: document.getElementById('name_' + id).value
                    },
                    statusCode: {
                        400: function() {
                            btnName_.disabled = false;
                            btnName_.className = 'btn btn-danger';
                            btnName_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnName_.disabled = false;
                            btnName_.className = 'btn btn-danger';
                            btnName_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnName_.disabled = false;
                            btnName_.className = 'btn btn-danger';
                            btnName_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnName_.disabled = false;
                    btnName_.className = 'btn btn-success';
                    btnName_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateMaxPrice = function(id) {
            var btnMaxPrice_ = document.getElementById('btnMaxPrice_' + id);
            if (btnMaxPrice_ != null) {
                btnMaxPrice_.disabled = true;
                btnMaxPrice_.className = 'btn btn-warning';
                btnMaxPrice_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/products-simple/" + id,
                    context: document.body,
                    data: {
                        max_price: document.getElementById('maxPrice_' + id).value
                    },
                    statusCode: {
                        400: function() {
                            btnMaxPrice_.disabled = false;
                            btnMaxPrice_.className = 'btn btn-danger';
                            btnMaxPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnMaxPrice_.disabled = false;
                            btnMaxPrice_.className = 'btn btn-danger';
                            btnMaxPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnMaxPrice_.disabled = false;
                            btnMaxPrice_.className = 'btn btn-danger';
                            btnMaxPrice_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el producto. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnMaxPrice_.disabled = false;
                    btnMaxPrice_.className = 'btn btn-success';
                    btnMaxPrice_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        updateWPStock = function(id) {
            var btnWPStock_ = document.getElementById('btnWPStock_' + id);
            if (btnWPStock_ != null) {
                btnWPStock_.disabled = true;
                btnWPStock_.className = 'btn btn-warning';
                btnWPStock_.innerHTML = '<i class="fa fa-hand-stop-o"></i>';
                $.ajax({
                    method: "PATCH",
                    url: "/api/warehouse-product-simple/" + id,
                    context: document.body,
                    data: {
                        stock: document.getElementById('wPStock_' + id).value
                    },
                    statusCode: {
                        400: function() {
                            btnWPStock_.disabled = false;
                            btnWPStock_.className = 'btn btn-danger';
                            btnWPStock_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el stock. Comuníquese con soporte.');
                        },
                        404: function() {
                            btnWPStock_.disabled = false;
                            btnWPStock_.className = 'btn btn-danger';
                            btnWPStock_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el stock. Comuníquese con soporte.');
                        },
                        500: function() {
                            btnWPStock_.disabled = false;
                            btnWPStock_.className = 'btn btn-danger';
                            btnWPStock_.innerHTML = '<i class="fa fa-refresh"></i>';
                            alert('No se pudo editar el stock. Comuníquese con soporte.');
                        }
                    }
                }).done(function(response) {
                    btnWPStock_.disabled = false;
                    btnWPStock_.className = 'btn btn-success';
                    btnWPStock_.innerHTML = '<i class="fa fa-thumbs-o-up"></i>';
                });
            }
        }
        // SERIALS
        deleteSerial = function(id) {
            $.ajax({
                url: "/api/serials/" + id,
                context: document.body,
                method: "DELETE",
                statusCode: {
                }
            }).done(function(response) {
                document.getElementById("trSerial_" + id).remove();
                // logica de borrado
                var serials = document.getElementById('serials_' + response.war_products_id);
                if (serials != null) {
                    serials = JSON.parse(serials.value);
                    var serials_ = [];
                    serials.forEach(element => {
                        if (element.id != id) {
                            serials_.push(element);
                        }
                    });
                    serials.value = JSON.stringify(serials_);
                    var btnSerials_ = document.getElementById('btnSerials_' + response.war_products_id);
                    if (btnSerials_ != null) {
                        btnSerials_.innerHTML = serials_.length + '<i class="fa fa-key"></i>';
                    }
                }
            });
        }
        newSerial = function() {
            document.getElementById('btnNewSerial').disabled = true;
            var dataSend = {
                warehouseId : document.getElementById('warWarehousesId').value,
                productId: selectedSerialProductId,
                serial: document.getElementById('serial').value,
                imei: document.getElementById('imei').value,
                warranty: document.getElementById('warranty').value,
                typeWarranty: document.getElementById('typeWarranty').value,
            };
            $.ajax({
                method: "POST",
                url: "/api/serials",
                context: document.body,
                data: dataSend,
                statusCode: {
                }
            }).done(function(response) {
                // logica de agregado
                document.getElementById('serial').value = '';
                document.getElementById('imei').value = '';
                document.getElementById('warranty').value = '';
                
                var serials = document.getElementById('serials_' + response.war_products_id);
                if (serials != null) {
                    serials_ = JSON.parse(serials.value);
                    serials_.push(response);
                    serials.value = JSON.stringify(serials_);

                    var btnSerials_ = document.getElementById('btnSerials_' + response.war_products_id);
                    if (btnSerials_ != null) {
                        btnSerials_.innerHTML = serials_.length + '<i class="fa fa-key"></i>';
                    }
                    
                    var tableSerialResumeBody = document.getElementById('tableSerialResumeBody');
                    if (tableSerialResumeBody != null) {
                        tableSerialResumeBody.innerHTML = '';
                        serials_.forEach(element => {
                            var tr = document.createElement('tr');
                            tr.setAttribute('id', 'trSerial_' + element.id);
                            tr.innerHTML = '<td>' + warehousesName(element.war_warehouses_id) + '</td>' +
                                '<td>' + element.serial + '</td>' +
                                '<td>' + element.imei + '</td>' +
                                '<td>' + typeWarrantyName(element.type_warranty) + '</td>' +
                                '<td>' + element.warranty + '</td>' + 
                                '<td><button class="btn btn-danger" onClick="deleteSerial(' + element.id + ');"><i class="fa fa-trash"></i></button></td>';
                            tableSerialResumeBody.insertBefore(tr, tableSerialResumeBody.nextSibling);
                        });                    
                    }
                }
                document.getElementById('btnNewSerial').disabled = false;
            });
        }
        warehousesName = function(id) {
            var message = 'SIN TIENDA';
            warehousesJson.forEach(element => {
                if (element.id == id) {
                    message = element.name;
                }
            });
            return message;
        }
        // MODALS & SUBMITS
        goToProductMovement = function() {
            location = '/products-movement?categoryId=' + document.getElementById('categoryId').value;
        }
        searchProduct = function(value) {
            var categoryId = document.getElementById('categoryId');
            if (categoryId != null) {
                if (value != '') {
                    location = '/products-movement?categoryId=' + categoryId.value + '&searchInput=' + value;                    
                } else {
                    alert("INGRESE UNA PALABRA/CÓDIGO PARA BUSCAR");
                }
            } else {
                alert("Error de sincronización. Comuníquese con soporte.");
            }
        }
        serialManagement = function(id) {
            selectedSerialProductId = id;
            $('#modal-serial').modal({ backdrop: 'static', keyboard: false });
            var serials = document.getElementById('serials_' + id);
            if (serials != null) {
                serials = JSON.parse(serials.value);
                // fill table 
                var tableSerialResumeBody = document.getElementById('tableSerialResumeBody');
                if (tableSerialResumeBody != null) {
                    tableSerialResumeBody.innerHTML = '';
                    serials.forEach(element => {
                        var tr = document.createElement('tr');
                        tr.setAttribute('id', 'trSerial_' + element.id);
                        tr.innerHTML = '<td>' + warehousesName(element.war_warehouses_id) + '</td>' +
                            '<td>' + element.serial + '</td>' +
                            '<td>' + element.imei + '</td>' +
                            '<td>' + typeWarrantyName(element.type_warranty) + '</td>' +
                            '<td>' + element.warranty + '</td>' + 
                            '<td><button class="btn btn-danger" onClick="deleteSerial(' + element.id + ');"><i class="fa fa-trash"></i></button></td>';
                        tableSerialResumeBody.insertBefore(tr, tableSerialResumeBody.nextSibling);
                    });                    
                }
            }
        }
        closeModal = function() {
            $('#modal-serial').modal('toggle');
        }
        typeWarrantyName = function(id) {
            var message = 'DÍAS';
            switch (id) {
                case 1:
                    message = "DÍAS";
                    break;
                case 2:
                    message = "MESES";
                    break;
                case 3:
                    message = "AÑOS";
                    break;            
                default:
                    message = "DÍAS";
                    break;
            }
            return message;
        }
        autoSearchInput = function(inp) {
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    searchProduct(inp.value);
                }
            });
        }
        // event listener
        autoSearchInput(document.getElementById('searchInput'));
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>