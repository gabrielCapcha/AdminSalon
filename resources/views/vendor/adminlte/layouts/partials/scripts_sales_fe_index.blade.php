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
    var deleteSale;
    var saleDetailModal;
    var deleteSaleSubmit;
    var downloadPdfById;
    var deletedSaleId = 0;
    var selectTypeDocument;
    var selectedTypeDocuments = [];
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
        var saleIndexTable = $('#sale_index').DataTable({
            "scrollX": true,
            // "scrollY": true,
            "processing": true,
            "lengthChange": false,
            "order": [[ 16, "desc" ]],
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "columnDefs": [
                {
                    "targets": [10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32],
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
                    $.get('/api/sales-fe', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        stateId: $('#stateSaleId').val(),
                        warehouseId: $('#warehouseId').val(),
                        paymentId: $('#paymentId').val(),
                        dateRange: $('#dateRange').val(),
                        rzSocial: $('#rzSocial').val(),
                        // typeDocument: $('#typeDocument').val(),
                        typeDocuments: selectedTypeDocuments,
                        }, function(res) {
                            arraySales = [];
                            res.data.forEach(element => {
                                arraySales[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            }, 
            "columns"    : [
                {'data': function(data) {
                    return data.fe_ruc;
                }},
                {'data': function(data) {
                    var message = data.sale_type_document_name;
                    if (message == 'NOTA DE VENTA') {
                        message = 'PRECUENTA';
                    }
                    return message;
                }},
                {'data': function(data) {
                    var typeCode = '00';
                    switch (parseInt(data.sal_type_document_id)) {
                        case 1:
                            typeCode = '03';
                            break;
                        case 2:
                            typeCode = '01';
                            break;
                        case 5:
                            typeCode = '00';
                            break;
                        case 9:
                            typeCode = '07';
                            break;
                        case 10:
                            typeCode = '07';
                            break;
                        default:
                            break;
                    }
                    return typeCode;
                }},
                {'data': function(data) {
                    if (data.ticket == null) {
                        return data.serie + '-' + ("000000" + data.number).slice(-8);
                    } else {
                        return data.ticket;
                    }
                }},
                {'data': 'warehouse_name'},
                {'data':   function (data) {
                        if (data.customer_ruc == null || data.customer_ruc == "") {
                            return data.customer_dni;
                        } else {
                            if (data.sal_type_document_id == 1 || data.sal_type_document_id == 5 || data.sal_type_document_id == 9) {
                                return data.customer_dni;
                            } else {
                                return data.customer_ruc;
                            }
                        }
                    }
                },
                {'data': function(data) {
                    var typeDoc = '00';
                    switch (parseInt(data.customer_flag_type_person)) {
                        case 1:
                            typeDoc = '01';
                        break;
                        case 2:
                            typeDoc = '06';
                        break;
                        case 3:
                            typeDoc = '04';
                        break;
                        case 4:
                            typeDoc = '07';
                        break;
                        default:
                            break;
                    }
                    return typeDoc;
                }},
                {'data': function (data) {
                    var message = data.customer_name + ' ' + data.customer_lastname;
                    if (data.customer_flag_type_person == 2) {
                        message = data.customer_rz_social;
                    }
                    return message;
                }},
                {'data': 'sale_state_name'},
                {'data': 'currency'},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        return parseFloat(data.amount).toFixed(2);
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        if (data.sal_type_document_id == 5) {
                            return parseFloat(0).toFixed(2);
                        } else {
                            return parseFloat(data.subtotal).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        if (data.sal_type_document_id == 5) {
                            return parseFloat(0).toFixed(2);
                        } else {
                            return parseFloat(data.op_inafectas).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        if (data.sal_type_document_id == 5) {
                            return parseFloat(0).toFixed(2);
                        } else {
                            return parseFloat(data.op_exoneradas).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        if (data.sal_type_document_id == 5) {
                            return parseFloat(0).toFixed(2);
                        } else {
                            return parseFloat(data.op_gratuitas).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        if (data.sal_type_document_id == 5) {
                            return parseFloat(0).toFixed(2);
                        } else {
                            return parseFloat(data.op_icbper).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        if (data.sal_type_document_id == 5) {
                            return parseFloat(0).toFixed(2);
                        } else {
                            return parseFloat(data.taxes).toFixed(2);
                        }
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        return parseFloat(data.services).toFixed(2);
                    } else {
                        return parseFloat(0).toFixed(2);
                    }
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id != 8) {
                        if (data.partial_discount != null) {
                            return (parseFloat(data.discount) + parseFloat(data.partial_discount)).toFixed(2);    
                        } else {
                            return parseFloat(data.discount).toFixed(2);
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
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data) {
                    if (data.sal_type_document_id == 5) {
                        return 'NO';
                    } else {
                        if (data.idsd_other != null) {
                            return 'SÍ';
                        } else {
                            if (data.c_is_sent != null) {
                                if (data.c_is_sent == 'yes') {
                                    return 'SÍ';
                                } else {
                                    return 'NO';
                                }
                            } else {
                                if (data.sal_type_document_id == 5) {
                                    data.c_has_sunat_successfully_passed = null;
                                    return '-';
                                } else {
                                    if (data.sunat_log != null) {
                                        var sunat_log = JSON.parse(data.sunat_log);
                                        if (sunat_log.success == 0) {    
                                            data.c_has_sunat_successfully_passed = 'no';
                                            data.c_is_sent == 'yes'
                                            return 'SI';
                                        } else {
                                            data.c_has_sunat_successfully_passed = 'yes';
                                            return 'SI';
                                        }
                                    } else {
                                        data.c_has_sunat_successfully_passed = null;
                                        return 'SIN HASH';
                                    }
                                }
                            }
                        }
                    }
                }},
                {'data': function (data) {
                    if (data.sal_type_document_id == 5) {
                        return 'NO';
                    } else {
                        if (data.idsd_other != null) {
                            message = 'NO';
                            data.c_has_sunat_successfully_passed = 'no';
                            if (data.hash != null) {
                                switch (data.idsd_other) {
                                    case 0:
                                        data.c_has_sunat_successfully_passed = 'yes';
                                        message = 'SÍ';
                                        break;
                                    case 1033:
                                        data.c_has_sunat_successfully_passed = 'yes';
                                        message = 'SÍ';
                                        break;
                                    default:
                                        message = 'NO';
                                        break;
                                }
                            }
                            return message;
                        } else {
                            if (data.c_has_sunat_successfully_passed != null) {
                                if (data.c_has_sunat_successfully_passed == 'yes') {
                                    return 'SÍ';
                                } else {
                                    return 'NO';
                                }
                            } else {
                                if (data.sal_type_document_id == 5) {
                                    data.c_has_sunat_successfully_passed = null;
                                    return '-';
                                } else {
                                    return 'NO';
                                }
                            }
                        }
                    }
                }},
                {'data': function (data) {
                    var message = data.hash;
                    if (message == null) {
                        message = 'SIN HASH';
                    }
                    return message;
                }},
                {'data': function (data) {
                    if (data.url_invoice == null) {
                        return '<button type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                            '<button disabled type="button" onClick="downloadXmlById(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-cloud-download"></i></button><span> </span>' +
                            '<button disabled type="button" onClick="downloadCdrById(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button>';
                    } else {
                        return '<button type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                            '<button type="button" onClick="downloadXmlById(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-cloud-download"></i></button><span> </span>' +
                            '<button type="button" onClick="downloadCdrById(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button>';
                    }
                }},
            ],
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.sal_sale_states_id == 8) {
                    $node.addClass('danger');
                } else {
                    if (data.idsd_other != null && data.hash != null) {
                        switch (data.idsd_other) {
                            case 0:
                                if (data.sal_type_document_id != 5) {
                                    $node.addClass('success');
                                }
                                break;
                            case 1033:
                                if (data.sal_type_document_id != 5) {
                                    $node.addClass('success');
                                }
                                break;
                            default:
                                $node.addClass('warning');
                                break;
                        }
                     } else {
                        if (data.c_has_sunat_successfully_passed == 'no') {
                            if (data.c_is_sent == 'yes') {
                                $node.addClass('danger');
                            } else {
                                $node.addClass('warning');
                            }
                        } else if (data.c_has_sunat_successfully_passed == 'yes') {
                            $node.addClass('success');
                        }
                    }
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                var i__ = 0;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    i__ = i;
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                // MONTOS
                // Importe total
                var column = 8 + 2;
                importeTotal = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            // console.log("valor anterior", intVal(a))
                            // console.log("valor a sumar", intVal(b))
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // Op. Gravada
                var column = 9 + 2;
                opGravada = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // Op. Inafecta
                var column = 10 + 2;
                opInafecta = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // Op. Exonerada
                var column = 11 + 2;
                opExonerada = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // Op. Gratuitas
                var column = 12 + 2;
                opGratuitas = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // ICBPER
                var column = 13 + 2;
                icbper = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // IGV
                var column = 14 + 2;
                igv = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // SERVICIO
                var column = 15 + 2;
                servicio = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
                        if (sale_.sal_type_document_id == 9 || sale_.sal_type_document_id == 10) {
                            return intVal(a) - intVal(b);
                        } else {
                            return intVal(a) + intVal(b);
                        }
                    } else {
                        return intVal(a);
                    }
                }, 0 );
                // DESCUENTOS
                var column = 16 + 2;
                descuento = api.column( column ).data().reduce( function (a, b, iterator) {
                    var sale_ = data[iterator];
                    if (sale_.sal_sale_states_id != 8) {
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
                $(api.column(0).footer()).html('<p>RESUMEN DE VENTAS:</p><ul>' +
                        '<li>OP. GRAVADA: <strong>' + parseFloat(opGravada).toFixed(2) + '</strong></li>' +
                        '<li>OP. INAFECTA: <strong>' + parseFloat(opInafecta).toFixed(2) + '</strong></li>' +
                        '<li>OP. EXONERADA: <strong>' + parseFloat(opExonerada).toFixed(2) + '</strong></li>' +
                        '<li>OP. EXPORTACION: <strong>' + parseFloat(opGratuitas).toFixed(2) + '</strong></li>' +
                        '<li>ICBPER: <strong>' + parseFloat(icbper).toFixed(2) + '</strong></li>' +
                        '<li>IGV (18%): <strong>' + parseFloat(igv).toFixed(2) + '</strong></li>' +
                        '<li>SERVICIOS (13%): <strong>' + parseFloat(servicio).toFixed(2) + '</strong></li>' +
                        '<li>DESCUENTOS: <strong>' + parseFloat(descuento).toFixed(2) + '</strong></li>' +
                        '<li>IMPORTE TOTAL: <strong>' + parseFloat(importeTotal).toFixed(2) + '</strong></li>' +
                        '</ul>'
                    );
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

        downloadPdfById = function(id) {
            var document = arraySales[id];
            if (document.fe_status == 0) {
                window.open(document.url_invoice);
            } else {
                window.open('https://sm-soft.tumi-soft.com/web/fe-document-pdf/' + document.ruc + '/' + document.ticket);
            }
        }
        downloadXmlById = function(id) {
            var document = arraySales[id];
            if (document.idsd_other != null) {
                window.open('https://fe.tumi-soft.com' + document.url_xml);
            } else {
                var url = document.url_invoice.replace("/pdf/", "/document/");
                url = url.replace("PDF", "ZIP");
                window.open(url);
            }
        }
        downloadCdrById = function(id) {
            var document = arraySales[id];
            if (document.idsd_other != null) {
                window.open('https://fe.tumi-soft.com' + document.url_cdr);
            } else {
                var url = document.url_invoice.replace("/pdf/", "/cdr/R-");
                url = url.replace("PDF", "ZIP");
                window.open(url);
            }
        }
        selectTypeDocument = function (id) {
            var indexOf_ = selectedTypeDocuments.indexOf(id);
            if(indexOf_ < 0) {
                selectedTypeDocuments.push(id);
                switch (id) {
                    case 2:
                        document.getElementById('typeDocument_' + id).className = 'btn btn-danger';
                        break;
                    case 1:
                        document.getElementById('typeDocument_' + id).className = 'btn btn-warning';
                        break;
                    case 5:
                        document.getElementById('typeDocument_' + id).className = 'btn btn-info';
                        break;                
                    default:
                        document.getElementById('typeDocument_' + id).className = 'btn btn-primary';
                        break;
                }
            } else {
                selectedTypeDocuments[indexOf_] = 0;
                document.getElementById('typeDocument_' + id).className = 'btn btn-default';
            }
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>