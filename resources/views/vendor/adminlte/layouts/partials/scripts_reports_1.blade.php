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
    $(document).ready(function() {
        var commisionValue  = 0;
        var totalSaleValue  = 0;
        var xCommisionValue = document.getElementById('commisionValue');
        var xTotalSaleValue = document.getElementById('totalSaleValue');
        var saleIndexTable  = $('#reports_1').DataTable({
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
                commisionValue = 0;
                totalSaleValue = 0;
                    $.get('/api/reports-1', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        stateId: $('#stateSaleId').val(),
                        warehouseId: $('#warehouseId').val(),
                        paymentId: $('#paymentId').val(),
                        dateRange: $('#dateRange').val(),
                        }, function(res) {
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': 'warehouseName'},
                {'data': 'dateStart'},
                {'data': 'dateEnd'},
                {'data': 'sales_count'},
                {'data': 'sales_nulled_count'},
                {'data': 'sales_finished_count'},
                {'data': 'sales_amount'},
                {'data': 'discount_amount'},
                {'data': function (data, type, dataToSet) {
                        var a = parseFloat(data.sales_amount_percent);
                        var b = parseFloat(data.sales_amount);
                        commisionValue = commisionValue + a;
                        totalSaleValue = totalSaleValue + b;
                        xCommisionValue.innerHTML = commisionValue.toFixed(2);
                        xTotalSaleValue.innerHTML = "(" + totalSaleValue.toFixed(2) + ")";
                        return a.toFixed(2);
                    }
                }
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
        )
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>