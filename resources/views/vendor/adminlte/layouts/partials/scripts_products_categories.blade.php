<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script>
    var values = 1;
    var deletedCategoryId = 0;
    var deleteCategory;
    var editCategory;
    var editedCategoryId = 0;
    var arrayCategories = [];
    var deleteCategorySubmit;
    $(document).ready(function() {
        var categoryIndexTable = $('#categories').DataTable({
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
                    $.get('/api/categories', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        }, function(res) {
                            arrayCategories = [];
                            res.data.forEach(element => {
                                arrayCategories[element.id] = element;
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
                    var message = 'ACTIVO';
                    if (data.flag_active == 0) {
                        message = 'INACTIVO';
                    }
                    return message;
                }},
                {'data': function (data, type, dataToSet) {
                    var message = 'SI ES ADICIONAL';
                    if (data.additional == 0) {
                        message = 'NO ES ADICIONAL';
                    }
                    return message;
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
                        return '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    } else {
                        //habilitado
                        return '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteCategory(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" onClick="editCategory(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        $('#searchButton').on('click', function(e) {
            categoryIndexTable.search( this.value ).draw();
        });

        //Functions
        deleteCategory = function(id) {
            deletedCategoryId = id;
            var category = arrayCategories[id];
            var deleteCategoryText = document.getElementById('deletedCategoryText');
            deleteCategoryText.innerHTML = "¿Está seguro de eliminar a la categoría " + category.name + "?";
        }

        deleteCategorySubmit = function() {
            if (deletedCategoryId != 0) {
                var comment = document.getElementById('deleteCategoryComment').value;
                $.ajax({
                    url: "/api/categories/" + deletedCategoryId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deletedCategoryId = 0;
                            alert("La categoría no se pudo eliminar porque se encuentra asociada a productos.");
                        }
                    }
                }).done(function(response) {
                    deletedCategoryId = 0;
                    window.location.href = "/categories";
                });
            } else {
                console.log("No se pudo eliminar la categoría con id " + deletedCategoryId);
            }
        }

        editCategory = function(id) {
            window.location.href = "/categories/" + id;
        }    
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
