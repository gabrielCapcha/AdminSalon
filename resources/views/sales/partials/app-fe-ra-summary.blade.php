<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/img/new-login/iso_300_soft.png" type="image/x-icon" />
    <title> TumiSoft</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/fonts/fonts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/buttons/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- jvectormap -->
    <!-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> -->
    <!-- Theme style -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue-new fixed sidebar-mini">
<div id="app">
    <div class="wrapper">

    @include('adminlte::layouts.partials.mainheader')

    @include('adminlte::layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('adminlte::layouts.partials.contentheader')

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('adminlte::layouts.partials.controlsidebar')

    @include('adminlte::layouts.partials.footer')

</div><!-- ./wrapper -->
</div>
@section('scripts')
<!-- REQUIRED JS SCRIPTS -->
<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var arraySales = [];
        // Table List
        var saleIndexTable = $('#sale_index').DataTable({
            "scrollX": true,
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
                    $.get('/api/fe-documents', {
                        limit: data.length,
                        offset: data.start,
                        rzSocial: $('#rzSocial').val(),
                        dateRange: $('#dateRange').val(),
                        code: 'RA',
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
                {'data': function(data, type, dataToSet) {
                    var message = data.ticket;
                    if (data.ticket == null) {
                        message = data.serie + '-' + ("000000" + data.sequenz).slice(-8);
                    }
                    return '<b>' + message + '</b>';
                }},
                {'data': 'ruc'},
                {'data':   function (data, type, dataToSet) {
                    var message = 'BETA';
                    switch (parseInt(data.type_process)) {
                        case 1:
                            message = 'PRODUCCIÓN';
                            break;
                        default:
                            break;
                    }
                    return message;
                }},
                {'data':   function (data, type, dataToSet) {
                    return '<strong>' + ("000" + data.json_ids.length).slice(-3) + ' Comprobantes </strong>';
                }},
                {'data':   function (data, type, dataToSet) {
                    message = 'NO ENVIADO';
                    if (data.flag_send == 1) {
                        message = 'ENVIADO';
                    }
                    return message;
                }},
                {'data': 'created_at'},
                {'data': 'sended_at'},
                {'data': function (data, type, dataToSet) {
                    var enabledResend = "";
                    var enabledSync = "";
                    if (data.flag_send == 1) {
                        enabledResend = 'disabled';
                    } else {
                        enabledSync = 'disabled';
                    }
                    var message = '<button type="button" class="btn btn-info btn-xs" onClick="summaryDocumentsDetail(' + data.id + ')">DETALLE</button> ' +
                        ' <button type="button" class="btn btn-warning btn-xs" ' + enabledResend + ' onClick="resendSummaryDocument(' + data.id + ')">REENVIAR</button> ' +
                        ' <button type="button" class="btn btn-success btn-xs" ' + enabledSync + '  onClick="syncSummaryDocument(' + data.id + ')">SINCRONIZAR</button>';
                    return message;
                }}
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.sal_sale_states_id != 8 &&
                    data.sal_type_document_id != 5 &&
                    (data.hash == null || data.hash == "")) {
                        if (data.sunat_log != null) {
                            var sunatLog = JSON.parse(data.sunat_log);
                            if (sunatLog.ticket != undefined) {
                                if (sunatLog.ticket.cod_sunat == '0000') {
                                    $node.addClass('default');
                                }
                            }
                        } else {
                            $node.addClass('warning');
                        }
                }
                switch (data.sal_sale_states_id) {
                    case 8:
                        $node.addClass('danger');
                        break;
                    case 10:
                        $node.addClass('success');
                        break;
                    case 11:
                        $node.addClass('warning');
                        break;
                    default:
                        break;
                }
            },
        });
        // Date range picker
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
        // Search button
        $('#searchButton').on('click', function(e) {
            saleIndexTable.ajax.reload();
            saleIndexTable.search( this.value ).draw();
        });
        // functions
        summaryDocumentsDetail = function(id) {
            $('#modal-summary-documents-detail').modal({ backdrop: 'static', keyboard: false });
            var summaryDocumentText = document.getElementById('summaryDocumentText');
            if (summaryDocumentText != null) {
                summaryDocumentText.innerHTML = arraySales[id].serie + '-' + arraySales[id].sequenz;
            }
            // summaryDocumentBody
            var summaryDocumentBody = '';
            arraySales[id].json_documents.forEach(element => {
                var tr = '<tr>' +
                    '<td>' + element.TIPO_COMPROBANTE+ '</td>' +
                    '<td>' + element.NRO_COMPROBANTE+ '</td>' +
                    '<td>' + element.TIPO_DOCUMENTO + '</td>' +
                    '<td>' + element.NRO_DOCUMENTO + '</td>' +
                    '<td>' + element.GRAVADA + '</td>' +
                    '<td>' + element.IGV + '</td>' +
                    '<td>' + element.TOTAL + '</td>' +
                    '<td>' + "####" + '</td>' +
                    '<td>' + "####" + '</td>' +
                    '<td>' + "####" + '</td>' +
                    '</tr>';
                
                summaryDocumentBody = summaryDocumentBody + tr;
            });
            document.getElementById('summaryDocumentBody').innerHTML = summaryDocumentBody;
        }
        resendSummaryDocument = function(id) {
            $('#modal-on-load').modal({ backdrop: 'static', keyboard: false });
            $.ajax({
                method: "GET",
                url: "/api/sunat-sync/" + id + "?document=summaryDocument",
                context: document.body,
                statusCode: {
                    400: function(response) {
                        $('#modal-on-load').modal('toggle');
                        // alert("NO SE PUDO SINCRONIZAR VENTA. ERROR EN SERVIDORES DE SUNAT");
                        // $('#modal-error-step').modal({ backdrop: 'static', keyboard: false });
                    },
                    500: function(response) {
                        $('#modal-on-load').modal('toggle');
                        // alert("NO SE PUDO SINCRONIZAR VENTA. ERROR EN SERVIDORES DE SUNAT");
                        // $('#modal-error-step').modal({ backdrop: 'static', keyboard: false });
                    },
                }
            }).done(function(response) {
                $('#modal-on-load').modal('toggle');
                saleIndexTable.ajax.reload(null, false);
            });
        }
        syncSummaryDocument = function(id) {
            saleIndexTable.ajax.reload(null, false);
        }
    });
</script>
@show

</body>
</html>
