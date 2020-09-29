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
    var deleteFeature;
    var deletedFeatureId = 0;
    var deleteFeatureSubmit;
    var editFeature;
    var editedFeatureId = 0;
    var arrayFeatures = [];
    $(document).ready(function() {
        var saleIndexTable = $('#features').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "serverSide": false,
            'ordering'    : true,
            'order'       : [[ 0, "desc" ]],
            "bPaginate": true,
            "searching": false,
            "ajax": function(data, callback, settings) {
                    $.get('/api/features', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        }, function(res) {
                            arrayFeatures = [];
                            res.data.forEach(element => {
                                arrayFeatures[element.id] = element;
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
                        return '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteFeature(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" onClick="editFeature(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
        });

        //Var Functions
        deleteFeature = function(id) {
            deletedFeatureId = id;
            var feature = arrayFeatures[deletedFeatureId];
            var deleteFeatureText = document.getElementById('deleteFeatureText');
            deleteFeatureText.innerHTML = "¿Está seguro de eliminar a la característica " + feature.name + "?";
        }
        deleteFeatureSubmit = function() {
            if (deletedFeatureId != 0) {
                var comment = document.getElementById('deleteFeatureComment').value;
                $.ajax({
                    url: "/api/features/" + deletedFeatureId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deletedFeatureId = 0;
                            alert("La característica no se pudo eliminar porque se encuentra asociada a productos.");
                        }
                    }
                }).done(function(response) {
                    deletedFeatureId = 0;
                    window.location.href = "/features";
                });
            } else {
                console.log("No se pudo eliminar esta característica con id " + deletedFeatureId);
            }
        }
        editFeature = function(id) {
            window.location.href = "/features/" + id;
        }    
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
