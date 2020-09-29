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
    var arrayProducts = [];
    var arrayProductsRecipies = [];
    var goToKardex;
    var editProduct;
    var goToTransfers;
    var priceListProduct;
    var priceListSubmit;
    var selectedProduct = 0;
    $(document).ready(function() {
        var productRecipieId = 0;
        var saleIndexTable = $('#products_index').DataTable({
            "scrollX": true,
            "processing": true,
            "lengthChange": false,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                { extend: 'excelHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL' }
            ],
            "serverSide": true,
            "bPaginate": true,
            "ordering": false,
            "searching": false,
            "ajax": function(data, callback, settings) {
                    $.get('/api/products-for-recipies', {
                        limit: data.length,
                        offset: data.start,
                        searchInput: $('#searchInput').val(),
                        categoryId: $('#categoryId').val(),
                        }, function(res) {
                            arrayProducts = [];
                            res.data.forEach(element => {
                                arrayProducts[element.id] = element;
                            });
                            callback({
                                recordsTotal: res.total,
                                recordsFiltered: res.total,
                                data: res.data
                            });
                        });
            },
            "columns"    : [
                {'data': 'category_name'},
                {'data': function (data) {
                    return '<a style="cursor:pointer;" onClick="showProductDetail(' + data.id + ')">' + data.code + '</a>';
                }},
                {'data': function (data) {
                    var message = 'VENTA';
                    switch (data.flag_operation) {
                        case 1:
                        message = 'COMPRA';
                            break;
                        case 2:
                        message = 'VENTA';
                            break;
                        case 3:
                        message = 'COMPRA Y VENTA';
                            break;                    
                        default:
                        message = 'VENTA';
                            break;
                    }
                    return message;
                }},
                {'data': 'auto_barcode'},
                {'data': 'name'},
                {'data': 'description'},
                {'data': function(data) {
                    if (data.recipies == null || data.recipies.length == 0) {
                        return 'SIN RECETA';                        
                    } else {
                        var message = '<ul align="left">';
                        data.recipies.forEach(element => {
                            message = message + '<li>(' + element.code + ') ' + element.name + ' - ' + element.quantity + '</li>';
                        });
                        message = message + '</ul>';
                        return message;
                    }
                }},
                {'data': function (data) {
                    return '<button type="button" onClick="recipiesSetUp(' + data.id + ');" class="btn btn-warning btn-xs" style="width: 25px;"><i class="fa fa-cubes"></i></button>';
                }}
            ]
        });

        var priceListTable = $('tablePriceList').DataTable({
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
        });
        
        $('#searchButton').on('click', function(e) {
            saleIndexTable.search( this.value ).draw();
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
            }
        )
        //Listeners
        var searchProduct = document.getElementById('searchInput');
        searchProduct.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                $('#searchButton').trigger('click');
            }
        });
        recipiesSetUp = function(id) {
            productRecipieId = id;
            document.getElementById('productRecipiesTBody').innerHTML = '';
            var product = arrayProducts[id];
            if (product != undefined) {
                if (product.recipies != null) {
                    var productDetailStockPriceListTBody_ = '';
                    product.recipies.forEach(element => {
                        productDetailStockPriceListTBody_ = productDetailStockPriceListTBody_ + 
                        '<tr id="row_' + element.id + '">'+
                            '<td> '+ element.categoryName +' </td>' +
                            '<td> '+ element.code +' </td>' +
                            '<td> '+ element.operation +' </td>' +
                            '<td> '+ element.autoBarcode +' </td>' +
                            '<td> '+ element.name +' </td>' +
                            '<td> '+ element.unitName +' </td>' +
                            '<td> '+ element.quantity +' </td>' +
                            '<td> <button type="button" onClick="removeRecipie(' + element.id + ');" class="btn btn-danger btn-xs" style="width: 25px;"><i class="fa fa-trash"></i></button> </td>' +
                        '</tr>';
                    });
                    document.getElementById('productRecipiesTBody').innerHTML = productDetailStockPriceListTBody_;
                }
                document.getElementById('productRecipieHeader').innerHTML = 'RECETAS DEL PRODUCTO: <strong>(' + product.code + ') ' +product.name + ' - ' + product.description + '</strong>';
            }
            $('#modal-product-recipie').modal({ backdrop: 'static', keyboard: false });
        }
        goToKardex = function(id) {
            var product___ = arrayProducts[id];
            location = "/kardex/" + product___.code;
        }
        editProduct = function(id) {
            location = "/products/" + id;
        }
        goToTransfers = function(id) {
            var product___ = arrayProducts[id];
            location = "/new-transfer/" + product___.code;
        }
        showProductDetail = function (id) {
            document.getElementById('productDetailStockPriceListTBody').innerHTML = '';
            var product = arrayProducts[id];
            document.getElementById('productDetailHeader').innerHTML = product.name;
            if (product.description == null) {
                document.getElementById('productDetailDescription').innerHTML = 'SIN DESCRIPCIÓN';
            } else {
                document.getElementById('productDetailDescription').innerHTML = product.description;
            }
            document.getElementById('productDetailCode').innerHTML = product.code;
            document.getElementById('productDetailAutoBarCode').innerHTML = product.auto_barcode;
            document.getElementById('productDetailCategory').innerHTML = product.category_name;
            document.getElementById('productDetailModel').innerHTML = product.model;
            document.getElementById('productDetailBrand').innerHTML = product.brand_name;
            if (product.urlImage != null) {
                document.getElementById('productDetailImage').src = product.url_image;
            }
            $('#modal-product-detail').modal({ backdrop: 'static', keyboard: false });
            $.ajax({
                url: "/api/products/" + id + "/for-detail",
                context: document.body
            }).done(function(response) {
                // productDetailStockPriceListTBody
                var productDetailStockPriceListTBody_ = '';
                response.warehouses.forEach(element => {
                    if (element.price_list == null) {
                        var priceList = {
                            price: 0,
                            quantity: 0,
                            wholeSalePrice: 0,
                        };
                        var location = 'SIN DATOS';
                    } else {
                        var priceList = Object.keys(element.price_list)[0];
                        priceList = element.price_list[priceList];
                        var location = element.location;
                        if (location == null) {
                            location = 'SIN DATOS';
                        }
                    }
                    if (priceList.minPrice == undefined) {
                        priceList.minPrice = 'SIN DATOS';
                    }
                    if (priceList.maxPrice == undefined) {
                        priceList.maxPrice = 'SIN DATOS';
                    }
                    productDetailStockPriceListTBody_ = productDetailStockPriceListTBody_ + 
                    '<tr>'+
                        '<td> '+ element.name +' </td>' +
                        '<td> '+ location +' </td>' +
                        '<td> '+ element.stock +' </td>' +
                        '<td> '+ priceList.price +' </td>' +
                        '<td> '+ priceList.quantity +' </td>' +
                        '<td> '+ priceList.wholeSalePrice +' </td>' +
                        '<td> '+ priceList.minPrice +' </td>' +
                        '<td> '+ priceList.maxPrice +' </td>' +
                    '</tr>';
                });
                document.getElementById('productDetailStockPriceListTBody').innerHTML = productDetailStockPriceListTBody_;
            });
        }
        addRecipie = function (id) {
            if (arrayProductsRecipies[id] != undefined) {
                var productRecipieQuantity = document.getElementById('productRecipieQuantity_' + id);
                if (productRecipieQuantity != null && parseFloat(productRecipieQuantity.value) > 0) {
                    if (document.getElementById("row_" + id) != null) {
                        document.getElementById("row_" + id).remove();
                        // AGREGAR A LA TABLA
                            var product = arrayProductsRecipies[id];
                            var xTable = document.getElementById('productRecipiesTBody');
                            var tr = document.createElement('tr');
                            tr.setAttribute("id", "row_" + product.id);
                            tr.setAttribute("style", "font-size:12px;");
                            var operation = 'VENTA';
                            if (product.flagOperation != undefined) {                                                
                                switch (product.flagOperation) {
                                    case 1:
                                        operation = 'VENTA';
                                        break;
                                    case 2:
                                        operation = 'COMPRA';
                                        break;
                                    case 1:
                                        operation = 'COMPRA Y VENTA';
                                        break;                                                
                                    default:
                                        operation = 'VENTA';
                                        break;
                                }
                            } else {
                                switch (product.flag_operation) {
                                    case 1:
                                        operation = 'VENTA';
                                        break;
                                    case 2:
                                        operation = 'COMPRA';
                                        break;
                                    case 1:
                                        operation = 'COMPRA Y VENTA';
                                        break;                                                
                                    default:
                                        operation = 'VENTA';
                                        break;
                                }
                            }
                            tr.innerHTML = '<td> '+ product.categoryName +' </td>' +
                                '<td> '+ product.code +' </td>' +
                                '<td> '+ operation +' </td>' +
                                '<td> '+ product.autoBarcode +' </td>' +
                                '<td> '+ product.name +' </td>' +
                                '<td> '+ product.unitName +' </td>' +
                                '<td> '+ productRecipieQuantity.value +'</td>' +
                                '<td> <button type="button" onClick="removeRecipie(' + product.id + ');" class="btn btn-danger btn-xs" style="width: 25px;"><i class="fa fa-trash"></i></button> </td>';
                            xTable.insertBefore(tr, xTable.firstChild);
                        // AGREGAR AL SERVIDOR
                        var dataSend = {
                            operation : 1,
                            parentProduct: productRecipieId,
                            detail : {
                                id: product.id,
                                code: product.code,
                                autoBarcode: product.autoBarcode,
                                name: product.name,
                                operation: operation,
                                unitName: product.unitName,
                                description: product.description,
                                quantity: productRecipieQuantity.value,
                                urlImage: product.urlImage,
                                categoryName: product.categoryName,
                            }
                        }
                        $.ajax({
                            method: "POST",
                            url: "/api/products-manage-recipie",
                            context: document.body,
                            data: dataSend,
                            statusCode: {
                            }
                        }).done(function(response) {
                            $('#searchButton').trigger('click');
                        });
                    }
                } else {
                    alert("CANTIDAD INGRESADA NO ES VÁLIDA. INTÉNTELO NUEVAMENTE");
                }
            }
        }
        removeRecipie = function(id) {
            if (document.getElementById("row_" + id) != null) {
                document.getElementById("row_" + id).remove();   
            }
            // BORRAR DEL SERVIDOR
            var dataSend = {
                operation : 0,
                parentProduct: productRecipieId,
                detail : {
                    id: id
                }
            }
            $.ajax({
                method: "POST",
                url: "/api/products-manage-recipie",
                context: document.body,
                data: dataSend,
                statusCode: {
                }
            }).done(function(response) {
                $('#searchButton').trigger('click');
            });
        }
        function autocompleteForProducts(inp) {
            var currentFocus;
            var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
            inp.addEventListener("keydown", function(e) {
                if (e.keyCode == 13) {
                    var a, b, i, val = this.value;
                    if (!val) { return false;}
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items-recipies");
                    this.parentNode.appendChild(a);
                    mainheaderSearchBar.style.height = "10px";
                    mainheaderSearchBar.style.zIndex = "9";
                    //LLAMADA AL SERVICIO
                    $.ajax({
                        url: "/api/products-for-sale/" + val,
                        context: document.body,
                        statusCode: {
                            404: function() {
                                alert("No se encontraron productos. Verifique si este cuenta con stock");
                            }
                        }
                    }).done(function(response) {
                        if (response.length == 0) {
                            inp.value = "";
                            alert("No se encontraron productos. Verifique si este cuenta con stock");
                        } else {
                            for (i = 0; i < response.length; i++) {
                                var nameLastname = response[i].name + ' - ' + response[i].code + ' - ' + response[i].autoBarcode + ' <b>MARCA: ' + response[i].brandName + ' (STOCK: ' + response[i].stock + ')</b>';
                                b = document.createElement("DIV");
                                b.setAttribute('class', 'form-control-autocomplete');
                                b.innerHTML += nameLastname;
                                b.innerHTML += "<input type='hidden' value='" + i + "'>";
                                // if (response[i].stock > 0) {
                                    // if (arrayProductsRecipies[response[i].id] != undefined) {    
                                    //     b.style.background = '#eee';
                                    //     b.style.cursor = 'no-drop';
                                    // } else {
                                        b.style.background = '#ffffff';
                                        b.style.cursor = 'pointer';
                                        b.addEventListener("click", function(e) {
                                            var iterator = this.getElementsByTagName("input")[0].value;
                                            inp.value = "";
                                            product = response[iterator];
                                            arrayProductsRecipies[product.id] = product;
                                            var operation = 'VENTA';
                                            if (product.flagOperation != undefined) {                                                
                                                switch (product.flagOperation) {
                                                    case 1:
                                                        operation = 'VENTA';
                                                        break;
                                                    case 2:
                                                        operation = 'COMPRA';
                                                        break;
                                                    case 1:
                                                        operation = 'COMPRA Y VENTA';
                                                        break;                                                
                                                    default:
                                                        operation = 'VENTA';
                                                        break;
                                                }
                                            } else {
                                                switch (product.flag_operation) {
                                                    case 1:
                                                        operation = 'VENTA';
                                                        break;
                                                    case 2:
                                                        operation = 'COMPRA';
                                                        break;
                                                    case 1:
                                                        operation = 'COMPRA Y VENTA';
                                                        break;                                                
                                                    default:
                                                        operation = 'VENTA';
                                                        break;
                                                }
                                            }
                                            var xTable = document.getElementById('productRecipiesTBody');
                                            var tr = document.createElement('tr');
                                            tr.setAttribute("id", "row_" + product.id);
                                            tr.setAttribute("style", "font-size:12px;");
                                            tr.innerHTML = '<td> '+ product.categoryName +' </td>' +
                                                '<td> '+ product.code +' </td>' +
                                                '<td> '+ operation +' </td>' +
                                                '<td> '+ product.autoBarcode +' </td>' +
                                                '<td> '+ product.name +' </td>' +
                                                '<td> '+ product.unitName +' </td>' +
                                                '<td><input class="form-control" style="width:100%;" type="number" step="0.1" id="productRecipieQuantity_'+ product.id +'" value="0.00" onClick="this.select();"></td>' +
                                                '<td> <button type="button" onClick="addRecipie(' + product.id + ');" class="btn btn-success btn-xs" style="width: 25px;"><i class="fa fa-check"></i></button> ' + 
                                                '<span> </span><button type="button" onClick="removeRecipie(' + product.id + ');" class="btn btn-danger btn-xs" style="width: 25px;"><i class="fa fa-trash"></i></button> </td>';
                                            xTable.insertBefore(tr, xTable.firstChild);
                                        });
                                    // }
                                // } else {
                                //     b.style.background = '#eee';
                                //     b.style.cursor = 'no-drop';
                                // }
                                a.appendChild(b);
                                var mainheaderSearchBar = document.getElementById('mainheaderSearchBar');
                            }                            
                        }
                    });
                }
            });
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items-recipies");
                for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
                }
            }
            document.addEventListener("click", function (e) {closeAllLists(e.target);});
        }
        autocompleteForProducts(document.getElementById('searchProduct'));
    });

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>