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
    var openPriceList;
    $(document).ready(function() {
        var data = JSON.parse(document.getElementById('json_response').value);
        var priceListId = data.priceListId;
        var priceListSymbolCode = data.priceListSymbolCode;
        var arrayProducts = [];
        var totalM = 0;
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
            "order": [[ 6, "asc" ]],
            "ordering": true,
            "columnDefs": [
                {
                    "targets": [3,9,10,11,12,13],
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
            "searching": true,
            "ajax": function(data, callback, settings) {
                $.get('/api/reports-stocks-products', {
                    limit: data.length,
                    offset: data.start,
                    warehouseId: $('#warehouseId').val(),
                    categoryId: $('#categoryId').val(),
                    brandId: $('#brandId').val(),
                    }, function(res) {
                        arrayProducts = [];
                        res.data.forEach(element => {
                            arrayProducts[element.id] = element;
                            var price = 0;
                            priceListId = document.getElementById('priceListId').value;
                            if (priceListId != 0 && element.price_list != null) {
                                if (element.price_list[priceListId] != undefined) {
                                    price = parseFloat(element.price_list[priceListId].price).toFixed(2);
                                }
                            }
                        });
                        callback({
                            recordsTotal: res.data.length,
                            recordsFiltered: res.data.length,
                            data: res.data
                        });
                    });
            },
            "columns"    : [
                // {'data': function(data) {
                //     var message = 'PADRE';
                //     if (data.product_parent_id != null) {
                //         message = 'HIJO';
                //     }
                //     return message;
                // }},
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
                    var stock = parseFloat(data.stock);
                    // if (stock < 0) {
                    //     stock = 0;
                    // }
                    return stock.toFixed(2);
                }},
                {'data': function(data) {
                    return data.warehouse_name;
                }},
                {'data': function(data) {
                    return data.model;
                }},
                {'data': function(data) {
                    return data.description;
                }},
                {'data': function(data) {
                    return data.category_name;
                }},
                {'data': function(data) {
                    return data.brand_name;
                }},
                {'data': function(data) {
                    var message = 0;
                    priceListId = document.getElementById('priceListId').value;
                    if (priceListId != 0 && data.price_list != null) {
                        if (data.price_list[priceListId] != undefined) {
                            message = parseFloat(data.price_list[priceListId].price).toFixed(2);
                        }
                    }
                    return (message*parseFloat(data.stock)).toFixed(2);
                }},
                {'data': function(data) {
                    var message = '0.00';
                    priceListId = document.getElementById('priceListId').value;
                    if (priceListId != 0 && data.price_list != null) {
                        if (data.price_list[priceListId] != undefined) {
                            message = parseFloat(data.price_list[priceListId].price).toFixed(2);
                        }
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = '0.00';
                    priceListId = document.getElementById('priceListId').value;
                    if (priceListId != 0 && data.price_list != null) {
                        if (data.price_list[priceListId] != undefined) {
                            message = parseFloat(data.price_list[priceListId].quantity).toFixed(2);
                        }
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = '0.00';
                    priceListId = document.getElementById('priceListId').value;
                    if (priceListId != 0 && data.price_list != null) {
                        if (data.price_list[priceListId] != undefined) {
                            message = parseFloat(data.price_list[priceListId].wholeSalePrice).toFixed(2);
                        }
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = '0.00';
                    message = parseFloat(data.price_cost).toFixed(2);
                    return message;
                }},
                {'data': function(data) {
                    return '<button onClick="openPriceList('+ data.id +')"> Ver precios </button>';
                }},
            ],
            "responsive": true,
            "rowCallback": function( row, data, index ) {
                var $node = this.api().row(row).nodes().to$();
                if (data.stock < 1) {
                    $node.addClass('danger');
                } else if (data.stock <= data.min_stock) {
                    $node.addClass('warning');
                } else {
                    $node.addClass('success');
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total stock
                totalS = api
                    .column( 3, {search:'applied'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total stock
                totalMM = api
                    .column( 9, {search:'applied'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $(api.column(6, {search:'applied'}).footer()).html('TOTAL DE STOCK: ' + parseFloat(totalS).toFixed(2) + '<br>VALOR EN DINERO: ' + parseFloat(totalMM).toFixed(2));
            }
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
        //var functions
        openPriceList = function(id) {
            var priceListTBody = document.getElementById('priceListTBody');
            priceListTBody.innerHTML = '';
            data.priceLists.forEach(element => {
                var priceList = arrayProducts[id].price_list;
                var tr = document.createElement('tr');
                var priceListTBodyText = '<td>' + element.name + ' (' + element.symbol_code + ')' + '</td>';
                    if (priceList[element.id]) {
                        priceListTBodyText = priceListTBodyText +
                        '<td>' + priceList[element.id].price + '</td>' + 
                        '<td>' + priceList[element.id].quantity + '</td>' + 
                        '<td>' + priceList[element.id].wholeSalePrice + '</td>';
                    }
                tr.innerHTML = priceListTBodyText;
                priceListTBody.insertBefore(tr, priceListTBody.firstChild);
            });
            $('#modal-price-list').modal({ backdrop: 'static', keyboard: false });
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>