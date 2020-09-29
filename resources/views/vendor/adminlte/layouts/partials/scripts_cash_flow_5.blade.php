<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/chartjs/Chart.js') }}" type="text/javascript"></script>

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
    var printDocument;
    var arraySales = [];
    $(function () {
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieChart       = new Chart(pieChartCanvas)
        var PieData        = [
            {
            value    : 700,
            color    : '#f56954',
            highlight: '#f56954',
            label    : 'Chrome'
            },
            {
            value    : 500,
            color    : '#00a65a',
            highlight: '#00a65a',
            label    : 'IE'
            },
            {
            value    : 400,
            color    : '#f39c12',
            highlight: '#f39c12',
            label    : 'FireFox'
            },
            {
            value    : 600,
            color    : '#00c0ef',
            highlight: '#00c0ef',
            label    : 'Safari'
            },
            {
            value    : 300,
            color    : '#3c8dbc',
            highlight: '#3c8dbc',
            label    : 'Opera'
            },
            {
            value    : 100,
            color    : '#d2d6de',
            highlight: '#d2d6de',
            label    : 'Navigator'
            }
        ]
        var pieOptions     = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke    : true,
            //String - The colour of each segment stroke
            segmentStrokeColor   : '#fff',
            //Number - The width of each segment stroke
            segmentStrokeWidth   : 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps       : 100,
            //String - Animation easing effect
            animationEasing      : 'easeOutBounce',
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate        : true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale         : false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive           : true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio  : true,
            //String - A legend template
            legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions)
    });
    $(document).ready(function() {
        var saleIndexTable = $('#open_cash_5').DataTable({
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
                    $.get('/api/pre-closing', {
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
                        return data.lastname.toUpperCase() + ", " + data.name.toUpperCase();
                    }
                },
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data':   function (data, type, dataToSet) {
                        if (data.out_of_money) {
                            return 'SÍ';
                        } else {
                            return 'NO';
                        }
                    }
                },
                {'data':    function (data, type, dataToSet) {
                        return data.currency + ' ' + data.amount;
                    }
                },
                {'data':    function (data, type, dataToSet) {
                        return data.currency + ' ' + data.real_amount;
                    }
                },
                {'data':    function (data, type, dataToSet) {
                        return data.currency + ' ' + data.sales_amount;
                    }
                },
                // {'data': 'incomes_amount'},
                // {'data': 'retreats_amount'},
                // {'data': 'openings_amount'},
                // {'data': 'expenses_amount'},
                // {'data': 'incounts_amount'},
                {'data': function (data, type, dataToSet) {
                    if (data.flag_active == 0) {
                        //deshabilitado
                        return '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            // '<button type="button" data-toggle="modal" data-target="#modal-info" onClick="documentDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>';
                    } else {
                        //habilitado
                        // return '<button type="button" data-toggle="modal" data-target="#modal-info" onClick="documentDetailModal(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button><span> </span>' +
                        return '<button type="button" onClick="printDocument(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>';
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
        documentDetailModal = function(id) {
            // var detailOpenCashCreatedAt = document.getElementById('detailOpenCashCreatedAt');
            // detailOpenCashCreatedAt.innerHTML = 'PRE CUADRE: '  + arraySales[id].created_at;
            // var conditionYesOrNo = arraySales[id].out_of_money;
            // var textConditionYesOrNo = "Si";
            // if (!conditionYesOrNo) {
            //     textConditionYesOrNo = "No";
            // }
            // //ITEMS TABLE
            // document.getElementById('warehouseName').innerHTML = arraySales[id].warehouseName;
            // document.getElementById('employeeName').innerHTML = arraySales[id].lastname.toUpperCase() + ", " + arraySales[id].name.toUpperCase();
            // document.getElementById('dateValue').innerHTML = arraySales[id].created_at;
            // document.getElementById('givesMoney').innerHTML = textConditionYesOrNo;
            // document.getElementById('boxAmount').innerHTML = "S/ " + arraySales[id].amount;
            // document.getElementById('incomesAmount').innerHTML = "S/ " + arraySales[id].real_amount;
            // document.getElementById('salesAmount').innerHTML = "S/ " + arraySales[id].sales_amount;
            // //ITEMS TABLE
        }

        printDocument = function(id) {
            alert(id);
        }  
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>