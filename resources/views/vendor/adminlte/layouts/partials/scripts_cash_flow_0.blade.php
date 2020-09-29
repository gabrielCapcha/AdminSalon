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
    var editDocument;
    var deleteDocument;
    var deleteDocumentSubmit;
    var editDocumentId = 0;
    var deletedDocumentId = 0;
    var arraySales = [];
    $(document).ready(function() {
        var saleIndexTable = $('#open_cash_0').DataTable({
            "processing": true,
            "scrollX": true,
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
                    $.get('/api/open-cash', {
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
                {'data':   function (data, type, dataToSet) {
                        return data.name.toUpperCase() + " " + data.lastname.toUpperCase();
                    }
                },
                {'data': function (data, type, dataToSet) {
                        return data.currency + ' ' + data.amount;
                    }
                },
                {'data': 'date_opening'},
                {'data': 'time_opening'},
                {'data':   function (data, type, dataToSet) {
                        if (data.sal_cash_desk_pre_closing_id != null) {
                            return 'SÍ';
                        } else {
                            return 'NO';
                        }
                    }
                },
                {'data':   function (data, type, dataToSet) {
                        if (data.flag_active == 0) {
                            return data.updated_at;
                        } else {
                            return 'SIN ANULAR';
                        }
                    }
                },
                {'data': function (data, type, dataToSet) {
                    if (data.flag_active == 0 || (data.sal_cash_desk_pre_closing_id != null)) {
                        //deshabilitado
                        return '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" data-target="#modal-info" onClick="documentDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>';
                    } else {
                        //habilitado
                        return '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteDocument(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" data-target="#modal-info" onClick="documentDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>';
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

        //functions
        function saveEditDocument() {
            if (editDocumentId != 0) {
                var editAmountValue_ = document.getElementById('editAmountValue').value;
                $.ajax({
                    url: "/api/open-cash/" + editDocumentId,
                    context: document.body,
                    method: "PATCH",
                    data: {
                        "value": parseFloat(editAmountValue_)
                    },
                    statusCode: {
                        400 : function() {
                            editDocumentId = 0;
                            alert("La apertura de caja no se pudo editar.");
                        }
                    }
                }).done(function(response){
                    editDocumentId = 0;
                    window.location.href = "/open-cash";
                });
            } else {
                console.log("No se pudo editar la apertura de caja con id " + editDocumentId);
            }
        }

        //Var functions
        documentDetailModal = function(id) {
            var detailOpenCashCreatedAt = document.getElementById('detailOpenCashCreatedAt');
            detailOpenCashCreatedAt.innerHTML = 'APERTURA DE CAJA: '  + arraySales[id].created_at;
            //ITEMS TABLE
            document.getElementById('warehouseName').innerHTML = arraySales[id].warehouseName;
            document.getElementById('employeeName').innerHTML = arraySales[id].lastname.toUpperCase() + ", " + arraySales[id].name.toUpperCase();
            document.getElementById('dateValue').innerHTML = arraySales[id].date_opening;
            document.getElementById('timeValue').innerHTML = arraySales[id].time_opening;
            document.getElementById('amountValue').innerHTML = arraySales[id].currency + ' ' + arraySales[id].amount;
            document.getElementById('commentaryValue').innerHTML = arraySales[id].commentary;
            //ITEMS TABLE
        }
        deleteDocument = function(id) {
            deletedDocumentId = id;
            var deleteSaleText = document.getElementById('deletedSaleText');
            deleteSaleText.innerHTML = "¿Desea eliminar la apertura de la caja?";
        }
        deleteDocumentSubmit = function(){
            if (deletedDocumentId != 0) {
                var comment = document.getElementById('deleteDocumentComment').value;
                $.ajax({
                    url: "/api/open-cash/" + deletedDocumentId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400:function() {
                            deletedDocumentId = 0;
                            alert("La apertura de caja no se pudo eliminar.");
                        }
                    }
                }).done(function(response){
                    deletedDocumentId = 0;
                    window.location.href = "/open-cash";
                });
            } else {
                console.log("No se pudo eliminar la apertura de caja con id " + deletedDocumentId);
            }
        }
        editDocument = function(id) {
            editDocumentId = id;
            var editOpenCashCreatedAt = document.getElementById('editOpenCashCreatedAt');
            editOpenCashCreatedAt.innerHTML = 'APERTURA DE CAJA: '  + arraySales[id].created_at;
            //ITEMS TABLE
            document.getElementById('editWarehouseName').innerHTML = arraySales[id].warehouseName;
            document.getElementById('editEmployeeName').innerHTML = arraySales[id].lastname.toUpperCase() + ", " + arraySales[id].name.toUpperCase();
            document.getElementById('editDateValue').innerHTML = arraySales[id].date_opening;
            document.getElementById('editTimeValue').innerHTML = arraySales[id].time_opening;
            document.getElementById('editAmountValue').value = arraySales[id].amount;
            document.getElementById('editCommentaryValue').value = arraySales[id].commentary;
            //ITEMS TABLE
        }
        
        //Click functions
        $('#saveEditDocument').click(saveEditDocument);
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>