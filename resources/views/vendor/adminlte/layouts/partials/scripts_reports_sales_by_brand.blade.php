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
        var totalLine       = 0;
        var pTotalMix  = document.getElementById('pTotalMix');
        var pTotalCash = document.getElementById('pTotalCash');
        var pTotalVisa = document.getElementById('pTotalVisa');
        var pTotalMCard = document.getElementById('pTotalMastercard');
        var pTotalTransfer = document.getElementById('pTotalTransfer');
        var pTotalCheck = document.getElementById('pTotalCheck');
        var pTotalCredit = document.getElementById('pTotalCredit');
        var pTotalLetter = document.getElementById('pTotalLetter');
        var pTotal = document.getElementById('pTotal');
        //DATATABLE
        var saleIndexTable  = $('#reports_1').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "columnDefs": [
                {
                    "targets": [1,2,3,4,5,6,7,8,9],
                    "className": 'dt-body-right'
                }
            ],
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
                $.get('/api/reports-sales-by-brand', {
                    limit: 100,
                    offset: 0,
                    warehouseId: $('#warehouseId').val(),
                    dateRange: $('#dateRange').val(),
                    }, function(res) {
                        callback({
                            recordsTotal: res.length,
                            recordsFiltered: res.length,
                            data: res
                        });
                        totalLine = 0;
                        //SUM LOGIC
                        var v1 = saleIndexTable.column(1).data().sum();
                        var v2 = saleIndexTable.column(2).data().sum();
                        var v3 = saleIndexTable.column(3).data().sum();
                        var v4 = saleIndexTable.column(4).data().sum();
                        var v5 = saleIndexTable.column(5).data().sum();
                        var v6 = saleIndexTable.column(6).data().sum();
                        var v7 = saleIndexTable.column(7).data().sum();
                        var v8 = saleIndexTable.column(8).data().sum();
                        pTotalCash.innerHTML = '' + v1.toFixed(2);
                        pTotalVisa.innerHTML = '' + v2.toFixed(2);
                        pTotalMCard.innerHTML = '' + v3.toFixed(2);
                        pTotalMix.innerHTML = '' + v4.toFixed(2);
                        pTotalTransfer.innerHTML = '' + v5.toFixed(2);
                        pTotalCheck.innerHTML = '' + v6.toFixed(2);
                        pTotalCredit.innerHTML = '' + v7.toFixed(2);
                        pTotalLetter.innerHTML = '' + v8.toFixed(2);
                        pTotal.innerHTML = '' + (v1 + v2 + v3 + v4 + v5 + v6 + v7 + v8).toFixed(2);
                    });
            },
            "columns"    : [
                {'data': function(data) {
                    totalLine = 0;
                    return data.name;
                }},
                {'data': function(data) {
                    //EFECTIVO
                    var id__ = 1;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //VISA
                    var id__ = 2;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //MASTERCARD
                    var id__ = 3;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //MIXTO
                    var id__ = 5;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //DEPOSITO/TRANSFERENCIA
                    var id__ = 6;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //CHEQUE
                    var id__ = 7;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //CREDITO
                    var id__ = 8;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //LETRA
                    var id__ = 9;
                    var message = '0.00';
                    data.products.forEach(element => {
                        if (element.sal_type_payments_id == id__) {
                            message = element.sumAmount;
                            totalLine = totalLine + parseFloat(element.sumAmount);
                        }
                    });
                    return parseFloat(message).toFixed(2);
                }},
                {'data': function(data) {
                    //SUM LOGIC
                    return (totalLine).toFixed(2);
                }}
            ],
            "responsive": true
        });
        //DATATABLE
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