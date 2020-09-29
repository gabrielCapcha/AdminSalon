<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/buttons/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.print.min.js') }}" type="text/javascript"></script>
<script>
    //Document Ready
    var formValidation;
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
        var jsonResponse = JSON.parse(document.getElementById('jsonResponse').value);
        var d = new Date(jsonResponse.inventoryInfo.inventoryDate),
        dformat = [
            ("0000" + d.getFullYear()).slice(-4),
            ("00" + (d.getMonth()+1)).slice(-2),
            ("00" + d.getDate()).slice(-2),
        ].join('-')+' '+
        [
            ("00" + d.getHours()).slice(-2),
            ("00" + d.getMinutes()).slice(-2),
            ("00" + d.getSeconds()).slice(-2),
        ].join(':');
        $('#inventoryDate').val(dformat);
        var data = {};
        var inventoryTable  = $('#table').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' },
            ],
            "pageLength": 5,
            "serverSide": false,
            "bPaginate": true,
            "ordering": true,
            "searching": true,
            "responsive": true,
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
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total conteo
                totalC = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total Sumatoria CashXQuantity
                totalQ = api
                    .column( 10 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $(api.column(4).footer()).html('TOTAL DE STOCK: ' + totalS + ' - TOTAL DE CONTEO: ' + totalC + ' - PRECIO TOTAL : ' + totalQ);
            }
        });
        formValidation = function(){
            var button = document.getElementById('button');
            button.disabled = true;
            $.ajax({
                method: "PATCH",
                url: "/api/inventories/" + jsonResponse.inventoryInfo.id,
                context: document.body,
                statusCode: {
                    500: function() {
                        button.disabled = false;
                        alert('No se pudo finalizar el inventario. Verifique la información ingresada e inténtelo nuevamente.');
                    },
                    403: function() {
                        button.disabled = false;
                        alert('No se pudo finalizar el inventario. Verifique la información ingresada e inténtelo nuevamente.');
                    },
                    400: function() {
                        button.disabled = false;
                        alert('No se pudo finalizar el inventario. Verifique la información ingresada e inténtelo nuevamente.');
                    },
                }
            }).done(function(response) {
                data = {};
                location = "/inventories";
            });
        }
    });
</script>
