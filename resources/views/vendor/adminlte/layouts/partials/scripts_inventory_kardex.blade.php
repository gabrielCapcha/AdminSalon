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
    //initial vars
    var getKardex;
    $(document).ready(function() {
        var dataSend = {};
        var q = 0;
        var transferData = $('#transferData').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,            
            // "columnDefs": [
            //     {
            //         "targets": [6],
            //         "className": 'dt-body-right'
            //     }
            // ],
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            'bDestroy': true,
            "serverSide": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                $.get('/api/kardex-detail/' + dataSend.productId + '/' + dataSend.warehouseId + '/' + dataSend.startDate + '/' + dataSend.endDate, {
                    limit: 100,
                    offset: 0,
                    }, function(res) {
                        callback({
                            recordsTotal: res.length,
                            recordsFiltered: 10,
                            data: res
                        });
                    });
            },
            "columns"    : [
                {'data': function(data) {
                    if (data.documentNumber.length <= 6) {
                        var documentCode = "";
                        if (data.documentType === "INGRESO DE MERCADERIA GENERAL") {
                            documentCode = "IMG-";
                        } else if (data.documentType === "SALIDA DE MERCADERIA GENERAL") {
                            documentCode = "SMG-";
                        }
                        documentCode = documentCode + ("00000000" + data.documentNumber).slice(-6);
                        return documentCode;
                    } else {
                        return data.documentNumber;
                    }
                }},
                {'data': function(data) {
                    return data.quantityIn;
                }},
                {'data': function(data) {
                    return data.quantityOut;
                }},
                // {'data': function(data) {
                //     var value = parseFloat(data.quantityIn) - parseFloat(data.quantityOut);
                //     q = q + value;
                //     return q;
                // }},
                {'data': function (data, type, dataToSet) {
                    var dateL = data.operationDate;
                    if (data.operationDate == null) {
                        dateL = data.createdAt;
                    }
                    var d = new Date(dateL),
                    dformat = [
                        ("00" + d.getDate()).slice(-2),
                        ("00" + (d.getMonth()+1)).slice(-2),
                        ("0000" + d.getFullYear()).slice(-4),
                    ].join('/');
                    return dformat;
                }},
                {'data': function (data, type, dataToSet) {
                    var dateL = new Date(data.operationDate);
                    if (data.operationDate == null) {
                        dateL = data.createdAt;
                    }
                    var d = new Date(dateL),
                    dformat = [
                        ("00" + d.getHours()).slice(-2),
                        ("00" + d.getMinutes()).slice(-2),
                        ("00" + d.getSeconds()).slice(-2),
                    ].join(':');
                    return dformat;
                }},
                {'data': function(data) {
                    var message = '-';
                    if (data.description != null) {
                        message = data.description;
                    }
                    if (data.saleDetail != null && parseFloat(data.quantityIn) > 0) {
                        if (data.saleDetail.sal_sale_states_id == 8) {
                            message = 'MERCADERIA REINGRESADA';
                        }
                    }
                    return message.toUpperCase();
                }},
                {'data': function(data) {
                    var message = '-';
                    if (data.saleDetail != null) {
                        if (data.saleDetail.sal_sale_states_id == 8  && parseFloat(data.quantityIn) > 0) {
                            message = 'INGRESO DE MERCADERIA POR <strong>ANULACIÓN DE VENTA</strong><br>MOTIVO: <strong>' + data.saleDetail.commentary + '</strong>';
                        } else {
                            message = 'VENTA REALIZADA A <strong>' + data.saleDetail.customerName + ' ' + data.saleDetail.customerLastname + '</strong> POR EL USUARIO <strong>' + data.saleDetail.salemanName + ' ' + data.saleDetail.salemanLastname + '</strong>.';
                        }
                    }
                    if (data.transferDetail != null) {
                        var sourceDelivered = data.transferDetail.warehouseSourceName;
                        if (data.transferDetail.deliveryUserName != null) {
                            sourceDelivered = sourceDelivered + ' (' + data.transferDetail.deliveryUserName + ' ' + data.transferDetail.deliveryUserLastname + ')';
                        }
                        message = 'TRANSFERENCIA REALIZADA A <strong>' + sourceDelivered + '</strong>';
                        if (data.transferDetail.clearanceUserName != null) {
                            message = message + 'A EL USUARIO <strong>' + data.transferDetail.clearanceUserName + ' ' + data.transferDetail.clearanceUserLastname + '</strong>.';
                        }
                    }
                    if (data.saleDetail == null && data.transferDetail == null) {
                        if (data.quantityIn != "0.00") {
                            message = "INGRESO DE MERCADERÍA";
                        } else if (data.quantityOut != "0.00") {
                            message = "SALIDA DE MERCADERÍA";
                        } else {
                            message = data.documentType;
                        }
                    }
                    return message;
                }},
            ],
            "responsive": true
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
        //Data vars
        var data = {};
        //Functions
        function autocompleteForProducts(inp) {
            var currentFocus;
            var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    this.parentNode.appendChild(a);
                    mainheaderSearchBar.style.height = "50px";
                    //LLAMADA AL SERVICIO
                    $.ajax({
                        url: "/api/products-for-inventory?searchInput=" + val,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron productos.");
                            }
                        }
                    }).done(function(response) {
                        if (response.length == 0) {
                            inp.value = "";
                            alert("No se encontraron productos.");
                        } else {
                            for (i = 0; i < response.length; i++) {
                                var nameLastname = response[i].name + ' - ' + response[i].code;
                                b = document.createElement("DIV");
                                b.setAttribute('class', 'form-control-autocomplete');
                                b.style.background = '#ffffff';
                                b.style.cursor = 'pointer';
                                b.innerHTML += nameLastname;
                                b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                b.addEventListener("click", function(e) {
                                    var iterator = this.getElementsByTagName("input")[0].value;
                                    inp.value = "";
                                    product = response[iterator];
                                    if (product != undefined) {
                                        data.product = product;
                                        var searchProduct = document.getElementById('searchProduct');
                                        searchProduct.value = product.name;
                                    } else {
                                        alert("No se encontraron productos.");
                                    }
                                    closeAllLists();
                                });
                                a.appendChild(b);
                            }                            
                        }
                    });
                }
            });
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        //Auto callbacks
        autocompleteForProducts(document.getElementById('searchProduct'));
        //var functions
        getKardex = function (){
            var warehouseId = document.getElementById('warehouseId').value;
            var dateRange = document.getElementById('dateRange').value;
            var startDate = dateRange.substring(6, 10) + '-' + dateRange.substring(3, 5) + '-' + dateRange.substring(0, 2);
            var endDate = dateRange.substring(19, 23) + '-' + dateRange.substring(16, 18) + '-' + dateRange.substring(13, 15);
            dataSend = {
                productId : data.product.id,
                warehouseId : warehouseId,
                startDate: startDate,
                endDate: endDate,
            };
            q = 0;
        }
        //DATATABLE
        $('#searchButton').on('click', function(e) {
            transferData.search( this.value ).draw();
        });
    });
</script>