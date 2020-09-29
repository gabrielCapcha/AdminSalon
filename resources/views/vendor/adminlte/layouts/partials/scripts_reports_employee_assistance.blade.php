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
        var rolesConfig = [];
        rolesConfig[1] = 'SUPER ADMINISTRADOR';
        rolesConfig[2] = 'SUPER ADMINISTRADOR';
        rolesConfig[3] = 'CAJA TUMIPOS';
        rolesConfig[4] = 'ALMACENERO';
        rolesConfig[5] = 'ADMINISTRADOR FOOD';
        rolesConfig[6] = 'ADMINISTRADOR POS';
        rolesConfig[7] = 'COCINERO';
        rolesConfig[8] = 'MESERO';
        rolesConfig[9] = 'CAJA TUMIFOOD';
        rolesConfig[10] = 'VENDEDOR INDIVIDUAL POS';
        rolesConfig[11] = 'VENDEDOR INDIVIDUAL FOOD';
        rolesConfig[12] = 'CONTADOR';
        rolesConfig[13] = 'ADMINISTRADOR DE TIENDA POS';
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
        $('#reports_1 thead tr').clone(true).appendTo( '#reports_1 thead' );
        $('#reports_1 thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input class="filter" type="text" placeholder="'+title+'" />' );
            $( 'input', this ).on( 'keyup change', function () {
                if ( saleIndexTable.column(i).search() !== this.value ) {
                    saleIndexTable.column(i).search( this.value ).draw();
                }
            } );
        } );
        //DATATABLE
        var saleIndexTable  = $('#reports_1').DataTable({
            "scrollX": true,
            "processing": true,
            "orderCellsTop": true,
            "fixedHeader": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            "serverSide": false,
            "paging": true,
            'order': [[ 0, "desc" ]],
            "ordering": true,
            "searching": true,
            "ajax": function(data, callback, settings) {
                $.get('/api/reports-employee-assistance', {
                    limit: data.length,
                    offset: data.start,
                    warehouseId: $('#warehouseId').val(),
                    dateRange: $('#dateRange').val(),
                    }, function(res) {
                        callback({
                            recordsTotal: res.length,
                            recordsFiltered: res.length,
                            data: res
                        });
                    });
            },
            "columns"    : [
                {'data': function(data) {
                    return data.assistance_date;
                }},
                {'data': function(data) {
                    return data.warehouse_name;
                }},
                {'data': function(data) {
                    var message = '';
                    data.roles_config.forEach(element => {
                        if (element.apps_id != 1) { 
                            message = rolesConfig[element.roles_id].toUpperCase();   
                        }
                    });
                    return message;
                }},
                {'data': function(data) {
                    return data.employee_name + ' ' + data.employee_lastname;
                }},
                {'data': function(data) {
                    return data.commentary;
                }},
                {'data': function(data) {
                    if (data.date_start == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return data.date_start;
                    }
                }},
                {'data': function(data) {
                    if (data.date_start_image == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return '<a href="'+data.date_start_image+'" target="_blank">'+data.date_start_image+'</a>';
                    }
                }},
                {'data': function(data) {
                    if (data.break_start == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return data.break_start;
                    }
                }},
                {'data': function(data) {
                    if (data.break_start_image == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return '<a href="'+data.break_start_image+'" target="_blank">'+data.break_start_image+'</a>';
                    }
                }},
                {'data': function(data) {
                    if (data.break_end == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return data.break_end;
                    }
                }},
                {'data': function(data) {
                    if (data.break_end_image == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return '<a href="'+data.break_end_image+'" target="_blank">'+data.break_end_image+'</a>';
                    }
                }},
                {'data': function(data) {
                    if (data.date_end == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return data.date_end;
                    }
                }},
                {'data': function(data) {
                    if (data.date_end_image == null) {
                        return 'SIN INFORMACIÓN';
                    } else {
                        return '<a href="'+data.date_end_image+'" target="_blank">'+data.date_end_image+'</a>';
                    }
                }},
            ],
            "responsive": true,
        });
        //DATATABLE
        $('#searchButton').on('click', function(e) {
            saleIndexTable.ajax.reload();
            saleIndexTable.search( this.value ).draw();
        });
        $('.filter').on('click', function(e){
            e.stopPropagation();
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