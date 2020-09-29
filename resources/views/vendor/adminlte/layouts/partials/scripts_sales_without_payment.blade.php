<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    var openSign;
    var arraySales = [];
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
    var openModalCreateSinglePayment;
    var submitConvertToRemissionGuide;
    $(document).ready(function() {
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
                    $.get('/api/sales-without-payments', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        stateId: $('#stateSaleId').val(),
                        warehouseId: $('#warehouseId').val(),
                        paymentId: $('#paymentId').val(),
                        dateRange: $('#dateRange').val(),
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
                {'data': function(data, type, dataToSet) {
                    var message = data.ticket;
                    if (data.ticket == null) {
                        message = data.serie + '-' + ("000000" + data.number).slice(-8);
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = 'FLUJO';
                    if (data.flag_reserve == 1) {
                        message = 'RESERVA';
                    }
                    return message;
                }},
                {'data': 'warehouse_name'},
                {'data':   function (data, type, dataToSet) {
                    if (data.customer_ruc != '' && data.customer_ruc != null) {
                        return data.customer_ruc;
                    } else {
                        return data.customer_dni;
                    }
                }},
                {'data': 'sale_state_name'},
                {'data': function (data, type, dataToSet) {
                    return "(" + data.currency + ") " + (parseFloat(data.amount)).toFixed(2);
                }},
                {'data': function (data, type, dataToSet) {
                    var paymentAmount = data.paymentAmount;
                    if (paymentAmount == null) {
                        paymentAmount = parseFloat(0).toFixed(2);
                    }
                    return "(" + data.currency + ") " + paymentAmount;
                }},
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.sal_sale_states_id == 8) {
                        return '<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" disabled title="Crear Pago Directo" class="btn btn-primary btn-xs" onClick="openModalCreateSinglePayment('+ data.id +');"><i class="fa fa-money"></i></button><span> </span>';
                    } else {
                        var message = '<button type="button" title="Ver detalle de venta" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Crear Pago Directo" class="btn btn-primary btn-xs" onClick="openModalCreateSinglePayment('+ data.id +');"><i class="fa fa-money"></i></button><span> </span>';
                        return message;
                    }
                }}
            ],
            "responsive": true,
            // "rowCallback": function( row, data, index ) {
            //     var $node = this.api().row(row).nodes().to$();
            //     switch (data.sal_sale_states_id) {
            //         case 8:
            //             $node.addClass('danger');
            //             break;
            //         case 10:
            //             $node.addClass('success');
            //             break;
            //         case 11:
            //             $node.addClass('warning');
            //             break;
                
            //         default:
            //             break;
            //     }
            // },
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

        $('#dateCheckCharged').datepicker('setDate', 'now');

        $('#dateTransfer').datepicker('setDate', 'now');

        $('#dateVisa').datepicker('setDate', 'now');

        $('#dateMastercard').datepicker('setDate', 'now');

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
            if (email.checkValidity()) {
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
            } else {
                email.style.borderColor = "red";
                alert("Ingrese un correo válido");
            }            
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
                var items_ = [];
                var amount_ = 0;
                var saleDocument = arraySales[convertToCreditNoteId];
                var commentaryNC = document.getElementById('commentaryNC_' + convertToCreditNoteId).value;
                saleDocument.items.forEach(element => {
                    var checkBox_ = document.getElementById('quotationProductsBodyCheckbox_' + element.id);
                    if (checkBox_ != null) {
                        if (checkBox_.checked) {
                            var quantity_ = document.getElementById('quotationProductsBodyQuantity_' + element.id).value;
                            if (quantity_ != 0 && quantity_ != "") {
                                if (quantity_ <= element.quantity) {
                                    element.quantity = quantity_;
                                }
                                amount_ = amount_ + (element.quantity * element.price);
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
        
        convertToCreditNote = function(id) {
            convertToCreditNoteId = id;
            var saleDocument = arraySales[id];
            var detailSaleCreditNote = document.getElementById('detailSaleCreditNote');
            var message = '¿Desea generar una <strong>Nota de crédito</strong> a partir de este documento?';
            detailSaleCreditNote.innerHTML = '<ul>' + message.toUpperCase() + 
                    '<li>FECHA: <strong>' + saleDocument.created_at + '</strong></li>' +
                    '<li>TICKET: <strong>' + saleDocument.ticket +  '</strong></li>' +
                    '<li>MONTO: <strong>' + parseFloat(saleDocument.amount).toFixed(2) + '</strong></li>' +
                    '<li>CLIENTE: <strong>' + saleDocument.data_client[0].name + '</strong></li>' +
                    '<li>COMENTARIO: <input type="text" id="commentaryNC_'+ id +'" placeholder="Ingrese un comentario" class="form-control"></li>' +
                '</ul>';

            var quotationProductsBody = document.getElementById('quotationProductsBody');
            var table = $('#quotationProducts').DataTable();
            table.destroy();
            $("#quotationProductsBody tr").remove();
            var quotationProductsBodyText = '';
            saleDocument.items.forEach(element => {
                var messageFlagActive = 'ACTIVO';
                if (element.flag_active == 0) {
                    messageFlagActive = 'INACTIVO';
                }
                var tr = document.createElement('tr');
                var text = '<td><input type="checkbox" checked id="quotationProductsBodyCheckbox_'+ element.id +'" /></td><td>' + element.name + '</td>' + 
                    '<td> ' + messageFlagActive + '</td><td><input type="number" id="quotationProductsBodyQuantity_' + element.id + '" value="' + element.quantity + '" min="0" max="' + element.quantity + '" style="width:100%;"/></td>' + '<td> ' + parseFloat(element.price).toFixed(2) + '</td>';
                tr.innerHTML = text;
                quotationProductsBody.insertBefore(tr, quotationProductsBody.nextSibling);
            });
            var quotationProducts = $('#quotationProducts').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
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
            $('#modal-credit-note').modal({ backdrop: 'static', keyboard: false });
        }

        openModalCreateSinglePayment = function (id) {
            $('#modal-create-single-payment').modal({ backdrop: 'static', keyboard: false });
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
            var detailSaleCreatedAtHeader__ = 'NUEVO PAGO PARA VENTA #' + arraySales[id].ticket + '<br>';
            var detailSaleCreatedAt__ = detailSaleCreatedAtHeader__ +
                'CLIENTE: ' + arraySales[id].customer_name + ' ' + arraySales[id].customer_lastname + '<br>' +
                'DIRECCIÓN CLIENTE: ' + customer_address + '<br>';
            detailSaleCreatedAt.innerHTML = detailSaleCreatedAt__;

            //totalImport outOfRangeImport
            if (arraySales[id].paymentAmount != null) {
                document.getElementById('totalImport').value = parseFloat(0.00).toFixed(2);
                document.getElementById('PaymentFinish').value = arraySales[id].paymentAmount;
                document.getElementById('outOfRangeImport').value = (parseFloat(arraySales[id].amount) - parseFloat(arraySales[id].paymentAmount)).toFixed(2);
            } else {
                document.getElementById('totalImport').value = parseFloat(0.00).toFixed(2);
                document.getElementById('PaymentFinish').value = parseFloat(0.00).toFixed(2);
                document.getElementById('outOfRangeImport').value = parseFloat(arraySales[id].amount).toFixed(2);
            }
        }

        submitNewPayment = function() {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            var tabCurrency = document.getElementById('tabCurrency').value;
            var typeCharge = document.getElementById('typeCharge').value;
            var flagSunat = document.getElementById('flagSunat').value;
            // Check
            var checkCode = document.getElementById('checkCode').value;
            var dateCheckCharged = document.getElementById('dateCheckCharged').value;
            var checkReference = document.getElementById('checkReference').value;
            var totalCheck = document.getElementById('totalCheck').value;
            // Transfer
            var majorAccountTransfer = document.getElementById('majorAccountTransfer').value;
            var dateTransfer = document.getElementById('dateTransfer').value;
            var transferReference = document.getElementById('transferReference').value;
            var totalTransfer = document.getElementById('totalTransfer').value;
            // Cash
            var cashReference = document.getElementById('cashReference').value;
            var totalCash = document.getElementById('totalCash').value;
            // Visa
            var dateVisa = document.getElementById('dateVisa').value;
            var visaCode = document.getElementById('visaCode').value;
            var totalVisa = document.getElementById('totalVisa').value;
            // Mastercard
            var dateMastercard = document.getElementById('dateMastercard').value;
            var mastercardCode = document.getElementById('mastercardCode').value;
            var totalMastercard = document.getElementById('totalMastercard').value;
            // logic
            var amountPayment = 0;
            var availablePayments = [];
            if (totalCheck != '' && (parseFloat(totalCheck) > 0)) {
                availablePayments.push({
                    id: 7,
                    payment_data: {
                        code: checkCode,
                        date: dateCheckCharged,
                        reference: checkReference,
                        total: parseFloat(totalCheck).toFixed(2)
                    }
                })
                amountPayment = parseFloat(amountPayment) + parseFloat(totalCheck);
            }
            if (totalTransfer != '' && (parseFloat(totalTransfer) > 0)) {
                availablePayments.push({
                    id: 6,
                    payment_data: {
                        majorAccount: majorAccountTransfer,
                        date: dateTransfer,
                        reference: transferReference,
                        total: parseFloat(totalTransfer).toFixed(2)
                    }
                })
                amountPayment = parseFloat(amountPayment) + parseFloat(totalTransfer);
            }
            if (totalCash != '' && (parseFloat(totalCash) > 0)) {
                availablePayments.push({
                    id: 1,
                    payment_data: {
                        reference: cashReference,
                        total: parseFloat(totalCash).toFixed(2)
                    }
                })
                amountPayment = parseFloat(amountPayment) + parseFloat(totalCash);
            }
            if (totalVisa != '' && (parseFloat(totalVisa) > 0)) {
                availablePayments.push({
                    id: 2,
                    payment_data: {
                        date: dateVisa,
                        code: visaCode,
                        total: parseFloat(totalVisa).toFixed(2)
                    }
                })
                amountPayment = parseFloat(amountPayment) + parseFloat(totalVisa);
            }
            if (totalMastercard != '' && (parseFloat(totalMastercard) > 0)) {
                availablePayments.push({
                    id: 3,
                    payment_data: {
                        date: dateMastercard,
                        code: mastercardCode,
                        total: parseFloat(totalMastercard).toFixed(2)
                    }
                })
                amountPayment = parseFloat(amountPayment) + parseFloat(totalMastercard);
            }
            // Send Array
            if (convertToId != 0) {
                var typePaymentId = 5;
                if (availablePayments.length == 1) {
                    typePaymentId = availablePayments[0].id;
                }
                var dataSend = {
                    sal_sale_documents_id: arraySales[convertToId].id,
                    sal_type_document_id: arraySales[convertToId].sal_type_document_id,
                    sal_type_payments_id: typePaymentId,
                    customer_id: arraySales[convertToId].customer_id,
                    currency: arraySales[convertToId].currency,
                    amount: amountPayment,
                    sale_amount: arraySales[convertToId].amount,
                    json_data: availablePayments,
                    flag_sunat: flagSunat,
                    type_charge: typeCharge,
                };
                // Api Call
                $.ajax({
                    method: "POST",
                    url: "/api/create-new-single-payment",
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            button.disabled = false;
                            alert("Hubo un error en el registro. Es posible que hayan más pagos en cola.");
                        }
                    }
                }).done(function(response) {
                    $('#modal-on-load').modal('toggle');
                    // Check
                    document.getElementById('checkCode').value = '';
                    document.getElementById('dateCheckCharged').value = '';
                    document.getElementById('totalCheck').value = parseFloat(0).toFixed(2);
                    // Transfer
                    document.getElementById('majorAccountTransfer').value = '';
                    document.getElementById('dateTransfer').value = '';
                    document.getElementById('transferReference').value = '';
                    document.getElementById('totalTransfer').value = parseFloat(0).toFixed(2);
                    // Cash
                    document.getElementById('majorAccount').value = '';
                    document.getElementById('ccNumber').value = '';
                    document.getElementById('totalCash').value = parseFloat(0).toFixed(2);
                    convertToId = 0
                    $('#searchButton').trigger('click');
                });
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
            var detailSaleCreatedAt__ = arraySales[id].type_document_name + ': ' + arraySales[id].ticket + ' <br>' + 
                'CLIENTE: ' + arraySales[id].customer_name + ' ' + arraySales[id].customer_lastname + '<br>' +
                'DIRECCIÓN CLIENTE: ' + arraySales[id].customer_address + '<br>';
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
                    htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>' + element.name + '</td><td>'+ arraySales[id].currency + ' ' + parseFloat(element.amount).toFixed(2) + '</td><td>'+ arraySales[id].currency + ' ' + parseFloat(element.exchange).toFixed(2) + '</td><td>'+ arraySales[id].currency + ' ' + parseFloat(element.amount - element.exchange).toFixed(2) + '</td></tr>';
                });
            htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>DESCUENTO TOTAL</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].discount).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].discount).toFixed(2) + '</td></tr>';
            htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>SUBTOTAL</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].subtotal).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].subtotal).toFixed(2) + '</td></tr>';
            htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>IMPUESTOS</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].taxes).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].taxes).toFixed(2) + '</td></tr>';
            htmlDetailSalePaymentTable = htmlDetailSalePaymentTable + '<tr><td>SERVICIOS (' + arraySales[id].service_percent + ' %)</td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].services).toFixed(2) + '</td><td> - </td><td>'+ arraySales[id].currency + ' ' + parseFloat(arraySales[id].services).toFixed(2) + '</td></tr>';
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

        downloadPdfById = function(id) {
            window.open('/api/print-sale-pdf-by-id/' + id);
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>