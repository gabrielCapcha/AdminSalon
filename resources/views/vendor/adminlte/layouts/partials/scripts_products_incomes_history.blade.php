<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/buttons/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.print.min.js') }}" type="text/javascript"></script>

<script>
    var detailModal;
    var downloadXls;
    $(function () {
        var data = {};
        var arrayIncomes = [];
        var count = 0;
        $('#inventoryRecords').DataTable({
            "scrollX": true,
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'order'       : [[ 0, "desc" ]],
            'info'        : true,
            'autoWidth'   : true,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
            ],
            "bDestroy": true,
            "ajax": function(data, callback, settings) {
                    $.get('/api/inventory-records', {
                        limit: data.length,
                        offset: data.start,
                        }, function(res) {
                            count = res.length;
                            res.forEach(element => {
                                arrayIncomes[element.id] = element;
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
                    return count--;
                }},
                {'data': function (data) {
                    return data.serie + '-' + ("000000" + data.number).slice(-8);
                }},
                {'data': function (data, type, dataToSet) {
                    var message = 'INGRESO DE MERCADERÍA';
                    if (data.warehouse != null) {
                        message = data.warehouse.name;
                    }
                    return message;
                }},
                {'data': function (data) {
                    return data.name.toUpperCase();
                }},
                {'data': function (data) {
                    if (data.commentary != null) {
                        return data.commentary.toUpperCase();                        
                    } else {
                        return "";
                    }
                }},
                {'data': function (data, type, dataToSet) {
                    var d = new Date(data.createdAt),
                    dformat = [
                        ("00" + d.getDate()).slice(-2),
                        ("00" + (d.getMonth()+1)).slice(-2),
                        ("0000" + d.getFullYear()).slice(-4),
                    ].join('/');
                    return dformat;
                }},
                {'data': function (data, type, dataToSet) {
                    var d = new Date(data.createdAt),
                    dformat = [
                        ("00" + d.getHours()).slice(-2),
                        ("00" + d.getMinutes()).slice(-2),
                        ("00" + d.getSeconds()).slice(-2),
                    ].join(':');
                    return dformat;
                }},
                // {'data': function (data, type, dataToSet) {
                //     var dateL = data.registerDate;
                //     if (data.registerDate == null) {
                //         dateL = data.createdAt;
                //     }
                //     var d = new Date(dateL),
                //     dformat = [
                //         ("00" + d.getDate()).slice(-2),
                //         ("00" + (d.getMonth()+1)).slice(-2),
                //         ("0000" + d.getFullYear()).slice(-4),
                //     ].join('/');
                //     return dformat;
                // }},
                // {'data': function (data, type, dataToSet) {
                //     var dateL = new Date(data.registerDate);
                //     if (data.registerDate == null) {
                //         dateL = data.createdAt;
                //     }
                //     var d = new Date(dateL),
                //     dformat = [
                //         ("00" + d.getHours()).slice(-2),
                //         ("00" + d.getMinutes()).slice(-2),
                //         ("00" + d.getSeconds()).slice(-2),
                //     ].join(':');
                //     return dformat;
                // }},
                {'data': function (data, type, dataToSet) {
                    return data.details.length + ' productos';
                }},
                {'data': function (data, type, dataToSet) {
                    return '<button type="button" onClick="detailModal(' + data.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-list-ul"></i></button><span> </span>';
                }}
            ]
        });

        changeQuantityModal = function(detailId) {
            var tdQuantity_ = document.getElementById('tdQuantity_' + detailId);
            if (tdQuantity_ != null) {
                tdQuantity_.innerHTML = '<input class="form-control" style="width:100%;" type="number" onClick="this.select();" step=0.1 id="inputQuantity_'+ detailId +'" value="'+ tdQuantity_.innerText +'">';
                var btnChangeQuantity_ = document.getElementById('btnChangeQuantity_' + detailId);
                if (btnChangeQuantity_ != null) {
                    btnChangeQuantity_.className = 'btn btn-success';
                    btnChangeQuantity_.innerHTML = '<i class="fa fa-check"></i>';
                    btnChangeQuantity_.onclick = function(){
                        submitQuantityChange(detailId);
                    };
                }
            } else {
                alert("No se puede editar el ingreso. Comuníquese con soporte.");
            }
        }

        submitQuantityChange = function(detailId) {
            var inputQuantity_ = document.getElementById('inputQuantity_' + detailId);
            if (inputQuantity_ != null) {
                inputQuantity_.readOnly = true;
                var btnChangeQuantity_ = document.getElementById('btnChangeQuantity_' + detailId);
                if (btnChangeQuantity_ != null) {
                    btnChangeQuantity_.className = 'btn btn-warning';
                    btnChangeQuantity_.innerHTML = '<i class="fa fa-check"></i>';
                    btnChangeQuantity_.disabled = true;
                }
                // PATCH
                $.ajax({
                    method: "PATCH",
                    url: "/api/transfer-detail/" + detailId,
                    context: document.body,
                    data: {
                        quantity: inputQuantity_.value
                    },
                    statusCode: {
                        400: function() {
                            alert("No se puede editar el ingreso. Comuníquese con soporte.");
                        },
                        500: function() {
                            alert("No se puede editar el ingreso. Comuníquese con soporte.");
                        }
                    }
                }).done(function(response) {
                    // CONVERT HTML ELEMENTS
                    btnChangeQuantity_.disabled = false;
                    btnChangeQuantity_.onclick = function(){
                        changeQuantityModal(detailId);
                    };
                    var tdQuantity_ = document.getElementById('tdQuantity_' + detailId);
                    if (tdQuantity_ != null) {
                        tdQuantity_.innerHTML = parseFloat(response.quantity).toFixed(2);
                    }
                    var tdDevolution_ = document.getElementById('tdDevolution_' + detailId);
                    if (tdDevolution_ != null) {
                        tdDevolution_.innerHTML = parseFloat(response.devolution).toFixed(2);
                    }
                    var totalPrice_ = document.getElementById('totalPrice_' + detailId);
                    if (totalPrice_ != null) {
                        totalPrice_.innerHTML = (parseFloat(response.quantity)*parseFloat(response.price_cost)).toFixed(2);
                    }
                    var totalCostValue = document.getElementById('totalCostValue');
                    if (totalCostValue != null) {
                        var value_ = parseFloat(totalCostValue.value);
                        totalCostValue.value = (value_ + (parseFloat(response.difference)*parseFloat(response.price_cost))).toFixed(2);
                        document.getElementById('inventoryTitleDetail').innerHTML = 'Detalle de registro de inventariado' + ' <b>' + totalCostValue.value + '</b>';
                    }
                });
            } else {
                alert("No se puede editar el ingreso. Comuníquese con soporte.");
            }
        }

        detailModal = function (id) {
            $.ajax({
                method: 'GET',
                url: '/api/transfer-detail/' + id,
                context: document.body,
            }).done(function(response) {
                //logic response
                var tbodyTransfersPrProduct = document.getElementById('tbodyTransfersPrProduct');
                var table = $('#example1').DataTable();
                table.destroy();
                $("#tbodyTransfersPrProduct tr").remove();
                var total_cost = 0;
                response.forEach(element => {
                    var statusMessage = '<button class="btn btn-warning" id="btnChangeQuantity_'+ element.id +'" onClick="changeQuantityModal(' + element.id + ');"><i class="fa fa-pencil"</button>';
                    // switch (element.status) {
                    //     case 1:
                    //     statusMessage = 'ENVIADO';
                    //         break;
                    //     case 2:
                    //     statusMessage = 'ACEPTADO';
                    //         break;
                    //     case 3:
                    //     statusMessage = 'ENTREGADO';
                    //         break;
                    //     default:
                    //     statusMessage = 'SIN DEFINIR';
                    //         break;
                    // }
                    var total_price = (parseFloat(element.price_cost)*parseFloat(element.quantity)).toFixed(2);
                    var tr = document.createElement('tr');
                    var trText_ = '<td>' + element.name + '</td><td>' + element.code + '</td><td>' + element.auto_barcode + '</td>' +
                        '<td id="tdQuantity_'+ element.id +'">' + element.quantity + '</td><td id="tdDevolution_' + element.id + '">' + 
                        element.devolution + '</td><td>' + element.price_cost + '</td><td id="totalPrice_' + element.id + '">' + total_price +
                        '</td><td>' + statusMessage + '</td>';
                    tr.innerHTML = trText_;
                    tbodyTransfersPrProduct.insertBefore(tr, tbodyTransfersPrProduct.nextSibling);
                    total_cost = parseFloat(total_cost) + parseFloat(total_price);
                });

                document.getElementById('totalCostValue').value = total_cost;
                document.getElementById('inventoryTitleDetail').innerHTML = 'Detalle de registro de inventariado' + ' <b>' + total_cost.toFixed(2) + '</b>';
                
                $('#example1').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : false,
                    'info'        : true,
                    'autoWidth'   : true,
                    "language": {
                        "url": "/js/languages/datatables/es.json"
                    },
                    "dom": 'Bfrtip',
                    "buttons": [
                        'excel', 'pdf'
                    ],
                    "bDestroy": true
                });
                $("#modal-resume").modal({ backdrop: 'static', keyboard: false });
            });
        }
    });
</script>
