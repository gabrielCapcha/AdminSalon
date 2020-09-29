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
<script src="{{ asset('/plugins/buttons/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.print.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                }
        
                return a + b;
            }, 0);
        });
        $('#reports_1 thead tr').clone(true).appendTo( '#reports_1 thead' );
        $('#reports_1 thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input class="filter" type="text" placeholder="'+title+'" />' );
            $( 'input', this ).on( 'keyup change', function () {
                if ( saleIndexTable.column(i).search() !== this.value ) {
                    saleIndexTable.column(i).search( this.value ).draw();
                }
            } );
        } );
        //DATATABLE
        var saleIndexTable  = $('#reports_1').DataTable({
            "scrollX": true,
            "processing": true,
            "orderCellsTop": true,
            "fixedHeader": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            "serverSide": false,
            "paging": true,
            'order': [[ 0, "desc" ]],
            "ordering": true,
            "searching": true,
            "ajax": function(data, callback, settings) {
                $.get('/api/reports-orders', {
                    limit: data.length,
                    offset: data.start,
                    warehouseId: $('#warehouseId').val(),
                    dateRange: $('#dateRange').val(),
                    stateId: $('#stateSaleId').val(),
                    tableCode: $('#tableCode').val(),
                    }, function(res) {
                        callback({
                            recordsTotal: res.data.length,
                            recordsFiltered: res.data.length,
                            data: res.data
                        });
                    });
            },
            "columns"    : [
                {'data': function(data) {
                    return data.warehouse_name;
                }},
                {'data': function(data) {
                    return data.updated_at;
                }},
                {'data': function(data) {
                    return data.ticket;
                }},
                {'data': function(data) {
                    var message = 'INICIADO';
                    switch (data.sal_sale_states_id) {
                        case 1:
                            message = 'INICIADO';
                            break;
                        case 3:
                            message = 'ENTREGADO';
                            break;  
                        case 5:
                            message = 'ENTREGADO';
                            break;  
                        case 8:
                            message = 'ANULADO';
                            break;  
                        default:
                            message = 'INICIADO';
                            break;
                    }
                    return message;
                }},
                {'data': function(data) {
                    return data.table_code;
                }},
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
                    return data.name;
                }},
                {'data': function(data) {
                    return parseFloat(data.price_pr_product).toFixed(2);
                }},
                {'data': function(data) {
                    var message = 'SIN DESPACHAR';
                    if (data.sal_type_document_id != 6) {
                        message = 'DESPACHO DIRECTO';
                    } else {
                        switch (data.flag_active) {
                            case 0:
                                if (data.deleted_by == null || data.deleted_by == 0) {
                                    message = 'DESPACHADO';    
                                } else {
                                    message = 'ANULADO';
                                }
                                break;
                            case 1:
                                message = 'SIN DESPACHAR';
                                break;  
                            default:
                                message = 'SIN DESPACHAR';
                                break;
                        }
                    }
                    return message;
                }},
                {'data': function(data) {
                    if (data.created_by == null) {
                        return 'SIN USUARIO';
                    } else {
                        if (data.employeeCName != null || data.employeeCLastname != null) {
                            return data.employeeCName.toUpperCase() + ' ' + data.employeeCLastname.toUpperCase();
                        } else {
                            return 'SIN USUARIO';
                        }
                    }
                }},
                {'data': function(data) {
                    if (data.deleted_by == null) {
                        return 'SIN USUARIO';
                    } else {
                        if (data.employeeDName != null || data.employeeDLastname != null) {
                            return data.employeeDName.toUpperCase() + ' ' + data.employeeDLastname.toUpperCase();
                        } else {
                            return 'SIN USUARIO';
                        }
                    }
                }},
                {'data': function(data) {
                    return data.commentary;
                }}
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.sal_type_document_id != 6) {
                    $node.addClass('warning');
                } else { 
                    switch (data.flag_active) {
                        case 0:
                            if (data.deleted_by == null || data.deleted_by == 0) {
                                $node.addClass('success');
                            } else {
                                $node.addClass('danger');
                            }
                            break;
                        case 1:
                            $node.addClass('row-green');
                            break;  
                        default:
                            break;
                    }                    
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total stock
                totalS = api
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                // Update footer
                $(api.column(4).footer()).html('TOTAL DE INGRESOS EN PRODUCTOS: ' + parseFloat(totalS).toFixed(2));
            }
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
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>