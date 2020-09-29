<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/buttons/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.print.min.js') }}" type="text/javascript"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    var checkedProducts = [];
    var arrayProducts = [];
    var arrayCommission = [];
    var goToKardex;
    var editProduct;
    var goToTransfers;
    var priceListProduct;
    var priceListSubmit;
    var selectedProduct = 0;
    var commissionListJson = [];
    $(document).ready(function() {
        var data = {};
        data.priceListId = 0;
        data.products = [];
        data.productSearchComission = null;
        data.commissions = [];
        var app_id = document.getElementById('app_id').value;
        app_id = JSON.parse(app_id);
        var priceListValues = document.getElementById('priceListValues').value;
        priceListValues = JSON.parse(priceListValues);
        var employeesJson = document.getElementById('employeesJson').value;
        employeesJson = JSON.parse(employeesJson);
        var commissionCount = 0;
        
        function getBase64(file, fileType) {
            var reader = new FileReader();
            var btnEditProduct = document.getElementById('btnEditProduct');
            btnEditProduct.disabled = true;
            reader.readAsDataURL(file);
            reader.onload = function () {
                $.ajax({
                    method: "POST",
                    url: "https://sm-soft.tumi-soft.com/image/one-upload",
                    context: document.body,
                    data: {
                        type: fileType,
                        image: reader.result
                    }
                }).done(function(response) {
                    data.urlImage = response.data[0];
                    btnEditProduct.disabled = false;
                });
            };
            reader.onerror = function (error) {
                btnEditProduct.disabled = false;
            };
        }
        function validateKey(s) {
            return s.indexOf(' ') >= 0;
        }
        // if (priceListValues[0].com_companies_id === 644 || priceListValues[0].com_companies_id === 645 || priceListValues[0].com_companies_id === 664 || parseInt(priceListValues[0].com_companies_id) === 666 || parseInt(priceListValues[0].com_companies_id) === 948) {
            if (app_id === 6) {
            console.log("entro 1");
            var saleIndexTable = $('#products_index').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                {
                    text: 'Exportación completa',
                    action: function ( e, dt, node, config ) {
                        completeExport();
                    }
                },
                {
                    text: 'Tipo de afectación IGV',
                    action: function ( e, dt, node, config ) {
                        taxTypeAffection();
                    }
                },
                {
                    text: 'Administrar precios',
                    action: function ( e, dt, node, config ) {
                        priceManagement();
                    }
                },
                {
                    text: 'Crear comisiones',
                    action: function ( e, dt, node, config ) {
                        comissionAssign();
                    }
                },
            ],
            "serverSide": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                    $.get('/api/products', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        categoryId: $('#categoryId').val(),
                        brandId: $('#brandId').val(),
                        parent: $('#parent').val(),
                        stateId: $('#stateId').val(),
                        }, function(res) {
                            arrayProducts = [];
                            res.data.forEach(element => {
                                arrayProducts[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': function (data) {
                    var checkedAllButton = document.getElementById('checkedAllButton');
                    var checked = '';
                    if (checkedAllButton != null) {
                        if (checkedProducts.includes(data.id)) {
                            checked = 'checked';
                        } else {
                            if (checkedAllButton.checked) {
                                checked = 'checked';
                                checkedProducts.push(data.id);
                            }
                        }
                    }
                    return '<input type="checkbox" onclick="checkedProduct(' + data.id + ');" id="checkboxProduct_' + data.id + '" ' + checked + '>';
                }},
                {'data': function (data) {
                    var message = data.category_name;
                    if (data.sub_categories.length > 0) {
                        message = message + '<br><p style="font-size:10px;">';
                        data.sub_categories.forEach(element => {
                            // message = message + ' ' + element.subCategoryName;
                            message = message + '- ' + element.category.name + '<br>';
                        });
                        message = message + '</p>';
                    }
                    return message;
                }},
                {'data': 'brand_name'},
                {'data': function (data) {
                    var message = 'PADRE <span></span><button onClick="goToCreateChilds(' + data.id + ');" class="btn btn-warning btn-xs" title="Agregar productos hijos"> <i class="fa fa-child"></i> </button>';
                    if (data.product_parent_id != null) {
                        message = 'HIJO';
                    }
                    return message;
                }},
                {'data': function (data) {
                    return '<a style="cursor:pointer;" onClick="showProductDetail(' + data.id + ')">' + data.code + '</a>';
                }},
                {'data': 'auto_barcode'},
                {'data': function (data) {
                    var message = 'GESTIÓN LIBRE';
                    switch (data.allotment_type) {
                        case 0:
                            message = 'GESTIÓN LIBRE';
                            break;
                        case 1:
                            message = 'GESTIÓN POR LOTES';
                            break;
                        case 2:
                            message = 'GESTIÓN POR SERIES';
                            break;
                        default:
                            message = 'GESTIÓN LIBRE';
                            break;
                    }
                    return message;
                }},
                {'data': 'name'},
                {'data': 'description'},
                {'data': 'price_cost'},
                {'data': function(data) {
                    var message = "Gravado - Operación Onerosa";
                    switch (parseInt(data.tax_exemption_reason_code)) {
                        case 10: 
                            message = "Gravado – Operación Onerosa";
                            break;
                        case 11: 
                            message = "Gravado – Retiro por premio";
                            break;
                        case 12: 
                            message = "Gravado – Retiro por donación";
                            break;
                        case 13: 
                            message = "Gravado – Retiro";
                            break;
                        case 14: 
                            message = "Gravado – Retiro por publicidad";
                            break;
                        case 15: 
                            message = "Gravado – Bonificaciones";
                            break;
                        case 16: 
                            message = "Gravado – Retiro por entrega a trabajadores";
                            break;
                        case 17: 
                            message = "Gravado – IVAP";
                            break;
                        case 20: 
                            message = "Exonerado - Operación Onerosa";
                            break;
                        case 21: 
                            message = "Exonerado – Transferencia Gratuita";
                            break;
                        case 30: 
                            message = "Inafecto - Operación Onerosa";
                            break;
                        case 31: 
                            message = "Inafecto – Retiro por Bonificación";
                            break;
                        case 32: 
                            message = "Inafecto – Retiro";
                            break;
                        case 33: 
                            message = "Inafecto – Retiro por Muestras Médicas";
                            break;
                        case 34: 
                            message = "Inafecto - Retiro por Convenio Colectivo";
                            break;
                        case 35: 
                            message = "Inafecto – Retiro por premio";
                            break;
                        case 36: 
                            message = "Inafecto - Retiro por publicidad";
                            break;
                        case 40: 
                            message = "Exportación";
                            break;
                        case 7152: 
                            message = "IMPUESTO A BOLSAS PLASTICAS - ICBPER";
                            break;
                        default:
                            break;
                    }
                    return message;
                }},
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data) {
                    if (data.flag_active == 0) { 
                            // '<button type="button" disabled class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-exchange"></i></button><span> </span>' +
                            // '<button type="button" disabled class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-bar-chart"></i></button><span> </span>' +
                        return '<button type="button" onClick="editProduct(' + data.id + ')" class="btn btn-warning btn-xs" style="width: 25px;"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-default btn-xs" style="width: 25px;"><i class="fa fa-cubes"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-usd"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-key"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-danger btn-xs" style="width: 25px;"><i class="fa fa-trash"></i></button><span> </span>';
                    } else {
                            // '<button type="button" onClick="goToTransfers(' + data.id + ');" class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-exchange"></i></button><span> </span>' +
                            // '<button type="button" onClick="goToKardex(' + data.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-bar-chart"></i></button><span> </span>' +
                        var message = '<button title="Editar producto" type="button" onClick="editProduct(' + data.id + ')" class="btn btn-warning btn-xs" style="width: 25px;"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button title="Asignar área" type="button" onClick="areaProduct(' + data.id + ');" class="btn btn-default btn-xs" style="width: 25px;"><i class="fa fa-cubes"></i></button><span> </span>' +
                            '<button title="Lista de precios" type="button" onClick="priceListProduct(' + data.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-usd"></i></button><span> </span>' +
                            '<button title="Administración de series" type="button" onClick="getSerialsByProduct(' + data.id + ');" class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-key"></i></button><span> </span>' +
                            '<button title="Eliminar producto" type="button" onClick="deleteProductModal(' + data.id + ');" class="btn btn-danger btn-xs" style="width: 25px;"><i class="fa fa-trash"></i></button><span> </span>';
                        if (data.company_id == 534) {
                            var ecommerceInfo = false;
                            data.stocks.forEach(element => {
                                if (element.json_ecommerce != null) {
                                    ecommerceInfo = true;
                                }
                            });
                            if (ecommerceInfo) {
                                message = message +
                                '<button type="button" onClick="updateEcommerceModal(' + data.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-shopping-cart"></i></button><span> </span>';
                            } else {
                                message = message +
                                '<button type="button" onClick="updateEcommerceModal(' + data.id + ');" class="btn btn-default btn-xs" style="width: 25px;"><i class="fa fa-shopping-cart"></i></button><span> </span>';
                            }
                        }
                        return message;
                    }
                }}
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.flag_active == 0) {
                    $node.addClass('danger');
                }
            },
        });
        } else {
            var saleIndexTable = $('#products_index').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                {
                    text: 'Exportación completa',
                    action: function ( e, dt, node, config ) {
                        completeExport();
                    }
                },
                {
                    text: 'Tipo de afectación IGV',
                    action: function ( e, dt, node, config ) {
                        taxTypeAffection();
                    }
                },
                {
                    text: 'Administrar precios',
                    action: function ( e, dt, node, config ) {
                        priceManagement();
                    }
                }
            ],
            "serverSide": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                    $.get('/api/products', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        categoryId: $('#categoryId').val(),
                        brandId: $('#brandId').val(),
                        parent: $('#parent').val(),
                        stateId: $('#stateId').val(),
                        }, function(res) {
                            arrayProducts = [];
                            res.data.forEach(element => {
                                arrayProducts[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': function (data) {
                    var checkedAllButton = document.getElementById('checkedAllButton');
                    var checked = '';
                    if (checkedAllButton != null) {
                        if (checkedProducts.includes(data.id)) {
                            checked = 'checked';
                        } else {
                            if (checkedAllButton.checked) {
                                checked = 'checked';
                                checkedProducts.push(data.id);
                            }
                        }
                    }
                    return '<input type="checkbox" onclick="checkedProduct(' + data.id + ');" id="checkboxProduct_' + data.id + '" ' + checked + '>';
                }},
                {'data': function (data) {
                    var message = data.category_name;
                    if (data.sub_categories.length > 0) {
                        message = message + '<br><p style="font-size:10px;">';
                        data.sub_categories.forEach(element => {
                            // message = message + ' ' + element.subCategoryName;
                            message = message + '- ' + element.category.name + '<br>';
                        });
                        message = message + '</p>';
                    }
                    return message;
                }},
                {'data': 'brand_name'},
                {'data': function (data) {
                    var message = 'PADRE <span></span><button onClick="goToCreateChilds(' + data.id + ');" class="btn btn-warning btn-xs" title="Agregar productos hijos"> <i class="fa fa-child"></i> </button>';
                    if (data.product_parent_id != null) {
                        message = 'HIJO';
                    }
                    return message;
                }},
                {'data': function (data) {
                    return '<a style="cursor:pointer;" onClick="showProductDetail(' + data.id + ')">' + data.code + '</a>';
                }},
                {'data': 'auto_barcode'},
                {'data': function (data) {
                    var message = 'GESTIÓN LIBRE';
                    switch (data.allotment_type) {
                        case 0:
                            message = 'GESTIÓN LIBRE';
                            break;
                        case 1:
                            message = 'GESTIÓN POR LOTES';
                            break;
                        case 2:
                            message = 'GESTIÓN POR SERIES';
                            break;
                        default:
                            message = 'GESTIÓN LIBRE';
                            break;
                    }
                    return message;
                }},
                {'data': 'name'},
                {'data': 'description'},
                {'data': 'price_cost'},
                {'data': function(data) {
                    var message = "Gravado - Operación Onerosa";
                    switch (parseInt(data.tax_exemption_reason_code)) {
                        case 10: 
                            message = "Gravado – Operación Onerosa";
                            break;
                        case 11: 
                            message = "Gravado – Retiro por premio";
                            break;
                        case 12: 
                            message = "Gravado – Retiro por donación";
                            break;
                        case 13: 
                            message = "Gravado – Retiro";
                            break;
                        case 14: 
                            message = "Gravado – Retiro por publicidad";
                            break;
                        case 15: 
                            message = "Gravado – Bonificaciones";
                            break;
                        case 16: 
                            message = "Gravado – Retiro por entrega a trabajadores";
                            break;
                        case 17: 
                            message = "Gravado – IVAP";
                            break;
                        case 20: 
                            message = "Exonerado - Operación Onerosa";
                            break;
                        case 21: 
                            message = "Exonerado – Transferencia Gratuita";
                            break;
                        case 30: 
                            message = "Inafecto - Operación Onerosa";
                            break;
                        case 31: 
                            message = "Inafecto – Retiro por Bonificación";
                            break;
                        case 32: 
                            message = "Inafecto – Retiro";
                            break;
                        case 33: 
                            message = "Inafecto – Retiro por Muestras Médicas";
                            break;
                        case 34: 
                            message = "Inafecto - Retiro por Convenio Colectivo";
                            break;
                        case 35: 
                            message = "Inafecto – Retiro por premio";
                            break;
                        case 36: 
                            message = "Inafecto - Retiro por publicidad";
                            break;
                        case 40: 
                            message = "Exportación";
                            break;
                        case 7152: 
                            message = "IMPUESTO A BOLSAS PLASTICAS - ICBPER";
                            break;
                        default:
                            break;
                    }
                    return message;
                }},
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data) {
                    if (data.flag_active == 0) { 
                            // '<button type="button" disabled class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-exchange"></i></button><span> </span>' +
                            // '<button type="button" disabled class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-bar-chart"></i></button><span> </span>' +
                        return '<button type="button" onClick="editProduct(' + data.id + ')" class="btn btn-warning btn-xs" style="width: 25px;"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-default btn-xs" style="width: 25px;"><i class="fa fa-cubes"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-usd"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-key"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-danger btn-xs" style="width: 25px;"><i class="fa fa-trash"></i></button><span> </span>';
                    } else {
                            // '<button type="button" onClick="goToTransfers(' + data.id + ');" class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-exchange"></i></button><span> </span>' +
                            // '<button type="button" onClick="goToKardex(' + data.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-bar-chart"></i></button><span> </span>' +
                        var message = '<button title="Editar producto" type="button" onClick="editProduct(' + data.id + ')" class="btn btn-warning btn-xs" style="width: 25px;"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button title="Asignar área" type="button" onClick="areaProduct(' + data.id + ');" class="btn btn-default btn-xs" style="width: 25px;"><i class="fa fa-cubes"></i></button><span> </span>' +
                            '<button title="Lista de precios" type="button" onClick="priceListProduct(' + data.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-usd"></i></button><span> </span>' +
                            '<button title="Administración de series" type="button" onClick="getSerialsByProduct(' + data.id + ');" class="btn btn-info btn-xs" style="width: 25px;"><i class="fa fa-key"></i></button><span> </span>' +
                            '<button title="Eliminar producto" type="button" onClick="deleteProductModal(' + data.id + ');" class="btn btn-danger btn-xs" style="width: 25px;"><i class="fa fa-trash"></i></button><span> </span>';
                        if (data.company_id == 534) {
                            var ecommerceInfo = false;
                            data.stocks.forEach(element => {
                                if (element.json_ecommerce != null) {
                                    ecommerceInfo = true;
                                }
                            });
                            if (ecommerceInfo) {
                                message = message +
                                '<button type="button" onClick="updateEcommerceModal(' + data.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-shopping-cart"></i></button><span> </span>';
                            } else {
                                message = message +
                                '<button type="button" onClick="updateEcommerceModal(' + data.id + ');" class="btn btn-default btn-xs" style="width: 25px;"><i class="fa fa-shopping-cart"></i></button><span> </span>';
                            }
                        }
                        return message;
                    }
                }}
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.flag_active == 0) {
                    $node.addClass('danger');
                }
            },
        });
        }

        var priceListTable = $('tablePriceList').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "serverSide": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
        });

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
            }
        )
        //Listeners
        var searchProduct = document.getElementById('searchInput');
        searchProduct.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                $('#searchButton').trigger('click');
            }
        });
        getSerialsByProduct = function(id) {
            $.ajax({
                url: '/api/serials-by-product/' + id,
                context: document.body,
                method: "GET",
                statusCode: {
                }
            }).done(function(response){
                var tBodySerials = document.getElementById('tBodySerials');
                if (tBodySerials != null) {
                    tBodySerials.innerHTML = '';
                    var textTr = '';
                    response.forEach(element => {
                        textTr = textTr + '<tr><td>' + element.serial + '</td><td>' + element.imei + '</td></tr>';
                    });
                    tBodySerials.innerHTML = textTr;
                }
            });
            $("#modal-serials").modal({backdrop: 'static', keyboard: false});
        }
        goToKardex = function(id) {
            var product___ = arrayProducts[id];
            location = "/kardex/" + product___.code;
        }
        completeExport = function() {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            $.get('/api/products', {
                searchInput: $('#searchInput').val(),
                categoryId: $('#categoryId').val(),
                parent: $('#parent').val(),
                allProducts: true,
            }, function(res) {
                var a = document.createElement("a");
                a.href = res.full;
                a.download = res.file;
                document.body.appendChild(a);
                a.click();
                $('#modal-on-load').modal('toggle');
            })
            .fail(function() {
                $('#modal-on-load').modal('toggle');
                alert("La exportación a excel es demasiado grande. Por favor, pruebe con otros filtros");
            });
        }
        taxTypeAffection = function() {
            $('#modal-type-affection').modal({ backdrop: 'static', keyboard: false });
            var multipleTypeAffection = document.getElementById('multipleTypeAffection');
            if (multipleTypeAffection != null) {
                multipleTypeAffection.value = 0;
            }
        }
        multipleTypeAffectionSubmit = function() {
            var multipleTypeAffection = document.getElementById('multipleTypeAffection');
            if (multipleTypeAffection != null) {
                // validations
                if (checkedProducts.length > 0) {
                    if (parseInt(multipleTypeAffection.value) !== 0) {
                        var btnMultipleTypeAffection = document.getElementById('btnMultipleTypeAffection');
                        if (btnMultipleTypeAffection != null) {
                            btnMultipleTypeAffection.disabled = true;
                            // call onLoad
                            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
                            // call api
                            $.ajax({
                                method: "PATCH",
                                url: "/api/products-multiple-update",
                                context: document.body,
                                data: {
                                    condition: "typeAffection",
                                    checkedProducts: checkedProducts,
                                    multipleTypeAffection: multipleTypeAffection.value,
                                    searchInput: $('#searchInput').val(),
                                    categoryId: $('#categoryId').val(),
                                    brandId: $('#brandId').val(),
                                    parent: $('#parent').val(),
                                    stateId: $('#stateId').val(),
                                },
                                statusCode: {
                                    400: function() {
                                        $('#modal-on-load').modal('toggle');
                                        alert('No se culminar la operación. Comuníquese con soporte.');
                                    },
                                    404: function() {
                                        $('#modal-on-load').modal('toggle');
                                        alert('No se culminar la operación. Comuníquese con soporte.');
                                    },
                                    500: function() {
                                        $('#modal-on-load').modal('toggle');
                                        alert('No se culminar la operación. Comuníquese con soporte.');
                                    }
                                }
                            }).done(function(response) {
                                // api response
                                checkedProducts = [];
                                $('#modal-on-load').modal('toggle');
                                $('#modal-type-affection').modal('toggle');
                                btnMultipleTypeAffection.disabled = false;
                                alert("Cambio de tipo de afectación realizado correctamente.");
                                $('#searchButton').trigger('click');
                            });
                        }
                    } else {
                        alert("Debe seleccionar una opción");
                    }
                } else {
                    alert("Debe seleccionar al menos un producto.");
                }
            }
        }
        priceManagement = function() {
            $('#modal-massive-price').modal({ backdrop: 'static', keyboard: false });
            var massivePriceWarehouse = document.getElementById('massivePriceWarehouse');
            if (massivePriceWarehouse != null) {
                massivePriceWarehouse.value = 0;
            }
        }
        priceManagementSubmit = function() {
            var massivePriceWarehouse = document.getElementById('massivePriceWarehouse');
            if (massivePriceWarehouse != null) {
                // validations
                if (checkedProducts.length > 0) {
                    var btnPriceManagement = document.getElementById('btnPriceManagement');
                    if (btnPriceManagement != null) {
                        btnPriceManagement.disabled = true;
                        // call onLoad
                        $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
                        // call api
                        var priceListValues_ = {};
                        priceListValues.forEach(element => {
                            var price = document.getElementById('massive_price_' + element.id).value;
                            var quantity = document.getElementById('massive_quantity_' + element.id).value;
                            var wholeSalePrice = document.getElementById('massive_wholeSalePrice_' + element.id).value;
                            priceListValues_[element.id] = {
                                'price' : price,
                                'quantity' : quantity,
                                'wholeSalePrice' : wholeSalePrice,
                            };
                        });
                        $.ajax({
                            method: "PATCH",
                            url: "/api/products-multiple-update",
                            context: document.body,
                            data: {
                                condition: "price",
                                checkedProducts: checkedProducts,
                                warehouse: massivePriceWarehouse.value,
                                priceList: priceListValues_,
                                searchInput: $('#searchInput').val(),
                                categoryId: $('#categoryId').val(),
                                brandId: $('#brandId').val(),
                                parent: $('#parent').val(),
                                stateId: $('#stateId').val(),
                            },
                            statusCode: {
                                400: function() {
                                    $('#modal-on-load').modal('toggle');
                                    alert('No se culminar la operación. Comuníquese con soporte.');
                                },
                                404: function() {
                                    $('#modal-on-load').modal('toggle');
                                    alert('No se culminar la operación. Comuníquese con soporte.');
                                },
                                500: function() {
                                    $('#modal-on-load').modal('toggle');
                                    alert('No se culminar la operación. Comuníquese con soporte.');
                                }
                            }
                        }).done(function(response) {
                            // api response
                            checkedProducts = [];
                            $('#modal-on-load').modal('toggle');
                            $('#modal-massive-price').modal('toggle');
                            btnPriceManagement.disabled = false;
                            alert("Cambio de precios realizado correctamente.");
                            $('#searchButton').trigger('click');
                        });
                    }
                } else {
                    alert("Debe seleccionar al menos un producto.");
                }
            }
        }
        comissionAssign = function() {
            $("#modal-commission-conf").modal({backdrop: 'static', keyboard: false});
        }
        commissionDeleteAll = function() {
            for (let index = 0; index < commissionCount; index++) {
                commissionDelete(index);
            }
            data.commissions = [];
            commissionCount = 0;
        }
        commissionSubmit = function() {
            for (let index = 0; index < commissionCount; index++) {
                // console.log("Guardando fila " + index);
                var commission = {};
                if (document.getElementById("commissionEmployee_" + index)
                    !== null) {
                    commission.type = 2;
                    commission.employeeId = document.getElementById("commissionEmployee_" + index).value;
                    commission.productId = document.getElementById("commissionProductId_" + index).value;
                    commission.productName = document.getElementById("commissionProductName_" + index).value; 
                    commission.amount = document.getElementById("commissionAmount_" + index).value;
                    commission.operation = document.getElementById("commissionOperation_" + index).value;
                    data.commissions.push(commission);
                }
            }
            // ver json de comisiones
            console.log(data.commissions);
            var aprove = true;
            data.commissions.forEach(element => {
                if (element.amount == "" || element.employeeId == null) {
                    aprove = false;
                }
            });
            if (aprove == false) {
                data.commissions = [];
                alert('No se pueden agregar las comisiones, verifique que los campos estén llenados correctamente');
            } else {
                $('#modal-on-load').modal('show');
                // call api
                $.ajax({
                method: "POST",
                url: "/api/commissions",
                context: document.body,
                data: {
                    commissions: data.commissions
                },
                statusCode: {
                    400: function() {
                        $('#modal-on-load').modal('toggle');
                        $('#modal-commission-conf').modal('hide');
                        alert('No se culminar la operación. Comuníquese con soporte.');
                    },
                    404: function() {
                        $('#modal-on-load').modal('toggle');
                        $('#modal-commission-conf').modal('hide');
                        alert('No se culminar la operación. Comuníquese con soporte.');
                    },
                    500: function() {
                        $('#modal-on-load').modal('toggle');
                        $('#modal-commission-conf').modal('hide');
                        alert('No se culminar la operación. Comuníquese con soporte.');
                    }
                }
                }).done(function(response) {
                    // api response
                    commissionDeleteAll();
                    $('#modal-commission-conf').modal('hide');
                    $('#modal-on-load').modal('hide');
                });
            }
        }
        commissionDelete = function(id) {
            console.log("Se borró la comisión de posición: " + id);
            if (document.getElementById('div_commissionEmployee_' + id) !== null ) {
                document.getElementById("br_commissionEmployee_" + id).remove();
                document.getElementById("div_commissionEmployee_" + id).remove();
                // document.getElementById("commissionEmployee_" + id).remove();
                document.getElementById("div_commissionProduct_" + id).remove();
                // document.getElementById("br_commissionProduct_" + id).remove();
                // document.getElementById("commissionProductId_" + id).remove();
                // document.getElementById("commissionProductName_" + id).remove();
                document.getElementById("br_commissionDetails_" + id).remove();
                document.getElementById("div_commissionAmount_" + id).remove();
                document.getElementById("div_commissionOperation_" + id).remove();
                // document.getElementById("commissionAmount_" + id).remove();
                // document.getElementById("commissionOperation_" + id).remove();
                document.getElementById("br_comissionDelete_" + id).remove();
                document.getElementById("comissionDelete_" + id).remove();                
            }
        }
        commissionUpdate = function() {
            // agregar search de products
            arrayCommission.push(data.productSearchComission);
            // commisionEmployees
            var commisionEmployees = document.getElementById('commisionEmployees');
            if (commisionEmployees != null) {
                var newObject = document.createElement('div');
                // newObject.setAttribute("class", "col-md-12");
                var textSelect = '<br id="br_commissionEmployee_' + commissionCount + '"/>'+
                        '<div style="float: left; padding-bottom: 10px" id="div_commissionEmployee_' + commissionCount + '">'+
                            '<select id="commissionEmployee_' + commissionCount + '" class="form-control"  style="width: 200px">'+
                            '<option selected="true" value="null">SELECCIONE EMPLEADO</option>';
                employeesJson.forEach(element => {
                    textSelect = textSelect + '<option value='+ element.id +'>' + element.name +  ' ' + element.lastname + '</option>';
                });
                textSelect = textSelect + '</select></div>';
                newObject.innerHTML = textSelect;
                commisionEmployees.appendChild(newObject);                
            }
            // commisionProducts
            var commisionProducts = document.getElementById('commisionProducts');
            if (commisionProducts != null) {
                var newObject = document.createElement('div');
                newObject.setAttribute("id", "div_commissionProduct_" + commissionCount);
                newObject.setAttribute("align", "center");
                var textSelect = '<br id="br_commissionProduct_' + commissionCount + '"/>' +
                    '<div style="float: left; padding-left: 10px; padding-bottom: 10px">'+
                        '<input id="commissionProductId_' + commissionCount + '" type="hidden" value="' + data.productSearchComission.id + '">' +
                        '<input style="width: 280px" id="commissionProductName_' + commissionCount + '" type="text" class="form-control" readonly value="' + data.productSearchComission.name + ' - ' + data.productSearchComission.code + '">'+
                    '</div>';
                newObject.innerHTML = textSelect;
                commisionProducts.appendChild(newObject);
            }
            // commisionDetails
            var commisionDetails = document.getElementById('commisionDetails');
            if (commisionDetails != null) {
                var newObject = document.createElement('div');
                var textSelect = '<br id="br_commissionDetails_' + commissionCount + '"/>'+
                    '<div>'+
                        '<div style="float: left; padding-left: 10px; padding-bottom: 10px" id="div_commissionAmount_' + commissionCount + '">'+
                            '<input type="number" autocomplete="off" class="form-control" id="commissionAmount_' + commissionCount + '" placeholder="#" style="width: 50px">'+
                        '</div>'+
                        '<div style="float: left; padding-left: 10px; padding-bottom: 10px" id="div_commissionOperation_' + commissionCount + '">'+
                            '<select id="commissionOperation_' + commissionCount + '" class="form-control"  style="width: 70px">'+
                                '<option value="1">%</option>'+
                                '<option value="2">S/.</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>';
                newObject.innerHTML = textSelect;
                commisionDetails.appendChild(newObject);
            }
            // commisionOptions
            var commisionOptions = document.getElementById('commisionOptions');
            if (commisionOptions != null) {
                var newObject = document.createElement('div');
                newObject.setAttribute("align", "center");
                var textSelect = '<br id="br_comissionDelete_' + commissionCount + '"/>'+
                    '<div style="float: left; padding-left: 10px; padding-bottom: 10px">' +
                        '<button type="button" class="btn btn-danger btn-flat" id="comissionDelete_' + commissionCount + '" onClick="commissionDelete(' + commissionCount + ');">'+
                            '<i class="fa fa-trash">'+
                        '</button>'+
                    '</div>';
                newObject.innerHTML = textSelect;
                commisionOptions.appendChild(newObject);
            }
            commissionCount++;
            document.getElementById('searchProduct').value = "";
        }

        editProduct = function(id) {
            selectedProduct = id;
            data.validCode = true;
            var productCode = document.getElementById('productCode');
            productCode.style.borderColor = "#4cae4c";
            data.validCode = true;
            var product = arrayProducts[selectedProduct];
            document.getElementById('productCode').value = product.code;
            document.getElementById('productAutoBarCode').value = product.auto_barcode;
            document.getElementById('productName').value = product.name;
            document.getElementById('productForeignName').value = product.foreign_name;
            document.getElementById('productModel').value = product.model;
            document.getElementById('productDescription').value = product.description;
            document.getElementById('allotmentType').value = product.allotment_type;
            document.getElementById('productTaxExemptionReasonCode').value = product.tax_exemption_reason_code;
            document.getElementById('productTypeOperation').value = product.flag_operation;
            document.getElementById('productType').value = product.type;
            document.getElementById('productCategory').value = product.category_id;
            document.getElementById('productBrand').value = product.brand_id;
            document.getElementById('productFlagUniversalPromo').value = product.flag_universal_promo;
            document.getElementById('productWeight').value = product.weigth;
            document.getElementById('productCurrency').value = product.currency;
            document.getElementById('productUnity').value = product.unit_id;
            document.getElementById('productMinPrice').value = product.min_price;
            document.getElementById('productMaxPrice').value = product.max_price;
            document.getElementById('productPriceCost').value = product.price_cost;
            document.getElementById('productImage').value = '';
            document.getElementById('productFlagActive').value = product.flag_active;
            data.urlImage = product.url_image;
            document.getElementById('allotmentType').disabled = false;
            $("#modal-edit-product").modal({backdrop: 'static', keyboard: false});
        }
        editProductSubmit = function() {
            var dataSend = {};
            if (data.validCode) {
                dataSend.code = document.getElementById('productCode').value.toUpperCase();
                dataSend.currency = document.getElementById('productCurrency').value;
                dataSend.name = document.getElementById('productName').value.toUpperCase();
                dataSend.description = document.getElementById('productDescription').value.toUpperCase();
                dataSend.type = document.getElementById('productType').value;
                dataSend.flagOperation = document.getElementById('productTypeOperation').value;
                dataSend.model = document.getElementById('productModel').value.toUpperCase();
                dataSend.weigth = document.getElementById('productWeight').value;
                dataSend.unitId = document.getElementById('productUnity').value;
                dataSend.allotmentType = document.getElementById('allotmentType').value;
                dataSend.taxExemptionReasonCode = document.getElementById('productTaxExemptionReasonCode').value;
                dataSend.setting = false;
                dataSend.categoryId = document.getElementById('productCategory').value;
                dataSend.brandId = document.getElementById('productBrand').value;
                dataSend.autoBarcode = document.getElementById('productAutoBarCode').value.toUpperCase();
                dataSend.foreignName = document.getElementById('productForeignName').value.toUpperCase();
                dataSend.flagUniversalPromo = document.getElementById('productFlagUniversalPromo').value;
                dataSend.minPrice = document.getElementById('productMinPrice').value;
                dataSend.maxPrice = document.getElementById('productMaxPrice').value;
                dataSend.priceCost = document.getElementById('productPriceCost').value;
                dataSend.flagActive = document.getElementById('productFlagActive').value;
                dataSend.urlImage = data.urlImage;
                $.ajax({
                    method: "PATCH",
                    url: "/api/products/" + selectedProduct,
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            alert('No se pudo editar el producto. Verifique los campos NOMBRE, CÓDIGOS, DESCRIPCIÓN Y MODELO.');
                        },
                        404: function() {
                            alert('No se pudo editar el producto. El producto no existe.');
                        },
                        500: function() {
                            alert('No se pudo editar el producto. Verifique la información ingresada e inténtelo nuevamente.');
                        }
                    }
                }).done(function(response) {
                    selectedProduct = 0;
                    $('#modal-edit-product').modal('toggle');
                    $('#searchButton').trigger('click');
                });
            } else {
                alert("Ingrese un código de producto válido");
            }
        }
        goToTransfers = function(id) {
            var product___ = arrayProducts[id];
            location = "/new-transfer/" + product___.code;
        }
        priceListProduct = function(id) {
            var btnPricelist = document.getElementById('btnPricelist');
            if (btnPricelist != null) {
                btnPricelist.innerHTML = 'GUARDAR';
            }
            selectedProduct = id;
            priceListValues.forEach(element => {
                //INPUT DISABLED TRUE
                document.getElementById('price_' + element.id).readOnly = false;
                document.getElementById('quantity_' + element.id).readOnly = false;
                document.getElementById('wholeSalePrice_' + element.id).readOnly = false;
                //INPUT SET VALUES
                document.getElementById('price_' + element.id).value = "0";
                document.getElementById('quantity_' + element.id).value = "0";
                document.getElementById('wholeSalePrice_' + element.id).value = "0";
            });
            var warehouseDestiny_ = document.getElementById('warehouseDestiny');
            if (warehouseDestiny_ != null) {
                warehouseDestiny_.value = document.getElementById('warehouseId').value;
            }
            var warehouseDestiny  = warehouseDestiny_.value;
            // GET PRICELIST BY PRODUCTID AND WAREHOUSEID
            warehouseDestiny_.disabled = true;
            $.ajax({
                url: '/api/product-warehouse-price-list/' + id + '/' + warehouseDestiny,
                context: document.body,
                method: "GET",
                statusCode: {
                    400 : function() {
                        priceListValues.forEach(element => {
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = false;
                            document.getElementById('quantity_' + element.id).readOnly = false;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = false;
                        });
                        warehouseDestiny_.disabled = false;
                    }, 
                    401 : function() {
                        priceListValues.forEach(element => {
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = false;
                            document.getElementById('quantity_' + element.id).readOnly = false;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = false;
                        });
                        warehouseDestiny_.disabled = false;
                    },
                    404 : function() {
                        priceListValues.forEach(element => {
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = true;
                            document.getElementById('quantity_' + element.id).readOnly = true;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = true;
                        });
                        warehouseDestiny_.disabled = false;
                        var btnPricelist = document.getElementById('btnPricelist');
                        if (btnPricelist != null && warehouseDestiny != 0) {
                            btnPricelist.innerHTML = 'ESTE PRODUCTO NO SE ENCUENTRA EN EL ALMACÉN SELECCIONADO';
                        } else {
                            btnPricelist.innerHTML = 'GUARDAR';
                        }
                    }, 
                    500 : function() {
                        priceListValues.forEach(element => {
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = false;
                            document.getElementById('quantity_' + element.id).readOnly = false;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = false;
                        });
                        warehouseDestiny_.disabled = false;
                    }, 
                }
            }).done(function(response){
                var btnPricelist = document.getElementById('btnPricelist');
                if (btnPricelist != null) {
                    btnPricelist.innerHTML = 'GUARDAR';
                }
                $.each(response, function(index, value) {
                    //INPUT DISABLED TRUE
                    document.getElementById('price_' + index).readOnly = false;
                    document.getElementById('quantity_' + index).readOnly = false;
                    document.getElementById('wholeSalePrice_' + index).readOnly = false;
                    //INPUT SET VALUES
                    document.getElementById('price_' + index).value = value.price;
                    document.getElementById('quantity_' + index).value = value.quantity;
                    document.getElementById('wholeSalePrice_' + index).value = value.wholeSalePrice;
                });
                warehouseDestiny_.disabled = false;
            });

            $("#modal-price-list").modal({backdrop: 'static', keyboard: false});
        }
        areaProduct = function(id) {
            selectedProduct = id;
            var product = arrayProducts[selectedProduct];
            var areaProductLabelName = document.getElementById('areaProductLabelName');
            if (areaProductLabelName != null) {
                areaProductLabelName.innerHTML = "PRODUCTO: " + product.code + ' - ' + product.name ;
            }
            $("#modal-area-product").modal({backdrop: 'static', keyboard: false});
        }
        searchWarehousePriceList = function() {
            // GET PRICELIST BY PRODUCTID AND WAREHOUSEID
            var warehouseDestiny_ = document.getElementById('warehouseDestiny');
            var warehouseDestiny  = warehouseDestiny_.value;
            // GET PRICELIST BY PRODUCTID AND WAREHOUSEID
            warehouseDestiny_.disabled = true;
            var id = selectedProduct;
            warehouseDestiny_.disabled = true;
            warehouseDestiny = warehouseDestiny_.value;
            $.ajax({
                url: '/api/product-warehouse-price-list/' + id + '/' + warehouseDestiny,
                context: document.body,
                method: "GET",
                statusCode: {
                    400 : function() {
                        priceListValues.forEach(element => {
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = false;
                            document.getElementById('quantity_' + element.id).readOnly = false;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = false;
                        });
                        warehouseDestiny_.disabled = false;
                    },
                    401 : function() {
                        priceListValues.forEach(element => {
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = false;
                            document.getElementById('quantity_' + element.id).readOnly = false;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = false;
                        });
                        warehouseDestiny_.disabled = false;
                    },
                    404 : function() {
                        priceListValues.forEach(element => {
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = true;
                            document.getElementById('quantity_' + element.id).readOnly = true;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = true;
                            // VALUES
                            document.getElementById('price_' + element.id).value = 0.00;
                            document.getElementById('quantity_' + element.id).value = 0.00;
                            document.getElementById('wholeSalePrice_' + element.id).value = 0.00;
                        });
                        warehouseDestiny_.disabled = false;
                        var btnPricelist = document.getElementById('btnPricelist');
                        btnPricelist.innerHTML = 'ESTE PRODUCTO NO SE ENCUENTRA EN EL ALMACÉN SELECCIONADO';
                    }, 
                    500 : function() {
                        priceListValues.forEach(element => {    
                            //INPUT DISABLED TRUE
                            document.getElementById('price_' + element.id).readOnly = false;
                            document.getElementById('quantity_' + element.id).readOnly = false;
                            document.getElementById('wholeSalePrice_' + element.id).readOnly = false;
                        });
                        warehouseDestiny_.disabled = false;
                    }, 
                }
            }).done(function(response){
                var btnPricelist = document.getElementById('btnPricelist');
                if (btnPricelist != null) {
                    btnPricelist.innerHTML = 'GUARDAR';
                }
                $.each(response, function(index, value) {
                    //INPUT DISABLED TRUE
                    document.getElementById('price_' + index).readOnly = false;
                    document.getElementById('quantity_' + index).readOnly = false;
                    document.getElementById('wholeSalePrice_' + index).readOnly = false;
                    //INPUT SET VALUES
                    document.getElementById('price_' + index).value = value.price;
                    document.getElementById('quantity_' + index).value = value.quantity;
                    document.getElementById('wholeSalePrice_' + index).value = value.wholeSalePrice;
                });
                warehouseDestiny_.disabled = false;
            });
        }
        updateEcommerceModal = function(id) {
            selectedProduct = id;
            var product = arrayProducts[selectedProduct];
            var ecommerceProductLabel = document.getElementById('ecommerceProductLabel');
            if (ecommerceProductLabel != null) {
                ecommerceProductLabel.innerHTML = product.code + ' - ' + product.name;
            }
            $('#modal-ecommerce').modal({ backdrop: 'static', keyboard: false });
        }
        searchEcommerceByWarehouse = function() {
            var warehouseId = document.getElementById('warehouseEcommerceDestiny').value;
            var product = arrayProducts[selectedProduct];
            var jsonEcommerce = null;
            product.stocks.forEach(element => {
                if (parseInt(element.warehouse_id) == parseInt(warehouseId)) {
                    jsonEcommerce = element.json_ecommerce;
                }
            });
            if (jsonEcommerce != null) {
                // jsonEcommerce = JSON.parse(jsonEcommerce);
                $('#ecommerce_productId').val(jsonEcommerce.shopify.productId);
                $('#ecommerce_variantId').val(jsonEcommerce.shopify.variantId);
            } else {
                $('#ecommerce_productId').val(0);
                $('#ecommerce_variantId').val(0);
            }
        }
        updateEcommerceSubmit = function() {
            var warehouseId = document.getElementById('warehouseEcommerceDestiny').value;
            var jsonEcommerce = null;
            switch (parseInt(warehouseId)) {
                // rebelsclo.com
                case 890:
                    jsonEcommerce = {
                        "shopify": {
                            "store": "testmehrebels.myshopify.com",
                            "apiKey": "cc8bbc52fc074235cb81a401eb467acb",
                            "secret": "2fc6ecef3784cce98552555ff0870a59",
                            "warehouseId": parseInt(warehouseId),
                            "warProductId": parseInt(selectedProduct),
                            "productId": $('#ecommerce_productId').val(),
                            "variantId": $('#ecommerce_variantId').val(),
                            "exampleUrl": "https://cc8bbc52fc074235cb81a401eb467acb:2fc6ecef3784cce98552555ff0870a59@testmehrebels.myshopify.com/admin/api/2019-10/orders.json",
                            "sharedSecret": "407db21d5005e54600a632f4d236e06d"
                        }
                    };
                    break;
                // mehperu.com
                case 1153:
                    jsonEcommerce = {
                        "shopify": {
                            "store": "pruebasrebmeh.myshopify.com",
                            "apiKey": "79ea93580c87a34ee3eac8787e93eab5",
                            "secret": "589cff2eca4650d3eacfac6a981593f0",
                            "warehouseId": parseInt(warehouseId),
                            "warProductId": parseInt(selectedProduct),
                            "productId": $('#ecommerce_productId').val(),
                            "variantId": $('#ecommerce_variantId').val(),
                            "exampleUrl": "https://79ea93580c87a34ee3eac8787e93eab5:589cff2eca4650d3eacfac6a981593f0@pruebasrebmeh.myshopify.com/admin/api/2019-10/orders.json",
                            "sharedSecret": "04611ce68503388bdf6a773aee0790e7"
                        }
                    };
                    break;
                default:
                    break;
            }
            $.ajax({
                method: "PATCH",
                url: "/api/warehouse-product-ecommerce",
                context: document.body,
                data: jsonEcommerce,
                statusCode: {
                    401: function() {
                        alert('Hubo un problema al actualizar. Posiblemente no se encontró el producto en ese almacén/tienda.');
                    }
                }
            }).done(function(response) {
                $('#ecommerce_productId').val(0)
                $('#ecommerce_variantId').val(0)
                $('#searchButton').trigger('click');
            });
        }
        deleteProductModal = function(id) {
            selectedProduct = id;
            var product = arrayProducts[selectedProduct];
            var deletedSaleText = document.getElementById('deletedSaleText');
            if (deletedSaleText != null) {
                deletedSaleText.innerHTML = '¿Desea eliminar al producto: (' + product.code + ') ' + product.name + '?';
            }
            $('#modal-danger').modal({ backdrop: 'static', keyboard: false });
        }
        deleteProductSubmit = function() {
            if (selectedProduct != 0) {
                var comment = document.getElementById('deleteComment').value;
                $.ajax({
                    url: "/api/products/" + selectedProduct + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            selectedProduct = 0;
                            alert("No se puede eliminar un producto que haya sido vendido");
                        },
                        401: function() {
                            selectedProduct = 0;
                            alert("Su sesión ha finalizado");
                        },
                        500: function() {
                            selectedProduct = 0;
                            alert("Error interno, por favor verifique su conexión");
                        }
                    }
                }).done(function(response) {
                    selectedProduct = 0;
                    $('#modal-danger').modal('toggle');
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo eliminar la venta con id " + selectedProduct);
            }
        }
        areaProductSubmit = function() {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            $.get('/api/products-area-update', {
                productId: selectedProduct,
                areaId: $('#areaId').val(),
                warehouseId: $('#warehouseDestinyArea').val(),
            }, function(res) {
                $('#modal-on-load').modal('toggle');
                alert("La actualización de área se realizó correctamente.");
            })
            .fail(function() {
                $('#modal-on-load').modal('toggle');
                alert("No se pudo cambiar el área del producto. Verifique la información e inténtelo nuevamente.");
            });
        }
        priceListSubmit = function() {
            var priceListValues_ = {};
            var warehouseDestiny = document.getElementById('warehouseDestiny').value;
            priceListValues.forEach(element => {
                var price = document.getElementById('price_' + element.id).value;
                var quantity = document.getElementById('quantity_' + element.id).value;
                var wholeSalePrice = document.getElementById('wholeSalePrice_' + element.id).value;
                priceListValues_[element.id] = {
                    'price' : price,
                    'quantity' : quantity,
                    'wholeSalePrice' : wholeSalePrice,
                };
            });
            var dataSend = {
                'product_id': selectedProduct,
                'warehouse_id' : warehouseDestiny,
                'price_list' : priceListValues_,
            };
            $.ajax({
                method: "PATCH",
                url: "/api/warehouse-product-price-list",
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        alert('Ese producto no existe en ese almacén/tienda.');
                    }
                }
            }).done(function(response) {
                console.log(response);
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
            document.getElementById('productDetailAutoBarCode').innerHTML = product.auto_barcode;
            document.getElementById('productDetailCategory').innerHTML = product.category_name;
            document.getElementById('productDetailModel').innerHTML = product.model;
            document.getElementById('productDetailBrand').innerHTML = product.brand_name;
            if (product.url_image != null) {
                document.getElementById('productDetailImage').src = product.url_image;
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
                        var priceList = Object.keys(element.price_list)[0];
                        priceList = element.price_list[priceList];
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
        goToCreateChilds = function(id) {
            location = 'new-product?parentId=' + id;
        }
        checkedAll = function() {
            var checkedAllButton = document.getElementById('checkedAllButton');
            arrayProducts.forEach(element => {
                var checkboxProduct = document.getElementById('checkboxProduct_' + element.id);
                if (checkboxProduct != null) {
                    checkboxProduct.checked = checkedAllButton.checked;
                    if (checkedAllButton.checked) {
                        checkedProducts.push(element.id);
                    }
                }
            });
            if (checkedAllButton.checked) {
                checkedProducts.push('all');
            } else {
                checkedProducts = [];
            }
        }
        checkedProduct = function(id) {
            var checkboxProduct = document.getElementById('checkboxProduct_' + id);
            if (checkboxProduct != null) {
                if (checkboxProduct.checked) {
                    checkedProducts.push(id);
                } else {
                    var checkedProducts_ = [];
                    checkedProducts.forEach(element => {
                        if (element !== id && element !== 'all') {
                            checkedProducts_.push(element);
                        }
                    });
                    checkedProducts = checkedProducts_;
                    var checkedAllButton = document.getElementById('checkedAllButton');
                    if (checkedAllButton != null) {
                        checkedAllButton.checked = false;
                    }

                }
            }
        }
        //LISTENERS
        var productCode = document.getElementById('productCode');
        productCode.addEventListener('change', function() {
            //search for code
            if (productCode.value.length > 0) {
                $.ajax({
                    method: "GET",
                    url: "/api/product-exists/" + productCode.value,
                    context: document.body,
                    statusCode: {
                        400: function() {
                            data.validCode = false;
                            productCode.style.borderColor = "#d9534f";
                        }
                    }
                }).done(function(response) {
                    productCode.style.borderColor = "#4cae4c";
                    data.validCode = true;
                    data.code = productCode.value;
                });
            }
        });
        var productImage = document.getElementById('productImage');
        productImage.addEventListener('change', function() {
            var fileName = productImage.files[0].name;
            var fileSize = productImage.files[0].size;
            var fileType = productImage.files[0].type;
            var fileModifiedDate = productImage.files[0].lastModifiedDate;
            // if (fileSize > maxImageSize) {
            //     alert("Imagen demasiado grande. Máximo permitido de 1Mb");
            // } else {
                getBase64(productImage.files[0], fileType);
            // }
        });

        //AUTOCOMPLETE
        function autocompleteForProducts(inp) {
            var currentFocus;
            var searchBar = document.getElementById('searchBar');
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items-commission");
                    a.setAttribute("style", "z-index: 10; position: absolute;");
                    this.parentNode.appendChild(a);
                    searchBar.style.height = "30px";
                    //LLAMADA AL SERVICIO
                    $.ajax({
                        url: "/api/products-search-for-inventory/" + val + "?noWarehouse=true&tropics=true",
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron productos. Verifique si esta creado");
                            }
                        }
                    }).done(function(response) {
                        if (response.length == 0) {
                            inp.value = "";
                            alert("No se encontraron productos. Verifique si esta creado");
                        } else {
                            for (i = 0; i < response.length; i++) {
                                var nameLastname = response[i].name + ' - ' + response[i].code + ' - ' + response[i].autoBarcode;
                                b = document.createElement("DIV");
                                b.setAttribute('class', 'form-control-autocomplete');
                                b.innerHTML += nameLastname;
                                b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                b.style.cursor = 'pointer';
                                b.addEventListener("click", function(e) {
                                    var iterator = this.getElementsByTagName("input")[0].value;
                                    product = response[iterator];
                                    data.productSearchComission = product;
                                    if (product !== null) {
                                        commissionUpdate();                                        
                                    } else {
                                        alert("Hubo un problema al agregar producto");
                                    }
                                });
                                a.appendChild(b);
                                var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
                            }                          
                        }
                    });
                }
            });
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items-commission");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        // FIRST STEPS
        autocompleteForProducts(document.getElementById('searchProduct'));
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>