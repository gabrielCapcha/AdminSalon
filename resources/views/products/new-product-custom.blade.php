@extends('adminlte::layouts.app_products_new_product_custom')

@section('sidebar_products')
active
@endsection
@section('sidebar_products_1')
active
@endsection

@section('htmlheader_title')
	CREAR PRODUCTO
@endsection

@section('contentheader_title')
	{{ trans('message.products_title') }}
@endsection
@section('contentheader_description')	
  {{ trans('message.new-product') }}
@endsection
@section('main-content')
  <div class="row">
    <div class="col-md-12">
        <!-- <form id="form" role="form" action="/products" method="POST"> -->
        <input type="hidden" id="jsonResponseData" value="{{ json_encode($jsonResponse) }}">
            <div class="col-md-6">
                <div class="box box-primary"  style="margin-bottom: 0px;">
                    <div class="box-body">
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productType">TIPO DE ITEM</label>
                            <select name="productType" id="productType" class="form-control">
                            <option value="1">INVENTARIABLE</option>
                            <option value="2">NO INVENTARIABLE</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productTypeOperation">TIPO DE OPERACIÓN</label>
                            <select name="productTypeOperation" id="productTypeOperation" class="form-control">
                            <option value="1">COMPRA</option>
                            <option selected value="2">VENTA</option>
                            <option value="3">COMPRA Y VENTA</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productCode">CÓDIGO INTERNO</label>
                            <input class="form-control" id="productCode" name="productCode" placeholder="Código de producto" maxlength="25"/>
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productAutoBarCode">CÓDIGO DE BARRAS</label>
                            <input class="form-control" id="productAutoBarCode" name="productAutoBarCode" placeholder="Código de barras" maxlength="25"/>
                        </div>
                        <div class="form-group">
                            <label for="productName">NOMBRE</label>
                            <input class="form-control" id="productName" name="productName" placeholder="Ingrese un nombre para el producto" maxlength="250" required/>
                        </div>
                        <div class="form-group">
                            <label for="productForeignName">NOMBRE EXTRANJERO</label>
                            <input class="form-control" id="productForeignName" name="productForeignName" placeholder="Ingrese un nombre extranjero" maxlength="250" />
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productModel">MODELO</label>
                            <input class="form-control" id="productModel" name="productModel" placeholder="Ingrese un modelo" maxlength="250" />
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <!-- (MAX 1Mb) -->
                            <label for="productImage">IMAGEN </label>
                            <input type="file" style="width:100%;" class="form-control" id="productImage" name="productImage" accept=".jpg, .jpeg, .png">
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productCategory">CATEGORÍA <button id="btnSubCategoryModal" onClick="subCategoryModal();" class="btn btn-info btn-xs" style="padding: 0px 5px 0px 5px; margin-left: 10px; font-size: 11px; line-height: normal; background: #3c8dbc;">Subcategorías</button></label>
                            <select name="productCategory" id="productCategory" class="form-control">
                            @foreach ($jsonResponse->categories as $object)
                                <option value="{{ $object->id }}">{{ $object->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="selectBrand">MARCA</label>
                            <select id="brandId" name="brandId" class="form-control" >
                                @foreach ($jsonResponse->brands as $object)
                                    <option value="{{ $object->id }}">{{ $object->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">DESCRIPCIÓN</label>
                            <textarea class="form-control" style="resize: none;" id="productDescription" name="productDescription" placeholder="Ingrese una descripción para el producto" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary" style="margin-bottom: 0px;">
                    <div class="box-body">
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productFlagUniversalPromo">PROMOCIÓN UNIVERSAL</label>
                            <select name="productFlagUniversalPromo" id="productFlagUniversalPromo" class="form-control">
                                <option value="0">NO</option>
                                <option value="1">SÍ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productCurrency">MONEDA POR DEFECTO</label>
                            <select name="productCurrency" id="productCurrency" class="form-control">
                                <option value="PEN">PEN (S/)</option>
                                <option value="USD">USD ($)</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="allotmentType">GESTIÓN DE ARTÍCULO</label>
                            <select name="allotmentType" id="allotmentType" class="form-control">
                            <option value="0">GESTIÓN LIBRE</option>
                            <option value="1">GESTIÓN POR LOTES</option>
                            <option value="2">GESTIÓN POR SERIES</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" style="padding-left: 0px;">
                            <label for="productGeneralUnitId">UNIDAD DE MEDIDA</label>
                            <select name="productGeneralUnitId" id="productGeneralUnitId" class="form-control">
                              @foreach ($jsonResponse->units as $object)
                                <option value="{{ $object->id }}">{{ $object->name }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12" style="padding-left: 0px;">
                            <label for="productTaxExemptionReasonCode">TIPO DE AFECTACIÓN DEL IGV</label>
                            <select name="productTaxExemptionReasonCode" id="productTaxExemptionReasonCode" class="form-control">
                              <option selected value="10">Gravado - Operación Onerosa</option>
                              <option value="11">Gravado – Retiro por premio</option>
                              <option value="12">Gravado – Retiro por donación</option>
                              <option value="13">Gravado – Retiro</option>
                              <option value="14">Gravado – Retiro por publicidad</option>
                              <option value="15">Gravado – Bonificaciones</option>
                              <option value="16">Gravado – Retiro por entrega a trabajadores</option>
                              <option value="17">Gravado – IVAP</option>
                              <option value="20">Exonerado - Operación Onerosa</option>
                              <option value="21">Exonerado – Transferencia Gratuita</option>
                              <option value="30">Inafecto - Operación Onerosa</option>
                              <option value="31">Inafecto – Retiro por Bonificación</option>
                              <option value="32">Inafecto – Retiro</option>
                              <option value="33">Inafecto – Retiro por Muestras Médicas</option>
                              <option value="34">Inafecto - Retiro por Convenio Colectivo</option>
                              <option value="35">Inafecto – Retiro por premio</option>
                              <option value="36">Inafecto - Retiro por publicidad</option>
                              <option value="40">Exportación</option>
                              <option value="7152">IMPUESTO A BOLSAS PLASTICAS - ICBPER</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4" style="padding-left: 0px;">
                            <label for="productGeneralWeight">PESO (Kg)</label>
                            <input type="number" step=".01" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productGeneralWeight" name="productGeneralWeight" placeholder="Ingrese peso del producto (Kg)" value="0.00">
                        </div>
                        <div class="form-group col-md-4" style="padding-left: 0px;">
                            <label for="">PRECIO MÍNIMO</label>
                            <input type="number" step=".01" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productMinPrice" name="productMinPrice" placeholder="{{ trans('message.enter_amount') }}" value="0.00">
                        </div>
                        <div class="form-group col-md-4" style="padding-left: 0px;">
                            <label for="">PRECIO MÁXIMO</label>
                            <input type="number" step=".01" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productMaxPrice" name="productMaxPrice" placeholder="{{ trans('message.enter_amount') }}" value="0.00">
                        </div>
                        <div class="form-group col-md-4" style="padding-left: 0px;">
                            <label for="productGeneralPrice">PRECIO GENERAL</label>
                            <input type="number" step=".01" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productGeneralPrice" name="productGeneralPrice" placeholder="{{ trans('message.enter_amount') }}" value="0.00">
                        </div>
                        <div class="form-group col-md-4" style="padding-left: 0px;">
                            <label for="productGeneralQuantity">CANTIDAD</label>
                            <input type="number" step=".01" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productGeneralQuantity" name="productGeneralQuantity" placeholder="{{ trans('message.enter_amount') }}" value="0.00">
                        </div>
                        <div class="form-group col-md-4" style="padding-left: 0px;">
                            <label for="productGeneralWholeSalePrice">PRECIO X MAYOR</label>
                            <input type="number" step=".01" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productGeneralWholeSalePrice" name="productGeneralWholeSalePrice" placeholder="{{ trans('message.enter_amount') }}" value="0.00">
                        </div>
                        <div class="form-group col-md-12" style="padding-left: 0px;">
                            <label for="productPriceCost">PRECIO COSTO</label>
                            <input type="number" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productPriceCost" name="productPriceCost" placeholder="INGRESE PRECIO COSTO" value="0.00">
                        </div>
                        <br>
                        <div class="form-group" style="margin-top: 30px;">
                            <label for="btnFeatures">OPCIONES AVANZADAS</label>
                            <button id="btnProductWarehouses" class="btn btn-block btn-info" onClick="openWarehouseProduct();">ELEGIR SUCURSALES</button>
                            <button id="btnFeatures" class="btn btn-block btn-warning" onClick="openFeatures();" data-toggle="modal" data-target="#modal-features" data-backdrop="static" data-keyboard="false">ADMINISTRAR OPCIONES</button>
                            <button id="btnWarehouses" class="btn btn-block btn-success" onClick="openWarehouses();">ADMINISTRAR PRODUCTOS HIJOS</button>
                            <button id="btnSaveChanges" class="btn btn-block btn-danger" onClick="createNewProduct();">CREAR PRODUCTO NUEVO</button>
                        </div>
                    </div>
                </div>
            </div>
          <!--MODALS-->
          <div class="modal fade" id="modal-product-warehouse">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Seleccione sucursales en donde desea agregar el producto</h4>
                </div>
                <p style="padding-left: 20px"><input id="allWarehouses" type="checkbox" value="0" onClick="checkAll();"/> TODAS LAS TIENDAS </p>
                @foreach ($jsonResponse->warehouses as $object)
                  @if ($object->id != 0)
                    <p style="padding-left: 20px"><input id="{{ $object->id }}" type="checkbox" name="{{ $object->name }}" value="{{ $object->id }}"/> {{ $object->name }} </p>
                  @endif
                @endforeach
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">REGRESAR</button>
                  <button type="button" onClick="saveWarehouseCreate();" class="btn btn-success pull-right" data-dismiss="modal">GUARDAR</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="modal-resume">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Resumen de registro de productos</h4>
                </div>
                <div class="col-md-12" id="productsResume" style="padding:10px;">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">REGRESAR</button>
                  <button type="button" onClick="saveProductSubmit();" class="btn btn-success pull-right" data-dismiss="modal">GUARDAR</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="modal-response">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Resumen de registro de productos</h4>
                </div>
                <div class="col-md-12" id="productsResponse" style="padding:10px;">
                </div>
                <div class="modal-footer">
                  <button type="button" onClick="goToNewProduct();" class="btn btn-warning pull-left" data-dismiss="modal">Nuevo producto</button>
                  <button type="button" onClick="goToProducts();" class="btn btn-success pull-right" data-dismiss="modal">Ver productos</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="modal-price-list">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Ingrese los precios por almacén</h4>
                </div>
                <div class="col-md-12" id="priceListUl">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button type="button" id="closePriceListModal" onClick="savePriceListPrices();" class="btn btn-success pull-right" data-dismiss="modal">Guardar</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <div class="modal fade" id="modal-subcategories">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 id="subCategoryModalText" class="modal-title">SUBCATEGORÍAS DISPONIBLES</h4>
                    </div>
                    <div class="col-md-12" style="padding:10px;">
                        <!-- form start -->
                        <div id="rowSubCategories" align="center">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <br>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
          </div>
          <div class="modal fade" id="modal-features">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Ingrese las opciones de producto</h4>
                </div>
                <div class="col-md-12" id="priceListUl">
                  <br>
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="featuresHeader">
                    </ul>
                    <div class="tab-content" id="featuresContent">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button type="button" onClick="saveFeatures();" class="btn btn-success pull-right" data-dismiss="modal">Guardar</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
          </div>
          <div class="modal fade bd-example-modal-lg" id="modal-warehouses">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Administre las opciones de los productos hijos</h4>
                </div>
                <div class="col-md-12" id="warehousePrProducts">
                  <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped" style="font-size:75%;">
                      <thead id="theadWarehouseProducts">
                        <tr>
                          <th width="25%">Productos hijos</th>
                          <th width="10%">C.BARRAS</th>
                          <th width="15%">IMPRESIÓN</th>
                          <th width="15%">P.Unitario</th> 
                          <th width="15%">Cantidad</th> 
                          <th width="15%">P.PorMayor</th>
                        </tr>
                      </thead>
                      <tbody id="tbodyWarehouseProducts">
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button type="button" onClick="saveWarehouseProducts();" class="btn btn-success pull-right" data-dismiss="modal">Guardar</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
        <!-- </form> -->
      </div>
    </div>			
@endsection
