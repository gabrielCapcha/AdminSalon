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
        var data = {
            newCustomer : {}
        };
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
                    $.get('/api/transport-company', {
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
                {'data': 'ruc'},
                {'data': 'name'},
                {'data': 'address'},
                {'data': 'district'},
                {'data': 'province'},
                {'data': 'department'},
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

        searchNewClientSunatButton = function() {
            var x = document.getElementById("loadingDivNewCustomer");
            var searchClientSunat = document.getElementById('searchNewClientSunat').value;
            var clientDataResponse = document.getElementById("newClientDataResponse");
            switch (searchClientSunat.length) {
                case 11:
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    } else {
                        x.style.display = "none";
                    }
                    $.ajax({
                        url: "/api/customer-in-sunat/by/ruc/" + searchClientSunat,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                x.style.display = "none";
                                alert("No se encontraron registros en la SUNAT.");
                            },
                            500: function () {
                                x.style.display = "none";
                                alert("Hubo problemas al conectarse con SUNAT.");
                            }
                        }
                    }).done(function(response) {
                        if (response.condicion == "HABIDO") {
                            x.style.display = "none";
                            document.getElementById('searchNewClientSunat').value = "";
                            var buttonSaveNewClient = document.getElementById('saveNewClient');
                            buttonSaveNewClient.disabled = false;
                            clientDataResponse.innerHTML = "";
                            var form = document.createElement('form');
                            form.innerHTML ='<div class="box-body col-md-6">' +
                                '<div class="form-group">' +
                                '<label for="clientDni">DNI</label>' +
                                '<input type="text" class="form-control" id="clientDni" readonly placeholder="Ingrese DNI" value="' + response.dni + '"></div>' +
                                '<div class="form-group"><label for="clientNames">NOMBRES</label>' +
                                '<input type="text" class="form-control" id="clientNames" readonly placeholder="Ingrese NOMBRES" value="' + response.nombre + '"></div>' +
                                '<div class="form-group"><label for="clientFirstLastname">TIPO DE CONTRIBUYENTE</label>' + 
                                '<input type="text" class="form-control" id="clientFirstLastname" readonly placeholder="Ingrese TIPO DE CONTRIBUYENTE" value="' + response.tipo_contribuyente + '"></div>' +
                                '<div class="form-group"><label for="clientSecondLastname">RUC</label>' +
                                '<input type="text" class="form-control" id="clientSecondLastname" readonly placeholder="Ingrese RUC" value="' + searchClientSunat + '"></div>' +
                                '<div class="form-group"><label for="clientEmail">CORREO ELECTRÓNICO</label>' +
                                '<input type="text" class="form-control" id="clientEmail" maxlength=100 placeholder="Ingrese CORREO ELECTRÓNICO" value=""></div></div>' +
                                '<div class="box-body col-md-6"><div class="form-group"><label for="clientPhone">TELÉFONO DE CONTACTO</label>' +
                                '<input type="text" class="form-control" id="clientPhone" maxlength=25 placeholder="Ingrese TELÉFONO DE CONTACTO" value=""></div>' +
                                '<div class="form-group"><label for="clientAddress">DIRECCIÓN</label>' +
                                '<input type="text" class="form-control" id="clientAddress" maxlength=200 placeholder="Ingrese DIRECCIÓN" value="' + response.domicilio + '"></div>'+
                                '<div class="form-group"><label for="clientDistrict">DISTRITO</label>' +
                                '<input type="text" class="form-control" id="clientDistrict" maxlength=100 placeholder="Ingrese DISTRITO" value="' + response.distrito + '"></div>'+
                                '<div class="form-group"><label for="clientDistrict">PROVINCIA</label>' +
                                '<input type="text" class="form-control" id="clientProvince" maxlength=100 placeholder="Ingrese PROVINCIA" value="' + response.provincia + '"></div>'+
                                '<div class="form-group"><label for="clientDepartment">DEPARTAMENTO</label>' +
                                '<input type="text" class="form-control" id="clientDepartment" maxlength=100 placeholder="Ingrese DEPARTAMENTO" value="' + response.departamento + '"></div>'+
                                '</div>';
                            clientDataResponse.appendChild(form);
                            data.newCustomer = response;
                            data.newCustomer.typeCustomer = 2;
                            data.newCustomer.name = response.nombre;
                            data.newCustomer.lastname = '';
                            data.newCustomer.ruc = searchClientSunat;
                        } else {
                            x.style.display = "none";
                            alert("Ruc en condición NO HABIDO.");
                        }
                    });
                    break;
                default:
                    alert("DNI o RUC ingresado no son válidos.");
                    break;
            }
        }

        saveNewClient = function() {
            var button = document.getElementById('saveNewClient');
            data.newCustomer.phone = document.getElementById("clientPhone").value;
            data.newCustomer.email = document.getElementById("clientEmail").value;
            data.newCustomer.address = document.getElementById("clientAddress").value;
            data.newCustomer.district = document.getElementById("clientDistrict").value;
            data.newCustomer.province = document.getElementById("clientProvince").value;
            data.newCustomer.department = document.getElementById("clientDepartment").value;
            if (data.newCustomer.dni == '-') {
                data.newCustomer.dni = null;
            }
            $.ajax({
                method: "POST",
                url: "/api/transport-company",
                context: document.body,
                data: data.newCustomer,
                statusCode: {
                    400: function() {
                        button.disabled = false;
                        alert("Hubo un error en el registro. Es posible que la empresa ya esté registrada.");
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
