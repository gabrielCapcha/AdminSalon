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
    var values = 1;
    var detailDocument;
    var editDocument;
    var arrayInventories = [];
    $(document).ready(function() {
        var saleIndexTable = $('#inventories').DataTable({
            "scrollX": true,
            'processing'  : true,
            // 'serverSide'  : true,
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'order'       : [[ 0, "desc" ]],
            'info'        : true,
            'autoWidth'   : true,
            'language': {
                "url": "/js/languages/datatables/es.json"
            },
            'bDestroy': true,
            "ajax": function(data, callback, settings) {
                    $.get('/api/inventories', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        }, function(res) {
                            arrayInventories = [];
                            res.forEach(element => {
                                arrayInventories[element.id] = element;
                            });                             
                            callback({
                                recordsTotal: res.length,
                                recordsFiltered: res.length,
                                data: res
                            });
                        });
            },
            "columns"    : [
                {'data': function (data, type, dataToSet) {
                    var myDate = new Date(data.inventoryDate);
                    return myDate.toLocaleString();
                }},
                {'data': 'warehouse.name'},
                {'data': 'responsible'},
                {'data': function (data, type, dataToSet) {
                    switch (data.status) {
                        case 1:
                            return 'INVENTARIADO';
                            break;
                        case 2:
                            return 'CERRADO';
                            break;                    
                        default:
                            return 'SIN ESPECIFICAR';
                            break;
                    }
                }},
                {'data': function(data, type, dataToSet) {
                    if (data.closedAt != null) {
                        var myDate = new Date(data.closedAt);
                        return myDate.toLocaleString();   
                    } else {
                        return 'ABIERTO';
                    }
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.closedAt != null) {
                        //deshabilitado
                        return '<button type="button" onClick="detailDocument(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button>';
                    } else {
                        //habilitado
                        return '<button type="button" onClick="editDocument(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
        });

        //Var Functions
        detailDocument = function(id) {
            window.location.href = "/inventories/" + id;
        }

        editDocument = function(id) {
            window.location.href = "/inventories/" + id;
        }    
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>