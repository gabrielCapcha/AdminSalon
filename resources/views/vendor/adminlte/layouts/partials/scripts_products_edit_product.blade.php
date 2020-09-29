<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>

<script>
    //Primary variables
    var goToProducts;
    var openFeatures;
    var saveFeatures;
    var openWarehouses;
    var toggleCheckbox;
    var createNewFeature;
    var createNewProduct;
    var saveWarehouseProducts;
    //Document Ready
    $(document).ready(function() {
        //Initialize variables
        var data = {};
        var warehouses_ = [];
        var maxImageSize = 1048576;
        var categoryFeatures_ = [];
        //data var
        data.urlImage = null;
        data.warehouseProduct = [];
        data.warehouseProductNew = [];
        data.jsonResponseData = JSON.parse(document.getElementById("jsonResponseData").value);
        //functions
        function getBase64(file, fileType) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                $.ajax({
                    method: "POST",
                    url: "https://sm-soft.tumi-soft.com/image/one-upload",
                    context: document.body,
                    data: {
                        type: fileType,
                        image: reader.result
                    }
                }).done(function(response) {
                    data.urlImage = response.data[0];
                });
            };
            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        }
        function validateKey(s) {
            return s.indexOf(' ') >= 0;
        }
        //var functions
        goToProducts = function () {
            location = "/products";
        }
        toggleCheckbox = function(featureId) {
            categoryFeatures_.forEach(element => {
                if (element.id == featureId) {
                    element.features.forEach(element_ => {
                        var featureCategoryIdCheckbox_ = document.getElementById('featureCategoryIdCheckbox_' + featureId + '_' + element_.id);
                        if (featureCategoryIdCheckbox_ != null) {
                            if (featureCategoryIdCheckbox_.checked) {
                                featureCategoryIdCheckbox_.checked = false;
                            } else {
                                featureCategoryIdCheckbox_.checked = true;
                            }
                        }
                    });
                }
            });
        }
        createNewProduct = function() {
            var id___ = document.getElementById('productId').value;
            data.code = document.getElementById('productCode').value.toUpperCase();
            data.currency = document.getElementById('productCurrency').value;
            data.name = document.getElementById('productName').value.toUpperCase();
            data.description = document.getElementById('productDescription').value.toUpperCase();
            data.type = document.getElementById('productType').value;
            data.model = document.getElementById('productModel').value.toUpperCase();
            data.weigth = document.getElementById('productWeight').value;
            data.unitId = document.getElementById('productUnity').value;
            data.allotmentType = document.getElementById('allotmentType').value;
            data.setting = false;
            data.categoryId = document.getElementById('productCategory').value;
            data.autoBarcode = document.getElementById('productAutoBarCode').value.toUpperCase();
            data.foreignName = document.getElementById('productForeignName').value.toUpperCase();
            data.price = document.getElementById('productGeneralPrice').value;
            data.flagUniversalPromo = document.getElementById('productFlagUniversalPromo').value;
            delete data.validCode;
            if (data.price != undefined) {
                $.ajax({
                    method: "PATCH",
                    url: "/api/products/" + id___,
                    context: document.body,
                    data: data,
                    statusCode: {
                        400: function() {
                            alert('No se pudo editar el producto. Verifique los campos NOMBRE, CÓDIGOS, DESCRIPCIÓN Y MODELO.');
                        },
                        404: function() {
                            alert('No se pudo editar el producto. El producto no existe.');
                        },
                        500: function() {
                            alert('No se pudo editar el producto. Verifique la información ingresada e inténtelo nuevamente.');
                        }
                    }
                }).done(function(response) {
                    goToProducts();
                });
            } else {
                alert("Ingrese un precio general válido");
            }
        }
        openFeatures = function() {
            var categoryId_  = document.getElementById('productCategory').value;
            var categories_  = data.jsonResponseData.categories;

            console.log(categoryFeatures_);
            console.log(data.jsonResponseData);
            categoryFeatures_ = [];
            //ordernar objeto de categorías
            // categories_.forEach(element => {
            //     if (element.id == categoryId_) {
            //         categoryFeatures_ = element.features;
            //     }
            // });
            console.log(categoryFeatures_);
            //agregar features a objeto de categorías
            categoryFeatures_.forEach(element => {
                data.jsonResponseData.features.forEach(element_ => {
                    if (element.id == element_.id) {
                        element.features = element_.features;
                    } 
                });
            });
            //llenar información en el modal
            var featuresHeader = document.getElementById('featuresHeader');
            featuresHeader.innerHTML = '';
            var featuresContent = document.getElementById('featuresContent');
            featuresContent.innerHTML = '';
            var featuresHeaderText = '';
            var featuresContentText = '';
            var iterator = 0;
            categoryFeatures_.forEach(element => {
                if (iterator == 0) {
                    featuresHeaderText = featuresHeaderText + '<li class="active"><a href="#activity_' + element.id + '" data-toggle="tab">' + element.name + '</a></li>';
                    featuresContentText = featuresContentText + '<div class="active tab-pane" id="activity_' + element.id + '">' +
                    '<div class="box"><div class="box-header with-border"><h3 class="box-title">Administre sus opciones</h3></div>' +
                    '<div class="box-body"><table class="table table-bordered"><tr><th style="width: 10px"><input type="checkbox" class="minimal" checked onClick="toggleCheckbox(' + element.id + ');" /></th><th>NOMBRE</th><th>LLAVE</th></tr>';
                } else {
                    featuresHeaderText = featuresHeaderText + '<li><a href="#activity_' + element.id + '" data-toggle="tab">' + element.name + '</a></li>';
                    featuresContentText = featuresContentText + '<div class="tab-pane" id="activity_' + element.id + '">' +
                    '<div class="box"><div class="box-header with-border"><h3 class="box-title">Administre sus opciones</h3></div>' +
                    '<div class="box-body"><table class="table table-bordered"><tr><th style="width: 10px"><input type="checkbox" class="minimal" checked onClick="toggleCheckbox(' + element.id + ');" /></th><th>NOMBRE</th><th>LLAVE</th></tr>';
                }
                
                var trIncludesFt = '<tbody id="featureTable_' + element.id + '">';
                element.features.forEach(element_ => {
                    trIncludesFt = trIncludesFt + '<tr>' +
                        '<td><input id="featureCategoryIdCheckbox_' + element.id + '_' + element_.id + '" type="checkbox" class="minimal" checked></td>' + 
                        '<td>' + element_.name + '</td>' +
                        '<td>' + element_.id + '</td>' +
                        '</tr>';
                });
                //AGREGAR COLUMNA NUEVA PARA NUEVOS FEATURES
                featuresContentText = featuresContentText + trIncludesFt + '<tr><td><input type="checkbox" class="minimal"></td><td><input type="text" id="newFeatureName_' + element.id + '" class="input-sm form-control"></td><td><input type="text" id="newFeatureId_' + element.id + '" class="input-sm form-control"></td></tr></tbody></table></div></div></div>';
                iterator++;
            });
            //AGREGAR ADDFEATURE
            featuresHeaderText = featuresHeaderText + '<li><a href="#addFeature" data-toggle="tab">+</a></li>';
            featuresContentText = featuresContentText + '<div class="tab-pane" id="addFeature"><div class="form-horizontal"><div class="form-group"><label for="inputName" class="col-sm-2 control-label">NOMBRE</label><div class="col-sm-10"><input type="text" class="form-control" id="newEmptyFeatureName" placeholder="Nombre de la opción"></div></div>' + 
            '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="button" onClick="createNewFeature();" class="btn btn-danger">Crear</button></div></div></div></div>';
            //AGREGAR ADDFEATURE
            featuresHeader.innerHTML = featuresHeaderText;
            featuresContent.innerHTML = featuresContentText;
            //LISTENER PARA AGREGAR NUEVA COLUMNA DE FEATURES
            categoryFeatures_.forEach(element => {
                listenersForNewInputs(element);
            });
        }
        //LISTENERS
        var productCode = document.getElementById('productCode');
        productCode.addEventListener('change', function() {
            //search for code
            if (productCode.value.length > 0) {
                $.ajax({
                    method: "GET",
                    url: "/api/product-exists/" + productCode.value,
                    context: document.body,
                    statusCode: {
                        400: function() {
                            data.validCode = false;
                            productCode.style.borderColor = "#d9534f";
                        }
                    }
                }).done(function(response) {
                    productCode.style.borderColor = "#4cae4c";
                    data.validCode = true;
                    data.code = productCode.value;
                });
            }
        });
        var productImage = document.getElementById('productImage');
        productImage.addEventListener('change', function() {
            var fileName = productImage.files[0].name;
            var fileSize = productImage.files[0].size;
            var fileType = productImage.files[0].type;
            var fileModifiedDate = productImage.files[0].lastModifiedDate;
            // if (fileSize > maxImageSize) {
            //     alert("Imagen demasiado grande. Máximo permitido de 1Mb");
            // } else {
                getBase64(productImage.files[0], fileType);
            // }
        });
    });
</script>
