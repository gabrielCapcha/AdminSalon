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
    //initial vars
    var getKardex;
    $(document).ready(function() {
        var dataSend = {};
        var q = 0;
        var transferData = $('#transferData').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,            
            // "columnDefs": [
            //     {
            //         "targets": [6],
            //         "className": 'dt-body-right'
            //     }
            // ],
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            'bDestroy': true,
            "serverSide": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                $.get('/api/kardex-brand-detail/' + dataSend.brandId + '/' + dataSend.warehouseId + '/' + dataSend.startDate + '/' + dataSend.endDate, {
                    limit: data.length,
                    offset: data.start,
                    }, function(res) {
                        callback({
                            recordsTotal: res.total,
                            recordsFiltered: res.total,
                            data: res.data
                        });
                    });
            },
            "columns"    : [
                {'data': function(data) {
                    return data.brandName;
                }},
                {'data': function(data) {
                    return data.productCode;
                }},
                {'data': function(data) {
                    return data.productAutoBarCode;
                }},
                {'data': function(data) {
                    return data.productName.toUpperCase();
                }},
                {'data': function(data) {
                    return data.quantityIn;
                }},
                {'data': function(data) {
                    return data.quantityOut;
                }},
                {'data': function(data) {
                    return parseFloat(parseFloat(data.quantityIn) - parseFloat(data.quantityOut)).toFixed(2);
                }},
                {'data': function(data) {
                    return data.stock;
                }},
            ],
            "responsive": true
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
        //Data vars
        var data = {};
        //var functions
        getKardex = function (){
            var brandId = document.getElementById('brandId').value;
            var warehouseId = document.getElementById('warehouseId').value;
            var dateRange = document.getElementById('dateRange').value;
            var startDate = dateRange.substring(6, 10) + '-' + dateRange.substring(3, 5) + '-' + dateRange.substring(0, 2);
            var endDate = dateRange.substring(19, 23) + '-' + dateRange.substring(16, 18) + '-' + dateRange.substring(13, 15);
            dataSend = {
                brandId : brandId,
                warehouseId : warehouseId,
                startDate: startDate,
                endDate: endDate,
            };
            q = 0;
        }
        //DATATABLE
        $('#searchButton').on('click', function(e) {
            transferData.search( this.value ).draw();
        });
    });
</script>