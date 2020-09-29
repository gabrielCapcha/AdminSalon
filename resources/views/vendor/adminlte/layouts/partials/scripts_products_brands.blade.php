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
    var values = 1;
    var deleteCategory;
    var editCategory;
    var arrayBrands = [];
    $(document).ready(function() {
        var editedId = 0;
        var saleIndexTable = $('#brands').DataTable({
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
                    $.get('/api/brands', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        }, function(res) {
                            arrayBrands = [];
                            res.data.forEach(element => {
                                arrayBrands[element.id] = element;
                            });                             
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': 'id'},
                {'data': 'name'},
                {'data': 'code'},
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.flag_active == 0) {
                        //deshabilitado
                        return '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    } else {
                        //habilitado
                        return '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteDocument(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" onClick="editDocument(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.ajax.reload();
            saleIndexTable.search( this.value ).draw();
        });

        //Functions

        deleteDocument = function(id) {
            // deletedSaleId = id;
            // var deleteSaleText = document.getElementById('deletedSaleText');
            // deleteSaleText.innerHTML = "¿Está seguro de eliminar a este cliente?";
        }

        editDocument = function(id) {
            var brand = arrayBrands[id];
            editedId = id;
            document.getElementById('editBrandName').value = brand.name;
            document.getElementById('editBrandCode').value = brand.code;
            $('#modal-edit-brand').modal({ backdrop: 'static', keyboard: false });
        }
        editDocumentSubmit = function() {
            var dataSend = {
                name: document.getElementById('editBrandName').value,
                code: document.getElementById('editBrandCode').value
            };
            if (editedId != 0) {
                $.ajax({
                    method: "PATCH",
                    url: "/api/brands/" + editedId,
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            editedId = 0;
                            alert('LA MARCA NO SE PUDO ACTUALIZAR. VOLVER A INTENTAR');
                        }
                    }
                }).done(function(response) {
                    editedId = 0;
                    $('#searchButton').trigger('click');
                    $('#modal-edit-brand').modal('toggle');
                });   
            }
        }
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
