<!-- Laravel App -->
<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.lightSlider.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/bootstrap-toggle/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
<!-- Datatables -->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script>
    //Document Ready
    $(document).ready(function() {
        //Initialize variables
        var data = {};
        var amount = 0;
        var paymentAmount = 0;
        var arrayDocuments = [];
        var arraySelectedDocuments = [];
        //Data variables
        data.currency = 'PEN';
        data.customer = null;
        data.customerId = 0;
        //Date range picker
        $('#dateCheckCharged').datepicker('setDate', 'now');
        $('#dateTransfer').datepicker('setDate', 'now');
        $('#dateVisa').datepicker('setDate', 'now');
        $('#dateMastercard').datepicker('setDate', 'now');
        // functions
        function autocompleteForClients(inp) {
            var currentFocus;
            var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items-payments");
                    this.parentNode.appendChild(a);
                    mainheaderSearchBar.style.height = "50px";
                    if (val.length > 3) {
                        //LLAMADA AL SERVICIO
                        $.ajax({
                            url: "/api/customers?searchInput=" + val,
                            context: document.body,
                            statusCode: {
                                404: function() {
                                    alert("No se encontró al cliente. ¿Desea registrarlo?");
                                }
                            }
                        }).done(function(response) {
                            if (response.data.length == 0) {
                                var searchNewClientSunat = document.getElementById('searchNewClientSunat');
                                searchNewClientSunat.value = inp.value;
                                inp.value = "";
                                $('#newClient').trigger('click');
                            } else if (response.data.length == 1) {
                                inp.value = response.data[0].name + ' ' + response.data[0].lastname;
                                data.newCustomer = response.data[0];
                                data.newCustomer.typeCustomer = response.data[0].flag_type_person;
                                chooseClient();
                                closeAllLists();
                                searchSaleForm();
                            } else {
                                for (i = 0; i < response.data.length; i++) {
                                    var nameLastname = response.data[i].name + ' ' + response.data[i].lastname + ' - ' + response.data[i].dni;
                                    if (response.data[i].flag_type_person == 2) {
                                        nameLastname = response.data[i].rz_social + ' - ' + response.data[i].ruc;
                                    }
                                    b = document.createElement("DIV");
                                    b.style.background = '#ffffff';
                                    b.setAttribute('class', 'form-control-autocomplete');
                                    b.style.cursor = 'pointer';
                                    b.innerHTML += nameLastname;
                                    b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                    b.addEventListener("click", function(e) {
                                        var iterator = this.getElementsByTagName("input")[0].value;
                                        inp.value = response.data[iterator].name + ' ' + response.data[iterator].lastname;
                                        data.newCustomer = response.data[iterator];
                                        data.newCustomer.typeCustomer = response.data[iterator].flag_type_person;
                                        chooseClient();
                                        closeAllLists();
                                        searchSaleForm();
                                    });
                                    a.appendChild(b);
                                }                            
                            }
                        });
                    }
                }
            });
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items-payments");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        function chooseClient() {
            genericCustomer = data.newCustomer;
            data.customer   = genericCustomer;
            data.customerId = genericCustomer.id;
            if (genericCustomer.name == null) {
                genericCustomer.name = genericCustomer.rz_social;
                genericCustomer.lastname = '';
            }
            document.getElementById("inputSearchClient").value = genericCustomer.name + " " + genericCustomer.lastname;
        }
        function newSaleButton() {
            location.reload();
        }
        //var functions
        searchSaleForm = function () {
            arraySelectedDocuments = [];
            var genericCustomer_ = JSON.parse(document.getElementById("genericCustomer").value);
            if (data.customerId != genericCustomer_.id && data.customerId != 0) {
                $('#modal-search-sale').modal({ backdrop: 'static', keyboard: false });
                searchQuotationObj = null;
                var customerId__ = data.customerId;
                var table = $('#searchQuotationTable').DataTable();
                table.destroy();
                table = $('#searchQuotationTable').DataTable({
                    // "scrollX": true,
                    "processing": true,
                    "orderCellsTop": true,
                    "order" : [[ 5, "desc" ]],
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
                            $.get('/api/search-document-without-payments-by-customer-id/' + customerId__, {
                                limit: data.length,
                                offset: data.start,
                                }, function(res) {
                                    arrayDocuments = res.data;
                                    callback({
                                        recordsTotal: res.total,
                                        recordsFiltered: res.total,
                                        data: res.data
                                    });
                                });
                    },
                    "columns" : [
                        {
                            "orderable": false,
                            "data": function (data) {
                                return '<input type="checkbox" id="checkBoxSearchDocument_' + data.id + '" />';
                            },
                        },
                        { "data": function (data) {
                            var message = data.ticket + ' <span> </span><button type="button" title="Descargar venta en formato PDF" onClick="downloadPdfById(' + data.id + ')" class="btn btn-default btn-xs"><i class="fa fa-print"></i></button>';
                            if (data.ticket == null) {
                                message = 'SIN DOCUMENTO';
                            }
                            return message;
                        }},
                        { "data": "currency" },
                        { "data": function (data) {
                            return parseFloat(data.paymentAmount).toFixed(2);
                        }},
                        { "data": function (data) {
                            return parseFloat(data.amount).toFixed(2);
                        }},
                        { "data": "created_at" }
                    ],
                    "responsive": true,
                    "bDestroy": true,
                });

                // Add event listener for opening and closing details
                $('#searchQuotationTable tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row( tr );            
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        // row.child.hide();
                        // tr.removeClass('shown');
                    } else {
                        // Open this row
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                    }
                });

                document.getElementById('button').disabled = false;
            } else {
                alert('Cliente no válido. Ingrese un cliente RUC o DNI');
            }
        }
        searchQuotationCheckbox = function () {
            arrayDocuments.forEach(element => {
                var checkBoxSearchDocument_ = document.getElementById('checkBoxSearchDocument_' + element.id);
                if (checkBoxSearchDocument_ != null && checkBoxSearchDocument_.disabled == false) {
                    document.getElementById('checkBoxSearchDocument_' + element.id).checked = document.getElementById('mainCheckbox').checked;
                }
            });
        }
        downloadPdfById = function(id) {
            window.open('/api/print-sale-pdf-by-id/' + id);
        }
        openModalCreateSinglePayment = function (id) {
            amount = 0;
            paymentAmount = 0;

            arrayDocuments.forEach(element => {
                if (document.getElementById('checkBoxSearchDocument_' + element.id) != null) {
                    if (document.getElementById('checkBoxSearchDocument_' + element.id).checked) {
                        amount = parseFloat(amount) + parseFloat(element.amount);
                        paymentAmount = parseFloat(paymentAmount) + parseFloat(element.paymentAmount);
                        arraySelectedDocuments.push({
                            id: element.id,
                            amount: element.amount,
                            ticket: element.ticket,
                            createdAt: element.created_at,
                            typeDocument: element.sal_type_document_id,
                            paymentAmount: element.paymentAmount
                        });
                    }
                }
            });

            document.getElementById('totalImport').value = parseFloat(0.00).toFixed(2);
            document.getElementById('PaymentFinish').value = parseFloat(paymentAmount).toFixed(2);
            document.getElementById('outOfRangeImport').value = (parseFloat(amount) - parseFloat(paymentAmount)).toFixed(2);
            $('#modal-create-single-payment').modal({ backdrop: 'static', keyboard: false });
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
            var typePaymentId = 5;
            if (availablePayments.length == 1) {
                typePaymentId = availablePayments[0].id;
            }
            var dataSend = {
                sal_sale_documents_id: null,
                sal_type_document_id: null,
                sal_type_payments_id: typePaymentId,
                customer_id: data.customerId,
                currency: tabCurrency,
                amount: amountPayment,
                sale_amount: amount,
                json_data: availablePayments,
                json_sales: arraySelectedDocuments,
                flag_sunat: flagSunat,
                type_charge: typeCharge,
            };
            // Api Call
            $.ajax({
                method: "POST",
                url: "/api/payments",
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
                $('#modal-final-step').modal({ backdrop: 'static', keyboard: false });
            });
        }
        //AUTOCOMPLETE LOGIC
        autocompleteForClients(document.getElementById('inputSearchClient'));
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>