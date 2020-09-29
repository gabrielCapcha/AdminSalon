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

<script src="{{ asset('/plugins/buttons/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/buttons/buttons.print.min.js') }}" type="text/javascript"></script>
<script>
    //Primary variables
    var goToProducts;
    var goToNewProduct;
    var openFeatures;
    var saveFeatures;
    var openWarehouses;
    var toggleCheckbox;
    var priceListModal;
    var createNewFeature;
    var createNewProduct;
    var savePriceListPrices;
    var saveWarehouseProducts;
    var childProductToggleCheckbox;
    var toggleCheckboxFeaturesElements;
    var toggleCheckboxFeaturesElementsObject;
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
        var childProductsSkip = [];
        var elementCategoryNFeatures = [];
        var trueElementCategoryNFeatures_ = [];
        var subcategories = {};
        //data var
        data.productPerWarehouse = [];
        data.urlImage = null;
        data.validCode = false;
        data.priceLists = [];
        data.priceListsNew = [];
        data.warehouseProduct = [];
        data.warehouseProductNew = [];
        data.jsonResponseData = JSON.parse(document.getElementById("jsonResponseData").value);
        document.getElementById("jsonResponseData").value = '';
        data.featuresNamesCombinations = [];
        data.finalProductData = {
            childs: []
        };
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
                            tr.innerHTML = '<td><input id="featureCategoryIdCheckbox_' + element.id + '_' + newFeatureId_.value.toUpperCase() + '" type="checkbox" class="minimal"></td>' + 
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
        //var functions
        childProductToggleCheckbox = function (id) {
            if (childProductsSkip.includes(id)) {
                delete childProductsSkip[childProductsSkip.indexOf(id)];
            } else {
                childProductsSkip.push(id);
            }
        }
        goToProducts = function () {
            location = "/products";
        }
        goToNewProduct = function() {
            location = "/new-product";   
        }
        openWarehouses = function() {
            if (data.validCode) {
                var featuresNames___ = [];
                var featuresIds___ = [];
                categoryFeatures_.forEach(element => {
                    var nFeatures___ = [];
                    var iFeatures___ = [];
                    element.features.forEach(elementFeature => {
                        if (elementFeature.checkedToggle) {
                            nFeatures___.push(elementFeature.name);
                            iFeatures___.push(elementFeature.id);
                        }
                    });
                    if (nFeatures___.length > 0) {
                        featuresNames___.push(nFeatures___);
                        featuresIds___.push(iFeatures___);
                    }
                });
                if (featuresNames___.length > 0) {
                    data.featuresIdsCombinations = allPossibleCases(featuresIds___, true);
                    var featuresNamesCombinations = allPossibleCases(featuresNames___, false);
                    //create tbody
                    $("#tbodyWarehouseProducts tr").remove();
                    var example1 = $('#example1').DataTable();
                    example1.destroy();
                    //create tbody
                    var tbodyWarehouseProducts = document.getElementById('tbodyWarehouseProducts');
                    tbodyWarehouseProducts.innerHTML = '';
                    for (let index = 0; index < featuresNamesCombinations.length; index++) {
                        var trtbodyWarehouseProducts = document.createElement('tr');
                        var conditionChilds = false;
                        var childObject = {};
                        data.finalProductData.childs.forEach(elementChilds => {
                            categoryFeatureCode = document.getElementById('productCode').value + data.featuresIdsCombinations[index];
                            if (elementChilds.categoryFeaturesCode == categoryFeatureCode) {
                                conditionChilds = true;
                                childObject = elementChilds;
                            }
                        });
                        if (conditionChilds) {
                            var trtbodyWarehouseProducts_ = '<td width="25%"><input type="checkbox" class="minimal" checked onClick="childProductToggleCheckbox(' + index + ');" /> ' + featuresNamesCombinations[index] + '</td>' +
                                '<td><input onClick="this.select();" type="hidden" id="categoryFeaturesCode_' + index + '" class="form-control" value="'+ childObject.categoryFeaturesCode +'">'+
                                    '<input onClick="this.select();" type="text"   id="autoBarcode_' + index + '" class="form-control" value="'+ childObject.autoBarcode +'" ></td>'+
                                '<td><input onClick="this.select();" type="text"   id="forPrint_' + index + '" class="form-control" value="'+ childObject.forPrint +'" ></td>'+
                                '<td><input onClick="this.select();" type="number" id="plPrice_' + index + '" style="width:100%;" class="form-control" value="' + childObject.plPrice + '"></td>'+
                                '<td><input onClick="this.select();" type="number" id="plQuantity_' + index + '" style="width:100%;" class="form-control" value="' + childObject.plQuantity + '"></td>'+
                                '<td><input onClick="this.select();" type="number" id="plWholeSalePrice_' + index + '" style="width:100%;" class="form-control" value="' + childObject.plWholeSalePrice + '"></td>';
                        } else {
                            var trtbodyWarehouseProducts_ = '<td width="25%"><input type="checkbox" class="minimal" checked onClick="childProductToggleCheckbox(' + index + ');" /> ' + featuresNamesCombinations[index] + '</td>' +
                                '<td><input onClick="this.select();" type="hidden" id="categoryFeaturesCode_' + index + '" class="form-control" value="'+ document.getElementById('productCode').value + data.featuresIdsCombinations[index] +'">'+
                                    '<input onClick="this.select();" type="text"   id="autoBarcode_' + index + '" class="form-control" value="'+ document.getElementById('productAutoBarCode').value + data.featuresIdsCombinations[index] +'" ></td>'+
                                '<td><input onClick="this.select();" type="text"   id="forPrint_' + index + '" class="form-control" value="'+ document.getElementById('productCode').value + data.featuresIdsCombinations[index] +'" ></td>'+
                                '<td><input onClick="this.select();" type="number" id="plPrice_' + index + '" style="width:100%;" class="form-control" value="' + document.getElementById('productGeneralPrice').value + '"></td>'+
                                '<td><input onClick="this.select();" type="number" id="plQuantity_' + index + '" style="width:100%;" class="form-control" value="' + document.getElementById('productGeneralQuantity').value + '"></td>'+
                                '<td><input onClick="this.select();" type="number" id="plWholeSalePrice_' + index + '" style="width:100%;" class="form-control" value="' + document.getElementById('productGeneralWholeSalePrice').value + '"></td>';
                        }
                        trtbodyWarehouseProducts.innerHTML = trtbodyWarehouseProducts_;
                        tbodyWarehouseProducts.insertBefore(trtbodyWarehouseProducts, tbodyWarehouseProducts.firstChild);
                    }
                    data.featuresNamesCombinations = featuresNamesCombinations;
                    $('#example1').DataTable({
                        'paging'      : false,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : true,
                        'info'        : true,
                        'autoWidth'   : true,
                        "language": {
                            "url": "/js/languages/datatables/es.json"
                        },
                        "dom": 'Bfrtip',
                        "buttons": [],
                        "bDestroy": true
                    });
                    $('#modal-warehouses').modal({backdrop: 'static', keyboard: false}); 
                } else {
                    alert("No se han seleccionado opciones de producto.");    
                }
            } else {
                alert("Ingrese un código de producto válido.");
            }
        }
        openWarehouseProduct = function () {
            $('#modal-product-warehouse').modal({ backdrop: 'static', keyboard: false });
        }
        checkAll = function () {
            if (document.getElementById("allWarehouses").checked == true) {
                data.jsonResponseData.warehouses.forEach(element => {
                    var checkedBox = document.getElementById(element.id);
                    if(checkedBox != undefined) {
                        checkedBox.checked = true;
                    }
                });
            } else {
                data.jsonResponseData.warehouses.forEach(element => {
                    var checkedBox = document.getElementById(element.id);
                    if(checkedBox != undefined) {
                        checkedBox.checked = false;
                    }
                });
            }
            
        }
        saveWarehouseCreate = function () {
            data.productPerWarehouse = [];
            data.jsonResponseData.warehouses.forEach(element => {
                var checkedBox = document.getElementById(element.id);
                if(checkedBox != undefined) {
                    if (checkedBox.checked == true) {
                        data.productPerWarehouse.push(element.id);
                    }
                }
            });
        }
        saveWarehouseProducts = function() {
            data.finalProductData.childs = [];
            var featuresNamesCombinations_ = [];
            for (let index = 0; index < data.featuresNamesCombinations.length; index++) {
                if (!childProductsSkip.includes(index)) {
                    var elementValue = {
                        "name": data.featuresNamesCombinations[index].toUpperCase(),
                        "categoryFeaturesCode": document.getElementById("categoryFeaturesCode_" + index).value.toUpperCase(),
                        "code": document.getElementById("autoBarcode_" + index).value.toUpperCase(),
                        "autoBarcode" : document.getElementById("autoBarcode_" + index).value.toUpperCase(),
                        "forPrint" : document.getElementById("forPrint_" + index).value.toUpperCase(),
                        "plQuantity": document.getElementById("plQuantity_" + index).value,
                        "plPrice": document.getElementById("plPrice_" + index).value,
                        "plWholeSalePrice" : document.getElementById("plWholeSalePrice_" + index).value,
                        "productPerWarehouse": data.productPerWarehouse,
                    };
                    data.finalProductData.childs.push(elementValue);
                }
            }
            //PRICELISTS
            if (data.priceLists.length == 0) {
                priceListModal();
                savePriceListPrices();   
            }
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
                            '<div class="box-body"><table class="table table-bordered"><tr><th style="width: 10px"><input type="checkbox" class="minimal" onClick="toggleCheckbox(' + newFeature___.id + ');" /></th><th>NOMBRE</th><th>LLAVE</th></tr>';
                            var trIncludesFt = '<tbody id="featureTable_' + newFeature___.id + '">';
                            newFeature___.features.forEach(element_ => {
                                trIncludesFt = trIncludesFt + '<tr>' +
                                    '<td><input id="featureCategoryIdCheckbox_' + newFeature___.id + '_' + element_.id + '" type="checkbox" class="minimal"></td>' + 
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
                    if (checkBox.checked) {
                        elementFeature.checkedToggle = true
                    } else {
                        elementFeature.checkedToggle = false;                        
                    }
                });
            });
            //GUARDAR FEATURES MARCADOS
            trueElementCategoryNFeatures_ = elementCategoryNFeatures;
        }
        toggleCheckbox = function(featureId) {
            var conditionToggleCheckbox = false;
            var toggleCheckbox_ = document.getElementById('toggleCheckbox_' + featureId);
            if (toggleCheckbox_ != null) {
                if (toggleCheckbox_.checked == true) {
                    conditionToggleCheckbox = true;
                }
            }
            categoryFeatures_.forEach(element => {
                if (element.id == featureId) {
                    element.features.forEach(element_ => {
                        var featureCategoryIdCheckbox_ = document.getElementById('featureCategoryIdCheckbox_' + featureId + '_' + element_.id);
                        if (featureCategoryIdCheckbox_ != null) {
                            // toggleCheckboxFeaturesElementsObject(featureCategoryIdCheckbox_, featureId, element_.id);
                            if (conditionToggleCheckbox) {
                                featureCategoryIdCheckbox_.checked = true;
                            } else {
                                featureCategoryIdCheckbox_.checked = false;
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
        subCategoryModal = function() {
            document.getElementById('rowSubCategories').innerHTML = '';
            var button = document.getElementById('btnSubCategoryModal');
            button.disabled = true;
            $.ajax({
                method: "GET",
                url: "/api/categories?parentCategory=" + document.getElementById('productCategory').value,
                context: document.body,
                statusCode: {
                    500: function() {
                        button.disabled = false;
                        alert('No se encontraron subcategorías');
                    },
                    404: function() {
                        button.disabled = false;
                        alert('No se encontraron subcategorías');
                    },
                    403: function() {
                        button.disabled = false;
                        alert('No se encontraron subcategorías');
                    },
                    400: function() {
                        button.disabled = false;
                        alert('No se encontraron subcategorías');
                    },
                }
            }).done(function(response) {
                button.disabled = false;
                if (response.length > 0) {
                    // document.getElementById('subCategoryModalText').innerHTML = "SUBCATEGORÍAS DISPONIBLES DE " + $('#productCategory').text();
                    // CARGA DE SUCURSALES
                    var rowSubCategories = document.getElementById('rowSubCategories');
                    response.forEach(element => {
                        var btn = document.createElement("BUTTON");
                        btn.onclick = function() {
                            if (subcategories[element.id] != undefined) {
                                subcategories[element.id] = undefined;
                                document.getElementById('btnSubCategory_' + element.id).style.backgroundColor = "#ffffff"; 
                                document.getElementById('btnSubCategory_' + element.id).style.color = "#000000"; 
                            } else {
                                document.getElementById('btnSubCategory_' + element.id).style.backgroundColor = "#337ab7"; 
                                document.getElementById('btnSubCategory_' + element.id).style.color = "#ffffff"; 
                                subcategories[element.id] = element;
                            }
                        };
                        btn.setAttribute("class", "form-control");
                        btn.setAttribute("id", "btnSubCategory_" + element.id);
                        btn.style.width = '100%';
                        btn.style.padding = '5px';
                        btn.style.margin = '5px';
                        var t = document.createTextNode(element.name);
                        btn.appendChild(t);
                        rowSubCategories.appendChild(btn);
                        // APPLY COLOR
                        if (subcategories[element.id] != undefined) {
                            document.getElementById('btnSubCategory_' + element.id).style.backgroundColor = "#337ab7"; 
                            document.getElementById('btnSubCategory_' + element.id).style.color = "#ffffff"; 
                        }
                    });
                    $('#modal-subcategories').modal({ backdrop: 'static', keyboard: false });
                } else {
                    alert('No se encontraron subcategorías');
                }
            });
        }
        createNewProduct = function() {
            document.getElementById('productDescription').style.borderColor = '#ccc';
            document.getElementById('productModel').style.borderColor = '#ccc';
            document.getElementById('productName').style.borderColor = '#ccc';

            if (document.getElementById('productDescription').value == '') {
                document.getElementById('productDescription').style.borderColor = 'red';
                alert('No se pudo registrar el nuevo producto. Ingrese una DESCRIPCIÓN.');
            } else if(document.getElementById('productModel').value == '') {
                document.getElementById('productModel').style.borderColor = 'red';
                alert('No se pudo registrar el nuevo producto. Ingrese un MODELO.');
            } else if(document.getElementById('productName').value == '') {
                document.getElementById('productName').style.borderColor = 'red';
                alert('No se pudo registrar el nuevo producto. Ingrese un Nombre.');
            } else if (data.productPerWarehouse.length == 0) {
                alert("No se pudo registrar el nuevo producto. Faltan elegir sucursales");
            } else {
                //PRICELISTS
                if (data.validCode) {
                    var weight = document.getElementById('productGeneralWeight').value;
                    data.code = data.code.toUpperCase();
                    data.name = document.getElementById('productName').value.toUpperCase();
                    data.description = document.getElementById('productDescription').value.toUpperCase();
                    data.foreignName = document.getElementById('productForeignName').value.toUpperCase();
                    data.type = document.getElementById('productType').value;
                    data.flagOperation = document.getElementById('productTypeOperation').value;
                    data.currency = document.getElementById('productCurrency').value;
                    data.model = document.getElementById('productModel').value.toUpperCase();
                    data.weight = parseFloat(weight);
                    data.unitId = document.getElementById('productGeneralUnitId').value;
                    data.taxExemptionReasonCode = document.getElementById('productTaxExemptionReasonCode').value;
                    data.brandId = document.getElementById('brandId').value;
                    data.categoryId = document.getElementById('productCategory').value;
                    data.autoBarCode = document.getElementById('productAutoBarCode').value;
                    data.price = document.getElementById('productGeneralPrice').value;
                    data.quantity = document.getElementById('productGeneralQuantity').value;
                    data.wholeSalePrice = document.getElementById('productGeneralWholeSalePrice').value;
                    data.flagUniversalPromo = document.getElementById('productFlagUniversalPromo').value;
                    data.minPrice = document.getElementById('productMinPrice').value;
                    data.maxPrice = document.getElementById('productMaxPrice').value;
                    data.priceCost = document.getElementById('productPriceCost').value;
                    data.allotmentType = document.getElementById('allotmentType').value;
                    data.parentId = data.jsonResponseData.parentId;
                    console.log("data", data)
                    if (data.price != undefined) {
                        var productsResume  = document.getElementById('productsResume');
                        var productsResume_ = '<br><p class="form-control">Producto padre: ' + data.name + '</p><br>' + 
                            '<ul>Productos hijos generados: ' + (data.finalProductData.childs.length);
                            data.finalProductData.childs.forEach(element => {
                                productsResume_ = productsResume_ + '<li>' + element.name + ' - ' + element.autoBarcode + ' - ' + element.forPrint +'</li>';
                            });
                        productsResume_ = productsResume_ + '</ul><br><br>';
                        productsResume.innerHTML = productsResume_;
                        $("#modal-resume").modal({backdrop: 'static', keyboard: false});
                    } else {
                        alert("Ingrese un precio general válido");
                    }
                } else {
                    alert("Ingrese un código de producto válido.");
                }
            }
        }
        saveProductSubmit = function() {
            data.jsonResponseData = [];
            data.subcategories = subcategories;
            console.log("final save", data);
            $.ajax({
                method: "POST",
                url: "/api/products-custom",
                context: document.body,
                data: data,
                statusCode: {
                    500: function() {
                        alert('No se pudo registrar el nuevo producto. Verifique la información ingresada e inténtelo nuevamente.');
                    }, 
                    400: function() {
                        alert('No se pudo registrar el nuevo producto. Verifique los campos NOMBRE, CÓDIGOS, DESCRIPCIÓN Y MODELO.');
                    }
                }
            }).done(function(response) {
                var quantityOperation_ = 0;
                if (data.warehouseProduct.length != 0) {
                    quantityOperation_ = data.warehouseProduct.length;
                }
                var productsResponse  = document.getElementById('productsResponse');
                var productsResponse_ = '<br><p class="form-control">Producto <b>' + data.name + '</b> generado correctamente</p><br>';
                if (data.jsonResponseData.parentId != undefined && data.jsonResponseData.parentId != null) {
                    var productsResponse_ = productsResponse_ + '<p class="form-control">Productos hijos generados correctamente</p>';
                }
                productsResponse.innerHTML = productsResponse_;
                $("#modal-response").modal({backdrop: 'static', keyboard: false});
            });
        }
        toggleCheckboxFeaturesElements = function(elementCategoryId, elementFeatureId) {
            var checkbox = document.getElementById('featureCategoryIdCheckbox_' + elementCategoryId + '_' + elementFeatureId);
            if (checkbox != null) {
                if (checkbox.checked) {
                    if (elementCategoryNFeatures[elementCategoryId] == undefined) {
                        elementCategoryNFeatures[elementCategoryId] = [];
                    }
                    if (!elementCategoryNFeatures[elementCategoryId].includes(elementFeatureId)) {
                        elementCategoryNFeatures[elementCategoryId].push(elementFeatureId);
                    }
                } else {
                    if (elementCategoryNFeatures[elementCategoryId] != undefined) {
                        if (elementCategoryNFeatures[elementCategoryId].includes(elementFeatureId)) {
                            elementCategoryNFeatures[elementCategoryId].splice(elementCategoryNFeatures[elementCategoryId].indexOf(elementFeatureId), 1);
                        }
                    }
                }
            }
        }
        toggleCheckboxFeaturesElementsObject = function(checkbox, elementCategoryId, elementFeatureId) {
            if (checkbox.checked) {
                if (elementCategoryNFeatures[elementCategoryId] == undefined) {
                    elementCategoryNFeatures[elementCategoryId] = [];
                }
                if (!elementCategoryNFeatures[elementCategoryId].includes(elementFeatureId)) {
                    elementCategoryNFeatures[elementCategoryId].push(elementFeatureId);
                }
            } else {
                if (elementCategoryNFeatures[elementCategoryId] != undefined) {
                    if (elementCategoryNFeatures[elementCategoryId].includes(elementFeatureId)) {
                        elementCategoryNFeatures[elementCategoryId].splice(elementCategoryNFeatures[elementCategoryId].indexOf(elementFeatureId), 1);
                    }
                }
            }
            console.log(elementCategoryNFeatures);
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
                    '<div class="box-body"><table class="table table-bordered"><tr><th style="width: 10px"><input type="checkbox" class="minimal" id="toggleCheckbox_'+ element.id +'" onClick="toggleCheckbox(' + element.id + ');" /></th><th>NOMBRE</th><th>LLAVE</th></tr>';
                } else {
                    featuresHeaderText = featuresHeaderText + '<li><a href="#activity_' + element.id + '" data-toggle="tab">' + element.name + '</a></li>';
                    featuresContentText = featuresContentText + '<div class="tab-pane" id="activity_' + element.id + '">' +
                    '<div class="box"><div class="box-header with-border"><h3 class="box-title">Administre sus opciones</h3></div>' +
                    '<div class="box-body"><table class="table table-bordered"><tr><th style="width: 10px"><input type="checkbox" class="minimal" id="toggleCheckbox_'+ element.id +'" onClick="toggleCheckbox(' + element.id + ');" /></th><th>NOMBRE</th><th>LLAVE</th></tr>';
                }
                var trIncludesFt = '<tbody id="featureTable_' + element.id + '">';
                element.features.forEach(element_ => {
                    var checked = '';
                    if (trueElementCategoryNFeatures_[element.id] != undefined) {
                        if (trueElementCategoryNFeatures_[element.id].includes(element_.id)) {
                            checked = 'checked';
                        }
                    }
                    trIncludesFt = trIncludesFt + '<tr>' +
                        '<td><input id="featureCategoryIdCheckbox_' + element.id + '_' + element_.id + '" type="checkbox" ' + checked + ' onClick="toggleCheckboxFeaturesElements(' + element.id + ',\'' + element_.id + '\');" class="minimal" ></td>' + 
                        '<td>' + element_.name + '</td>' +
                        '<td>' + element_.id + '</td>' +
                        '</tr>';
                });
                //AGREGAR COLUMNA NUEVA PARA NUEVOS FEATURES
                featuresContentText = featuresContentText + trIncludesFt + '<tr><td><input type="checkbox" class="minimal"></td><td><input type="text" id="newFeatureName_' + element.id + '" class="input-sm form-control" placeholder="Ingrese un nombre"></td><td><input type="text" id="newFeatureId_' + element.id + '" class="input-sm form-control" placeholder="Ingrese un código o llave"></td></tr></tbody></table></div></div></div>';
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
                    url: "/api/product-exists/" + encodeURIComponent(productCode.value),
                    context: document.body,
                    statusCode: {
                        400: function() {
                            data.validCode = false;
                            productCode.style.borderColor = "#d9534f";
                        },
                        404: function() {
                            productCode.style.borderColor = "#4cae4c";
                            data.validCode = true;
                            data.code = productCode.value;
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
