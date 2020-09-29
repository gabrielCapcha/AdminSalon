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

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    var arraySales = [];
    var deleteSale;
    var deletedSaleId = 0;
    var downloadPdfById;
    var saleDetailModal;
    var deleteSaleSubmit;
    var credit = false;
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
        

        // $('#sale_index thead tr').clone(true).appendTo( '#sale_index thead' );
        // $('#sale_index thead tr:eq(1) th').each( function (i) {
        //     var title = $(this).text();
        //     $(this).html( '<input class="filter" type="text" placeholder="'+title+'" />' );
        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( saleIndexTable.column(i).search() !== this.value ) {
        //             saleIndexTable.column(i).search( this.value ).draw();
        //         }
        //     } );
        // } );

        var saleIndexTable = $('#sale_index').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "columnDefs": [
                {
                    "targets": [7, 8, 9 , 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
                    "className": 'dt-body-right'
                }
            ],
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            "serverSide": false,
            "paging": true,
            "ordering": false,
            "searching": true,
            "order": [[ 26, "desc" ]],
            "ajax": function(data, callback, settings) {
                    $.get('/api/sales-report', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        stateId: $('#stateSaleId').val(),
                        warehouseId: $('#warehouseId').val(),
                        employeeId: $('#employeeId').val(),
                        paymentId: $('#paymentId').val(),
                        dateRange: $('#dateRange').val(),
                        typeDocumentId: $('#typeDocumentId').val(),
                        }, function(res) {
                            arraySales = [];
                            res.data.forEach(element => {
                                arraySales[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.data.length,
                                recordsFiltered: res.data.length,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': function (data) {
                        var message = data.type_document_name;
                        if (message == 'NOTA DE VENTA') {
                            message = 'PRECUENTA';
                        }
                        return message;
                    }
                },
                {'data': function (data) {
                        return data.ticket;
                    }
                },
                {'data': function (data) {
                        if (data.customer_flag_type_person == 2) {
                            return data.customer_ruc;
                        } else {
                            return data.customer_dni;
                        }
                    }
                },
                {'data': function (data) {
                        if (data.customer_rz_social != null) {
                            return data.customer_rz_social;
                        } else if (data.customer_lastname != null || data.customer_name != null) {
                            return ((data.customer_lastname != null) ? data.customer_lastname : '')  + ' ' + ((data.customer_name != null) ? data.customer_name : '');
                        } else {
                            return 'SIN INFORMACIÓN';
                        }
                    }
                },
                {'data': function (data) {
                        return data.employee_name + ", " + data.employee_lastname;
                    }
                },
                {'data': function (data) {
                        var message = 'SIN INFORMACIÓN';
                        if (data.remission_guide != null) {
                            message = data.remission_guide;
                        } else {
                            if (data.data_client[0].quotationTypeDocument != undefined) {
                                switch (data.data_client[0].quotationTypeDocument) {
                                    case 2:
                                        message = 'BOLETA';
                                        break;
                                    case 3:
                                        message = 'FACTURA';
                                        break;
                                    case 1:
                                        message = 'PRECUENTA';
                                        break;
                                    default:
                                        message = 'SIN INFORMACIÓN';
                                        break;
                                }
                            } else {
                                if (data.data_client[0].quotationAffected != undefined) {
                                    message = data.data_client[0].quotationAffected[0].ticket;
                                }
                            }
                        }
                        return message;
                    }
                },
                {'data': 'sale_state_name'},
                {'data': 'currency'},
                {'data':  function (data) {
                    if (data.sal_sale_states_id != 8) {
                        return parseFloat(data.amount).toFixed(2);
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data':  function (data) {
                    if (data.sal_type_document_id != 5) {
                        if (data.sal_sale_states_id != 8) {
                            return parseFloat(data.subtotal).toFixed(2);
                        } else {
                            return parseFloat(0).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data':  function (data) {
                    if (data.sal_type_document_id != 5) {
                        if (data.sal_sale_states_id != 8) {
                            return parseFloat(data.taxes).toFixed(2);
                        } else {
                            return parseFloat(0).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "1" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "2" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "3" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "4" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "5" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "6" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "-";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "6" && data.sal_sale_states_id != 8) {
                                if (typeof element['operation_number'] !== 'undefined') {
                                    message = element['operation_number'];
                                }
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "7" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "8" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "-";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "8" && data.sal_sale_states_id != 8) {
                                if (typeof element['operation_number'] !== 'undefined') {
                                    message = element['operation_number'];
                                }
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "9" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "10" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "11" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "12" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "13" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "14" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                //NEW PAYMENTS
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "15" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "16" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "17" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "18" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data':  function (data) {
                    var message = "0.00";
                    data.data_client[0]['payments'].forEach(element => {
                        if (element != null) {
                            if (element['sal_type_payments_id'] == "19" && data.sal_sale_states_id != 8) {
                                message = parseFloat(element['amount']).toFixed(2);
                            }
                        }
                    });
                    return message;
                }},
                {'data': function (data) {
                    var message = "VENTA EN TIENDA";
                    switch (data.sale_terminal_id) {
                        case 0:
                            message = "VENTA EN TIENDA";
                            break;
                        case 1:
                            message = "VENTA POR WEB";
                            break;
                        case 2:
                            message = "VENTA POR REDES SOCIALES";
                            break;
                        default:
                            message = "VENTA EN TIENDA";
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
                {'data': function(data) {
                    if (data.commentary == null) {
                        return 'SIN COMENTARIO';
                    } else {
                        return data.commentary;
                    }
                }},
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.sal_sale_states_id == 8) {
                    $node.addClass('danger');
                } else if (data.sal_sale_states_id == 3) {
                    if (data.sal_type_document_id == 9 || data.sal_type_document_id == 10) {
                        $node.addClass('danger');
                    } else {
                        $node.addClass('success');
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
                // .column( 8, {search:'applied'} )
                totalS = api
                    .column( 8 )
                    .data()
                    .reduce( function (a, b, iterator) {
                        credit = false;
                        var sale_ = data[iterator];
                        sale_.data_client[0]['payments'].forEach(element => {
                            if (element != null) {
                                if (element['sal_type_payments_id'] == "8" && sale_.sal_sale_states_id != 8) {
                                    credit = true;
                                }
                            }
                        });
                        if (sale_.sal_sale_states_id != 8 && credit != true) {
                            if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                                return intVal(a) - intVal(b);
                            } else {
                                return intVal(a) + intVal(b);
                            }
                        } else {
                            return intVal(a);
                        }
                    }, 0 );
                    
                // Update footer
                $(api.column(0).footer()).html('ACUMULADO DE VENTAS: ' + parseFloat(totalS).toFixed(2));
            }
        });
        
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
                    "format": "DD/MM/YYYY h:mm A",
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
        );
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>