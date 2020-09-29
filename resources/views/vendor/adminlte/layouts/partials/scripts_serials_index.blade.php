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
    var arraySerials = [];
    var deletedId = 0;
    var editedId = 0;

    $(document).ready(function() {
        $('#sale_index thead tr').clone(true).appendTo( '#sale_index thead' );
        $('#sale_index thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input class="filter" type="text" placeholder="'+title+'" />' );
            $( 'input', this ).on( 'keyup change', function () {
                if ( saleIndexTable.column(i).search() !== this.value ) {
                    saleIndexTable.column(i).search( this.value ).draw();
                }
            } );
        } );

        var saleIndexTable = $('#sale_index').DataTable({
            "scrollX": true,
            "processing": true,
            "orderCellsTop": true,
            "fixedHeader": true,
            "lengthChange": false,
            "columnDefs": [
            ],
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
            'order': [[ 0, "desc" ]],
            "ordering": true,
            "searching": true,
            "ajax": function(data, callback, settings) {
                    $.get('/api/serials', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        warehouseId: $('#warehouseId').val(),
                        dateRange: $('#dateRange').val(),
                        }, function(res) {
                            arraySerials = [];
                            res.data.forEach(element => {
                                arraySerials[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {
                    'data': function(data) { return data.warehouseName;} ,
                    'name': 'warehouse_name',
                },
                {
                    'data': function(data) { return data.productCode + ' (' + data.productAutoBarCode + ') ' + data.productName;} ,
                    'name': 'product_name',
                },
                {
                    'data': 'serial',
                    'name': 'serial',
                },
                {
                    'data': 'imei',
                    'name': 'imei',
                },
                {'data': function(data) {
                    var message = 'DÍAS';
                    switch (data.type_warranty) {
                        case 1:
                            message = 'DÍAS';
                            break;
                        case 2:
                            message = 'MESES';
                            break;
                        case 3:
                            message = 'AÑOS';
                            break;                    
                        default:
                            message = 'DÍAS';
                            break;
                    }
                    return data.warranty + ' ' + message;
                }},
                {'data': function(data) {
                    var message = 'SIN FECHA';
                    if (data.sal_sale_documents_id != null) {
                        message = data.date_of_sale;
                    }
                    return message;
                }},
                {'data': function(data) {
                    if (data.date_of_sale != null) {
                        var dateOfSale = new Date(Date.parse(data.date_of_sale));
                        switch (data.type_warranty) {
                            case 1:
                                dateOfSale = dateOfSale.setDate(dateOfSale.getDate() + data.warranty);
                                break;
                            case 2:
                                dateOfSale = dateOfSale.setMonth(dateOfSale.getMonth() + data.warranty);
                                break;
                            case 3:
                                dateOfSale = new Date(dateOfSale.setFullYear(dateOfSale.getFullYear() + data.warranty));
                                break;                    
                            default:
                                dateOfSale = dateOfSale.setMonth(dateOfSale.getMonth() + data.warranty);
                                break;
                        }
                        var humanDate = new Date(dateOfSale);
                        //return humanDate.toISOString().slice(0,10);
                        return humanDate;
                    } else {
                        return 'SIN FECHA';
                    }
                }},
                {'data': function(data) {
                    var message = 'DISPONIBLE';
                    if (data.sal_sale_documents_id != null) {
                        message = 'VENDIDO';
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = 'SIN VENTA';
                    if (data.sal_sale_documents_id != null) {
                        message = data.saleTicket;
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = 'SIN DOCUMENTO';
                    if (data.sal_sale_documents_id != null) {
                        if (data.customerTypePerson == 1) {
                            message = data.customerDni;
                        } else {
                            message = data.customerRuc;
                        }
                    }
                    return message;
                }},
                {'data': function(data) {
                    var message = 'SIN CLIENTE';
                    if (data.sal_sale_documents_id != null) {
                        if (data.customerTypePerson == 1) {
                            message = data.customerName + ' ' + data.customerLastname;
                        } else {
                            message = data.customerRzSocial;
                        }
                    }
                    return message;
                }},
                {'data': function(data) {
                    return data.created_at;
                }},
                {'data': function(data) {
                    if (data.sal_sale_documents_id == null) {
                        return '<button type="button" onClick="updateSerial(' + data.id + ');" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button><span> </span>' +
                        '<button type="button" onClick="deleteSerial(' + data.id + ');" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';                        
                    } else {
                        return '<button type="button" disabled class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></button><span> </span>' +
                        '<button type="button" disabled class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    }
                }},
            ],
            "responsive": true,
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.ajax.reload();
            saleIndexTable.search( this.value ).draw();
        });
        $('.filter').on('click', function(e){
            e.stopPropagation();
        });

        //Date range picker
        $('#dateRange').daterangepicker(
            {
                timeZone: 'America/Lima',
                locale: {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Ok",
                    "cancelLabel": "Cerrar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Perzon.",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                },
                maxDate: moment().subtract(0, 'days').endOf('day'),
        });

        // functions
        updateSerial = function(id) {
            editedId = id;
            document.getElementById('editSerialSerial').value = arraySerials[editedId].serial; 
            document.getElementById('editSerialImei').value = arraySerials[editedId].imei;
            document.getElementById('editedSerialText').innerHTML = '¿Desea actualizar la serie <strong>' + arraySerials[editedId].serial + '</strong>?';
            editedSerialText
            $('#modal-warning').modal({ backdrop: 'static', keyboard: false });
        }
        deleteSerial = function(id) {
            deletedId = id;
            document.getElementById('deletedSerialText').innerHTML = '¿Desea eliminar la serie <strong>' + arraySerials[deletedId].serial + '</strong>?';
            $('#modal-danger').modal({ backdrop: 'static', keyboard: false });
        }
        deleteSerialSubmit = function() {
            if (deletedId != 0) {
                deleteSerialBtn.disabled = true;
                deleteSerialBtn.innerHTML = 'PROCESANDO...';
                // AJAX
                var comment = document.getElementById('deleteSerialComment');
                if (comment != null) {
                    comment = comment.value;
                }
                $.ajax({
                    url: "/api/serials/" + deletedId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            deletedId = 0;
                            deleteSerialBtn.disabled = false;
                            deleteSerialBtn.innerHTML = 'LA SERIE NO SE PUDO ELIMINAR. VOLVER A INTENTAR.';
                        }
                    }
                }).done(function(response) {
                    deletedId = 0;
                    deleteSerialBtn.disabled = false;
                    deleteSerialBtn.innerHTML = 'ACEPTAR';
                    $('#searchButton').trigger('click');
                    $('#modal-danger').modal('toggle');
                });
            }
        }
        editSerialSubmit = function() {
            if (editedId != 0) {
                editSerialBtn.disabled = true;
                editSerialBtn.innerHTML = 'PROCESANDO...';
                // AJAX
                var dataSend = {
                    serial: document.getElementById('editSerialSerial').value,
                    imei: document.getElementById('editSerialImei').value,
                }
                $.ajax({
                    method: "PATCH",
                    url: "/api/serials/" + editedId,
                    context: document.body,
                    data: dataSend,
                    statusCode: {
                        400: function() {
                            editedId = 0;
                            editSerialBtn.disabled = false;
                            editSerialBtn.innerHTML = 'LA SERIE NO SE PUDO ACTUALIZAR. VOLVER A INTENTAR.';
                        }
                    }
                }).done(function(response) {
                    editedId = 0;
                    editSerialBtn.disabled = false;
                    editSerialBtn.innerHTML = 'ACEPTAR';
                    $('#searchButton').trigger('click');
                    $('#modal-warning').modal('toggle');
                });
            }
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>