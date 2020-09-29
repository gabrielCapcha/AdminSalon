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
        var saleIndexTable = $('#reports_1').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "order": [[ 0, "asc" ]],
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "columnDefs": [
                {
                    "targets": [1,2,3,4,5,6,7,8,9,10,11,12],
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
            "ajax": function(data, callback, settings) {
                    $.get('/api/reports-employee-documents', {
                        limit: data.length,
                        offset: data.start,
                        warehouseId: $('#warehouseId').val(),
                        employeeId: $('#employeeId').val(),
                        brandId: $('#brandId').val(),
                        dateRange: $('#dateRange').val(),
                        }, function(res) {
                            arraySales = [];
                            arraySales[res.id] = res;
                            callback({
                                recordsTotal: res.length,
                                recordsFiltered: res.length,
                                data: res
                            });
                        });
            }, 
            "columns"    : [
                {'data': function(data) {
                    return data.name + ' ' + data.lastname;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 5
                                && element.sal_sale_states_id == 3
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 1
                                && element.sal_sale_states_id == 3
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 2
                                && element.sal_sale_states_id == 3
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 6
                                && element.sal_sale_states_id == 3
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 9
                                && element.sal_sale_states_id == 3
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 10
                                && element.sal_sale_states_id == 3
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 5
                                && element.sal_sale_states_id == 8
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 1
                                && element.sal_sale_states_id == 8
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 2
                                && element.sal_sale_states_id == 8
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 6
                                && element.sal_sale_states_id == 8
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 9
                                && element.sal_sale_states_id == 8
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = "0.00";
                    if (data.documents != undefined) {
                        data.documents.forEach(element => {
                            if (element.sal_type_document_id == 10
                                && element.sal_sale_states_id == 8
                                ) {
                                    message = element.totalDocumentAmount;
                            }
                        });
                    }
                    return message;
                }},
            ],
            "rowCallback": function( row, data, index ) {
                // var $node = this.api().row(row).nodes().to$();
                // if (data.sal_sale_states_id == 8) {
                //     $node.addClass('danger');
                // } else {
                //     if (data.idsd_other != null) {
                //         switch (data.idsd_other) {
                //             case 0:
                //                 $node.addClass('success');
                //                 break;                        
                //             default:
                //                 $node.addClass('warning');
                //                 break;
                //         }
                //      } else {
                //         if (data.c_has_sunat_successfully_passed == 'no') {
                //             if (data.c_is_sent == 'yes') {
                //                 $node.addClass('danger');
                //             } else {
                //                 $node.addClass('warning');
                //             }
                //         } else if (data.c_has_sunat_successfully_passed == 'yes') {
                //             $node.addClass('success');
                //         }
                //     }
                // }
            },
            "footerCallback": function (row, data, start, end, display) {
                // var api = this.api(), data;
                // var i__ = 0;
    
                // // Remove the formatting to get integer data for summation
                // var intVal = function ( i ) {
                //     i__ = i;
                //     return typeof i === 'string' ?
                //         i.replace(/[\$,]/g, '')*1 :
                //         typeof i === 'number' ?
                //             i : 0;
                // };
    
                // // TotalS
                // totalS = api
                //     .column( 6 )
                //     .data()
                //     .reduce( function (a, b, iterator) {
                //         var sale_ = data[iterator];
                //         if (sale_.sal_sale_states_id != 8) {
                //             return intVal(a) + intVal(b);
                //         } else {
                //             return intVal(a);
                //         }
                //     }, 0 );

                // // TotalN
                // totalN = api
                //     .column( 6 )
                //     .data()
                //     .reduce( function (a, b, iterator) {
                //         var sale_ = data[iterator];
                //         if (sale_.sal_sale_states_id == 8) {
                //             return intVal(a) + intVal(b);
                //         } else {
                //             return intVal(a);
                //         }
                //     }, 0 );
    
                // // Update footer
                // $(api.column(0).footer()).html('RESUMEN DE VENTAS APROBADAS: ' + parseFloat(totalS).toFixed(2) + ' - RESUMEN DE VENTAS ANULADAS: ' + parseFloat(totalN).toFixed(2));
            }
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.ajax.reload();
            saleIndexTable.search( this.value ).draw();
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
        });
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>