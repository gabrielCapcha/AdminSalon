<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    $(document).ready(function() {
        //DATATABLE
        var saleIndexTable  = $('#reports_1').DataTable({
            "scrollX": true,
            "processing": true,
            "fixedHeader": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "serverSide": true,
            "paging": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                $.get('/api/reports-sales-by-product', {
                    limit: data.length,
                    offset: data.start,
                    warehouseId: $('#warehouseId').val(),
                    brandId: $('#brandId').val(),
                    dateRange: $('#dateRange').val(),
                    }, function(res) {
                        callback({
                            recordsTotal: res.total,
                            recordsFiltered: res.total,
                            data: res.data
                        });
                    })
                .fail(function() {
                    callback({
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                    alert( "La consulta es muy grande para ser procesada. Inténlo en otro momento." );
                });
            },
            "columns"    : [
                {'data': function(data) {
                    return data.code;
                }},
                {'data': function(data) {
                    return data.auto_barcode;
                }},
                {'data': function(data) {
                    return data.category_name;
                }},
                {'data': function(data) {
                    return data.brand_name;
                }},
                {'data': function(data) {
                    return data.name;
                }},
                {'data': function(data) {
                    return data.description;
                }},
                {'data': function(data) {
                    // if ($('#warehouseId').val() == 0) {
                    //     return 'TODAS LAS TIENDAS';
                    // } else {
                    // }
                    return data.warehouse_name;
                }},
                {'data': function(data) {
                    return data.type_document_name;
                }},
                {'data': function(data) {
                    return data.created_at.substring(0,10);
                }},
                {'data': function(data) {
                    return data.created_at.substring(11,20);
                }},
                {'data': function(data) {
                    var message = data.serie + '-' + ("000000" + data.number).slice(-8);
                    if (data.ticket != null) {
                        message = data.ticket;
                    }
                    return message;
                }},
                {'data': function(data) {
                    return data.type_payment_name;
                }},
                {'data': function(data) {
                    if (data.amount_plus_discount == null) {
                        var discount = 0.00;
                        if (data.discount != null) {
                            discount = parseFloat(data.discount);
                        }
                        return (parseFloat(data.price) + discount).toFixed(2);
                    } else {
                        return parseFloat(data.amount_plus_discount).toFixed(2);
                    }
                }},
                {'data': function(data) {
                    if (data.discount == null) {
                        return "0.00";
                    } else {
                        return parseFloat(data.discount).toFixed(2);
                    }
                }},
                {'data': function(data) {
                    return parseFloat(data.price).toFixed(2);
                }},
                {'data': function(data) {
                    return parseFloat(data.quantity).toFixed(2);
                }},
                {'data': function(data) {
                    if (data.amount_plus_discount != null) {                     
                        return (parseFloat(data.amount_plus_discount)*parseFloat(data.quantity)).toFixed(2);   
                    } else {
                        return (parseFloat(data.amount)*parseFloat(data.quantity)).toFixed(2);   
                    }
                }},
                {'data': function(data) {
                    if (parseFloat(data.generalDiscount) > 0) {
                        var discount_ = ((parseFloat(data.price)*parseFloat(data.generalDiscount))/(parseFloat(data.generalDiscount) + parseFloat(data.amount))) * parseFloat(data.quantity);
                        return (discount_).toFixed(2);
                    } else {
                        return "0.00";
                    }
                }},
                {'data': function(data) {
                    var discount_ = ((parseFloat(data.price)*parseFloat(data.generalDiscount))/(parseFloat(data.generalDiscount) + parseFloat(data.amount)));
                    return '<b>' + ((parseFloat(data.price) - discount_) * parseFloat(data.quantity)).toFixed(2) + '</b>';
                }},
                {'data': function(data) {
                    var discount_ = ((parseFloat(data.price)*parseFloat(data.generalDiscount))/(parseFloat(data.generalDiscount) + parseFloat(data.amount)));
                    return (parseFloat(data.price) - discount_).toFixed(2);
                }},
                {'data': function(data) {
                    return data.employee_name;
                }},
                {'data': function(data) {
                    return data.customer_name;
                }},
                {'data': function(data) {
                    return data.rz_social;
                }},
                {'data': function(data) {
                    return data.dni;
                }},
                {'data': function(data) {
                    return data.ruc;
                }},
                {'data': function(data) {
                    return data.address;
                }},
                {'data': function(data) {
                    return data.phone;
                }}
            ],
            "responsive": true
        });
        //DATATABLE
        $('#searchButton').on('click', function(e) {
            saleIndexTable.ajax.reload();
            saleIndexTable.search( this.value ).draw();
        });
        $('.filter').on('click', function(e){
            e.stopPropagation();
        });
        //Date range picker
        $('#dateRange').daterangepicker(
            {
                timePicker: true,
                timePickerIncrement: 1,
                timeZone: 'America/Lima',
                locale: {
                    "format": "DD/MM/YYYY hh:mm A",
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

        exportToXls = function() {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            $.get('/api/reports-sales-by-product', {
                warehouseId: $('#warehouseId').val(),
                brandId: $('#brandId').val(),
                dateRange: $('#dateRange').val(),
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
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>