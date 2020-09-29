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
<script>
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
        //DATATABLE
        var saleIndexTable  = $('#reports_1').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "columnDefs": [
                {
                    "targets": [8,10,11],
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
            "ordering": true,
            "searching": true,
            "ajax": function(data, callback, settings) {
                $.get('/api/reports-sold-products', {
                    limit: data.length,
                    offset: data.start,
                    warehouseId: $('#warehouseId').val(),
                    brandId: $('#brandId').val(),
                    categoryId: $('#categoryId').val(),
                    typeDocumentId: $('#typeDocumentId').val(),
                    dateRange: $('#dateRange').val(),
                    employeeId: $('#employeeId').val(),
                    together: $('#together').val(),
                    }, function(res) {
                        callback({
                            recordsTotal: res.data.length,
                            recordsFiltered: res.data.length,
                            data: res.data
                        });
                    });
            },
            "columns"    : [
                {'data': function(data) {
                    return data.employee_name + ' ' + data.employee_lastname;
                }},
                {'data': function(data) {
                    return data.category_name;
                }},
                {'data': function(data) {
                    return data.code;
                }},
                {'data': function(data) {
                    return data.auto_barcode;
                }},
                {'data': function(data) {
                    return data.name;
                }},
                {'data': function(data) {
                    return data.brand_name;
                }},
                {'data': function(data) {
                    return data.model;
                }},
                {'data': function(data) {
                    return data.description;
                }},
                {'data': function(data) {
                    return parseFloat(data.quantity_sold).toFixed(2);
                }},
                {'data': function(data) {
                    return data.currency;
                }},
                {'data': function(data) {
                    return parseFloat(data.price_pr_product).toFixed(2);
                }},
                {'data': function(data) {
                    return parseFloat(data.price_cost).toFixed(2);
                }},
                {'data': function(data) {
                    // if ($('#warehouseId').val() == 0) {
                    //     return 'TODAS LAS TIENDAS';
                    // } else {
                    //     return data.warehouse_name;
                    // }
                    return data.warehouse_name;
                }}
            ],
            "responsive": true,
        });
        //DATATABLE
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
            }
        )
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>