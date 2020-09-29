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
    var cashClosingId__ = 0;
    var documentDetailModal;
    var showProductSummary;
    var printDocument;
    var openPdf;
    var arrayCashClose = [];
    $(document).ready(function() {
        var saleIndexTable = $('#open_cash_6').DataTable({
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
                    $.get('/api/cash-closing', {
                        limit: data.length,
                        offset: data.start,
                        warehouseId: $('#warehouseId').val(),
                        dateRange: $('#dateRange').val(),
                        }, function(res) {
                            arrayCashClose = [];
                            res.data.forEach(element => {
                                arrayCashClose[element.id] = element;
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
                        return data.lastname.toUpperCase() + ", " + data.name.toUpperCase();
                    }
                },
                {'data': function(data) {
                    return data.closed_at.substring(0,10);
                }},
                {'data': function(data) {
                    return data.closed_at.substring(11,20);
                }},
                {'data': 'total_preclosing'},
                {'data': function (data, type, dataToSet) {
                    if (data.flag_active == 0) {
                        //deshabilitado
                        return '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>';
                    } else {
                        //habilitado
                        return '<div id="loader_' + data.id + '" class="loader"></div><span> </span>' +
                        '<button id="buttonPrint_' + data.id + '" type="button" onClick="openPdf(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button><span> </span>' +
                        '<button type="button" onClick="showProductSummary(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-list-ol"></i></button>';
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
    
        //Functions
        showProductSummary = function(id) {
            var table = $('#productsSummary').DataTable();
            table.destroy();
            var cashClose       = arrayCashClose[id];
            var detailCashClose = document.getElementById('detailCashClose');
            detailCashClose.innerHTML = 'DETALLE DE PRODUCTOS DE CIERRE DE CAJA: ' + cashClose.closed_at;
            $.ajax({
                method: 'GET',
                url: '/api/cash-summary/' + id,
                context: document.body,
            }).done(function(response) {
                //logic response
                var tbodyProductsSummary = document.getElementById('tbodyProductsSummary');
                var table = $('#example1').DataTable();
                table.destroy();
                $("#tbodyProductsSummary tr").remove();
                response.items.forEach(element => {
                    var tr = document.createElement('tr');
                    var trText_ = '<td>' + element.name + '</td><td>' + element.code + '</td><td>' + element.currency + '</td><td>' + parseFloat(element.quantity).toFixed(2) + '</td><td>' + parseFloat(element.price).toFixed(2) + '</td>' +
                        '<td>' + parseFloat(element.total).toFixed(2) + '</td>';
                    tr.innerHTML = trText_;
                    tbodyProductsSummary.insertBefore(tr, tbodyProductsSummary.nextSibling);
                });
                
                $('#productsSummary').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
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
                $('#modal-detail-summary').modal({ backdrop: 'static', keyboard: false });
            });
        }

        documentDetailModal = function(id) {
            alert(id);
        }

        printDocument = function(id) {
            if (id == 0) {
                id = cashClosingId__;
            }
            // direct-print logic
            var buttonPrint_ = document.getElementById('buttonPrint_' + id);
            if (buttonPrint_ != null) {
                buttonPrint_.style.display = 'none';
            }
            var buttonPdf_ = document.getElementById('buttonPdf_' + id);
            if (buttonPdf_ != null) {
                buttonPdf_.style.display = 'none';
            }
            var loader_ = document.getElementById('loader_' + id);
            if (loader_ != null) {
                loader_.style.display = 'inline-block';
            }
            $.ajax({
                url: '/api/print-cash-close-by-id/' + id,
                context: document.body,
                method: "GET",
                statusCode: {
                    400 : function() {
                        editDocumentId = 0;
                        alert("No se pudo imprimir el cierre de caja");
                    }
                }
            }).done(function(response){
                buttonPrint_.style.display = 'inline-block';
                buttonPdf_.style.display = 'inline-block';
                loader_.style.display = 'none';
            });
        }

        openPdf = function(id) {
            if (id == 0) {
                id = cashClosingId__;
            }
            // PDF logic
            window.open('/api/print-cash-close-pdf-by-id/' + id);
        }

    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>