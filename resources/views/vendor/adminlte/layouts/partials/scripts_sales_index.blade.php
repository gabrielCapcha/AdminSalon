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
    var openSign;
    var userObject = null;
    var arraySales = [];
    var allotments = {};
    var arrayAllotments = {};
    var allotmentProductId = 0;
    var allotmentRealProductId = 0;
    var allotmentQuantityTotal = 0;
    var selectTypeDocument;
    var selectedTypeDocuments = [];
    var sendEmail;
    var deleteSale;
    var checkedAll;
    var sendEmailSubmit;
    var sendEmailId = 0;
    var convertToId = 0;
    var deletedSaleId = 0;
    var convertToCreditNoteId = 0;
    var downloadPdfById;
    var saleDetailModal;
    var deleteSaleSubmit;
    var convertToCreditNote;
    var convertToCreditNoteSubmit;
    var openModalConvertoToRemissionGuide;
    var submitConvertToRemissionGuide;
    $(document).ready(function() {
        var adminPrivilege = document.getElementById('adminPrivilege').value;
        var summaryDocumentSync = document.getElementById('summaryDocumentSync').value;
        var userObject = JSON.parse(document.getElementById('userObject').value);
        function getCurrencySymbolCode(currency) {
            var symbolCode = 'S/';
            switch (currency) {
                case 'PEN':
                    symbolCode = 'S/ ';
                    break;
                case 'USD':
                    symbolCode = '$ ';
                    break;
                case 'EUR':
                    symbolCode = '€ ';
                    break;
                case 'JPY':
                    symbolCode = '¥ ';
                    break;
                default:
                    symbolCode = '$ ';
                    break;
            }
            return symbolCode;
        }
        function WebSocketPrinter(options) {
            var defaults = {
                url: "ws://127.0.0.1:12212/printer",
                onConnect: function () {
                },
                onDisconnect: function () {
                },
                onUpdate: function () {
                },
            };

            var settings = Object.assign({}, defaults, options);
            var websocket;
            var connected = false;

            var onMessage = function (evt) {
                settings.onUpdate(evt.data);
            };

            var onConnect = function () {
                connected = true;
                settings.onConnect();
            };

            var onDisconnect = function () {
                connected = false;
                settings.onDisconnect();
                reconnect();
            };

            var connect = function () {
                websocket = new WebSocket(settings.url);
                websocket.onopen = onConnect;
                websocket.onclose = onDisconnect;
                websocket.onmessage = onMessage;
            };

            var reconnect = function () {
                connect();
            };

            this.submit = function (data) {
                if (Array.isArray(data)) {
                    data.forEach(function (element) {
                        websocket.send(JSON.stringify(element));
                    });
                } else {
                    websocket.send(JSON.stringify(data));
                }
            };

            this.isConnected = function () {
                return connected;
            };

            connect();
        }
        var printService = new WebSocketPrinter();
        var saleIndexTable = $('#sale_index').DataTable({
            "scrollX": false,
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
                $.get('/api/sales', {
                    limit: data.length,
                    offset: data.start,
                    searchInput: $('#searchInput').val(),
                    stateId: $('#stateSaleId').val(),
                    warehouseId: $('#warehouseId').val(),
                    sunatStatus: $('#sunatStatus').val(),
                    paymentId: $('#paymentId').val(),
                    dateRange: $('#dateRange').val(),
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
                {'data': function(data, type, dataToSet) {
                    var message = data.ticket;
                    if (data.ticket == null) {
                        message = data.serie + '-' + ("000000" + data.number).slice(-8);
                    }
                    var condition = 'FLUJO';
                    if (data.flag_reserve == 1) {
                        condition = 'RESERVA';
                    }
                    return '<b>' + message + '</b>' + '<br>(' + condition + ')';
                }},
                {'data': function (data) {
                   return data.created_at.substring(0,10); 
                }},
                {'data': function (data) {
                   return data.created_at.substring(11,20); 
                }},
                {'data': 'warehouse_name'},
                {'data':   function (data, type, dataToSet) {
                    var message = '';
                    if (data.customer_ruc != '' && data.customer_ruc != null) {
                        message = 'RUC: ' + data.customer_ruc;
                    } else {
                        message = 'DOC: ' + data.customer_dni;
                    }
                    var customerName = '';
                    if (data.customer_flag_type_person != 2) {
                        customerName = data.customer_name + ' ' + data.customer_lastname;
                    } else {
                        customerName = data.customer_rz_social;
                    }
                    return message + '<br><b>' + customerName + '</b>';
                }},
                {'data': 'sale_state_name'},
                {'data': function (data) {
                    var message = data.idsd_other;
                    if (data.sunat_log == null) {
                        message = "SIN INFORMACIÓN";
                    }
                    return message;
                }},
                {'data': function (data, type, dataToSet) {
                    return data.type_payment_name + " <br><b>" + getCurrencySymbolCode(data.currency) + (parseFloat(data.amount)).toFixed(2) + '</b>';
                }},
                {'data': function (data, type, dataToSet) {
                    var disabled = '';
                    if (adminPrivilege == 0) {
                        disabled = 'disabled';
                    }
                    if (data.sal_sale_states_id == 8) {
                        return '<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-primary btn-xs"><i class="fa fa-envelope"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                            '<br><hr style="margin:2px; border-top: 0px;">' +
                            '<button type="button" disabled title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button type="button" disabled title="Sincronizar con SUNAT" onClick="sunatSync(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i></button><span> </span>' + 
                            '<button type="button" title="Ver información de sunat" onClick="openSunatLogModal(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-book"></i></button>' + 
                            '<br><hr style="margin:2px; border-top: 0px;">' + 
                            '<button type="button" disabled class="btn btn-warning btn-xs"><i class="fa fa-sticky-note-o"></i></button><span> </span>' +
                            '<button type="button" disabled title="Crear Guía de Remisión" class="btn btn-primary btn-xs" onClick="openModalConvertoToRemissionGuide('+ data.id +');"><i class="fa fa-bars"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    } else {
                        var disabledSunat = 'disabled';
                        var viewSunatCode = '';
                        // VALIDACION DE ESTADO
                        if ((data.hash == null || data.hash == "") && data.sal_type_document_id != 5) {
                            disabledSunat = '';
                        }
                        // VALIDACION POR DIAS
                        if (data.dateDiff > 7 && data.sal_type_document_id == 2) {
                            disabled = 'disabled';
                            disabledSunat = 'disabled';
                        }
                        // } else if (data.dateDiff > 30 && data.sal_type_document_id == 1) {
                        //     disabled = 'disabled';
                        //     disabledSunat = 'disabled';
                        // }
                        // VALIDACION EN SUNAT_LOG
                        if (data.url_cdr == null && data.sal_type_document_id != 5) {
                            disabledSunat = '';
                        }
                        // VALIDACION EN SUNAT_LOG
                        if (data.sunat_log == null && data.sal_type_document_id != 5) {
                            disabledSunat = '';
                            viewSunatCode = 'disabled';
                        }
                        // ASIGNACION DE BOTONES
                        var message = '<button type="button" title="Ver detalle de venta" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Enviar venta por correo electrónico" data-toggle="modal" data-target="#modal-send-mail" onClick="sendEmail(' + data.id + ')" class="btn btn-primary btn-xs"><i class="fa fa-envelope"></i></button><span> </span>' +
                            '<button type="button" title="Descargar venta en formato PDF TICKET" onClick="downloadPdfById(' + data.id + ', ' + data.com_company_id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                            '<br><hr style="margin:2px; border-top: 0px;">' +
                            '<button type="button" title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button type="button" ' + disabledSunat + ' title="Sincronizar con SUNAT" onClick="sunatSync(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i></button><span> </span>' + 
                            '<button type="button" title="Ver información de sunat" ' + viewSunatCode + ' onClick="openSunatLogModal(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-book"></i></button>' + 
                            '<br><hr style="margin:2px; border-top: 0px;">';
                            if (data.sal_type_document_id == 1 || data.sal_type_document_id == 2) {
                                message = message + '<span> </span><button type="button" title="Convertir a Nota de Crédito" onClick="convertToCreditNote(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-sticky-note-o"></i></button><span> </span>';    
                                message = message + '<button type="button" title="Crear Guía de Remisión" class="btn btn-primary btn-xs" onClick="openModalConvertoToRemissionGuide('+ data.id +');"><i class="fa fa-bars"></i></button><span> </span>';
                                message = message + '<button type="button" '+ disabled +' title="Eliminar venta" data-toggle="modal" data-target="#modal-danger" id="deleteSaleBtn_'+ data.id +'" onClick="deleteSale(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                            } else if (data.sal_type_document_id == 5 || data.sal_type_document_id == 9 || data.sal_type_document_id == 10) {
                                message = message + '<span> </span><button disabled type="button" title="Convertir a Nota de Crédito" disabled onClick="convertToCreditNote(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-sticky-note-o"></i></button><span> </span>';
                                message = message + '<button type="button" disabled title="Crear Guía de Remisión" class="btn btn-primary btn-xs" onClick="openModalConvertoToRemissionGuide('+ data.id +');"><i class="fa fa-bars"></i></button><span> </span>';
                                message = message + '<button type="button" '+ disabled +' title="Eliminar venta" data-toggle="modal" data-target="#modal-danger" id="deleteSaleBtn_'+ data.id +'" onClick="deleteSale(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                            } else {
                                message = message + '<span> </span><button type="button" title="Convertir a Nota de Crédito" disabled onClick="convertToCreditNote(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-sticky-note-o"></i></button><span> </span>';
                                message = message + '<button type="button" title="Crear Guía de Remisión" class="btn btn-primary btn-xs" onClick="openModalConvertoToRemissionGuide('+ data.id +');"><i class="fa fa-bars"></i></button><span> </span>';
                                message = message + '<button type="button" title="Eliminar venta" disabled data-toggle="modal" data-target="#modal-danger" id="deleteSaleBtn_'+ data.id +'" onClick="deleteSale(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';                                
                            }
                        return message;
                    }
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.s3_pdf != null) {
                        return '<button type="button" class="btn btn-info btn-xs" onClick="downloadPdf(' + data.id + ')"><i class="fa fa-save"></i></button><span> </span>';
                    } else {
                        return '<button type="button" disabled class="btn btn-info btn-xs" onClick="downloadPdf(' + data.id + ')"><i class="fa fa-save"></i></button><span> </span>';
                    }
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.url_xml != null) {
                        return '<button type="button" class="btn btn-info btn-xs" onClick="downloadXml(' + data.id + ')"><i class="fa fa-save"></i></button><span> </span>';
                    } else {
                        return '<button type="button" disabled class="btn btn-info btn-xs" onClick="downloadXml(' + data.id + ')"><i class="fa fa-save"></i></button><span> </span>';
                    }
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.url_cdr != null) {
                        return '<button type="button" class="btn btn-info btn-xs" onClick="downloadCdr(' + data.id + ')"><i class="fa fa-save"></i></button><span> </span>';
                    } else {
                        return '<button type="button" disabled class="btn btn-info btn-xs" onClick="downloadCdr(' + data.id + ')"><i class="fa fa-save"></i></button><span> </span>';
                    }
                }},
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.sal_sale_states_id != 8 &&
                    data.sal_type_document_id != 5 &&
                    (data.sunat_log == null)) {
                        $node.addClass('warning');
                }
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
        });
        downloadPdf = function (id) {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            var sale = arraySales[id];
            var name = sale.fe_ruc + '-' + sale.ticket + '.pdf';
            var url = '/api/download-file?url=' + sale.s3_pdf + '&name=' + name;
            location = url;
            $('#modal-on-load').modal('toggle');
        }
        downloadXml = function (id) {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            var sale = arraySales[id];
            var name = sale.fe_ruc + '-' + sale.ticket + '.xml';
            var strtDt  = new Date(sale.created_at);
            var endDt  = new Date("2020-01-30 00:00:00");
            if (strtDt < endDt) {
                var prevUrl = 'https://fe.tumi-soft.com';
            } else {
                var prevUrl = 'https://fe-soft.tumi-soft.com';
                if (parseInt(sale.flag_type_device) == 1) {
                    prevUrl = 'https://fe-pos.tumi-soft.com';
                } else if(parseInt(sale.flag_type_device) == 2) {
                    prevUrl = 'https://fe-food.tumi-soft.com';
                }
            }
            var url = '/api/download-file?url=' + prevUrl + sale.url_xml + '&name=' + name;
            location = url;
            $('#modal-on-load').modal('toggle');
        }
        downloadCdr = function (id) {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            var sale = arraySales[id];
            var name = 'R-' + sale.fe_ruc + '-' + sale.ticket + '.xml';
            var prevUrl = 'https://fe-soft.tumi-soft.com';
            if (parseInt(sale.flag_type_device) == 1) {
                prevUrl = 'https://fe-pos.tumi-soft.com';
            } else if(parseInt(sale.flag_type_device) == 2) {
                prevUrl = 'https://fe-food.tumi-soft.com';
            }
            var url = '/api/download-file?url=' + prevUrl + sale.url_cdr + '&name=' + name;
            location = url;
            $('#modal-on-load').modal('toggle');
        }
        goToSummaryDocuments = function () {
            window.location.href = "/fe-documents";
        }
        sunatSync = function (id) {
            var sale = arraySales[id];
            if (sale.sal_type_document_id == 1 && !summaryDocumentSync) {
                $('#modal-summary-document').modal({ backdrop: 'static', keyboard: false });
            } else {
                $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
                $.ajax({
                    method: "GET",
                    url: "/api/sunat-sync/" + id,
                    context: document.body,
                    statusCode: {
                        400: function(response) {
                            $('#modal-on-load').modal('toggle');
                            // alert("NO SE PUDO SINCRONIZAR VENTA. ERROR EN SERVIDORES DE SUNAT");
                            // $('#modal-error-step').modal({ backdrop: 'static', keyboard: false });
                        },
                        500: function(response) {
                            $('#modal-on-load').modal('toggle');
                            // alert("NO SE PUDO SINCRONIZAR VENTA. ERROR EN SERVIDORES DE SUNAT");
                            // $('#modal-error-step').modal({ backdrop: 'static', keyboard: false });
                        },
                    }
                }).done(function(response) {
                    $('#modal-on-load').modal('toggle');
                    saleIndexTable.ajax.reload(null, false);
                    // $('#searchButton').trigger('click');
                });
            }
        }
        openSunatLogModal = function(id) {
            var divSunatLog = document.getElementById('div-sunat-log');
            if (divSunatLog != null) {
                var sale = arraySales[id];
                var idsd_other = sale.idsd_other;
                var message = "";
                if (idsd_other == '-1') {
                    message = "Código de error desconocido";
                } else if (parseInt(idsd_other) == 0) {
                    if (sale.sal_sale_states_id == 8) {
                        message = "Comprobante comunicado de baja sin errores";
                    } else {
                        message = "Comprobante emitido sin errores";
                    }
                } else {
                    $.ajax({
                    method: "GET",
                    url: "/api/catalog_errors/"+ idsd_other,
                    context: document.body,
                    statusCode: {
                            400: function() {
                            }
                        }
                    }).done(function(response) {
                        divSunatLog.innerHTML = response.message;
                    });
                }
                divSunatLog.innerHTML = message;
            }
            $('#modal-sunat-log').modal({ backdrop: 'static', keyboard: false });
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
        sendEmailSubmit = function () {
            document.getElementById('buttonSendMail').enabled = false;
            var email = document.getElementById('sendEmailComment');
            // if (email.checkValidity()) {
                $.ajax({
                method: "GET",
                url: "https://sm-soft.tumi-soft.com/api/customer/send-email/"+ email.value +"/" + sendEmailId,
                context: document.body,
                statusCode: {
                        400: function() {
                            document.getElementById('buttonSendMail').enabled = true;
                            alert("No se pudo enviar el correo");
                        }
                    }
                }).done(function(response) {
                    sendEmailId = 0;
                    document.getElementById('buttonSendMail').enabled = true;
                    $('#modal-send-mail').modal('toggle');
                    alert("Correo enviado");
                });
            // } else {
            //     email.style.borderColor = "red";
            //     alert("Ingrese un correo válido");
            // }
        }
        checkedAll = function() {
            var checkedAllButton = document.getElementById('checkedAllButton');
            if (convertToCreditNoteId != 0) {
                var saleDocument = arraySales[convertToCreditNoteId];
                saleDocument.items.forEach(element => {
                    var checkBox_ = document.getElementById('quotationProductsBodyCheckbox_' + element.id);
                    if (checkBox_ != null) {
                        if (checkedAllButton.checked) {
                            console.log("checked");
                            checkBox_.checked = true;
                        } else {
                            console.log("no checked");
                            checkBox_.checked = false;
                        }                        
                    }
                });
            }
        }
        convertToCreditNoteSubmit = function() {
            if (convertToCreditNoteId != 0) {
                $('#modal-credit-note').modal('toggle');
                $('#modal-credit-note-resume').modal('toggle');
                var items_ = [];
                var amount_ = 0;
                var saleDocument = arraySales[convertToCreditNoteId];
                var commentaryNC = document.getElementById('commentaryNC_' + convertToCreditNoteId).value;
                var codeTipoNC = document.getElementById('codeTipoNC_' + convertToCreditNoteId).value;
                var otherPercentNC = document.getElementById('otherPercentNC_' + convertToCreditNoteId).value;
                var showProductsNC = document.getElementById('showProductsNC_' + convertToCreditNoteId).value;
                saleDocument.items.forEach(element => {
                    var checkBox_ = document.getElementById('quotationProductsBodyCheckbox_' + element.id);
                    if (checkBox_ != null) {
                        if (checkBox_.checked) {
                            var quantity_ = document.getElementById('quotationProductsBodyQuantity_' + element.id).value;
                            var price_ = document.getElementById('quotationProductsBodyPrice_' + element.id).value;
                            if (quantity_ != 0 && quantity_ != "") {
                                if (quantity_ <= element.quantity) {
                                    element.quantity = parseFloat(quantity_);
                                    element.price = parseFloat(price_);
                                }
                                amount_ = amount_ + (parseFloat(element.quantity) * parseFloat(price_));
                                items_.push(element);
                            }
                        }
                    }
                });
                var dataSend = {
                    "amount": amount_,
                    "items" : items_,
                    "commentary": commentaryNC,
                    "type_document": saleDocument.sal_type_document_id,
                    "nc_percent": otherPercentNC,
                    "code_tipo_nc": codeTipoNC,
                    "show_products": showProductsNC,
                    "allotments": allotments
                };
                
                $.ajax({
                    method: "PATCH",
                    url: "/api/sales-to-credit-note/" + convertToCreditNoteId,
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            convertToCreditNoteId = 0;
                            alert("No se pudo generar la nota de crédito");
                        }
                    }
                }).done(function(response) {
                    convertToCreditNoteId = 0;
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo generar la nota de crédito de la venta con id " + convertToCreditNoteId);
            }
        }
        convertToCreditNotePreview = function() {
            if (convertToCreditNoteId != 0) {
                var items_ = [];
                var amount_ = 0;
                var saleDocument = arraySales[convertToCreditNoteId];
                var commentaryNC = document.getElementById('commentaryNC_' + convertToCreditNoteId).value;
                var codeTipoNC = document.getElementById('codeTipoNC_' + convertToCreditNoteId).value;
                var otherPercentNC = document.getElementById('otherPercentNC_' + convertToCreditNoteId).value;
                var showProductsNC = document.getElementById('showProductsNC_' + convertToCreditNoteId).value;
                saleDocument.items.forEach(element => {
                    var checkBox_ = document.getElementById('quotationProductsBodyCheckbox_' + element.id);
                    if (checkBox_ != null) {
                        if (checkBox_.checked) {
                            var quantity_ = document.getElementById('quotationProductsBodyQuantity_' + element.id).value;
                            var price_ = document.getElementById('quotationProductsBodyPrice_' + element.id).value;
                            if (quantity_ != 0 && quantity_ != "") {
                                if (quantity_ <= element.quantity) {
                                    element.quantity = parseFloat(quantity_);
                                    element.price = parseFloat(price_);
                                }
                                amount_ = amount_ + (parseFloat(element.quantity) * parseFloat(price_));
                                items_.push(element);
                            }
                        }
                    }
                });
                if (parseFloat(otherPercentNC) > 0) {
                    amount_ = parseFloat(amount_)*(parseFloat(otherPercentNC)/100);
                }
                // VALUES ASSIGNMENT
                var codeTipoNCName_ = 'TIPO DE NOTA DE CRÉDITO: <b>SIN DEFINIR</b>';
                switch (codeTipoNC) {
                    case '07':
                        codeTipoNCName_ = 'TIPO DE NOTA DE CRÉDITO: <b>(07) Devolución por item</b>';
                        break;
                    case '04':
                        codeTipoNCName_ = 'TIPO DE NOTA DE CRÉDITO: <b>(04) Descuento global</b>';
                        break;
                    default:
                        break;
                }
                var showProductsNCText = 'SI';
                switch (parseFloat(showProductsNC)) {
                    case 0:
                        showProductsNCText = 'NO';
                        break;
                    case 1:
                        showProductsNCText = 'SI';
                        break;                
                    default:
                        break;
                }
                document.getElementById('ncTypeResume').innerHTML = codeTipoNCName_;
                document.getElementById('ncPercentResume').innerHTML = 'PORCENTAJE DE GIRO (%): <b>' + otherPercentNC + '</b>';
                document.getElementById('ncShowProducts').innerHTML = 'MOSTRAR PRODUCTS: <b>' + showProductsNCText + '</b>';
                document.getElementById('ncAmountResume').innerHTML = 'MONTO DE NOTA DE CRÉDITO: <b>' + amount_ + '</b>';
                // TABLE ASSIGNMENT
                var quotationProductsBodyResume = document.getElementById('quotationProductsBodyResume');
                var table = $('#quotationProductsResume').DataTable();
                table.destroy();
                $("#quotationProductsBodyResume tr").remove();
                var quotationProductsBodyText = '';
                items_.forEach(element => {
                    var messageFlagActive = 'ACTIVO';
                    if (element.flag_active == 0) {
                        messageFlagActive = 'INACTIVO';
                    }
                    var tr = document.createElement('tr');
                    var text = '<td>' + element.name + '</td>' + 
                        '<td>' + messageFlagActive + '</td>' + 
                        '<td>' + element.quantity + '</td>' +
                        '<td>' + element.currency + ' (' + getCurrencySymbolCode(element.currency) + ')</td>' + 
                        '<td>' + element.price + '</td>';
                    tr.innerHTML = text;
                    quotationProductsBodyResume.insertBefore(tr, quotationProductsBodyResume.nextSibling);
                });
                var quotationProductsResume = $('#quotationProductsResume').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'pageLength'  : 5,
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
                $('#modal-credit-note-resume').modal({ backdrop: 'static', keyboard: false });
            }
        }
        ncTypeValidation = function(id) {
            var codeTipoNC_ = document.getElementById('codeTipoNC_' + id);
            if (codeTipoNC_ != null) {
                codeTipoNC_ = codeTipoNC_.value;
                switch (codeTipoNC_) {
                    case '07':
                        document.getElementById('otherPercentNC_' + id).readOnly = true;
                        document.getElementById('otherPercentNC_' + id).value = "0.00";
                        break;
                    case '04':
                        document.getElementById('otherPercentNC_' + id).readOnly = false;
                        break;                
                    default:
                        break;
                }
            }
        }
        convertToCreditNote = function(id) {
            convertToCreditNoteId = id;
            allotments = {};
            arrayAllotments = {};
            var saleDocument = arraySales[id];
            var detailSaleCreditNote = document.getElementById('detailSaleCreditNote');
            var customerName = '(DNI: '+ saleDocument.customer_dni +') - ' + saleDocument.customer_name + ' ' + saleDocument.customer_lastname;
            if (saleDocument.customer_flag_type_person == 2) {
                customerName = '(RUC: '+ saleDocument.customer_ruc +') - ' + saleDocument.customer_rz_social;
            }
            var ncTitle = document.getElementById('ncTitle');
            if (ncTitle != null) {
                ncTitle.innerHTML = 'GENERAR NOTA DE CRÉDITO AL' +  'CLIENTE: <strong>' + customerName + '</strong>' + 
                '<hr style="margin-top:1px; margin-bottom:1px;">' + 
                'FECHA: <strong>' + saleDocument.created_at + '</strong> - TICKET: <strong>' + saleDocument.ticket +  '</strong> - MONTO: <strong>' + parseFloat(saleDocument.amount).toFixed(2) + '</strong>';
            }
            detailSaleCreditNote.innerHTML = '<ul style="list-style-type: none;">' + 
                    '<li>COMENTARIO: <input type="text" id="commentaryNC_'+ id +'" placeholder="Ingrese un comentario" class="form-control"> &nbsp;' + 
                    'TIPO: <select onChange="ncTypeValidation(' + id + ');" id="codeTipoNC_'+ id +'" class="form-control">' +
                        // '<option value="01">(01) - Anulación de la operación</option>'+
                        // '<option value="02">(02) - Anulación por error del RUC</option>'+
                        // '<option value="03">(03) - Corrección por error en la descripción</option>'+
                        '<option value="04">(04) - Descuento Global</option>'+
                        // '<option  value="05">(05) - Descuento por item</option>'+
                        // '<option value="06">(06) - Devolución total</option>'+
                        '<option selected value="07">(07) - Devolución por item</option>'+
                        // '<option value="08">(08) - Bonificación</option>'+
                        // '<option value="09">(09) - Disminución en el valor</option>'+
                    '</select> &nbsp;' +
                    'PORCENTAJE GIRO (%): <input type="number" onClick="this.select();" step="0.1" id="otherPercentNC_'+ id +'" placeholder="Ingrese un porcentaje válido" class="form-control" style="width: 100px;" value="0.00" readonly> &nbsp;' +
                    'MOSTRAR PRODUCTOS? <select id="showProductsNC_'+ id +'" class="form-control"><option value="0">NO</option><option selected value="1">SI</option></select></li>' +
                '</ul>';
            var tableNCDynamic = document.getElementById('quotationProducts');
            tableNCDynamic.innerHTML = '<thead>'+
                                    '<tr>'+
                                        '<th><input type="checkbox" id="checkedAllButton" onClick="checkedAll();"></th>'+
                                        '<th>Producto</th>'+
                                        '<th>Estado</th>'+
                                        '<th>Cantidad</th>'+
                                        '<th>Moneda</th>'+
                                        '<th>Precio</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody id="quotationProductsBody"></tbody>';
                                // '<tbody id="quotationProductsBody"></tbody>' +
                                // '<tfoot>'+
                                //     '<tr>'+
                                //         '<td> - </td>'+
                                //         '<td>Producto</td>'+
                                //         '<td>Estado</td>'+
                                //         '<td>Cantidad</td>'+
                                //         '<td>Moneda</td>'+
                                //         '<td>Precio</td>'+
                                //     '</tr>'+
                                // '</tfoot>';
            $("#quotationProductsBody tr").remove();
            var quotationProductsBodyText = '';
            var quotationProductsBody = document.getElementById('quotationProductsBody');
            saleDocument.items.forEach(element => {
                var messageFlagActive = 'ACTIVO';
                if (element.flag_active == 0) {
                    messageFlagActive = 'INACTIVO';
                }
                var tr = document.createElement('tr');
                var quantityP_ = '<td><input type="number" onClick="this.select();" id="quotationProductsBodyQuantity_' + element.id + '" value="' + element.quantity + '" min="0" max="' + element.quantity + '" style="width:100%;"/></td>';
                if (element.allotmentType == 1) {
                    quantityP_ = '<td id="trAllotment_' + element.id + '"><input type="hidden" onClick="this.select();" id="quotationProductsBodyQuantity_' + element.id + '" value="' + element.quantity + '" min="0" max="' + element.quantity + '" style="width:100%;"/>' + element.quantity + '<span> </span> <button type="button" class="btn btn-primary btn-xs" onClick="openAllotmentModal(' + element.id + ', ' + id + ', ' + element.war_products_id + ')"><i class="fa fa-cubes"></i></button></td>';
                }
                var text = '<td><input type="checkbox" id="quotationProductsBodyCheckbox_'+ element.id +'" /></td>' + 
                    '<td>' + element.name + '</td>' + 
                    '<td> ' + messageFlagActive + '</td>' + 
                    quantityP_ +
                    '<td> ' + element.currency + ' (' + getCurrencySymbolCode(element.currency) + ')</td>' + 
                    '<td><input type="number" step="0.1" onClick="this.select();" id="quotationProductsBodyPrice_' + element.id + '" value="' + element.price + '" style="width:100%;"/></td>';
                tr.innerHTML = text;
                quotationProductsBody.insertBefore(tr, quotationProductsBody.nextSibling);
            });
            
            var table = $('#quotationProducts').DataTable();
            table.destroy();
            var quotationProducts = $('#quotationProducts').DataTable({
                "scrollY": "250px",
                "oSearch": {"sSearch": ' ' },
                // "scrollX": false,
                "scrollCollapse": true,
                "paging": false,
                // 'paging'      : true,
                'lengthChange': false,
                // 'pageLength'  : 5,
                'searching'   : true,
                'ordering'    : false,
                'info'        : true,
                'autoWidth'   : true,
                'stateSave': false,
                // 'processing': false,
                // 'serverSide': false,
                "language": {
                    "url": "/js/languages/datatables/es.json"
                },
                "dom": 'Bfrtip',
                "buttons": [
                    'excel', 'pdf'
                ],
                "bDestroy": true
            });
            $('#modal-credit-note').modal({ backdrop: 'static', keyboard: false });
        }
        openAllotmentModal = function (productId, saleId, realProductId) {
            allotmentProductId = productId;
            allotmentRealProductId = realProductId;
            $('#modal-allotment').modal({ backdrop: 'static', keyboard: false });
            // DATATABLE
            var table = $('#tableAllotmentProduct').DataTable();
            table.destroy();
            table = $('#tableAllotmentProduct').DataTable({
                // "scrollX": true,
                "processing": true,
                "orderCellsTop": true,
                "order" : [[ 0, "desc" ]],
                // "fixedHeader": true,
                "lengthChange": false,
                "language": {
                    "url": "/js/languages/datatables/es.json"
                },
                "serverSide": false,
                "paging": true,
                "ordering": true,
                "searching": true,
                "ajax": function(data, callback, settings) {
                        $.get('/api/allotments-by-sale-detail/' + productId, {
                            limit: data.length,
                            offset: data.start,
                            }, function(res) {
                                arrayAllotments[productId] = res;
                                callback({
                                    recordsTotal: res.length,
                                    recordsFiltered: res.length,
                                    data: res
                                });
                            });
                },
                "columns" : [
                    { "data": "description" },
                    { "data": "code" },
                    { "data": function (data) {
                        var message = 'SIN INFORMACIÓN';
                        if (data.json_data != undefined) {
                            data.json_data.forEach(element => {
                                if (data.quotationsAffected != null) {
                                    data.quotationsAffected.forEach(elementQuotationsAffected => {
                                        if (element.documentId == elementQuotationsAffected) {
                                            if (element.quantityClosed != undefined) {
                                                message = element.quantityClosed;                                                
                                            }
                                        }
                                    });
                                }
                            });
                        }
                        return message;
                    }},
                    { "data": function (data) {
                        var message = "";
                        if (data.json_data != undefined) {
                            data.json_data.forEach(element => {
                                if (element.quantityClosed == undefined) {
                                    element.quantityClosed = -1;
                                }
                                if (data.quotationsAffected == null) {
                                    if (element.documentId == saleId) {
                                        message = '<input type="hidden" id="quantityPermitted_' + data.id + '_' + data.quotationsAffected[0] + '" value="' + element.quantityClosed + '">' + 
                                        '<input type="number" class="form-control" style="width:100%;" id="quantityAllotment_' + data.id + '_' + data.quotationsAffected[0] + '" value="0.00" onClick="this.select();"/>';
                                    }
                                } else {
                                    data.quotationsAffected.forEach(elementQuotationsAffected => {
                                        if (element.documentId == elementQuotationsAffected) {
                                            message = '<input type="hidden" id="quantityPermitted_' + data.id + '_' + data.quotationsAffected[0] + '" value="' + element.quantityClosed + '">' + 
                                            '<input type="number" class="form-control" style="width:100%;" id="quantityAllotment_' + data.id + '_' + data.quotationsAffected[0] + '" value="0.00" onClick="this.select();"/>';
                                        }
                                    });
                                }
                            });
                        }
                        return message;
                    }},
                    { "data": "expiration_date" },
                ],
                "responsive": true,
                "bDestroy": true,
            });
        }
        allotmentValidation = function () {
            if (arrayAllotments[allotmentProductId] != undefined) {
                allotments[allotmentRealProductId] = [];
                var validation = true;
                var quantityTotal = 0;
                arrayAllotments[allotmentProductId].forEach(element => {
                    var quantity = document.getElementById('quantityAllotment_' + element.id + '_' + element.quotationsAffected[0]);
                    var permitted = document.getElementById('quantityPermitted_' + element.id + '_' + element.quotationsAffected[0]);
                    if (quantity != null && permitted != null) {
                        quantity = parseFloat(quantity.value);
                        permitted = parseFloat(permitted.value);
                        if (quantity < 0) {
                            quantity = 0;
                        }
                        if (permitted < quantity && permitted != -1) {
                            validation = false;
                        } else {
                            quantityTotal = quantityTotal + quantity;
                            // bloquear inputs
                            document.getElementById('quantityAllotment_' + element.id + '_' + element.quotationsAffected[0]).readOnly = true;
                            document.getElementById('quantityPermitted_' + element.id + '_' + element.quotationsAffected[0]).readOnly = true;
                            allotments[allotmentRealProductId].push(
                                {
                                    "allotmentDetailid": element.id,
                                    "quantity": quantity,
                                    "quotationAffected": element.quotationsAffected[0]
                                }
                            );
                        }
                        if (permitted == -1) {
                            validation = true;
                        }
                    } else {
                        validation = false;
                    }
                });
                if (validation) {
                    document.getElementById('allotmentButtonSubmit').disabled = !validation;
                    allotmentQuantityTotal = quantityTotal;
                } else {
                    alert("Las cantidades ingresadas no son adecuadas. Verifique su información.");
                }
            }
        }
        allotmentSubmit = function() {
            document.getElementById('allotmentButtonSubmit').disabled = true;
            $('#modal-allotment').modal('toggle');
            var tr = document.getElementById('trAllotment_' + allotmentProductId);
            if (tr != null) {
                tr.innerHTML = '<td><input type="hidden" onclick="this.select();" id="quotationProductsBodyQuantity_'+ allotmentProductId +'" value="' + allotmentQuantityTotal + '" min="0" max="5" style="width:100%;">' + allotmentQuantityTotal + '</td>';
            }
        }
        closeAllotmentModal = function() {
            $('#modal-allotment').modal('toggle');
        }
        openModalConvertoToRemissionGuide = function (id) {
            document.getElementById('buttonModalSubmit').disabled = false;
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

            var type_document_name = 'BOLETA';
            var detailSaleCreatedAtHeader__ = '¿DESEA GENERAR UNA GUÍA DE REMISIÓN A PARTIR DE LA VENTA: ' + arraySales[id].ticket + '?<br>';
            if (arraySales[id].sal_sale_states_id == 10) {
                detailSaleCreatedAtHeader__ = 'ESTA VENTA YA CUENTA CON UNA (O VARIAS) GUÍA DE REMISIÓN<br>';
                document.getElementById('buttonModalSubmit').disabled = true;
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
                            alert("Hubo un problema en convertir la cotización. No se especificó el tipo de documento.");
                        },
                    }
                }).done(function(response) {
                    convertToId = 0
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo generar el documento solicitado " + convertToId);
            }
        }
        sendEmail = function(id) {
            sendEmailId = id;
            var sale = arraySales[id];
            var deleteSaleText = document.getElementById('sendEmailText');
            var email = document.getElementById('sendEmailComment');
            email.value = sale.customer_email;
            deleteSaleText.innerHTML = "¿Desea enviar la venta #" + sale.serie + '-' + sale.number + " por correo electrónico?";
        }
        deleteSale = function(id) {
            deletedSaleId = id;
            var sale = arraySales[id];
            var deleteSaleText = document.getElementById('deletedSaleText');
            deleteSaleText.innerHTML = "¿Desea eliminar la venta #" + sale.serie + '-' + sale.number + "?";
        }
        saleDetailModal = function(id) {
            var detailSaleCreatedAt = document.getElementById('detailSaleCreatedAt');
            if (arraySales[id].customer_name == null) {
                arraySales[id].customer_name     = arraySales[id].customer_rz_social;
                arraySales[id].customer_lastname = '';
            }
            var clientName_ = '(' + arraySales[id].customer_dni + ') ' + arraySales[id].customer_name + ' ' + arraySales[id].customer_lastname;
            if (arraySales[id].customer_flag_type_person == 2) {
                clientName_ = '(' + arraySales[id].customer_ruc + ') ' + arraySales[id].customer_rz_social;
            }
            var clientAddress_ = arraySales[id].customer_address;
            if (clientAddress_ == null) {
                clientAddress_ = '';
            }
            var detailSaleCreatedAt__ = arraySales[id].type_document_name + ': ' + arraySales[id].ticket + ' <br>' + 
                'CLIENTE: ' + clientName_ + '<br>' +
                'DIRECCIÓN CLIENTE: ' + clientAddress_ + '<br>';
                if (arraySales[id].data_client[0].reference_document != null) {
                    detailSaleCreatedAt__ = detailSaleCreatedAt__ + 'DOCUMENTO REFERENCIADO: ' + arraySales[id].data_client[0].reference_document + '<br>';
                }
                if (arraySales[id].data_client[0].quotation_commentary) {
                    detailSaleCreatedAt__ = detailSaleCreatedAt__ + 'NOTA O COMENTARIO: ' + arraySales[id].data_client[0].quotation_commentary + '<br>';
                }
                if (arraySales[id].data_client[0].customer_validation_sign) {
                    detailSaleCreatedAt__ = detailSaleCreatedAt__ + '<button type="button" class="btn btn-danger btn-xs" onClick="openSign('+ id +');">CONFIRMACIÓN DE ENTREGA </button>' + '<br>';
                }
            detailSaleCreatedAt.innerHTML = detailSaleCreatedAt__;
            var detailSaleEmployeeName = document.getElementById('detailSaleEmployeeName');
            var commentary = "";
            if (arraySales[id].commentary != null) {
                commentary = arraySales[id].commentary;
            }
            detailSaleEmployeeName.innerHTML = 'ATENDIDO POR: <strong>' + arraySales[id].employee_name + ' ' + arraySales[id].employee_lastname + '</strong><br>' + commentary;
            //PAYMENTS TABLE
            var detailSalePaymentTable = document.getElementById('detailSalePaymentTable');
            var htmlDetailSalePaymentTable = '<table class="table" align="center"><thead><tr><th>DESCRIPCIÓN DE PAGOS</th><th>MONTO</th><th>VUELTO</th><th>REAL</th></tr></thead><tbody>';
                arraySales[id].data_client[0].payments.forEach(element => {
                    var currency = arraySales[id].currency;
                    if (element.currency != undefined) {
                        currency = element.currency;
                    }
                    htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>' + element.name + '</td><td>'+ currency + ' ' + parseFloat(element.amount).toFixed(2) + '</td><td>'+ currency + ' ' + parseFloat(element.exchange).toFixed(2) + '</td><td>'+ arraySales[id].currency + ' ' + parseFloat(element.amount - element.exchange).toFixed(2) + '</td></tr>';
                });
            htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>DESCUENTO TOTAL</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].discount).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].discount).toFixed(2) + '</td></tr>';
            if (arraySales[id].type_document_code !== 'NVT' && arraySales[id].type_document_code !== 'COT') { 
                htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>SUBTOTAL</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].subtotal).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].subtotal).toFixed(2) + '</td></tr>';
                htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>IMPUESTOS</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].taxes).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].taxes).toFixed(2) + '</td></tr>';
                htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>SERVICIOS (' + arraySales[id].service_percent + ' %)</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].services).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].services).toFixed(2) + '</td></tr>';   
            }
            htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>TOTAL</td><td>'+ arraySales[id].currency + ' ' + parseFloat(parseFloat(arraySales[id].amount)).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].amount).toFixed(2) + '</td></tr>';
            htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '</tbody></table>';
            detailSalePaymentTable.innerHTML = htmlDetailSalePaymentTable;
            //PAYMENTS TABLE
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
        openSign = function(id) {
            var myWindow = window.open("", "MsgWindow", "width=200, height=200");
            myWindow.document.write("<img width='200px' height='200px' src='data:image/png;base64, " + arraySales[id].data_client[0].customer_validation_sign + "'>");
        }
        deleteSaleSubmit = function() {
            if (deletedSaleId != 0) {
                var comment = document.getElementById('deleteSaleComment').value;
                var deleteSaleBtn_ = document.getElementById('deleteSaleBtn_' + deletedSaleId);
                if (deleteSaleBtn_ != null) {
                    deleteSaleBtn_.disabled = true;
                }
                $.ajax({
                    url: "/api/sales/" + deletedSaleId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deletedSaleId = 0;
                            alert("La venta no se pudo eliminar.");
                        }
                    }
                }).done(function(response) {
                    deletedSaleId = 0;
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo eliminar la venta con id " + deletedSaleId);
            }
        }
        downloadPdfById = function(id, companyId) {
            if (printService.isConnected()) {
                var message = getHexRawPrint(arraySales[id]);
                printService.submit({
                    'type': 'RECEIPT',
                    'raw_content': message,
                });
            } else {
                window.open('/api/print-sale-pdf-by-id/' + id);
            }
        }
        downloadPdfFeById = function(id) {
            var sale = arraySales[id];
            if (sale.s3_pdf != null) {
                window.open(sale.s3_pdf);
            } else {
                window.open('https://sm-soft.tumi-soft.com/web/fe-document-pdf/' + sale.fe_ruc + '/' + sale.ticket);
            }
        }
        now = function() {
            var date = new Date();
            var aaaa = date.getFullYear();
            var gg = date.getDate();
            var mm = (date.getMonth() + 1);

            if (gg < 10)
                gg = "0" + gg;

            if (mm < 10)
                mm = "0" + mm;

            var cur_day = aaaa + "-" + mm + "-" + gg;

            var hours = date.getHours()
            var minutes = date.getMinutes()
            var seconds = date.getSeconds();

            if (hours < 10)
                hours = "0" + hours;

            if (minutes < 10)
                minutes = "0" + minutes;

            if (seconds < 10)
                seconds = "0" + seconds;

            return cur_day + " " + hours + ":" + minutes + ":" + seconds;
        }
        getHexRawPrint = function(sale) {
            var type_document_name_plus = '';
            switch (sale.type_document_code) {
                case 'BLT':
                    type_document_name_plus = ' DE VENTA ELECTR\xd3NICA';
                    break;
                case 'FAC':
                    type_document_name_plus = ' ELECTR\xd3NICA';
                break;
                default:
                    break;
            }
            sale.customer_document_name = "DOC: ";
            sale.customer_document_number = sale.customer_dni;
            var customer_name = sale.customer_name + ' ' + sale.customer_lastname;
            switch (sale.customer_flag_type_person) {
                case 1:
                    sale.customer_document_name = "DNI: ";
                    break;
                case 2:
                    sale.customer_document_name = "RUC: ";
                    sale.customer_document_number = sale.customer_ruc;
                    customer_name = sale.customer_rz_social;
                    break;
                default:
                    break;
            }
            //Create ESP/POS commands for sample label
            var todayDate = now();
            var leftAlign = '\x1B' + '\x61' + '\x30';
            var rightAlign = '\x1B' + '\x61' + '\x32';
            var centerAlign = '\x1B' + '\x40' + '\x1B' + '\x61' + '\x31';
            var boldOn = '\x1B' + '\x45' + '\x0D';
            var boldOff = '\x1B' + '\x45' + '\x0A';
            var smallText = '\x1B' + '\x4D' + '\x31';
            var normalText = '\x1B' + '\x4D' + '\x30';
            // ISO-8859-1
            var cmds = '' + '\x0A';
            cmds += '------------------------------------------------' + '\x0A' +
                centerAlign + // center align
                sale.type_document_name + ' ' + type_document_name_plus + '\x0A' +                   // line break
                leftAlign + // left align
                // HEADER
                '------------------------------------------------' + '\x0A' +
                centerAlign + // center align
                userObject.company_name + '\x0A' +                   // line break
                userObject.company_rzsocial + '\x0A' +                   // line break
                userObject.company_ruc + '\x0A' +                   // line break
                userObject.company_address + '\x0A' +                   // line break
                userObject.company_code.replace(/!/g, '-') + '\x0A' +                   // line break
                'Suc: ' + userObject.war_warehouses_name + '\x0A' +                   // line break
                'Fecha de venta: ' + sale.created_at + '\x0A' +                   // line break
                'Fecha actual: ' + todayDate + '\x0A' +                   // line break
                boldOn + // bold on
                sale.ticket + '\x0A' +                   // line break
                boldOff + // bold off
                leftAlign + // left align
                '------------------------------------------------' + '\x0A' +
                // CUSTOMER
                centerAlign + // center align
                sale.customer_document_name + sale.customer_document_number + '\x0A' +                   // line break
                customer_name + '\x0A' +                   // line break
                leftAlign + // left align
                // ITEMS DETAILS
                '------------------------------------------------' + '\x0A' +
                'Descripción           Cant    P.Unid    P.Total' + '\x0A' +
                '------------------------------------------------' + '\x0A';
                sale.items.forEach(element => {
                    var description = element.code + ' - ' + element.name + ' (' + element.description + ') \x0A';
                    var quantity = ("                          " + parseFloat(element.quantity).toFixed(2)).slice(-26);
                    var unitPrice = ("          " + parseFloat(element.price).toFixed(2)).slice(-10);
                    var totalPrice = ("            " + parseFloat(element.quantity*element.price).toFixed(2)).slice(-12);
                    cmds += leftAlign;
                    cmds += description;
                    cmds += rightAlign;
                    cmds += quantity;
                    cmds += unitPrice;
                    cmds += totalPrice;
                });
                // SALE DETAILS
                cmds += '------------------------------------------------' + '\x0A';
                cmds += leftAlign;
                cmds += '           Subtotal           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.subtotal).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '         Op.Gravada           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.subtotal).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '       Op.Exonerada           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.op_exoneradas).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '        Op.Inafecta           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.op_inafectas).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '        Op.Gratuita           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.op_gratuitas).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '             ICBPER           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.op_icbper).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '           IGV(18%)           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.taxes).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '              Total           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.amount).toFixed(2)).slice(-12) + '\x0A';
                cmds += '------------------------------------------------' + '\x0A';
                cmds += leftAlign;
                cmds += '               Pago           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.amount + sale.exchange_amount).toFixed(2)).slice(-12) + '\x0A';
                cmds += leftAlign;
                cmds += '             Vuelto           ';
                cmds += rightAlign;
                cmds += ("     " + getCurrencySymbolCode(sale.currency)).slice(-4);
                cmds += ("               " + parseFloat(sale.exchange_amount).toFixed(2)).slice(-12) + '\x0A';
                cmds += '------------------------------------------------' + '\x0A';
                cmds += centerAlign;
                cmds += ((sale.sal_type_payments_id == 5) ?  sale.type_payment_name : 'PAGO ' + sale.type_payment_name)  + '\x0A';
                cmds += '------------------------------------------------' + '\x0A';
                cmds += 'Representación impresa de una:' + '\x0A';
                cmds += boldOn + sale.type_document_name + ' ' + type_document_name_plus + boldOff + '\x0A';
                cmds += 'Consulte su comprobante en:' + '\x0A';
                cmds += 'https://consulta-fe.tumi-soft.com' + '\x0A';
                cmds += '------------------------------------------------' + '\x0A';
                cmds += 'Atendido por: ' + sale.employee_name + ' ' + sale.employee_lastname + '\x0A';
                cmds += boldOn + ((userObject.warehouses_print_message != null) ? userObject.warehouses_print_message : userObject.print_message) + boldOff + '\x0A';
                cmds += 'Gracias por su compra' + '\x0A' + '\x0A';
                cmds += smallText + 'Powered by' + boldOn + ' www.tumi-soft.com' + boldOff + normalText + '\x0A';
                // PAYMENTS DETAIL
                cmds += '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A';
                cmds += '\x1B' + '\x69';          // cut paper (old syntax)
            cmds = window.btoa(unescape(encodeURIComponent( cmds )));
            return cmds;
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>