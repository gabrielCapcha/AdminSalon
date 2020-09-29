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
    var values = 1;
    var documentDetailModal;
    var deleteDocument;
    var deleteDocumentSubmit;
    var saveEditDocumentSubmit;
    var editDocumentId = 0;
    var deletedDocumentId = 0;
    var editDocument;
    var arraySales = [];
    $(document).ready(function() {
        var saleIndexTable = $('#open_cash_3').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            "serverSide": true,
            "bPaginate": false,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                    values = 1;
                    $.get('/api/expenses', {
                        limit: data.length,
                        offset: data.start,
                        warehouseId: $('#warehouseId').val(),
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
                {'data': 'warehouseName'},
                {'data':   function (data) {
                        return data.lastname.toUpperCase() + ", " + data.name.toUpperCase();
                    }
                },
                {'data': function(data) {
                    return data.expense_date.substring(0,10);
                }},
                {'data': function(data) {
                    return data.expense_date.substring(11,20);
                }},
                {'data': 'name_'},
                {'data': 'description'},
                {'data': function (data) {
                    var message = 'POR DEFECTO';
                    if (data.type_expense_name != null) {
                        message = data.type_expense_name;
                    }
                    return message;
                }},
                {'data': function (data) {
                    var message = 'EFECTIVO';
                    if (data.sal_type_payments_id == 6) {
                        message = 'DEPÓSITO';
                    }
                    return message;
                }},
                {'data': function (data) {
                    var message = 'SIN DATOS';
                    if (data.operation_number != null) {
                        message = data.operation_number;
                    }
                    return message;
                }},
                {'data': function (data) {
                        return data.currency + ' ' + parseFloat(data.amount).toFixed(2);
                    }
                },
                {'data':   function (data) {
                        if (data.flag_active == 0) {
                            return data.updated_at;
                        } else {
                            return 'SIN ANULAR';
                        }
                    }
                },
                {'data': function (data) {
                    if (data.flag_active == 0) {
                        //deshabilitado
                        return '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" data-target="#modal-info" onClick="documentDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    } else {
                        //habilitado
                        return '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteDocument(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" data-target="#modal-info" onClick="documentDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" data-target="#modal-edit" onClick="editDocument(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }}
            ],
            "responsive": true
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
        );

        //Var Functions
        documentDetailModal = function(id) {
            var detailOpenCashCreatedAt = document.getElementById('detailOpenCashCreatedAt');
            detailOpenCashCreatedAt.innerHTML = 'GASTO DE LA EMPRESA: '  + arraySales[id].created_at;
            //ITEMS TABLE
            document.getElementById('warehouseName').innerHTML = arraySales[id].warehouseName;
            document.getElementById('employeeName').innerHTML = arraySales[id].lastname.toUpperCase() + ", " + arraySales[id].name.toUpperCase();
            document.getElementById('dateValue').innerHTML = arraySales[id].created_at;
            document.getElementById('amountValue').innerHTML = arraySales[id].currency + ' ' + arraySales[id].amount;
            document.getElementById('expenseName').innerHTML = arraySales[id].name_;
            document.getElementById('expenseDescription').innerHTML = arraySales[id].description;
            if (arraySales[id].url_image != null && arraySales[id].url_image != "") {
                document.getElementById('expenseImage').href = arraySales[id].url_image;
                document.getElementById('expenseImage').target = '_blank';
            } else {
                document.getElementById('expenseImage').innerHTML = 'No tiene imagen adjunta';
            }
            //ITEMS TABLE
        }

        saveEditDocumentSubmit = function() {
            if (editDocumentId != 0) {
                var editAmountValue_ = document.getElementById('editAmountValue').value;
                var editNameValue_ = document.getElementById('editNameValue').value;
                var editDescriptionValue_ = document.getElementById('editDescriptionValue').value;
                $.ajax({
                    url: "/api/expenses/" + editDocumentId,
                    context: document.body,
                    method: "PATCH",
                    data: {
                        "value": parseFloat(editAmountValue_),
                        "name": editNameValue_,
                        "description": editDescriptionValue_,
                    },
                    statusCode: {
                        400 : function() {
                            editDocumentId = 0;
                            alert("El gasto no se pudo editar.");
                        }
                    }
                }).done(function(response){
                    editDocumentId = 0;
                    window.location.href = "/expenses";
                });
            } else {
                console.log("No se pudo editar el gasto con id " + editDocumentId);
            }
        }

        deleteDocument = function(id) {
            deletedDocumentId = id;
            var deleteSaleText = document.getElementById('deletedSaleText');
            deleteSaleText.innerHTML = "¿Desea eliminar el gasto?";
        }

        deleteDocumentSubmit = function(){
            if (deletedDocumentId != 0) {
                var comment = document.getElementById('deleteDocumentComment').value;
                console.log("El motivo de la eliminación: " + comment);
                $.ajax({
                    url: "/api/expenses/" + deletedDocumentId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400:function() {
                            deletedDocumentId = 0;
                            alert("El gasto no se pudo eliminar.");
                        }
                    }
                }).done(function(response){
                    deletedDocumentId = 0;
                    window.location.href = "/expenses";
                });
            } else {
                console.log("No se pudo eliminar el gasto con id " +deletedDocumentId);
            }
        }   
        editDocument = function(id) {
            editDocumentId = id;
            var editOpenCashCreatedAt = document.getElementById('editOpenCashCreatedAt');
            editOpenCashCreatedAt.innerHTML = 'GASTO: '  + arraySales[id].created_at;
            //ITEMS TABLE
            document.getElementById('editWarehouseName').innerHTML = arraySales[id].warehouseName;
            document.getElementById('editEmployeeName').innerHTML = arraySales[id].lastname.toUpperCase() + ", " + arraySales[id].name.toUpperCase();
            document.getElementById('editDateValue').innerHTML = arraySales[id].created_at;
            document.getElementById('editAmountValue').value = arraySales[id].amount;
            document.getElementById('editNameValue').value = arraySales[id].name_;
            document.getElementById('editDescriptionValue').value = arraySales[id].description;
            //ITEMS TABLE
        }    
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>