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
    var stateId = 8;
    var changeCheckbox;
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

        // CONVERT DIRECTLY
        changeCheckbox = function () {
            if (convertToId != 0) {
                arraySales[convertToId].items.forEach(element => {
                    var checkboxConvertTo_ = document.getElementById('checkboxConvertTo_' + element.id);
                    if (checkboxConvertTo_.disabled == false) {
                        checkboxConvertTo_.checked = document.getElementById('mainCheckbox').checked;                        
                    }
                });
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
                    detailSaleCreatedAtHeader__ = 'NO SE PUEDE CONVERTIR ESTA COTIZACIÓN. SIN DOCUMENTO DE CONVERSIÓN.<br>';
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

            var type_document_name = 'BOLETA';
            var detailSaleCreatedAtHeader__ = '¿DESEA GENERAR UNA GUÍA DE REMISIÓN A PARTIR DE COTIZACIÓN: ' + arraySales[id].ticket + '?<br>';
            switch (arraySales[id].data_client[0].quotationTypeDocument) {
                case 1:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    break;
                case 2:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    break;
                case 3:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    break;                        
                default:
                    document.getElementById('buttonModalSubmit').disabled = true;
                    detailSaleCreatedAtHeader__ = 'NO SE PUEDE CONVERTIR ESTA COTIZACIÓN. SIN DOCUMENTO DE CONVERSIÓN.<br>';
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
            var htmlDetailSaleItemsTable = '<table class="table" align="center"><thead><tr><th><input type="checkbox" id="mainCheckbox" onchange="changeCheckbox();" /></th><th>DESCRIPCIÓN DE PRODUCTOS</th><th>DISPONIBLE</th><th>TOTAL</th><th>PRECIO UNITARIO</th><th>PRECIO TOTAL</th></tr></thead>';
                arraySales[id].items.forEach(element => {
                    var disabled = '';
                    var readOnly = '';
                    if ((parseFloat(element.quantity) - parseFloat(element.converted)) <= 0) {
                        disabled = 'disabled';
                        readOnly = 'readonly';
                    }
                    htmlDetailSaleItemsTable = htmlDetailSaleItemsTable + '<tr><td><input type="checkbox" ' + disabled + ' id="checkboxConvertTo_' + element.id + '"></td><td>' + element.name + '</td><td><input type="number" onClick="this.select();" ' + readOnly + ' id="quantityConvertTo_' + element.id + '" value="' + (parseFloat(element.quantity) - parseFloat(element.converted)) + '" /></td><td>' + element.quantity + '</td><td>' + element.currency + ' ' + element.price + '</td><td>' + element.currency + ' ' +  (element.quantity*element.price) + '</td></tr>';
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

            var type_document_name = 'BOLETA';
            var detailSaleCreatedAtHeader__ = '¿DESEA GENERAR UNA ' + type_document_name + ' DE RESERVA A PARTIR DE COTIZACIÓN: ' + arraySales[id].ticket + '?<br>';
            switch (arraySales[id].data_client[0].quotationTypeDocument) {
                case 1:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    type_document_name = 'PRECUENTA';
                    detailSaleCreatedAtHeader__ = '¿DESEA GENERAR UNA ' + type_document_name + ' DE RESERVA A PARTIR DE COTIZACIÓN: ' + arraySales[id].ticket + '?<br>';
                    break;
                case 2:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    type_document_name = 'BOLETA';
                    detailSaleCreatedAtHeader__ = '¿DESEA GENERAR UNA ' + type_document_name + ' DE RESERVA A PARTIR DE COTIZACIÓN: ' + arraySales[id].ticket + '?<br>';
                    break;
                case 3:
                    document.getElementById('buttonModalSubmit').disabled = false;
                    type_document_name = 'FACTURA';
                    detailSaleCreatedAtHeader__ = '¿DESEA GENERAR UNA ' + type_document_name + ' DE RESERVA A PARTIR DE COTIZACIÓN: ' + arraySales[id].ticket + '?<br>';
                    break;                        
                default:
                    document.getElementById('buttonModalSubmit').disabled = true;
                    type_document_name = 'SIN INFORMACIÓN';
                    detailSaleCreatedAtHeader__ = 'NO SE PUEDE CONVERTIR ESTA COTIZACIÓN. SIN DOCUMENTO DE CONVERSIÓN.<br>';
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
        
        submitConvertToRemissionGuide = function () {
            if (convertToId != 0) {
                var dataSend = {
                    items : []
                };
                arraySales[convertToId].items.forEach(element => {
                    if (document.getElementById('checkboxConvertTo_' + element.id).checked) {
                        if (Number(document.getElementById('quantityConvertTo_' + element.id).value) > 0) {
                            var item = element;
                            if (document.getElementById('quantityConvertTo_' + element.id).value < (parseFloat(item.quantity) - parseFloat(item.converted))) {
                                item.quantity = document.getElementById('quantityConvertTo_' + element.id).value;
                            } else {
                                item.quantity = (parseFloat(item.quantity) - parseFloat(item.converted));
                            }
                            dataSend.items.push(item);
                        }
                    }
                });

                if (dataSend.items.length > 0) {
                    $.ajax({
                        url: "/api/sales/convert-to-remission-guide/" + convertToId,
                        context: document.body,
                        data: dataSend,
                        method: "POST",
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
                    alert("Se necesita escoger almenos un producto para crear la guía de remisión.");
                }
            } else {
                console.log("No se pudo generar el documento solicitado " + convertToId);
            }
        }

        submitConvertToReserveInvoice = function () {
            if (convertToId != 0) {
                var comment = document.getElementById('deleteSaleComment').value;
                $.ajax({
                    url: "/api/sales/convert-to-reserve-invoice/" + convertToId,
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
                    $.get('/api/quotations', {
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
                {'data': function (data, type, dataToSet) {
                        return data.ticket;
                    }
                },
                {'data': 'warehouse_name'},
                {'data': function (data, type, dataToSet) {
                        if (data.customer_flag_type_person == 2) {
                            return data.customer_rz_social.toUpperCase();
                        } else {
                            return data.data_client[0].name.toUpperCase();
                        }
                    }
                },
                {'data': function (data, type, dataToSet) {
                        return data.employee_name + ", " + data.employee_lastname;
                    }
                },
                {'data': function (data) {
                    if ((data.sal_sale_states_id == 12 || data.sal_sale_states_id == 10 || data.sal_sale_states_id == 8 || data.sal_sale_states_id == 5)) {
                        return '<select class="form-control" disabled><option value="0">' + data.sale_state_name + '</option></select>';
                    } else {
                        return '<select class="form-control" onChange="changeQuotationStatus(' + data.id + ');">' + 
                                '<option selected value="' + data.sal_sale_states_id + '">' + data.sale_state_name + '</option>' + 
                                '<option value="12">CERRADO</option>' + 
                            '</select>';
                    }
                }},
                {'data': function(data) {
                    var message = '';
                    if (data.table_code != null) {
                        message = data.table_code;
                    }
                    return message;
                }},
                {'data': 'currency_amount'},
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data) {
                    if ((data.sal_sale_states_id != 12 && data.sal_sale_states_id != 10 && data.sal_sale_states_id != 8) && data.customer_id != null && data.sal_sale_states_id != 5) {
                        var saleJson = JSON.stringify(data);
                        let objJsonB64 = btoa((encodeURIComponent(saleJson).replace(/%([0-9A-F]{2})/g,
                            function toSolidBytes(match, p1) {
                                return String.fromCharCode('0x' + p1);
                        })));
                        return '<button title="Detalle de cotización" type="button" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button title="Imprimir cotización" type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                            '<button title="Eliminar cotización" type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteSale(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            '<form method="POST" action="/new-sale" style="padding-right:3px; display:inline;"><input type="hidden" name="saleJson" value='+ objJsonB64 +' /><button title="Crear Venta Web" type="submit" class="btn btn-warning btn-xs"><i class="fa fa-arrow-circle-right"></i></button></form>' +
                            '<button title="Crear Guía de Remisión" type="button" class="btn btn-primary btn-xs" onClick="openModalConvertoToRemissionGuide('+ data.id +');"><i class="fa fa-bars"></i></button><span> </span>' +
                            '<button style="margin:1px;" title="Crear Venta Directa" type="button" class="btn btn-primary btn-xs" onClick="openModalConvertoToDirectInvoice('+ data.id +');"><i class="fa fa-lock"></i></button><span> </span>' +
                            '<button title="Crear Venta de Reserva" type="button" class="btn btn-primary btn-xs" onClick="openModalConvertoToReserveInvoice('+ data.id +');"><i class="fa fa-unlock"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            '<button type="button" title="Enviar venta por correo electrónico" data-toggle="modal" data-target="#modal-send-mail" onClick="sendEmail(' + data.id + ')" class="btn btn-primary btn-xs"><i class="fa fa-envelope"></i></button>';
                    } else if (data.customer_id == null && data.sal_sale_states_id != 5) {
                        var saleJson = JSON.stringify(data);
                        let objJsonB64 = btoa((encodeURIComponent(saleJson).replace(/%([0-9A-F]{2})/g,
                            function toSolidBytes(match, p1) {
                                return String.fromCharCode('0x' + p1);
                        })));
                        return '<button title="Detalle de cotización" type="button" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button title="Imprimir cotización" type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                            '<button title="Eliminar cotización" type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteSale(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            // '<button title="Crear Guía de Remisión" type="button" disabled class="btn btn-primary btn-xs"><i class="fa fa-bars"></i></button><span> </span>' +
                            // '<button title="Crear Venta Directa" type="button" disabled class="btn btn-primary btn-xs"><i class="fa fa-lock"></i></button><span> </span>' +
                            // '<button title="Crear Venta de Reserva" type="button" disabled class="btn btn-primary btn-xs"><i class="fa fa-unlock"></i></button><span> </span>' + 
                            '<form method="POST" action="/new-sale"><input type="hidden" name="saleJson" value='+ objJsonB64 +' /><button title="Crear Venta Web" type="submit" class="btn btn-warning btn-xs"><i class="fa fa-arrow-circle-right"></i></button></form><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            '<button type="button" title="Enviar venta por correo electrónico" data-toggle="modal" data-target="#modal-send-mail" onClick="sendEmail(' + data.id + ')" class="btn btn-primary btn-xs"><i class="fa fa-envelope"></i></button>';
                    } else {
                        return '<button title="Detalle de cotización" type="button" data-toggle="modal" data-target="#modal-info" onClick="saleDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" title="Descargar venta en formato PDF A4" onClick="downloadPdfFeById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-file-pdf-o"></i></button><span> </span>' + 
                            '<button title="Imprimir cotización" type="button" onClick="downloadPdfById(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                            '<button title="Eliminar cotización" type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            '<button disabled title="Crear Venta Web" type="submit" class="btn btn-warning btn-xs"><i class="fa fa-arrow-circle-right"></i></button><span> </span>' +
                            '<button title="Crear Guía de Remisión" type="button" disabled class="btn btn-primary btn-xs"><i class="fa fa-bars"></i></button><span> </span>' +
                            '<button title="Crear Venta Directa" type="button" disabled class="btn btn-primary btn-xs"><i class="fa fa-lock"></i></button><span> </span>' +
                            '<button title="Crear Venta de Reserva" type="button" disabled class="btn btn-primary btn-xs"><i class="fa fa-unlock"></i></button><span> </span><br><hr style="margin:2px; border-top: 0px;">' +
                            '<button type="button" title="Enviar venta por correo electrónico" data-toggle="modal" data-target="#modal-send-mail" onClick="sendEmail(' + data.id + ')" class="btn btn-primary btn-xs"><i class="fa fa-envelope"></i></button>';
                    }
                }}
            ]
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

        sendEmail = function(id) {
            sendEmailId = id;
            var sale = arraySales[id];
            var deleteSaleText = document.getElementById('sendEmailText');
            var email = document.getElementById('sendEmailComment');
            email.value = sale.customer_email;
            deleteSaleText.innerHTML = "¿Desea enviar la venta #" + sale.serie + '-' + sale.number + " por correo electrónico?";
        }

        sendEmailSubmit = function () {
            document.getElementById('buttonSendMail').enabled = false;
            var email = document.getElementById('sendEmailComment');
            
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
           
        }

        downloadPdfFeById = function(id) {
            var sale = arraySales[id];
            window.open('https://sm-soft.tumi-soft.com/web/fe-document-pdf/' + sale.fe_ruc + '/' + sale.ticket);
        }

        // openWebSale = function(id) {
        //     $.post( "/new-sale", { saleId: id} );
        // }
        
        changeQuotationStatus = function(id) {
            deletedSaleId = id;
            stateId = 12;
            var sale = arraySales[id];
            var deletedSaleText = document.getElementById('deletedSaleText');
            if (deletedSaleText != null) {
                document.getElementById('deletedSaleHeadText').innerHTML = 'CERRAR COTIZACIÓN';
                deletedSaleText.innerHTML = "¿Desea cambiar el estado de la cotización #" + sale.ticket + "?";                
            }
            $('#modal-danger').modal({ backdrop: 'static', keyboard: false });
        }

        deleteSale = function(id) {
            deletedSaleId = id;
            var sale = arraySales[id];
            var deletedSaleText = document.getElementById('deletedSaleText');
            if (deletedSaleText != null) {
                deletedSaleText.innerHTML = "¿Desea eliminar la cotización #" + sale.ticket + "?";                
            }
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
            if (deletedSaleId != 0) {
                var comment = document.getElementById('deleteSaleComment').value;
                $.ajax({
                    url: "/api/sales/" + deletedSaleId + "?comment=" + comment + '&stateId=' + stateId,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            $('#modal-danger').modal('toggle');
                            deletedSaleId = 0;
                            stateId = 8;
                            alert("La cotización no se pudo eliminar.");
                        }
                    }
                }).done(function(response) {
                    $('#modal-danger').modal('toggle');
                    deletedSaleId = 0;
                    stateId = 8;
                    $('#searchButton').trigger('click');
                });
            } else {
                console.log("No se pudo eliminar la cotización con id " + deletedSaleId);
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