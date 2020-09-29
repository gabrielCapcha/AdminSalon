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
    var saveTransferPrev;
    var saveTransfer;
    var goToProducts;
    var goToKardex;
    $(document).ready(function() {
        //Initialize variables
        var data = {};
        var count = 1;
        var dataSend = null;
        //Products value
        var productsLists = document.getElementById('productsLists');
        data.selectedProducts = [];
        data.productsLists = JSON.parse(productsLists.value);
        productsLists.value = '';
        var tBodyData = document.getElementById('tBodyData');
        data.productsLists.forEach(element => {
            var tr = document.createElement('tr');
            tr.setAttribute('id', 'tr_' + element.id);
            var condition = false;
            var description__ = 'SIN DESCRIPCIÓN';
            if (element.description != null) {
                description__ = element.description;
            }
            var urlImage = '/img/new_ic_logo_short.png';
            if (element.urlImage != null) {
                urlImage = element.urlImage;
            }
            if (element.stock > 0) {
                condition = true;
                var tdText_ = '<td><a href="'+ urlImage +'" target="_blank"><img src="' + urlImage + '" height="50px" width="50px" /></a></td>' + '<td>' + element.name + '</td><td>' + element.code + '</td><td>' + element.autoBarcode + '</td>' +
                    '<td>' + description__ + '</td><td>' + element.stock + '</td><td><input type="number" min="0" onClick="this.select();" value="' + element.stock + '" max="' + element.stock + '" step="0.1" id="quantity_' + element.id + '" /></td>';   
            } else {
                var tdText_ = '<td><a href="'+ urlImage +'" target="_blank"><img src="' + urlImage + '" height="50px" width="50px" /></a></td>' + '<td>' + element.name + '</td><td>' + element.code + '</td><td>' + element.autoBarcode + '</td>' +
                    '<td>' + description__ + '</td><td>' + element.stock + '</td><td><input type="number" min="0" onClick="this.select();" value="' + element.stock + '" max="' + element.stock + '" step="0.1" id="quantity_' + element.id + '" readonly/></td>';
            }
            tr.innerHTML = tdText_;
            tBodyData.insertBefore(tr, tBodyData.nextSibling);
            //listeners
            if (condition) {
                var quantity_ = document.getElementById('quantity_' + element.id);
                quantity_.addEventListener("keyup", function(e) {
                    if (!quantity_.checkValidity()) {
                        data.selectedProducts[element.id] = {
                            quantity  : 0,
                            condition : false,
                        };
                        quantity_.style.borderColor = "red";
                    } else {
                        data.selectedProducts[element.id] = {
                            quantity  : quantity_.value,
                            condition : true,
                            productId : element.id,
                            productName : element.name,
                            brandId : element.brandId,
                            code: element.code,
                            autoBarcode: element.autoBarcode,
                            description: element.description,
                        };
                        quantity_.style.borderColor = "#eee"
                    }
                });
            }
        });

        $('#transferData').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'dom': 'Bfrtip',
            'buttons': [],
            'order'       : [[ 0, "desc" ]],
            'info'        : true,
            'autoWidth'   : true,
            "language": {
                "url": "/js/languages/datatables/es.json"
            },
            "bDestroy": true,
        });

        //var functions
        saveTransferPrev = function () {
            var warehouseDestiny = document.getElementById('warehouseDestiny').value;
            if (warehouseDestiny != 0) {
                var tBodyDataPrev = document.getElementById('tBodyDataPrev');
                var count = 0;
                var sumQuantity = 0;
                var table = $('#transferDataPrev').DataTable();
                table.destroy();
                $("#tBodyDataPrev tr").remove(); 
                data.selectedProducts.forEach(element => {
                    if (element.condition) {
                        var tr = document.createElement('tr');
                        var description = 'SIN DESCRIPCIÓN';
                        if (element.description != null) {
                            description = element.description;
                        }
                        tr.setAttribute('id', 'tr_' + element.productId);
                            var tdText_ = '<td>' + element.productName + '</td><td>' + element.code + '</td>' + 
                                '<td>' + element.autoBarcode + '</td><td>' + description + '</td><td>' + element.quantity + '</td>';
                        tr.innerHTML = tdText_;
                        tBodyDataPrev.insertBefore(tr, tBodyDataPrev.nextSibling);
                        count++;
                        sumQuantity = sumQuantity + parseInt(element.quantity);
                    }
                });

                $('#transferDataPrev').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
                    'dom': 'Bfrtip',
                    'buttons': [],
                    'order'       : [[ 0, "desc" ]],
                    'info'        : true,
                    'autoWidth'   : true,
                    "language": {
                        "url": "/js/languages/datatables/es.json"
                    },
                    "bDestroy": true,
                });
                //change header
                var headerResumePrev = document.getElementById('headerResumePrev');
                var warehouseText = $("#warehouseDestiny option:selected").text();
                headerResumePrev.innerHTML = "Destino: " + warehouseText + ' - Productos seleccionados: ' + count + ' - Mercadería a entregar: ' + sumQuantity;
                //open modal
                $("#modal-resume-prev").modal({backdrop: 'static', keyboard: false});
            } else {
                alert('Seleccione un almacén de destino para continuar.');
            }
        }
        saveTransfer = function () {
            document.getElementById('saveButton').disabled = true;
            var warehouseDestiny = document.getElementById('warehouseDestiny').value;
            if (warehouseDestiny != 0) {
                dataSend = {
                    "warehouseOriginId": 0,
                    "warehouseSourceId": warehouseDestiny,
                    "subsidiaryId": 0,
                    "details": []
                };
                //logic
                data.selectedProducts.forEach(element => {
                    if (element.condition) {
                        var objElement = {
                            "brandId" : element.brandId,
                            "quantity" : element.quantity,
                            "productId" : element.productId,
                            "productName" : element.productName,
                        }
                        dataSend.details.push(objElement);
                    }
                });
            } else {
                alert('Seleccione un almacén de destino para continuar.');
            }
            //Api call
            $.ajax({
                method: "POST",
                url: "/api/transfer-warehouse-movement",
                context: document.body,
                data: dataSend,
                statusCode: {
                    400: function() {
                        document.getElementById('saveButton').disabled = false;
                        alert("No se pudo registrar el ingreso.");
                    }
                }
            }).done(function(response) {
                //message
                var warehouseText = $("#warehouseDestiny option:selected").text();
                var productsResume = document.getElementById('productsResume');
                productsResume.innerHTML = '<br><p class="form-control">Se realizó el ingreso de ' + (dataSend.details.length) + ' productos al almacén/tienda ' + warehouseText + '.';
                //openModal
                $("#modal-resume-prev").hide();
                $("#modal-resume").modal({backdrop: 'static', keyboard: false});
            });
        }
        goToKardex = function () {
            location = '/kardex';
        }
    });
</script>