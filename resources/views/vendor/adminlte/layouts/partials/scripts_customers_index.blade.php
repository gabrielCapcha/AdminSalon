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
    var idCustomerSubsidiary = 0;
    var editDocument;
    var editCustomer;
    var deleteDocument;
    var documentDetailModal;
    var arrayCustomers = [];
    var arrayCredits = [];
    $(document).ready(function() {
        var saleIndexTable = $('#customer_index').DataTable({
            "scrollX": true,
            "processing": true,
            "orderCellsTop": true,
            "fixedHeader": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            "serverSide": false,
            "paging": true,
            // 'order' : [[ 0, "desc" ]],
            "ordering": true,
            "searching": true,
            "ajax": function(data, callback, settings) {
                    $.get('/api/customers-simple', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        }, function(res) {
                            arrayCustomers = [];
                            res.forEach(element => {
                                arrayCustomers[element.id] = element;
                            });                             
                            callback({
                                recordsTotal: res.length,
                                recordsFiltered: res.length,
                                data: res
                            });
                        });
            },
            "columns"    : [
                {'data': function (data) {
                    var message = 'SIN ASIGNACIÓN';
                    if (data.employees != null) {
                        data.employees.forEach(element => {
                            if (element.main) {
                                message = '<a style="cursor:pointer;" onClick="openEmployeeAssingmentModal(' + data.id + ');">' + element.name + ' ' + element.lastname;
                            }
                        });
                    }
                    return message;
                }},
                {'data':  function (data, type, dataToSet) {
                    var message = "DNI";
                    switch (data.flag_type_person) {
                        case 2:
                            message = "RUC";
                            break;
                        case 3:
                            message = "CARNÉ EXTRANJERÍA";
                            break;
                        case 4:
                            message = "PASAPORTE";
                            break;
                        default:
                            break;
                    }
                    return message;
                }},
                {'data':  function (data, type, dataToSet) {
                    if (data.dni == "") {
                        return '';
                    } else {
                        if (data.flag_type_person == 2) {
                            return data.ruc;
                        } else {
                            if (data.flag_type_person == 1) {
                                return ("00000000" + data.dni).slice(-8);
                            } else {
                                return data.dni;
                            }
                        }
                    }
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.flag_type_person != 2) {
                        if (data.lastname == null && data.name == null) {
                            return '';
                        } else {
                            return data.lastname + ', ' + data.name;
                        } 
                    } else {
                        return '-';
                    }
                }},
                {'data': 'rz_social'},
                {'data': function (data) {
                        return data.email;
                }},
                {'data': function (data) {
                        return data.description;
                }},
                {'data': function (data) {
                    var message = data.district
                    if (message == null) {
                        message = '';
                    }
                    return message;
                }},
                {'data': function (data) {
                        return data.address;
                }},
                {'data': function (data) {
                        return data.phone;
                }},
                {'data': function (data) {
                        return data.contact;
                }},
                {'data': function (data) {
                        return data.website_address;
                }},
                {'data': function (data) {
                        return data.created_at;
                }},
                {'data': function (data) {
                        return data.date_birth;
                }},
                {'data': function (data) {
                    if (data.flag_active == 0) {
                        //deshabilitado
                        return '<button type="button" disabled onClick="editCustomer(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button><span> </span>' +
                            //'<button type="button" disabled data-toggle="modal" class="btn btn-success btn-xs"><i class="fa fa-map-o"></i></button><span> </span>' + 
                            '<button type="button" disabled data-toggle="modal" class="btn btn-info btn-xs"><i class="fa fa-money"></i></button><span> </span>' +
                            '<br><hr style="margin:2px; border-top: 0px;">' +
                            '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    } else {
                        //habilitado
                        return '<button type="button" onClick="editCustomer(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" onClick="openNewCustomerSubsidiary(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-map-o"></i></button><span> </span>' +
                            '<button type="button" data-toggle="modal" onClick="openNewCustomerCredit(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-money"></i></button><span> </span>' +
                            '<br><hr style="margin:2px; border-top: 0px;">' +
                            '<button type="button" data-toggle="modal" data-target="#modal-danger" onClick="deleteDocument(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
        });

        //Functions
        function getCurrencySymbolCode(currency) {
            var symbolCode = 'S/ ';
            switch (currency) {
                case 'PEN':
                    symbolCode = 'S/ ';
                    break;
                case 'USD':
                    symbolCode = '$ ';
                    break;
                case 'EUR':
                    symbolCode = '€ ';
                    break;
                case 'JPY':
                    symbolCode = '¥ ';
                    break;                
                default:
                    symbolCode = '$ ';
                    break;
            }
            return symbolCode;
        }
        openEmployeeAssingmentModal = function(id) {
            var modalEmployeeAssignmentText = document.getElementById('modalEmployeeAssignmentText');
            if (modalEmployeeAssignmentText != null) {
                modalEmployeeAssignmentText.innerHTML = 'USUARIOS ASIGNADOS AL CLIENTE: ' + arrayCustomers[id].name + ' ' + arrayCustomers[id].lastname;
                if (arrayCustomers[id].employees != null) {
                    var modalEmployeeAssignmentTBody = document.getElementById('modalEmployeeAssignmentTBody');
                    if (modalEmployeeAssignmentTBody != null) {
                        var modalEmployeeAssignmentTBody_ = '';
                        arrayCustomers[id].employees.forEach(element => {
                            modalEmployeeAssignmentTBody_ = modalEmployeeAssignmentTBody_ +
                                '<td>' + element.email + '</td>' +
                                '<td>' + element.name + '</td>' +
                                '<td>' + element.lastname + '</td>' +
                                '<td>' + (element.main ? 'SÍ':'NO') + '</td>' +
                                '<td>' + element.operationDate + '</td>' + 
                                '<td>' + (element.flagActive ? 'ACTIVO':'INACTIVO') + '</td>';
                        });
                        modalEmployeeAssignmentTBody.innerHTML = modalEmployeeAssignmentTBody_;
                    }
                }
            }
            $('#modal-employee-assignment').modal({ backdrop: 'static', keyboard: false });
        }

        documentDetailModal = function(id) {
            var detailOpenCashCreatedAt = document.getElementById('detailOpenCashCreatedAt');
            var customerName = "SIN DEFINIR";
            if (arrayCustomers[id].lastname != null && arrayCustomers[id].name != null) {
                customerName = arrayCustomers[id].lastname.toUpperCase() + ", " + arrayCustomers[id].name.toUpperCase();
            }
            var customerRUC = "SIN DEFINIR";
            if (arrayCustomers[id].ruc != "") {
                customerRUC = arrayCustomers[id].ruc;
            }
            var customerRzSocial = "SIN DEFINIR";
            if (arrayCustomers[id].rz_social != null) {
                customerRzSocial = arrayCustomers[id].rz_social;
            }
            var customerDNI = "SIN DEFINIR";
            if (arrayCustomers[id].dni != "") {
                customerDNI = arrayCustomers[id].dni;
            }
            detailOpenCashCreatedAt.innerHTML = 'CLIENTE: '  + customerName;
            //ITEMS TABLE
            document.getElementById('customerRUC').innerHTML = customerRUC;
            document.getElementById('customerDNI').innerHTML = customerDNI;
            document.getElementById('nameCustomer').innerHTML = customerName;
            document.getElementById('businessName').innerHTML = customerRzSocial;
            // document.getElementById('totalAmount').innerHTML = "S/ " + arrayCustomers[id].total_consume;
            //ITEMS TABLE
        }

        openNewCustomerSubsidiary = function(id) {
            var button = document.getElementById('newCustomerSubsidiaryButton');
            button.innerHTML = 'GUARDAR';
            button.onclick = function() { newCustomerSubsidiarySubmit(); }
            document.getElementById('newCustomerSubsidiaryJson').value = '';
            document.getElementById('newCustomerSubsidiaryAddress').value = '';
            document.getElementById('newCustomerSubsidiaryDistrict').value = '';
            document.getElementById('newCustomerSubsidiaryProvince').value = '';
            document.getElementById('newCustomerSubsidiaryDepartment').value = '';
            document.getElementById('newCustomerSubsidiaryCountry').value = '';
            document.getElementById('newCustomerSubsidiaryPhone').value = '';
            document.getElementById('newCustomerSubsidiaryUbigeo').value = '';
            document.getElementById('pac-input').value = '';
            var customer = arrayCustomers[id];
            idCustomerSubsidiary = id;
            document.getElementById('newCustomerSubsidiaryText').innerHTML = "NUEVA SUCURSAL DEL CLIENTE: " + customer.rz_social;
            if (customer.rz_social == null) {
                document.getElementById('newCustomerSubsidiaryText').innerHTML = "NUEVA SUCURSAL DEL CLIENTE: " + customer.name + ' ' + customer.lastname;
            }
            
            // // carga de sucursales
            var rowsCustomerSubsidiaries = document.getElementById('rowsCustomerSubsidiaries');
            rowsCustomerSubsidiaries.innerHTML = '<p>Cargando sucursales ... </p>';
            $.ajax({
                method: "GET",
                url: "/api/customer-subsidiary/" + customer.id,
                context: document.body,
                statusCode: {
                    404: function() {
                        rowsCustomerSubsidiaries.innerHTML = '<p>No se encontraron sucursales.</p>';
                    },
                }
            }).done(function(response) {
                // CARGA DE SUCURSALES
                rowsCustomerSubsidiaries.innerHTML = '';
                response.forEach(element => {
                    var btn = document.createElement("p");
                    btn.style.width = '80%';
                    btn.style.padding = '5px';
                    btn.setAttribute("id", "btnCustomerSubsidiary_" + element.id);
                    var deleteButton = '<button id="btnDeleteCustomerSubsidiary_' + element.id + '" type="button" onClick="deleteSubsidiary(' + element.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' + element.province +  ' - ' + element.district + ' - ' + element.address;btn.innerHTML = deleteButton;
                    rowsCustomerSubsidiaries.insertBefore(btn, rowsCustomerSubsidiaries.firstChild);
                });
            });
            
            $('#modal-subsidiary').modal({ backdrop: 'static', keyboard: false });
        }

        openNewCustomerCredit = function(id) {
            var btnUpdateCreditSubmit = document.getElementById('btnUpdateCreditSubmit');
            if (btnUpdateCreditSubmit != null) {
                btnUpdateCreditSubmit.disabled = true;
                document.getElementById('creditCurrency').value = 'PEN';
                document.getElementById('creditDetail').value = '';
                document.getElementById('creditAmount').value = '';
                document.getElementById('creditPeriod').value = '';
            }
            editCustomer = arrayCustomers[id];
            var customerName = editCustomer.name + " " + editCustomer.lastname;
            if (editCustomer.flag_type_person == 2) {
                customerName = editCustomer.rz_social;
            }
            document.getElementById('titleModalCredit').innerHTML = "LISTA DE CRÉDITOS DEL CLIENTE: " + "<b>" + customerName + "</b>";
            var tableCredit = $('#creditTable').DataTable();
            tableCredit.destroy();
            $('#creditTable').DataTable({
                "scrollX": true,
                "scrollY": "350px",
                "processing": true,
                "orderCellsTop": true,
                "fixedHeader": true,
                "lengthChange": false,
                "info": false,
                "language": {
                    "url": "/js/languages/datatables/es.json"
                },
                "serverSide": false,
                "paging": true,
                'order' : [[ 0, "desc" ]],
                "ordering": true,
                "searching": false,
                "ajax": function(data, callback, settings) {
                    $.get('/api/customers-credit-by-id/' + editCustomer.id, {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        }, function(res) {
                            arrayCredits = [];
                            res.forEach(element => {
                                arrayCredits[element.id] = element;
                            });     
                            callback({
                                recordsTotal: res.length,
                                recordsFiltered: res.length,
                                data: res
                            });
                        });
                },
                "columns"    : [
                    {'data': function (data) {
                        return data.name;
                    }},
                    {'data': function (data) {
                        return getCurrencySymbolCode(data.currency) + ' ' + parseFloat(data.amount).toFixed(2);
                    }},
                    {'data': function (data) {
                        return getCurrencySymbolCode(data.currency) + ' ' + parseFloat(data.debt).toFixed(2);
                    }},
                    {'data': function (data) {
                        return getCurrencySymbolCode(data.currency) + ' ' + (parseFloat(data.amount) - parseFloat(data.debt)).toFixed(2);
                    }},
                    {'data': function (data) {
                        return data.days;
                    }},
                    {'data': function (data) {
                        if (data.flag_active == 1) {
                            if (data.start_date == null) {
                                return "SIN USO";
                            } else {
                                return data.start_date;
                            }                            
                        } else {
                            return "NO DISPONIBLE";
                        }
                    }},
                    {'data': function (data) {
                        if (data.flag_active == 1) {
                            return '<button type="button" title="¿Desactivar crédito?" onClick="changeCreditStateOff(' + data.id + ')" class="btn btn-warning btn-xs"><i class="fa fa-toggle-off"></i></button><span> </span>' +
                            '<button type="button" title="Editar el crédito" onClick="editCredit(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button type="button" onClick="deleteCustomerCredit(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                        } else {
                            return '<button type="button" title="¿Activar crédito?" onClick="changeCreditStateOn(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-toggle-on"></i></button><span> </span>' +
                            '<button disabled type="button" title="Editar el crédito" onClick="editCredit(' + data.id + ')" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button><span> </span>' +
                            '<button type="button" onClick="deleteCustomerCredit(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                        }                        
                    }},
                ],
                "destroy": true,
            });
            $('#modal-new-credit').modal({ backdrop: 'static', keyboard: false });
        }

        editCredit = function (id) {
            var credit = arrayCredits[id];
            var btnUpdateCreditSubmit = document.getElementById('btnUpdateCreditSubmit');
            if (btnUpdateCreditSubmit != null) {
                btnUpdateCreditSubmit.disabled = false;
                btnUpdateCreditSubmit.onclick = function () {
                    updateCreditSubmit(id);
                };
                document.getElementById('creditCurrency').value = credit.currency;
                document.getElementById('creditDetail').value = credit.name;
                document.getElementById('creditAmount').value = credit.amount;
                document.getElementById('creditPeriod').value = credit.days;
            }
        }

        updateCreditSubmit = function(id) {
            var creditDetail = document.getElementById('creditDetail').value;
            if (creditDetail == '') {
                creditDetail = 'SIN INFORMACIÓN';
            }
            var dataSend = {
                "currency": document.getElementById('creditCurrency').value,
                "name": creditDetail.toUpperCase(),
                "amount": document.getElementById('creditAmount').value,
                "days": document.getElementById('creditPeriod').value,
            };
            $.ajax({
                method: "PATCH",
                url: "/api/customer-credit/" + id,
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        alert("No se pudo editar el crédito");
                    },
                }
            }).done(function(response) {
                var btnUpdateCreditSubmit = document.getElementById('btnUpdateCreditSubmit');
                if (btnUpdateCreditSubmit != null) {
                    btnUpdateCreditSubmit.disabled = true;
                    document.getElementById('creditCurrency').value = 'PEN';
                    document.getElementById('creditDetail').value = '';
                    document.getElementById('creditAmount').value = '';
                    document.getElementById('creditPeriod').value = '';
                }
                var tableCredit = $('#creditTable').DataTable();
                tableCredit.ajax.reload();
            });
        }

        changeCreditStateOff = function(id) {
            var dataSend = {
                flag_active: 0,
            };
            $.ajax({
                method: "PATCH",
                url: "/api/customer-credit/" + id,
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        alert("No se pudo cambiar el estado del crédito");
                    },
                }
            }).done(function(response) {
                var tableCredit = $('#creditTable').DataTable();
                tableCredit.ajax.reload();
            });
        }

        changeCreditStateOn = function(id) {
            var dataSend = {
                flag_active: 1,
            };
            $.ajax({
                method: "PATCH",
                url: "/api/customer-credit/" + id,
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        alert("No se pudo cambiar el estado del crédito");
                    },
                }
            }).done(function(response) {
                var tableCredit = $('#creditTable').DataTable();
                tableCredit.ajax.reload();
            });
        }

        deleteCustomerCredit = function(id) {
            var credit = arrayCredits[id];
            var titleDeleteCredit = document.getElementById('titleDeleteCredit');
            if (titleDeleteCredit != null) {
                titleDeleteCredit.innerHTML = '¿Desea eliminar el crédito <b>' + credit.name + '</b>?';
            }
            $('#modal-credit-danger').modal({ backdrop: 'static', keyboard: false });
            var btnDeleteCredit = document.getElementById('btnDeleteCredit');
            if (btnDeleteCredit != null) {
                btnDeleteCredit.onclick = function() {
                    deleteCustomerCreditSubmit(id);
                };
            }
        }

        deleteCustomerCreditSubmit = function(id) {
            $.ajax({
                method: "DELETE",
                url: "/api/customer-credit/" + id,
                context: document.body,
                statusCode: {
                    400: function() {
                        $('#modal-credit-danger').modal('toggle');
                        alert("No se pudo cambiar eliminar del crédito");
                    },
                }
            }).done(function(response) {
                $('#modal-credit-danger').modal('toggle');
                var tableCredit = $('#creditTable').DataTable();
                tableCredit.ajax.reload();
            });
        }

        newCreditSubmit = function() {
            var button = document.getElementById('btnNewCreditSubmit');
            if (button != null) {
                button.disabled = true;
                button.innerHTML = 'Procesando registro...';
                button.className = 'btn btn-warning';
                var creditDetail = document.getElementById('creditDetail').value;
                if (creditDetail == '') {
                    creditDetail = 'SIN INFORMACIÓN';
                }
                var dataSend = {
                    "currency": document.getElementById('creditCurrency').value,
                    "com_customers_id": editCustomer.id,
                    "name": creditDetail.toUpperCase(),
                    "amount": document.getElementById('creditAmount').value,
                    "days": document.getElementById('creditPeriod').value,
                };
                // WEBSERVICE
                $.ajax({
                    method: "POST",
                    url: "/api/new-customer-credit",
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            button.disabled = false;
                            button.innerHTML = 'GUARDAR';
                            button.className = 'btn btn-success';
                            alert("No se pudo crear el crédito");
                        },
                        500: function() {
                            button.disabled = false;
                            button.innerHTML = 'GUARDAR';
                            button.className = 'btn btn-success';
                            alert("No se pudo crear el crédito");
                        },
                    }
                }).done(function(response) {
                    document.getElementById('creditCurrency').value = 'PEN';
                    document.getElementById('creditDetail').value = "";
                    document.getElementById('creditAmount').value = "";
                    document.getElementById('creditPeriod').value = "";
                    var tableCredit = $('#creditTable').DataTable();
                    tableCredit.ajax.reload();
                    button.disabled = false;
                    button.innerHTML = 'GUARDAR';
                    button.className = 'btn btn-success';
                });
            } else {
                alert('No se puede continuar con el registro');
            }
        }

        deleteSubsidiary = function(id) {
            // llamar al servicio
            var btnDeleteCustomerSubsidiary = document.getElementById('btnDeleteCustomerSubsidiary_' + id);
            if (btnDeleteCustomerSubsidiary != null) {
                btnDeleteCustomerSubsidiary.disabled = true;
            }
            $.ajax({
                method: "DELETE",
                url: "/api/customer-subsidiary/" + id,
                context: document.body,
                statusCode: {
                    404: function() {
                        btnDeleteCustomerSubsidiary.disabled = false;
                        alert("No se pudo eliminar la sucursal.");
                    },
                }
            }).done(function(response) {
                // CARGA DE SUCURSALES
                var btnCustomerSubsidiary_ = document.getElementById('btnCustomerSubsidiary_' + id);
                if (btnCustomerSubsidiary_ != null) {
                    btnCustomerSubsidiary_.remove();
                }
                var rowsCustomerSubsidiaries = document.getElementById('rowsCustomerSubsidiaries');
                if (rowsCustomerSubsidiaries.childElementCount == 0) {
                    rowsCustomerSubsidiaries.innerHTML = 'No se encontraron sucursales.';
                } else {
                    console.log(rowsCustomerSubsidiaries.childElementCount);
                }
            });
        }

        newCustomerSubsidiarySubmit = function() {
            if (idCustomerSubsidiary != 0) {
                var button = document.getElementById('newCustomerSubsidiaryButton');
                button.disabled = true;
                button.innerHTML = "PROCESANDO NUEVA SUCURSAL...";
                
                var dataNewCustomerSubsidiary = {
                    com_customers_id: idCustomerSubsidiary,
                    website_description: document.getElementById('newCustomerSubsidiaryJson').value,
                    address: document.getElementById('newCustomerSubsidiaryAddress').value,
                    district: document.getElementById('newCustomerSubsidiaryDistrict').value,
                    province: document.getElementById('newCustomerSubsidiaryProvince').value,
                    department: document.getElementById('newCustomerSubsidiaryDepartment').value,
                    country: document.getElementById('newCustomerSubsidiaryCountry').value,
                    phone: document.getElementById('newCustomerSubsidiaryPhone').value,
                };

                if (dataNewCustomerSubsidiary.address != '') {
                    // WEBSERVICE
                    $.ajax({
                        method: "POST",
                        url: "/api/new-customer-subsidiary",
                        context: document.body,
                        data: dataNewCustomerSubsidiary,
                        statusCode: {
                            400: function() {
                                idCustomerSubsidiary = 0;
                                $('#modal-subsidiary').modal('toggle');
                                alert("No se pudo crear la nueva sucursal");
                            },
                            500: function() {
                                idCustomerSubsidiary = 0;
                                $('#modal-subsidiary').modal('toggle');
                                alert("No se pudo crear la nueva sucursal");
                            },
                        }
                    }).done(function(response) {
                        var rowsCustomerSubsidiaries = document.getElementById('rowsCustomerSubsidiaries');
                        if (rowsCustomerSubsidiaries.childElementCount == 0) {
                            rowsCustomerSubsidiaries.innerHTML = '';
                        }
                        var btn = document.createElement("p");
                            btn.style.width = '80%';
                            btn.style.padding = '5px';
                            btn.setAttribute("id", "btnCustomerSubsidiary_" + response.id);
                            var deleteButton = '<button id="btnDeleteCustomerSubsidiary_' + response.id + '" type="button" onClick="deleteSubsidiary(' + response.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button><span> </span>' + response.province +  ' - ' + response.district + ' - ' + response.address;
                            btn.innerHTML = deleteButton;
                            rowsCustomerSubsidiaries.insertBefore(btn, rowsCustomerSubsidiaries.firstChild);
                        button.disabled = false;
                        button.innerHTML = 'GUARDAR';
                    });
                } else {
                    button.disabled = false;
                    button.innerHTML = 'GUARDAR';
                }
            } else {
                console.log("idCustomerSubsidiary: " + idCustomerSubsidiary);
            }
        }

        deleteDocument = function(id) {
            deletedSaleId = id;
            var deleteSaleText = document.getElementById('deleteSaleComment');
            deleteSaleText.innerHTML = "¿Está seguro de eliminar a este cliente?";
        }

        editCustomer = function(id) {
            var customer = arrayCustomers[id];
            if (customer.flag_type_person == 2) {
                window.location.href = "/customers/edit-business/" + id;
            } else {
                window.location.href = "/customers/edit-natural/" + id;
            }
        }
    });    

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -12.046374, lng: -77.042793},
            zoom: 15,
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: false
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        var autocomplete = new google.maps.places.Autocomplete(input);
        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);
        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(15);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);

            // DOCUMENT
            document.getElementById('newCustomerSubsidiaryJson').value = JSON.stringify(place);
            document.getElementById('newCustomerSubsidiaryAddress').value = address;
            place.address_components.forEach(element => {
                element.types.forEach(elementType => {
                    switch (elementType) {
                        case 'locality':
                            document.getElementById('newCustomerSubsidiaryDistrict').value = element.long_name;
                            break;
                        case 'administrative_area_level_2':
                            document.getElementById('newCustomerSubsidiaryProvince').value = element.long_name;
                            break;
                        case 'administrative_area_level_1':
                            document.getElementById('newCustomerSubsidiaryDepartment').value = element.long_name;
                            break;
                        case 'country':
                            document.getElementById('newCustomerSubsidiaryCountry').value = element.long_name;
                            break;
                        case 'postal_code':
                            document.getElementById('newCustomerSubsidiaryUbigeo').value = element.long_name;
                            break;
                        default:
                            break;
                    }
                });
            });
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1siIQosDZ9PGGZeZZu9SJTs29INGWAC0&libraries=places&callback=initMap" async defer></script>
