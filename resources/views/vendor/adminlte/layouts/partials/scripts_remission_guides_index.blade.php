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
    var convertToId = 0;
    var deletedSaleId = 0;
    var closeRemissionGuideId = 0;
    var downloadPdfById;
    var saleDetailModal;
    var deleteSaleSubmit;
    var submitConvertToDirectInvoice;
    var submitConvertToRemissionGuide;
    var submitConvertToReserveInvoice;
    var openModalConvertoToDirectInvoice;
    var openModalConvertoToRemissionGuide;
    var openModalConvertoToReserveInvoice;
    $(document).ready(function() {

        // CONVERT TO IN PARTS
        var navListItems = $('div.setup-panel-3 div a'),
            allWells = $('.setup-content-3'),
            allNextBtn = $('.nextBtn-3'),
            allPrevBtn = $('.prevBtn-3');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-info').addClass('btn-pink');
                $item.addClass('btn-info');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content-3"),
                curStepBtn = curStep.attr("id"),
                prevStepSteps = $('div.setup-panel-3 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                prevStepSteps.removeAttr('disabled').trigger('click');
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content-3"),
                curStepBtn = curStep.attr("id"),
                nextStepSteps = $('div.setup-panel-3 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
                for(var i=0; i< curInputs.length; i++){
                    if (!curInputs[i].validity.valid){
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid)
                    nextStepSteps.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel-3 div a.btn-info').trigger('click');

        // CONVERT TO DIRECTLY
        downloadPdfFeById = function(id) {
            var sale = arraySales[id];
            if (sale.s3_url != null) {
                window.open(sale.s3_url);
            } else {
                window.open('https://sm-soft.tumi-soft.com/web/fe-document-pdf/' + sale.fe_ruc + '/' + sale.ticket);
            }
        }

        openModalConvertoToDirectInvoice = function (id) {
            document.getElementById('buttonModalSubmit').onclick = function() { submitConvertToDirectInvoice(); }
            $('#modal-converto-to').modal({ backdrop: 'static', keyboard: false });
            convertToId = id;
            var detailSaleCreatedAt = document.getElementById('detailSaleCreatedAtMct');
            if (arraySales[id].customer_name == null) {
                arraySales[id].customer_name     = arraySales[id].customer_rz_social;
                arraySales[id].customer_lastname = '';
            }
            var customer_address = arraySales[id].customer_address;
            if (customer_address == null) {
                customer_address = 'SIN INFORMACIÓN';
            }

            var type_document_name = 'BOLETA';
            var detailSaleCreatedAtHeader__ = '¿DESEA CONVERTIR LA ' + arraySales[id].type_document_name + ': ' + arraySales[id].ticket + ' EN UNA ' + type_document_name + '?<br>';
            switch (arraySales[id].data_client[0].quotationTypeDocument) {
                case 1:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    type_document_name = 'PRECUENTA';
                    detailSaleCreatedAtHeader__ = '¿DESEA CONVERTIR LA ' + arraySales[id].type_document_name + ': ' + arraySales[id].ticket + ' EN UNA ' + type_document_name + '?<br>';
                    break;
                case 2:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    type_document_name = 'BOLETA';
                    detailSaleCreatedAtHeader__ = '¿DESEA CONVERTIR LA ' + arraySales[id].type_document_name + ': ' + arraySales[id].ticket + ' EN UNA ' + type_document_name + '?<br>';
                    break;
                case 3:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    type_document_name = 'FACTURA';
                    detailSaleCreatedAtHeader__ = '¿DESEA CONVERTIR LA ' + arraySales[id].type_document_name + ': ' + arraySales[id].ticket + ' EN UNA ' + type_document_name + '?<br>';
                    break;                        
                default:
                    document.getElementById('buttonModalSubmit').disabled = true;
                    type_document_name = 'SIN INFORMACIÓN';
                    detailSaleCreatedAtHeader__ = 'NO SE PUEDE CONVERTIR ESTA GUÍA. SIN DOCUMENTO DE CONVERSIÓN. <br>';
                    break;
            }

            var detailSaleCreatedAt__ = detailSaleCreatedAtHeader__ + 
                'CLIENTE: ' + arraySales[id].customer_name + ' ' + arraySales[id].customer_lastname + '<br>' +
                'DIRECCIÓN CLIENTE: ' + customer_address + '<br>';
            detailSaleCreatedAt.innerHTML = detailSaleCreatedAt__;

            var detailSaleEmployeeName = document.getElementById('detailSaleEmployeeNameMct');
            var commentary = "";
            if (arraySales[id].commentary != null) {
                commentary = arraySales[id].commentary;
            }
            detailSaleEmployeeName.innerHTML = 'ATENDIDO POR: ' + arraySales[id].employee_name + ' ' + arraySales[id].employee_lastname + '<br>' + commentary;
            //ITEMS TABLE
            var detailSaleItemsTable = document.getElementById('detailSaleItemsTableMct');
            var htmlDetailSaleItemsTable = '<table class="table" align="center"><thead><tr><th>DESCRIPCIÓN DE PRODUCTOS</th><th>CANTIDAD</th><th>PRECIO UNITARIO</th><th>PRECIO TOTAL</th></tr></thead>';
                arraySales[id].items.forEach(element => {
                    htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '<tr><td>' + element.name + '</td><td>' + element.quantity + '</td><td>' + element.currency + ' ' + element.price + '</td><td>' + element.currency + ' ' +  (element.quantity*element.price) + '</td></tr>';
                });
            htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '</tbody></table>';
            detailSaleItemsTable.innerHTML = htmlDetailSaleItemsTable;
            //ITEMS TABLE
        }
        
        openModalConvertoToRemissionGuide = function (id) {
            document.getElementById('buttonModalSubmit').onclick = function() { submitConvertToRemissionGuide(); }
            $('#modal-converto-to').modal({ backdrop: 'static', keyboard: false });
            convertToId = id;
            var detailSaleCreatedAt = document.getElementById('detailSaleCreatedAtMct');
            if (arraySales[id].customer_name == null) {
                arraySales[id].customer_name     = arraySales[id].customer_rz_social;
                arraySales[id].customer_lastname = '';
            }
            var customer_address = arraySales[id].customer_address;
            if (customer_address == null) {
                customer_address = 'SIN INFORMACIÓN';
            }
            var detailSaleCreatedAt__ = '¿DESEA GENERAR UNA VENTA A PARTIR DE GUÍA: ' + arraySales[id].ticket + '?<br>' + 
                'CLIENTE: ' + arraySales[id].customer_name + ' ' + arraySales[id].customer_lastname + '<br>' +
                'DIRECCIÓN CLIENTE: ' + customer_address + '<br>';
            detailSaleCreatedAt.innerHTML = detailSaleCreatedAt__;
            var detailSaleEmployeeName = document.getElementById('detailSaleEmployeeNameMct');
            var commentary = "";
            if (arraySales[id].commentary != null) {
                commentary = arraySales[id].commentary;
            }
            detailSaleEmployeeName.innerHTML = 'ATENDIDO POR: ' + arraySales[id].employee_name + ' ' + arraySales[id].employee_lastname + '<br>' + commentary;
            //ITEMS TABLE
            var detailSaleItemsTable = document.getElementById('detailSaleItemsTableMct');
            var htmlDetailSaleItemsTable = '<table class="table" align="center"><thead><tr><th>DESCRIPCIÓN DE PRODUCTOS</th><th>CANTIDAD</th><th>PRECIO UNITARIO</th><th>PRECIO TOTAL</th></tr></thead>';
                arraySales[id].items.forEach(element => {
                    htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '<tr><td>' + element.name + '</td><td>' + element.quantity + '</td><td>' + element.currency + ' ' + element.price + '</td><td>' + element.currency + ' ' +  (element.quantity*element.price) + '</td></tr>';
                });
            htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '</tbody></table>';
            detailSaleItemsTable.innerHTML = htmlDetailSaleItemsTable;
            //ITEMS TABLE
        }

        openModalConvertoToReserveInvoice = function (id) {
            document.getElementById('buttonModalSubmit').onclick = function() { submitConvertToReserveInvoice(); }
            $('#modal-converto-to').modal({ backdrop: 'static', keyboard: false });
            convertToId = id;
            var detailSaleCreatedAt = document.getElementById('detailSaleCreatedAtMct');
            if (arraySales[id].customer_name == null) {
                arraySales[id].customer_name     = arraySales[id].customer_rz_social;
                arraySales[id].customer_lastname = '';
            }
            var customer_address = arraySales[id].customer_address;
            if (customer_address == null) {
                customer_address = 'SIN INFORMACIÓN';
            }
            var detailSaleCreatedAt__ = '¿DESEA GENERAR UNA VENTA A PARTIR DE GUÍA: ' + arraySales[id].ticket + '?<br>' + 
                'CLIENTE: ' + arraySales[id].customer_name + ' ' + arraySales[id].customer_lastname + '<br>' +
                'DIRECCIÓN CLIENTE: ' + customer_address + '<br>';
            detailSaleCreatedAt.innerHTML = detailSaleCreatedAt__;
            var detailSaleEmployeeName = document.getElementById('detailSaleEmployeeNameMct');
            var commentary = "";
            if (arraySales[id].commentary != null) {
                commentary = arraySales[id].commentary;
            }
            detailSaleEmployeeName.innerHTML = 'ATENDIDO POR: ' + arraySales[id].employee_name + ' ' + arraySales[id].employee_lastname + '<br>' + commentary;
            //ITEMS TABLE
            var detailSaleItemsTable = document.getElementById('detailSaleItemsTableMct');
            var htmlDetailSaleItemsTable = '<table class="table" align="center"><thead><tr><th>DESCRIPCIÓN DE PRODUCTOS</th><th>CANTIDAD</th><th>PRECIO UNITARIO</th><th>PRECIO TOTAL</th></tr></thead>';
                arraySales[id].items.forEach(element => {
                    htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '<tr><td>' + element.name + '</td><td>' + element.quantity + '</td><td>' + element.currency + ' ' + element.price + '</td><td>' + element.currency + ' ' +  (element.quantity*element.price) + '</td></tr>';
                });
            htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '</tbody></table>';
            detailSaleItemsTable.innerHTML = htmlDetailSaleItemsTable;
            //ITEMS TABLE
        }

        submitConvertToDirectInvoice = function() {
            if (convertToId != 0) {
                var comment = document.getElementById('deleteSaleComment').value;
                $.ajax({
                    url: "/api/sales/convert-to/" + convertToId,
                    context: document.body,
                    method: "GET",
                    statusCode: {
                        400: function(response) {
                            convertToId = 0;
                            alert(response.responseJSON.msg);
                        },
                        406: function(response) {
                            convertToId = 0;
                            alert(response.responseJSON.msg);
                        },
                        500: function(response) {
                            convertToId = 0;
                            alert("Hubo un problema en convertir la guía de remisión. No se especificó el tipo de documento.");
                        },
                    }
                }).done(function(response) {
                    convertToId = 0;
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo generar el documento solicitado " + convertToId);
            }
        }
        
        submitConvertToRemissionGuide = function () {
            if (convertToId != 0) {
                var comment = document.getElementById('deleteSaleComment').value;
                $.ajax({
                    url: "/api/sales/convert-to-remission-guide/" + convertToId,
                    context: document.body,
                    method: "GET",
                    statusCode: {
                        400: function(response) {
                            convertToId = 0;
                            alert(response.responseJSON.msg);
                        },
                        406: function(response) {
                            convertToId = 0;
                            alert(response.responseJSON.msg);
                        },
                        500: function(response) {
                            convertToId = 0;
                            alert("Hubo un problema en convertir la guía de remisión. No se especificó el tipo de documento.");
                        },
                    }
                }).done(function(response) {
                    convertToId = 0;
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo generar el documento solicitado " + convertToId);
            }
        }

        submitConvertToReserveInvoice = function () {
            alert("CONVERTIR A FACTURA DE RESERVA");
        }

        var saleIndexTable = $('#sale_index').DataTable({
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
            "ajax": function(data, callback, settings) {
                    $.get('/api/remission-guides', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        stateId: $('#stateSaleId').val(),
                        warehouseId: $('#warehouseId').val(),
                        employeeId: $('#employeeId').val(),
                        paymentId: $('#paymentId').val(),
                        dateRange: $('#dateRange').val(),
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
                {'data': function (data) {
                        if (data.ticket == null) {
                            return data.serie + '-' + ("000000" + data.number).slice(-8);
                        } else {
                            return data.ticket;
                        }
                    }
                },
                {'data': 'warehouse_name'},
                {'data': function (data) {
                        var message = data.oldTicket + ' </br>' +
                                    '<button type="button" title="Descargar venta en formato TICKET" onClick="downloadPdfById(' + data.sal_sale_documents_id + ', 1)" class="btn btn-default btn-xs"><i class="fa fa-print"></i></button>' +
                                    '<span> </span>' +
                                    '<button type="button" title="Descargar venta en formato A4" onClick="downloadPdfById(' + data.sal_sale_documents_id + ', 2)" class="btn btn-default btn-xs"><i class="fa fa-file"></i></button>' +
                                    ' </br>';
                        if (data.oldTicket == null) {
                            if (data.data_client[0]['quotationAffected'] != undefined) {
                                message = '';
                                data.data_client[0]['quotationAffected'].forEach(element => {
                                    console.log(element);
                                    message = message + element.ticket + ' </br>' +
                                    '<button type="button" title="Descargar venta en formato TICKET" onClick="downloadPdfById(' + element.id + ', 1)" class="btn btn-default btn-xs"><i class="fa fa-print"></i></button>' +
                                    '<span> </span>' +
                                    '<button type="button" title="Descargar venta en formato A4" onClick="downloadPdfById(' + element.id + ', 2)" class="btn btn-default btn-xs"><i class="fa fa-file"></i></button>' +
                                    ' </br>';
                                });
                            } else {
                                message = 'SIN DOCUMENTO';
                            }
                        }
                        return message;
                    }
                },
                {'data': function (data) {
                    if (data.customer_flag_type_person == 1) {
                        return data.customer_dni;
                    } else {
                        return data.customer_ruc;
                    }
                }},
                {'data': function (data) {
                    if (data.customer_flag_type_person == 1) {
                        return data.customer_name + ' ' + data.customer_lastname;
                    } else {
                        return data.customer_rz_social;
                    }
                }},                
                {'data': 'sale_state_name'},
                {'data': 'currency_amount'},
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data) {
                    if (data.sal_sale_states_id == 3 && data.customer_id != null) {
                        return '<button title="Detalle de guía de remisión" type="button" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button title="Imprimir guía de remisión" type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            
                            '<button style="margin:1px;" title="Cerrar guía de remisión" type="button" class="btn btn-warning btn-xs" onClick="openModalToCloseRemissionGuide('+ data.id +');"><i class="fa fa-lock"></i></button><span> </span>' +
                            '<button style="margin:1px;" title="Crear Venta Directa" type="button" class="btn btn-primary btn-xs" onClick="openModalConvertoToDirectInvoice('+ data.id +');"><i class="fa fa-random"></i></button><span> </span>' +
                            '<button title="Eliminar guía de remisión" type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteSale(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    } else if (data.customer_id == null) {
                        return '<button title="Detalle de guía de remisión" type="button" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button title="Imprimir guía de remisión" type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            
                            '<button style="margin:1px;" title="Cerrar guía de remisión" type="button" class="btn btn-warning btn-xs" onClick="openModalToCloseRemissionGuide('+ data.id +');"><i class="fa fa-lock"></i></button><span> </span>' +
                            '<button disabled style="margin:1px;" title="Crear Venta Directa" type="button" class="btn btn-primary btn-xs" onClick="openModalConvertoToDirectInvoice('+ data.id +');"><i class="fa fa-random"></i></button><span> </span>' +
                            '<button title="Eliminar guía de remisión" type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteSale(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>';
                    } else {
                        return '<button title="Detalle de guía de remisión" type="button" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button title="Imprimir guía de remisión" type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            
                            '<button style="margin:1px;" title="Cerrar guía de remisión" type="button" class="btn btn-warning btn-xs" onClick="openModalToCloseRemissionGuide('+ data.id +');"><i class="fa fa-lock"></i></button><span> </span>' +
                            '<button disabled style="margin:1px;" title="Crear Venta Directa" type="button" class="btn btn-primary btn-xs" onClick="openModalConvertoToDirectInvoice('+ data.id +');"><i class="fa fa-random"></i></button><span> </span>' +
                            '<button title="Eliminar guía de remisión" type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    }
                }}
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.flag_reserve == 1) {
                    $node.addClass('info');
                } else { 
                    switch (data.sal_sale_states_id) {
                        case 8:
                            $node.addClass('danger');
                            break;
                        case 10:
                            $node.addClass('success');
                            break;
                        case 11:
                            $node.addClass('warning');
                            break;
                    
                        default:
                            break;
                    }
                }
            },
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

        openModalToCloseRemissionGuide = function(id) {
            closeRemissionGuideId = id;
            var remissionGuide = arraySales[id];
            if (remissionGuide.sal_sale_states_id != 10) {
                document.getElementById('closeRemissionGuideTitle').innerHTML = '¿Desea cerrar esta guía de remisión? <b>(Ticket: ' + remissionGuide.ticket + ')</b>';
                $('#modal-close-remission-guide').modal({ backdrop: 'static', keyboard: false });
            } else {
                alert("La guía de remisión " + remissionGuide.ticket + " ya se encuentra convertida.");
            }
        }

        closeRemissionGuideSubmit = function() {
            $('#modal-close-remission-guide').modal('toggle');
            if (closeRemissionGuideId != 0) {
                $.ajax({
                    url: "/api/close-remission-guide/" + closeRemissionGuideId,
                    context: document.body,
                    method: "GET",
                    statusCode: {
                        400: function(response) {
                            alert("Hubo un problema en cerrar la guía de remisión. Comuníquese con soporte técnico.");
                        },
                        406: function(response) {
                            alert("Hubo un problema en cerrar la guía de remisión. Comuníquese con soporte técnico.");
                        },
                        500: function(response) {
                            alert("Hubo un problema en cerrar la guía de remisión. Comuníquese con soporte técnico.");
                        },
                    }
                }).done(function(response) {
                    closeRemissionGuideId = 0;
                    $('#searchButton').trigger('click');
                });
            } else {
                alert('No se puede cerrar la guía de remisión. Comuníquese con soporte técnico.');
            }
        }

        deleteSale = function(id) {
            deletedSaleId = id;
            var sale = arraySales[id];
            var deleteSaleText = document.getElementById('deletedSaleText');
            deleteSaleText.innerHTML = "¿Desea eliminar la guía de remisión #" + sale.serie + '-' + sale.number + "?";
        }

        saleDetailModal = function(id) {
            var detailSaleCreatedAt = document.getElementById('detailSaleCreatedAt');
            if (arraySales[id].customer_name == null) {
                arraySales[id].customer_name     = arraySales[id].customer_rz_social;
                arraySales[id].customer_lastname = '';
            } else {
                arraySales[id].customer_name = arraySales[id].customer_name + arraySales[id].customer_lastname;
            }
            var customer_address = arraySales[id].customer_address;
            if (customer_address == null) {
                customer_address = 'SIN INFORMACIÓN';
            }

            var detailSaleCreatedAt__ = arraySales[id].type_document_name + ': ' + arraySales[id].ticket + '<br>' + 
                'CLIENTE: ' + arraySales[id].customer_name + '<br>' +
                'DIRECCIÓN CLIENTE: ' + customer_address + '<br>';
                if (arraySales[id].data_client[0].quotation_commentary) {
                    detailSaleCreatedAt__ = detailSaleCreatedAt__ + 'NOTA O COMENTARIO: ' + arraySales[id].data_client[0].quotation_commentary + '<br>';
                }
            detailSaleCreatedAt.innerHTML = detailSaleCreatedAt__;

            var detailSaleEmployeeName = document.getElementById('detailSaleEmployeeName');
            var commentary = "";
            if (arraySales[id].commentary != null) {
                commentary = arraySales[id].commentary;
            }
            detailSaleEmployeeName.innerHTML = 'ATENDIDO POR: <strong>' + arraySales[id].employee_name + ' ' + arraySales[id].employee_lastname + '</strong><br>' + commentary;
            //ITEMS TABLE
            var detailSaleItemsTable = document.getElementById('detailSaleItemsTable');
            var htmlDetailSaleItemsTable = '<table class="table" align="center"><thead><tr><th>DESCRIPCIÓN DE PRODUCTOS</th><th>CANTIDAD</th><th>PRECIO UNITARIO</th><th>PRECIO TOTAL</th></tr></thead>';
                arraySales[id].items.forEach(element => {
                    htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '<tr><td>' + element.name + '</td><td>' + element.quantity + '</td><td>' + element.currency + ' ' + element.price + '</td><td>' + element.currency + ' ' +  (element.quantity*element.price) + '</td></tr>';
                });
            htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '</tbody></table>';
            detailSaleItemsTable.innerHTML = htmlDetailSaleItemsTable;
            //ITEMS TABLE
        }

        deleteSaleSubmit = function() {
            var deleteRemissionGuideBtn = document.getElementById('deleteRemissionGuideBtn');
            if (deletedSaleId != 0 && deleteRemissionGuideBtn != null) {
                deleteRemissionGuideBtn.disabled = true;
                var comment = document.getElementById('deleteSaleComment').value;
                $.ajax({
                    url: "/api/sales/" + deletedSaleId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deletedSaleId = 0;
                            alert("La guía de remisión no se pudo eliminar.");
                        }
                    }
                }).done(function(response) {
                    deletedSaleId = 0;
                    $('#modal-danger').modal('toggle');
                    $('#searchButton').trigger('click');
                    deleteRemissionGuideBtn.disabled = false;
                });
            } else {
                console.log("No se pudo eliminar la guía de remisión con id " + deletedSaleId);
            }
        }

        downloadPdfById = function(id, type = 1) {
            if (type == 1) {
                window.open('/api/print-sale-pdf-by-id/' + id);                
            } else {
                window.open('https://sm-soft.tumi-soft.com/web/fe-document-pdf/' + id);
            }
        }

        downloadFormatPdfById = function(id) {
            window.open('/api/print-format-pdf-by-id/' + id);
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>