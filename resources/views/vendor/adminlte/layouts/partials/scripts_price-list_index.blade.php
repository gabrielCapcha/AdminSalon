<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    var data = {
        priceListDeletedId: 0,
        priceListEditedId: 0,
    }
    var arrayPriceList = [];
    var editPriceList;
    var editPriceListSubmit;
    var deletePriceList;
    var deletePriceListSubmit;
    var createPriceList;
    var createPriceListSubmit;
    $(document).ready(function() {
        var saleIndexTable = $('#sale_index').DataTable({
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
                    $.get('/api/price-list', {
                        limit: data.length,
                        offset: data.start,
                        }, function(res) {
                            arrayPriceList = [];
                            res.forEach(element => {
                                arrayPriceList[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.length,
                                recordsFiltered: res.length,
                                data: res
                            });
                        });
            },
            "columns"    : [
                {'data': 'name'},
                {'data': 'description'},
                {'data': function (data, type, dataToSet) {
                    return data.currency + ' (' + data.symbol_code + ')';
                }},
                {'data': function (data, type, dataToSet) {
                        var response = 'NO';
                        if (data.flag_default === 1) {
                            response = 'SI'
                        }
                        return response;
                    }
                },
                {'data': function (data, type, dataToSet) {
                        var response = 'DESACTIVADO';
                        if (data.flag_active === 1) {
                            response = 'ACTIVADO'
                        }
                        return response;
                    }
                },
                {'data': function (data) {
                    return data.created_at.substring(0, 10);
                }},
                {'data': function (data) {
                    return data.created_at.substring(11, 20);
                }},
                {'data': function (data, type, dataToSet) {
                    if (data.flag_active == 1) {
                        return '<button type="button" onClick="editPriceList(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button><span> </span>'+
                            '<button type="button" onClick="deletePriceList(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    } else {
                        return '<button type="button" onClick="editPriceList(' + data.id + ')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button><span> </span>'+
                            '<button disabled type="button" onClick="deletePriceList(' + data.id + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                    }
                }}
            ],
            "responsive": true
        });

        //var functions
        editPriceList = function (id) {
            var priceList = arrayPriceList[id];
            data.priceListEditedId = id;
            console.log(priceList.flag_default);
            document.getElementById('priceListNameUpdate').value = priceList.name;
            document.getElementById('priceListCurrencyUpdate').value = priceList.currency;
            document.getElementById('priceListDescriptionUpdate').value = priceList.description;
            if (priceList.flag_default) {
                document.getElementById('priceListFlagDefaultUpdate').value = 'SI';                
            } else {
                document.getElementById('priceListFlagDefaultUpdate').value = 'NO';
            }
            $('#modal-edit').modal({ backdrop: 'static', keyboard: false });
        }
        editPriceListSubmit = function () {
            var flagDefault = 0;
            if (document.getElementById('priceListFlagDefaultUpdate').value == 'SI') {
                flagDefault = 1;
            }
            var dataSend = {
                currency: document.getElementById('priceListCurrencyUpdate').value,
                name: (document.getElementById('priceListNameUpdate').value).toUpperCase(),
                description: (document.getElementById('priceListDescriptionUpdate').value).toUpperCase(),
                flag_default: flagDefault,
            };
            $.ajax({
                url: "/api/price-list/" + data.priceListEditedId,
                context: document.body,
                method: "PATCH",
                data: dataSend,
                statusCode: {
                    400: function() {
                        data.priceListDeletedId = 0;
                        alert("La lista de precios no se pudo actualizar.");
                    }
                }
            }).done(function(response) {
                location = "/price-list";
            });
        }
        deletePriceList = function (id) {
            var priceList = arrayPriceList[id];
            data.priceListDeletedId = id;
            var deletedPriceListText = document.getElementById('deletedPriceListText');
            deletedPriceListText.innerHTML = "¿Desea eliminar la lista de precios " + priceList.name + "?";
            $('#modal-delete').modal({ backdrop: 'static', keyboard: false });
        }
        deletePriceListSubmit = function () {
            if (data.priceListDeletedId != 0) {
                var comment = document.getElementById('deletedPriceListComment').value;
                $.ajax({
                    url: "/api/price-list/" + data.priceListDeletedId + "?comment=" + comment,
                    context: document.body,
                    method: "DELETE",
                    statusCode: {
                        400: function() {
                            data.priceListDeletedId = 0;
                            alert("La lista de precios no se pudo eliminar.");
                        }
                    }
                }).done(function(response) {
                    location = "/price-list";
                });
            } else {
                console.log("No se pudo eliminar la lista de precios con id " + data.priceListDeletedId);
            }
        }
        createPriceList = function () {
            $('#modal-create').modal({ backdrop: 'static', keyboard: false });
        }
        createPriceListSubmit = function () {
            var flagDefault = 0;
            if (document.getElementById('newPriceListFlagDefault').value == 'SI') {
                flagDefault = 1;
            }
            var dataSend = {
                currency: document.getElementById('newPriceListCurrency').value,
                name: (document.getElementById('newPriceListName').value).toUpperCase(),
                description: (document.getElementById('newPriceListDescription').value).toUpperCase(),
                flag_default: flagDefault,
            };

            $.ajax({
                url: "/api/price-list",
                context: document.body,
                method: "POST",
                data: dataSend,
                statusCode: {
                    400: function() {
                        data.priceListDeletedId = 0;
                        alert("La lista de precios no se pudo crear.");
                    }
                }
            }).done(function(response) {
                location = "/price-list";
            });
        }
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>