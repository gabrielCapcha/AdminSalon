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
    var arraySales = [];
    $(document).ready(function() {
        var saleIndexTable = $('#brands').DataTable({
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
                    $.get('/api/transport-driver', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
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
                {'data': 'companyName'},
                {'data': 'name'},
                {'data': 'lastname'},
                {'data': 'license'},
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
            saleIndexTable.search( this.value ).draw();
        });

        //Functions

        saveNewClient = function() {
            var button = document.getElementById('saveNewClient');
            var newDriver = {
                tra_companies_id: document.getElementById('driverTransportCompany').value,
                name: document.getElementById('driverName').value,
                lastname: document.getElementById('driverLastname').value,
                license: document.getElementById('driverLicense').value,
                phone: document.getElementById('driverPhone').value,
                email: document.getElementById('driverEmail').value,
            };
            $.ajax({
                method: "POST",
                url: "/api/transport-driver",
                context: document.body,
                data: newDriver,
                statusCode: {
                    400: function() {
                        button.disabled = false;
                        alert("Hubo un error en el registro. Es posible que el conductor ya esté registrado.");
                    }
                }
            }).done(function(response) {
                button.disabled = false;
                $('#searchButton').trigger('click');
                $('#dismissNewClient').trigger('click');
            });
        }

        deleteDocument = function(id) {
            // deletedSaleId = id;
            // var deleteSaleText = document.getElementById('deletedSaleText');
            // deleteSaleText.innerHTML = "¿Está seguro de eliminar a este cliente?";
        }

        editDocument = function(id) {
            alert(id);
        }    
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
