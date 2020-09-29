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
    var deleteTable;
    var deletedTableId;
    var deleteSubmit;
    var editTable;
    var editedTableId;
    var editTableSubmit;
    var freeTable;
    var freeTableId;
    var freeTableSubmit;
    var arrayTables = [];
    $(document).ready(function() {
        var saleIndexTable = $('#terminals').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "serverSide": false,
            "bPaginate": true,
            "ordering": true,
            "searching": true,
            "ajax": function(data, callback, settings) {
                $.get('/api/tables', {
                    limit: data.length,
                    offset: data.start,
                    }, function(res) {
                        arrayTables = [];
                        res.forEach(element => {
                            arrayTables[element.id] = element;
                        });                             
                        callback({
                            recordsTotal: res.length,
                            recordsFiltered: res.length,
                            data: res
                        });
                    });
            },
            "columns"    : [
                {'data': 'table_code'},
                {'data': 'reservation_code'},
                {'data': 'table_name'},
                {'data': 'table_description'},
                {'data': 'floor'},
                {'data': function (data) {
                    var message = 'LIBRE';
                    if (data.orders != 0) {
                        message = 'OCUPADA';
                    }
                    return message;
                }},
                {'data': 'max_capacity'},
                {'data': function (data) {
                    var message = 'ACTIVA';
                    if (data.flag_active == 0) {
                        message = 'DESACTIVA';
                    }
                    return message;
                }},
                // {'data': 'taken'},
                {'data': function (data) {
                    if (data.flag_active == 0) {
                        return '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    } else {
                        var message = '';
                        if (data.reservation_code == 'AM') {
                            message = 'disabled';
                        }
                        return '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteTable(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" ' + message + ' data-toggle="modal" data-target="#modal-success" onClick="freeTable(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-eraser"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" data-target="#modal-warning" onClick="editTable(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
        });

        //var functions
        deleteTable = function(id) {
            deletedTableId = id;
            var table = arrayTables[deletedTableId];
            var deletedText = document.getElementById('deletedText');
            deletedText.innerHTML = "¿Está seguro de eliminar a la mesa " + table.table_name + "?";
        }
        editTable = function(id) {
            editedTableId = id;
            var table = arrayTables[editedTableId];
            var editedText = document.getElementById('editedText');
            editedText.innerHTML = "¿Está seguro de editar a la mesa " + table.table_name + "?";
            var editedForm = document.getElementById('editedForm');
            var editedFormContent = '<li> NOMBRE DE LA MESA: <br> <input type="text" id="tableName" class="form-control" value="' + table.table_name + '" placeholder="Ingrese un nombre" maxlength="25" style="width:25%;"></li>' +
                '<li> CÓDIGO DE MESA: <br> <input type="text" id="tableCode" class="form-control" value="' + table.table_code + '" placeholder="Ingrese un código" maxlength="5" style="width:25%;"></li>' +
                '<li> PISO DE UBICACIÓN: <br> <input type="number" id="tableFloor" class="form-control" value="' + table.floor + '" placeholder="Ingrese un piso" style="width:25%;"></li>' +
                '<li> CAPACIDAD MÁXIMA: <br> <input type="number" id="tableMaxCapacity" class="form-control" value="' + table.max_capacity + '" placeholder="Ingrese max. capacidad" style="width:25%;"></li>'; //falta reservation_code
            editedForm.innerHTML = editedFormContent;
        }
        freeTable = function(id) {
            freeTableId = id;
            var table = arrayTables[freeTableId];
            var freeText = document.getElementById('freeText');
            freeText.innerHTML = "¿Está seguro de liberar a la mesa " + table.table_name + "?";
            var freeForm = document.getElementById('freeForm');
            var freeFormContent = '<li> Número de órdenes actuales: ' + table.orders + '</li>';
            freeForm.innerHTML = freeFormContent;
        }
        deleteTableSubmit = function() {
            $.ajax({
                method: "DELETE",
                url: "/api/table/" + deletedTableId,
                context: document.body,
                statusCode: {
                    400: function() {
                        deletedTableId = 0;
                        alert("No se pudo eliminar la mesa");
                    }
                }
            }).done(function(response) {
                // console.log(response);
                deletedTableId = 0;
                location.reload();
            });
        }
        editTableSubmit = function() {
            var dataSend = {
                table_name: document.getElementById('tableName').value,
                table_code: document.getElementById('tableCode').value,
                floor: document.getElementById('tableFloor').value,
                max_capacity: document.getElementById('tableMaxCapacity').value,
            };
            $.ajax({
                method: "PATCH",
                url: "/api/table/" + editedTableId,
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        editedTableId = 0;
                        alert("No se pudo editar la mesa");
                    }
                }
            }).done(function(response) {
                // console.log(response);
                editedTableId = 0;
                location.reload();
            });            
        }
        freeTableSubmit = function() {
            $.ajax({
                method: "GET",
                url: "/api/free-table/" + freeTableId,
                context: document.body,
                statusCode: {
                    400: function() {
                        freeTableId = 0;
                        alert("No se pudo liberar la mesa");
                    }
                }
            }).done(function(response) {
                // console.log(response);
                freeTableId = 0;
                location.reload();
            });
        }
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>