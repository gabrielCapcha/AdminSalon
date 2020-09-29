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
    var openSign;
    var arrayAllotments = [];
    var selectTypeDocument;
    var selectedTypeDocuments = [];
    var sendEmail;
    var deleteSale;
    var checkedAll;
    var sendEmailSubmit;
    var sendEmailId = 0;
    var convertToId = 0;
    var deleteId = 0;
    var detailId = 0;
    var editedId = 0;
    var convertToCreditNoteId = 0;
    var downloadPdfById;
    var saleDetailModal;
    var deleteSaleSubmit;
    var convertToCreditNote;
    var convertToCreditNoteSubmit;
    var openModalConvertoToRemissionGuide;
    var submitConvertToRemissionGuide;
    $(document).ready(function() {
        $('#sale_index thead tr').clone(true).appendTo( '#sale_index thead' );
        $('#sale_index thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input class="filter" type="text" placeholder="'+title+'" />' );
            $( 'input', this ).on( 'keyup change', function () {
                if ( saleIndexTable.column(i).search() !== this.value ) {
                    saleIndexTable.column(i).search( this.value ).draw();
                }
            } );
        } );
        var saleIndexTable = $('#sale_index').DataTable({
            "scrollX": true,
            "processing": true,
            "orderCellsTop": true,
            "fixedHeader": true,
            "lengthChange": false,
            "columnDefs": [
            ],
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
                    $.get('/api/allotments', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        warehouseId: $('#warehouseId').val(),
                        dateRange: $('#dateRange').val(),
                        // typeDocument: $('#typeDocument').val(),
                        typeDocuments: selectedTypeDocuments,
                        }, function(res) {
                            arrayAllotments = [];
                            res.data.forEach(element => {
                                arrayAllotments[element.id] = element;
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
                    return data.code;
                }},
                {'data': function(data) {
                    if (data.war_transfers_id != null) {
                        return data.serie + '-' + data.number;
                    } else {
                        return 'RECUENTO DE INVENTARIO';
                    }
                }},
                {'data': function(data) {
                    return data.warehouse_name;
                }},
                {'data': function(data) {
                    var message = 'ABIERTO';
                    if (data.flag_closed == "1") {
                        message = 'CERRADO';
                    } else if (data.flag_active == "0") {
                        message = 'INACTIVO';
                    }
                    return message;
                }},                
                {'data': function(data) {
                    if (data.details[0]) {
                        return data.details[0].description;                        
                    } else {
                        return 0;
                    }
                }},
                {'data': function(data) {
                    if (data.details[0]) {
                        return data.details[0].quantity;
                    } else {
                        return 0;
                    }
                }},
                {'data': function(data) {
                    if (data.details[0]) {
                        return data.details[0].quantity_dispatch;
                    } else {
                        return 0;
                    }
                }},
                {'data': function(data) {
                    if (data.details[0]) {
                        return parseFloat(data.details[0].quantity - data.details[0].quantity_dispatch).toFixed(2);
                    } else {
                        return 0;
                    }
                }},
                {'data': function(data) {
                    if (data.details[0]) {
                        if (data.flag_active == 0) {
                            return 0;
                        } else {
                            return parseFloat(data.details[0].quantity - data.details[0].quantity_dispatch).toFixed(2);
                        }
                    } else {
                        return 0;
                    }
                }},
                {'data': function(data) {
                    if (data.details[0]) {
                        if (data.details[0].expiration_date == null) {
                            return 'SIN EXPIRACIÓN';
                        } else {
                            return data.details[0].expiration_date;
                        }
                    } else {
                        return '';
                    }
                }},
                {'data': function(data) {
                    if (data.flag_closed != "1") {
                        return '<button type="button" onClick="updateAllotment(' + data.id + ');" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button>';
                    } else {
                        return '<button type="button" disabled class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }},
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.flag_active == 1) {
                    switch (data.flag_closed) {
                        case 0:
                            $node.addClass('warning');
                            break;
                        case 1:
                            $node.addClass('success');
                            break;            
                        default:
                            break;
                    }
                } else {
                    $node.addClass('danger');
                }
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
        $('#editAllotmentExpirationDate').datepicker('setDate', 'now');
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

        updateAllotment = function(id) {
            editedId = id;
            document.getElementById('editedAllotmentText').innerHTML = '¿Desea actualizar el lote <strong>' + arrayAllotments[editedId].code + '</strong>?';
            document.getElementById('editAllotmentExpirationDate').value = arrayAllotments[editedId].details[0].expiration_date;
            $('#editAllotmentExpirationDate').datepicker('setDate', arrayAllotments[editedId].details[0].expiration_date);
            $('#modal-warning').modal({ keyboard: false });
        }

        editAllotmentSubmit = function() {
            if (editedId != 0) {
                editAllotmentBtn.disabled = true;
                editAllotmentBtn.innerHTML = 'PROCESANDO...';
                // AJAX
                var dataSend = {
                    expiration_date: document.getElementById('editAllotmentExpirationDate').value,
                }
                $.ajax({
                    method: "PATCH",
                    url: "/api/allotments/" + editedId,
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            editedId = 0;
                            editAllotmentBtn.disabled = false;
                            editAllotmentBtn.innerHTML = 'EL LOTE NO SE PUDO ACTUALIZAR. VOLVER A INTENTAR.';
                        }
                    }
                }).done(function(response) {
                    editedId = 0;
                    editAllotmentBtn.disabled = false;
                    editAllotmentBtn.innerHTML = 'ACEPTAR';
                    $('#searchButton').trigger('click');
                    $('#modal-warning').modal('toggle');
                });
            }
        }

        allotmentDetailModal = function(id) {
            detailId = id;
            document.getElementById('allotmentDetailMessage').innerHTML = 'DETALLE DEL PAGO #' + ("00000000" + arrayAllotments[detailId].id).slice(-8);
            // DATA ASSINGMENT
                // BASICS
                document.getElementById('flagSunat').value = parseFloat(arrayAllotments[detailId].flag_sunat).toFixed(2);
                document.getElementById('typeCharge').value = parseFloat(arrayAllotments[detailId].type_charge).toFixed(2);
                document.getElementById('totalImport').value = parseFloat(0.00).toFixed(2);
                document.getElementById('PaymentFinish').value = parseFloat(arrayAllotments[detailId].amount).toFixed(2);
                document.getElementById('outOfRangeImport').value = parseFloat(0.00).toFixed(2);
                if (arrayAllotments[detailId].json_data != null) {
                    arrayAllotments[detailId].json_data.forEach(element => {
                        switch (element.id) {
                            case "1":
                                // Cash
                                document.getElementById('cashReference').value = element.payment_data.reference;
                                document.getElementById('totalCash').value = parseFloat(element.payment_data.total).toFixed(2);
                                break;
                            case "2":
                                // Visa
                                document.getElementById('dateVisa').value = element.payment_data.date;
                                document.getElementById('visaCode').value = element.payment_data.code;
                                document.getElementById('totalVisa').value = parseFloat(element.payment_data.total).toFixed(2);
                                break;
                            case "3":
                                // Mastercard
                                document.getElementById('dateMastercard').value = element.payment_data.date;
                                document.getElementById('mastercardCode').value = element.payment_data.code;
                                document.getElementById('totalMastercard').value = parseFloat(element.payment_data.total).toFixed(2);
                                break;
                            case "6":
                                // Transfer
                                document.getElementById('majorAccountTransfer').value = element.payment_data.majorAccount;
                                document.getElementById('dateTransfer').value = element.payment_data.date;
                                document.getElementById('transferReference').value = element.payment_data.reference;
                                document.getElementById('totalTransfer').value = parseFloat(element.payment_data.total).toFixed(2);
                                break;
                            case "7":
                                // Check
                                document.getElementById('checkReference').value = element.payment_data.reference;
                                document.getElementById('checkCode').value = element.payment_data.code;
                                document.getElementById('dateCheckCharged').value = element.payment_data.date;
                                document.getElementById('totalCheck').value = parseFloat(element.payment_data.total).toFixed(2);
                                break;
                            default:
                                // Cash
                                document.getElementById('majorAccount').value = '';
                                document.getElementById('ccNumber').value = '';
                                document.getElementById('totalCash').value = parseFloat(0).toFixed(2);
                                // Transfer
                                document.getElementById('majorAccountTransfer').value = '';
                                document.getElementById('dateTransfer').value = '';
                                document.getElementById('transferReference').value = '';
                                document.getElementById('totalTransfer').value = parseFloat(0).toFixed(2);
                                // Check
                                document.getElementById('checkCode').value = '';
                                document.getElementById('dateCheckCharged').value = '';
                                document.getElementById('totalCheck').value = parseFloat(0).toFixed(2);
                                break;
                        }
                    });
                }
            // OPEN MODAL
            $('#modal-allotment-detail').modal({ keyboard: false });
        }
        
        paymentDeleteModal = function(id) {
            deleteId = id;
            document.getElementById('deletedSaleText').innerHTML = '¿Desea eliminar el pago #' + ("00000000" + arrayAllotments[deleteId].id).slice(-8) + '?';
            $('#modal-danger').modal({ keyboard: false });
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
                var saleDocument = arrayAllotments[convertToCreditNoteId];
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
                var saleDocument = arrayAllotments[convertToCreditNoteId];
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
            var saleDocument = arrayAllotments[id];
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
            $('#modal-credit-note').modal({ keyboard: false });
        }

        openModalConvertoToRemissionGuide = function (id) {
            document.getElementById('buttonModalSubmit').disabled = false;
            document.getElementById('buttonModalSubmit').onclick = function() { submitConvertToRemissionGuide(); }
            $('#modal-converto-to').modal({ keyboard: false });
            convertToId = id;
            var detailSaleCreatedAt = document.getElementById('detailSaleCreatedAtMct');
            if (arrayAllotments[id].customer_name == null) {
                arrayAllotments[id].customer_name     = arrayAllotments[id].customer_rz_social;
                arrayAllotments[id].customer_lastname = '';
            }
            var customer_address = arrayAllotments[id].customer_address;
            if (customer_address == null) {
                customer_address = 'SIN INFORMACIÓN';
            }

            var type_document_name = 'BOLETA';
            var detailSaleCreatedAtHeader__ = '¿DESEA GENERAR UNA GUÍA DE REMISIÓN A PARTIR DE LA VENTA: ' + arrayAllotments[id].ticket + '?<br>';
            if (arrayAllotments[id].sal_sale_states_id == 10) {
                detailSaleCreatedAtHeader__ = 'ESTA VENTA YA CUENTA CON UNA (O VARIAS) GUÍA DE REMISIÓN<br>';
                document.getElementById('buttonModalSubmit').disabled = true;
            }
            var detailSaleCreatedAt__ = detailSaleCreatedAtHeader__ +
                'CLIENTE: ' + arrayAllotments[id].customer_name + ' ' + arrayAllotments[id].customer_lastname + '<br>' +
                'DIRECCIÓN CLIENTE: ' + customer_address + '<br>';
            detailSaleCreatedAt.innerHTML = detailSaleCreatedAt__;

            var detailSaleEmployeeName = document.getElementById('detailSaleEmployeeNameMct');
            var commentary = "";
            if (arrayAllotments[id].commentary != null) {
                commentary = arrayAllotments[id].commentary;
            }
            detailSaleEmployeeName.innerHTML = 'ATENDIDO POR: ' + arrayAllotments[id].employee_name + ' ' + arrayAllotments[id].employee_lastname + '<br>' + commentary;
            //ITEMS TABLE
            var detailSaleItemsTable = document.getElementById('detailSaleItemsTableMct');
            var htmlDetailSaleItemsTable = '<table class="table" align="center"><thead><tr><th>DESCRIPCIÓN DE PRODUCTOS</th><th>CANTIDAD</th><th>PRECIO UNITARIO</th><th>PRECIO TOTAL</th></tr></thead>';
                arrayAllotments[id].items.forEach(element => {
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
            var sale = arrayAllotments[id];
            var deleteSaleText = document.getElementById('sendEmailText');
            var email = document.getElementById('sendEmailComment');
            email.value = sale.customer_email;
            deleteSaleText.innerHTML = "¿Desea enviar la venta #" + sale.serie + '-' + sale.number + " por correo electrónico?";
        }
        
        openSign = function(id) {
            var myWindow = window.open("", "MsgWindow", "width=200, height=200");
            myWindow.document.write("<img width='200px' height='200px' src='data:image/png;base64, " + arrayAllotments[id].data_client[0].customer_validation_sign + "'>");
        }

        deletePaymentSubmit = function() {            
            $('#modal-on-load').modal({ keyboard: false });
            if (deleteId != 0) {
                var comment = document.getElementById('deleteSaleComment').value;
                $.ajax({
                    url: "/api/payments/" + deleteId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deleteId = 0;
                            alert("El pago no se pudo eliminar.");
                        }
                    }
                }).done(function(response) {
                    $('#modal-on-load').modal('toggle');
                    deleteId = 0;
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo eliminar el pago con id " + deleteId);
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