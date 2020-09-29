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
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    var values = 1;
    var deleteUserSubmit;
    var deleteUser;
    var editUser;
    var arrayUsers = [];
    var deletedUserId = 0;
    var commissionCount = 0;
    var responseCommission = {};
    var commissions = [];
    $(document).ready(function() {
        var saleIndexTable = $('#users').DataTable({
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
                    $.get('/api/users', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        warehouseId: $('#warehouseId').val(),
                        }, function(res) {
                            arrayUsers = [];
                            res.data.forEach(element => {
                                arrayUsers[element.id] = element;
                            });                             
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': function (data, type, dataToSet) {
                    if (data.url_image == null) {
                        return '<img src="/img/new_ic_logo_short.png" height="50px">';
                    } else {
                        return '<img src="' + data.url_image + '" height="50px" width="50px">';
                    }
                }},
                {'data': 'code'},
                {'data': 'name'},
                {'data': 'lastname'},
                {'data': 'email'},
                {'data': 'warehouseName'},
                {'data': function (data, type, dataToSet) {
                    if (data.flag_active == 0) {
                        //deshabilitado
                        return '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" disabled class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button>';
                    } else {
                        //habilitado
                        return '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteUser(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' +
                            '<button type="button" onClick="editUser(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" data-target="#modal-commission-update" onClick="updateCommission(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-list"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
        });

        //Functions
        deleteUserSubmit = function() {
            if (deletedUserId != 0) {
                $.ajax({
                    url: "/api/users/" + deletedUserId,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deletedUserId = 0;
                            alert('No se pudo eliminar al usuario. Inténtelo nuevamente.');
                        },
                    }
                }).done(function(response){
                    deletedUserId = 0;
                    location = "/users";
                });
            }
        }
        deleteUser = function(id) {
            deletedUserId = id;
            var titleDeleteUser = document.getElementById('titleDeleteUser');
            titleDeleteUser.innerHTML = '¿Está seguro de eliminar al usuario ' + arrayUsers[id].name + ', ' + arrayUsers[id].lastname + '?';
        }
        editUser = function(id) {
            location = "/users/" + id;
        }
        updateCommission = function (id) {
            $.ajax({
                method: "GET",
                url: "/api/commissions-conf/by-employee/" + id,
                context: document.body,
                statusCode: {
                    401: function() {
                        alert('Hubo un problema al actualizar. Vuelva a intentarlo.');
                    }
                }
            }).done(function(response) {
                responseCommission = response;
                response[0].json_conf.products.forEach(element => {
                    // commisionProducts
                    commissionCount++;
                    var commisionProducts = document.getElementById('commisionProducts');
                    if (commisionProducts != null) {
                        var newObject = document.createElement('div');
                        newObject.setAttribute("class", "col-md-12");
                        newObject.setAttribute("id", "div_commissionProduct_" + element.id);
                        newObject.setAttribute("align", "center");
                        var textSelect = '<br id="br_commissionProduct_' + element.id + '"/>' +
                            '<input id="commissionProductId_' + element.id + '" type="hidden" value="' + element.id + '">' +
                            '<input id="commissionProductName_' + element.id + '" type="text" class="form-control" readonly value="' + element.productName +'">';
                        newObject.innerHTML = textSelect;
                        commisionProducts.appendChild(newObject);
                    }
                    // commisionDetails
                    var commisionDetails = document.getElementById('commisionDetails');
                    if (commisionDetails != null) {
                        var newObject = document.createElement('div');
                        newObject.setAttribute("class", "col-md-12");
                        newObject.setAttribute("id", "div_commissionDetail" + element.id);
                        var textSelect = '<br id="br_commissionDetails_' + element.id + '"/>'+
                                '<div class="col-md-6" id="div_commissionAmount_' + element.id + '">'+
                                    '<input type="text" autocomplete="off" class="form-control" id="commissionAmount_' + element.id + '" placeholder="MONTO" style="width: 100%" value="' + element.amount + '">'+
                                '</div>'+
                                '<div class="col-md-6" id="div_commissionOperation_' + element.id + '">'+
                                    '<select id="commissionOperation_' + element.id + '" class="form-control"  style="width: 100%">'+
                                    '<option selected value="'+ element.operation +'">'+ element.operationName.toUpperCase() +'</option>'+
                                    '<option value="'+ (element.operation == 1 ? 2 : 1) +'">'+ (element.operation == 1 ? "MONTO" : "PORCENTAJE") +'</option>'+
                                    '</select>'+
                                '</div>';
                        newObject.innerHTML = textSelect;
                        commisionDetails.appendChild(newObject);
                    }
                    // commisionOptions
                    var commisionOptions = document.getElementById('commisionOptions');
                    if (commisionOptions != null) {
                        var newObject = document.createElement('div');
                        newObject.setAttribute("class", "col-md-12");
                        newObject.setAttribute("id", "div_commissionOptions" + element.id);
                        newObject.setAttribute("align", "center");
                        var textSelect = '<br id="br_comissionDelete_' + element.id + '"/>'+
                            '<button type="button" class="btn btn-danger" id="comissionDelete_' + element.id + '" onClick="commissionDelete(' + element.id + ');">BORRAR</button>';
                        newObject.innerHTML = textSelect;
                        commisionOptions.appendChild(newObject);
                    }
                });
            });
            var titleUpdateCommission = document.getElementById('updateCommission');
            titleUpdateCommission.innerHTML = 'Editar comisiones asignadas al usario ' + arrayUsers[id].name + ', ' + arrayUsers[id].lastname;
        }

        commissionDelete = function(id) {
            if (document.getElementById('div_commissionProduct_' + id) !== null ) {
                document.getElementById("div_commissionProduct_" + id).remove();
                // document.getElementById("br_commissionProduct_" + id).remove();
                // document.getElementById("commissionProductId_" + id).remove();
                // document.getElementById("commissionProductName_" + id).remove();
                document.getElementById("div_commissionDetail" + id).remove();
                // document.getElementById("br_commissionDetails_" + id).remove();
                // document.getElementById("div_commissionAmount_" + id).remove();
                // document.getElementById("div_commissionOperation_" + id).remove();
                // document.getElementById("commissionAmount_" + id).remove();
                // document.getElementById("commissionOperation_" + id).remove();
                document.getElementById("div_commissionOptions" + id).remove();
                // document.getElementById("br_comissionDelete_" + id).remove();
                // document.getElementById("comissionDelete_" + id).remove();                
            }
        }

        commissionDeleteAll = function() {
            responseCommission[0].json_conf.products.forEach(element => {
                commissionDelete(element.id);
            });
            commissions = [];
            commissionCount = 0;
        }

        commissionSubmit = function() {
            $('#modal-on-load').modal({backdrop: 'static', keyboard: false});
            responseCommission[0].json_conf.products.forEach(element => {
                var commission = {};
                if (document.getElementById("div_commissionProduct_" + element.id)
                    !== null) {
                    commission.type = 2;
                    commission.employeeId = responseCommission[0].com_employee_id;
                    commission.productId = document.getElementById("commissionProductId_" + element.id).value;
                    commission.productName = document.getElementById("commissionProductName_" + element.id).value; 
                    commission.amount = document.getElementById("commissionAmount_" + element.id).value;
                    commission.operation = document.getElementById("commissionOperation_" + element.id).value;
                    commissions.push(commission);
                }
            });
            // ver json de comisiones
            // console.log(commissions);
            // call api
            $.ajax({
                method: "PATCH",
                url: "/api/commissions/" + parseInt(responseCommission[0].id),
                context: document.body,
                data: {
                    commissions: commissions
                },
                statusCode: {
                    400: function() {
                        $('#modal-on-load').modal('toggle');
                        alert('No se culminar la operación. Comuníquese con soporte.');
                    },
                    404: function() {
                        $('#modal-on-load').modal('toggle');
                        alert('No se culminar la operación. Comuníquese con soporte.');
                    },
                    500: function() {
                        $('#modal-on-load').modal('toggle');
                        alert('No se culminar la operación. Comuníquese con soporte.');
                    }
                }
            }).done(function(response) {
                // api response
                $('#modal-on-load').modal('toggle');
                commissionDeleteAll();
            });
        }
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>