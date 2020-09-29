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
                $.get('/api/kardex-warehouse-detail/' + dataSend.warehouseId + '/' + dataSend.startDate + '/' + dataSend.endDate, {
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
                    return data.productCode;
                }},
                {'data': function(data) {
                    return data.productAutoBarCode;
                }},
                {'data': function(data) {
                    return data.productName.toUpperCase();
                }},
                {'data': function(data) {
                    return ("000000" + data.documentNumber).slice(-6);
                }},
                {'data': function(data) {
                    return data.quantityIn;
                }},
                {'data': function(data) {
                    return data.quantityOut;
                }},
                {'data': function (data, type, dataToSet) {
                    var dateL = data.operationDate;
                    if (data.operationDate == null) {
                        dateL = data.createdAt;
                    }
                    var d = new Date(dateL),
                    dformat = [
                        ("00" + d.getDate()).slice(-2),
                        ("00" + (d.getMonth()+1)).slice(-2),
                        ("0000" + d.getFullYear()).slice(-4),
                    ].join('/');
                    return dformat;
                }},
                {'data': function (data, type, dataToSet) {
                    var dateL = new Date(data.operationDate);
                    if (data.operationDate == null) {
                        dateL = data.createdAt;
                    }
                    var d = new Date(dateL),
                    dformat = [
                        ("00" + d.getHours()).slice(-2),
                        ("00" + d.getMinutes()).slice(-2),
                        ("00" + d.getSeconds()).slice(-2),
                    ].join(':');
                    return dformat;
                }},
                {'data': function(data) {
                    var message = '-';
                    if (data.description != null) {
                        message = data.description;
                    }
                    return message.toUpperCase();
                }},
                {'data': function(data) {
                    var message = '-';
                    if (data.saleDetail != null) {
                        message = 'VENTA REALIZADA A <strong>' + data.saleDetail.customerName + ' ' + data.saleDetail.customerLastname + '</strong> POR EL USUARIO <strong>' + data.saleDetail.salemanName + ' ' + data.saleDetail.salemanLastname + '</strong>.';
                    }
                    if (data.transferDetail != null) {
                        var sourceDelivered = data.transferDetail.warehouseSourceName;
                        if (data.transferDetail.deliveryUserName != null) {
                            sourceDelivered = sourceDelivered + ' (' + data.transferDetail.deliveryUserName + ' ' + data.transferDetail.deliveryUserLastname + ')';
                        }
                        message = 'TRANSFERENCIA REALIZADA A <strong>' + sourceDelivered + '</strong> A EL USUARIO <strong>' + data.transferDetail.clearanceUserName + ' ' + data.transferDetail.clearanceUserLastname + '</strong>.';
                    }
                    if (data.saleDetail == null && data.transferDetail == null) {
                        message = data.documentType;
                    }
                    return message;
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
            var warehouseId = document.getElementById('warehouseId').value;
            var dateRange = document.getElementById('dateRange').value;
            var startDate = dateRange.substring(6, 10) + '-' + dateRange.substring(3, 5) + '-' + dateRange.substring(0, 2);
            var endDate = dateRange.substring(19, 23) + '-' + dateRange.substring(16, 18) + '-' + dateRange.substring(13, 15);
            dataSend = {
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