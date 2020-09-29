<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<!-- Datatables -->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/select2/i18n/es.js') }}" type="text/javascript"></script>

<script>
    //Primary variables
    var goToProducts;
    var openFeatures;
    var saveFeatures;
    var openWarehouses;
    var toggleCheckbox;
    var priceListModal;
    var createNewFeature;
    var createNewProduct;
    var savePriceListPrices;
    var saveWarehouseProducts;
    //Document Ready
    $(document).ready(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            language: 'es'
        });
        //Initialize variables
        var data = {};
        var warehouses_ = [];
        var maxImageSize = 1048576;
        var categoryFeatures_ = [];
        //data var
        data.urlImage = null;
        data.validCode = false;
        data.priceLists = [];
        data.priceListsNew = [];
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
        function updateCategoryFeatures(categoryId, categoryName, categoryFeatures) {
            $.ajax({
                method: "POST",
                url: "/api/categories-new-management",
                context: document.body,
                data: {
                    "json": JSON.stringify({
                        "categoryId": categoryId,
                        "name": categoryName,
                        "features" : categoryFeatures,
                    })
                }
            }).done(function(response) {
            });
        }
        function listenersForNewInputs(element) {
            var newFeatureId = document.getElementById('newFeatureId_' + element.id);
            newFeatureId.addEventListener('keyup', function(e) {
                event.preventDefault();
                if (e.keyCode == 13) {
                    var newFeatureName_ = document.getElementById('newFeatureName_' + element.id);
                    var newFeatureId_ = newFeatureId;
                    if (newFeatureName_.value.length < 1 || newFeatureId_.value.length < 1) {
                        console.log("Completar los datos correctamente");
                    } else {
                        if (!validateKey(newFeatureId_.value)) {
                            //AGREGAR FUNCION PARA AGREGAR EL FEATURE AL JSON DE LA BD
                            //FUNCION PARA AGREGAR EL FEATURE A LA TABLA DE LA WEB
                            var xTable = document.getElementById('featureTable_' + element.id);
                            var tr = document.createElement('tr');
                            tr.innerHTML = '<td><input id="featureCategoryIdCheckbox_' + element.id + '_' + newFeatureId_.value.toUpperCase() + '" type="checkbox" class="minimal" checked></td>' + 
                                        '<td>' + newFeatureName_.value.toUpperCase() + '</td>' +
                                        '<td>' + newFeatureId_.value.toUpperCase() + '</td>';
                            xTable.insertBefore(tr, xTable.firstChild);
                            //AGREGAR AL ARREGLO DE FEATURES
                            categoryFeatures_.forEach(element___ => {
                                if (element___.id == element.id) {
                                    element___.features.push({"id" : newFeatureId_.value.toUpperCase(),"name": newFeatureName_.value.toUpperCase()});
                                }
                            });
                            //LIMPIAR INPUTS
                            newFeatureName_.value = '';
                            newFeatureId_.value = '';
                            document.getElementById('newFeatureName_' + element.id).focus();
                        } else {
                            console.log("Completar los datos correctamente");
                        }
                    }
                }
            });
        }
        function allPossibleCases(arraySource, type) {
            if (arraySource.length == 1) {
                return arraySource[0];
            } else {
                var result = [];
                var allCasesOfRest = allPossibleCases(arraySource.slice(1), type);  // recur with the rest of arraySourceay
                for (var i = 0; i < allCasesOfRest.length; i++) {
                    for (var j = 0; j < arraySource[0].length; j++) {
                        if (type) {
                            result.push(arraySource[0][j] + allCasesOfRest[i]);   
                        } else {
                            result.push(arraySource[0][j] + ' ' + allCasesOfRest[i]);
                        }
                    }
                }
                return result;
            }
        }
        function allPossibleCasesJson(arrayIds, arrayNames) {
            if (arrayIds.length == 1) {
                return '"' + arrayIds[0] + '":"' + arrayNames[0] + '"';
            } else {
                var result = [];
                var allCasesOfRest = allPossibleCasesJson(arrayIds.slice(1), arrayNames.slice(1));  // recur with the rest of arrayIdsay
                for (var i = 0; i < allCasesOfRest.length; i++) {
                    for (var j = 0; j < arrayIds[0].length; j++) {
                        result.push('"' + arrayIds[0][j] + '":"' + arrayNames[0][j] + '"},{' + allCasesOfRest[i]);
                    }
                }
                return result;
            }
        }
        //var functions
        goToProducts = function () {
            location = "/products";
        }
        openWarehouses = function() {
            data.warehouseProduct = [];
            warehouses_ = [];
            var featuresNames___ = [];
            var featuresIds___ = [];
            $('#warehouseId option:selected').each(function() {
                var warehouse = {
                    "id": $(this).val(),
                    "name": $(this).text(),
                };
                warehouses_.push(warehouse);
            });
            categoryFeatures_.forEach(element => {
                var nFeatures___ = [];
                var iFeatures___ = [];
                element.features.forEach(elementFeature => {
                    if (elementFeature.checked) {
                        nFeatures___.push(elementFeature.name);
                        iFeatures___.push(elementFeature.id);
                    }
                });
                if (nFeatures___.length > 0) {
                    featuresNames___.push(nFeatures___);
                    featuresIds___.push(iFeatures___);
                }
            });
            var featuresIdsCombinations = allPossibleCases(featuresIds___, true);
            var featuresNamesCombinations = allPossibleCases(featuresNames___, false);
            var featuresJsonCombinations = allPossibleCasesJson(featuresIds___, featuresNames___);
            //create thead
            var theadWarehouseProducts = document.getElementById('theadWarehouseProducts');
            theadWarehouseProducts.innerHTML = '';
            var trTheadWarehouseProducts = document.createElement('tr');
            var trTheadWarehouseProducts_ = '<th width="25%">Productos hijos</th>';
            warehouses_.forEach(element => {
                trTheadWarehouseProducts_ = trTheadWarehouseProducts_ + '<th width="10%">' + element.name + '</th>';
            });
            trTheadWarehouseProducts.innerHTML = trTheadWarehouseProducts_;
            theadWarehouseProducts.insertBefore(trTheadWarehouseProducts, theadWarehouseProducts.firstChild);
            //create tbody
            var tbodyWarehouseProducts = document.getElementById('tbodyWarehouseProducts');
            tbodyWarehouseProducts.innerHTML = '';
            for (let index = 0; index < featuresNamesCombinations.length; index++) {
                var trtbodyWarehouseProducts = document.createElement('tr');
                var trtbodyWarehouseProducts_ = '<td width="25%">' + featuresNamesCombinations[index] + '</td>';
                warehouses_.forEach(element => {
                    var warehouseProduct = {
                        'code': featuresIdsCombinations[index],
                        'description': featuresNamesCombinations[index],
                        'features': featuresJsonCombinations[index],
                        'warehouse': element.id,
                        'element': 'inputStockWarehouseProduct_' + element.id + '_' + featuresIdsCombinations[index],
                        'value': 0,
                    };
                    data.warehouseProduct.push(warehouseProduct);
                    trtbodyWarehouseProducts_ = trtbodyWarehouseProducts_ + '<td width="10%"><input onClick="this.select();" id="inputStockWarehouseProduct_' + element.id + '_' + featuresIdsCombinations[index] + '" type="number" class="input-sm form-control" value="0"/></td>';
                });
                trtbodyWarehouseProducts.innerHTML = trtbodyWarehouseProducts_;
                tbodyWarehouseProducts.insertBefore(trtbodyWarehouseProducts, tbodyWarehouseProducts.firstChild);
            }
            $(function () {
                $('#example1').DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : true,
                    "language": {
                        "url": "/js/languages/datatables/es.json"
                    },
                    "bDestroy": true
                });
            });
        }
        saveWarehouseProducts = function() {
            //PRICELISTS
            if (data.priceLists.length == 0) {
                priceListModal();
                savePriceListPrices();   
            }
            //WEBSERVICE FOR WAREHOUSEPRODUCTS
            data.warehouseProductNew = [];
            data.warehouseProduct.forEach(element => {
                var elementValue_ = document.getElementById(element.element);
                var value__ = 0;
                if (elementValue_ != null) {
                    value__ = parseFloat(elementValue_.value).toFixed(2);
                }
                data.warehouseProductNew.push({
                    'code': element.code,
                    'description': element.description,
                    'features': [],
                    'warehouse': element.warehouse,
                    'element': element.element,
                    'value': value__,
                });
            });
            data.warehouseProduct = data.warehouseProductNew;
            data.warehouseProductNew = [];
        }
        createNewFeature = function() {
            var newEmptyFeatureName = document.getElementById('newEmptyFeatureName');
            if (newEmptyFeatureName.value.length < 1) {
                console.log('Ingrese un nombre de opción válido.');
            } else {
                var categoryId_  = document.getElementById('productCategory').value;
                var categories_  = data.jsonResponseData.categories;
                categories_.forEach(element => {
                    if (element.id == categoryId_) {
                        //LOGICA PARA CREAR FEATURE NUEVO EN LA BD
                        var newFeature___ = {
                            'features': [],
                            'name': newEmptyFeatureName.value.toUpperCase()
                        };
                        $.ajax({
                            method: "POST",
                            url: "/api/features",
                            context: document.body,
                            data: {
                                "json" : JSON.stringify(newFeature___)
                            }
                        }).done(function(response) {
                            newEmptyFeatureName.value = "";
                            newFeature___.id = response.id;
                            newFeature___.filterable = true;
                            newFeature___.includeInCode = true;
                            element.features.push(newFeature___);
                            categoryFeatures_ = element.features;
                            //CAMBIAR CABECERAS
                            var featuresHeader = document.getElementById('featuresHeader');
                            var featuresContent = document.getElementById('featuresContent');
                            var featuresHeaderText = document.createElement('li');
                            featuresHeaderText.innerHTML = '<a href="#activity_' + newFeature___.id + '" data-toggle="tab">' + newFeature___.name + '</a>';
                            featuresContentText_ = document.createElement('div');
                            featuresContentText_.setAttribute("class", "tab-pane");
                            featuresContentText_.setAttribute("id", "activity_" + newFeature___.id);
                            var featuresContentText = '<div class="box"><div class="box-header with-border"><h3 class="box-title">Administre sus opciones</h3></div>' +
                            '<div class="box-body"><table class="table table-bordered"><tr><th style="width: 10px"><input type="checkbox" class="minimal" checked onClick="toggleCheckbox(' + newFeature___.id + ');" /></th><th>NOMBRE</th><th>LLAVE</th></tr>';
                            var trIncludesFt = '<tbody id="featureTable_' + newFeature___.id + '">';
                            newFeature___.features.forEach(element_ => {
                                trIncludesFt = trIncludesFt + '<tr>' +
                                    '<td><input id="featureCategoryIdCheckbox_' + newFeature___.id + '_' + element_.id + '" type="checkbox" class="minimal" checked></td>' + 
                                    '<td>' + element_.name + '</td>' +
                                    '<td>' + element_.id + '</td>' +
                                    '</tr>';
                            });
                            //AGREGAR COLUMNA NUEVA PARA NUEVOS FEATURES
                            featuresContentText = featuresContentText + trIncludesFt + '<tr><td><input type="checkbox" class="minimal"></td><td><input type="text" id="newFeatureName_' + newFeature___.id + '" class="input-sm form-control"></td><td><input type="text" id="newFeatureId_' + newFeature___.id + '" class="input-sm form-control"></td></tr></tbody></table></div></div>';
                            featuresContentText_.innerHTML = featuresContentText;
                            featuresHeader.insertBefore(featuresHeaderText, featuresHeader.lastChild);
                            featuresContent.insertBefore(featuresContentText_, featuresContent.lastChild);
                            listenersForNewInputs(newFeature___);
                            //ACTUALIZAR FEATURES DE CATEGORÍA EN LA BD
                            updateCategoryFeatures(categoryId_, element.name, categoryFeatures_);
                        });
                    }
                });
            }
        }
        saveFeatures = function() {
            $.ajax({
                method: "POST",
                url: "/api/features-new-management",
                context: document.body,
                data: {
                    "json" : JSON.stringify(categoryFeatures_)
                }
            }).done(function(response) {
            });
            var categoryId_  = document.getElementById('productCategory').value;
            var categories_  = data.jsonResponseData.categories;
            categories_.forEach(element => {
                if (element.id == categoryId_) {
                    updateCategoryFeatures(element.id, element.name, categoryFeatures_);
                }
            });
            //GUARDAR FEATURES EN VARIABLE LOCAL DE PRODUCTO
            categoryFeatures_.forEach(element => {
                element.features.forEach(elementFeature => {
                    var checkBox = document.getElementById('featureCategoryIdCheckbox_' + element.id + '_' + elementFeature.id);
                    elementFeature.checked = checkBox.checked;
                });
            });
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
        priceListModal = function() {
            var priceLists_ = data.jsonResponseData.companyLoginData.priceLists;
            var bodyPriceListUl = document.getElementById('priceListUl');
            var generalPrice = parseFloat(document.getElementById('productGeneralPrice').value).toFixed(2);
            bodyPriceListUl.innerHTML = '';
            var mixedBodyPriceListUl = '';
            if ((data.priceLists.length > 0) && (data.priceLists.length == $('#warehouseId option:selected').length)) {
                data.priceLists.forEach(element => {
                    var priceListsHtml__ = '<div class="col-md-10">';
                    element.priceLists.forEach(element_ => {
                        priceListsHtml__ = priceListsHtml__ + 
                        '<div class="col-md-12" style="margin-bottom: 5px;">' +
                            '<div class="col-md-6">' + element_.name + ' - ' + element_.currency + ' (' + element_.symbol_code + ')' + '</div>' + 
                            '<div class="col-md-2"><input onClick="this.select();" type=number id="unitPrice_' + element.warehouseId + '_' + element_.id + '" class="form-control" style="width:100%;" placeholder="PxUnd" value="' + element_.price + '"/></div>' +
                            '<div class="col-md-2"><input onClick="this.select();" type=number id="quantity_' + element.warehouseId + '_' + element_.id + '" class="form-control" style="width:100%;" placeholder="QxMayor" value="' + element_.quantity + '"/></div>' + 
                            '<div class="col-md-2"><input onClick="this.select();" type=number id="wholeSalePrice_' + element.warehouseId + '_' + element_.id + '" class="form-control" style="width:100%;" placeholder="PxMayor" value="' + element_.wholeSalePrice + '"/></div><br>' + 
                        '</div>';
                    });
                    mixedBodyPriceListUl = mixedBodyPriceListUl + '<br><div class="col-md-2"><p>' + element.warehouseName + '</p></div>' + 
                        priceListsHtml__ + '</div><div class="col-md-12"><hr></div>';
                });
            } else {
                $('#warehouseId option:selected').each(function() {
                    var priceListsHtml__ = '<div class="col-md-10">';
                    priceLists_.forEach(element_ => {
                        priceListsHtml__ = priceListsHtml__ + 
                        '<div class="col-md-12" style="margin-bottom: 5px;">' +
                            '<div class="col-md-6">' + element_.name + ' - ' + element_.currency + ' (' + element_.symbol_code + ')' + '</div>' + 
                            '<div class="col-md-2"><input onClick="this.select();" type=number id="unitPrice_' + $(this).val() + '_' + element_.id + '" class="form-control" style="width:100%;" placeholder="PxUnd" value="' + generalPrice + '"/></div>' +
                            '<div class="col-md-2"><input onClick="this.select();" type=number id="quantity_' + $(this).val() + '_' + element_.id + '" class="form-control" style="width:100%;" placeholder="QxMayor" value="3"/></div>' + 
                            '<div class="col-md-2"><input onClick="this.select();" type=number id="wholeSalePrice_' + $(this).val() + '_' + element_.id + '" class="form-control" style="width:100%;" placeholder="PxMayor" value="' + generalPrice + '"/></div><br>' + 
                        '</div>';
                    });
                    mixedBodyPriceListUl = mixedBodyPriceListUl + '<br><div class="col-md-2"><p>' + $(this).text() + '</p></div>' + 
                        priceListsHtml__ + '</div><div class="col-md-12"><hr></div>';
                });
            }
            bodyPriceListUl.innerHTML = mixedBodyPriceListUl;
        }
        savePriceListPrices = function() {
            data.priceLists = [];
            var priceLists_ = data.jsonResponseData.companyLoginData.priceLists;
            $('#warehouseId option:selected').each(function() {
                var warehouse = {};
                warehouse.warehouseId = $(this).val();
                warehouse.warehouseName = $(this).text();
                warehouse.priceLists = [];
                priceLists_.forEach(element_ => {
                    var priceList = {};
                    priceList.id = element_.id;
                    priceList.name = element_.name;
                    priceList.currency = element_.currency;
                    priceList.symbol_code = element_.symbol_code;
                    priceList.price = parseFloat(document.getElementById('unitPrice_' + warehouse.warehouseId + '_' + element_.id).value).toFixed(2);
                    priceList.quantity = parseFloat(document.getElementById('quantity_' + warehouse.warehouseId + '_' + element_.id).value).toFixed(2);
                    priceList.wholeSalePrice = parseFloat(document.getElementById('wholeSalePrice_' + warehouse.warehouseId + '_' + element_.id).value).toFixed(2);
                    warehouse.priceLists.push(priceList);
                });
                data.priceLists.push(warehouse);
            });
        }
        createNewProduct = function() {
            //PRICELISTS
            if (data.priceLists.length == 0) {
                priceListModal();
                savePriceListPrices();
            }
            if (data.validCode) {
                if (data.priceLists.length > 0) {
                    data.code = data.code.toUpperCase();
                    data.name = document.getElementById('productName').value.toUpperCase();
                    data.description = document.getElementById('productDescription').value.toUpperCase();
                    data.type = document.getElementById('productType').value;
                    data.model = document.getElementById('productModel').value.toUpperCase();
                    data.weight = document.getElementById('productWeight').value;
                    data.unitId = document.getElementById('productUnity').value;
                    data.brandId = document.getElementById('brandId').value;
                    data.categoryId = document.getElementById('productCategory').value;
                    data.autoBarCode = document.getElementById('productAutoBarCode').value;
                    data.price = document.getElementById('productGeneralPrice').value;
                    data.flagUniversalPromo = document.getElementById('productFlagUniversalPromo').value;
                    if (data.price != undefined) {
                        $.ajax({
                            method: "POST",
                            url: "/api/products",
                            context: document.body,
                            data: data,
                            statusCode: {
                                500: function() {
                                    alert('No se pudo registrar el nuevo producto. Verifique la información ingresada e inténtelo nuevamente.');
                                }
                            }
                        }).done(function(response) {
                            var productsResume  = document.getElementById('productsResume');
                            var productsResume_ = '<br><p class="form-control">Producto padre: ' + data.name + '</p><br>' + 
                                '<p class="form-control">Productos hijos: ' + (data.warehouseProduct.length / warehouses_.length) + ' hijos generados</p>';
                            productsResume.innerHTML = productsResume_;
                            $("#modal-resume").modal({backdrop: 'static', keyboard: false});
                        });
                    } else {
                        alert("Ingrese un precio general válido");
                    }
                } else {
                    alert("Seleccione almacenes y gestione correctamente sus precios.");
                }
            } else {
                alert("Ingrese un código de producto válido.");
            }
        }
        openFeatures = function() {
            var categoryId_  = document.getElementById('productCategory').value;
            var categories_  = data.jsonResponseData.categories;
            categoryFeatures_ = [];
            //ordernar objeto de categorías
            categories_.forEach(element => {
                if (element.id == categoryId_) {
                    categoryFeatures_ = element.features;
                }
            });
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
