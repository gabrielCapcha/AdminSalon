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
    var values = 1;
    var editWarehouse;
    var formValidation;
    var deleteWarehouse;
    var deleteWarehouseSubmit;
    var deletedWarehouseId = 0;
    var arrayWarehouses = [];
    $(document).ready(function() {
        var saleIndexTable = $('#warehouses').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
            ],
            "serverSide": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                    $.get('/api/warehouses', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        }, function(res) {
                            arrayWarehouses = [];
                            res.data.forEach(element => {
                                arrayWarehouses[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': 'name'},
                {'data': function (data, type, dataToSet) {
                    var text = 'SIN RUC';
                    if (data.ruc != null) {
                        text = data.ruc;
                    }
                    return text;
                }},
                {'data': 'rz_social'},
                {'data': function (data, type, dataToSet) {
                    var text = 'BETA';
                    if (data.fe_status == 2) {
                        text = 'PRODUCCIÓN';
                    }
                    return text;
                }},
                {'data': function (data, type, dataToSet) {
                    var text = 'SUNAT';
                    if (data.fe_emisor == 2) {
                        text = 'OSE';
                    }
                    return text;
                }},
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.flag_active == 0) {
                        //deshabilitado
                        return '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    } else {
                        //habilitado
                        return '<button type="button" onClick="editWarehouse(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
        });

        //var Functions
        deleteWarehouseSubmit = function() {
            if (deletedWarehouseId != 0) {
                $.ajax({
                    url: "/api/warehouses/" + deletedWarehouseId,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deletedUserId = 0;
                            alert('No se pudo eliminar a la tienda. Inténtelo nuevamente.');
                        },
                    }
                }).done(function(response){
                    deletedUserId = 0;
                    location = "/warehouses";
                });
            }            
        }
        deleteWarehouse = function(id) {
            deletedWarehouseId = id;
            var deleteWarehouseText = document.getElementById('deleteWarehouseText');
            deleteWarehouseText.innerHTML = '¿Está seguro de eliminar a la tienda ' + arrayWarehouses[id].name + '?';
        }
        editWarehouse = function(id) {
            location = "/warehouses/" + id;
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>