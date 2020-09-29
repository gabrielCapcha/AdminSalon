@extends('adminlte::layouts.app_products_new_product')

@section('sidebar_products')
active
@endsection
@section('sidebar_products_1')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.products_title') }}
@endsection

@section('contentheader_title')
	{{ trans('message.products_title') }}
@endsection
@section('contentheader_description')	
  {{ trans('message.new-product') }}
@endsection

@section('main-content')
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <!-- <form id="form" role="form" action="/products" method="POST"> -->
        <input type="hidden" id="jsonResponseData" value="{{ json_encode($jsonResponse) }}">
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="productCode">CÓDIGO INTERNO</label>
                        <input class="form-control" id="productCode" name="productCode" placeholder="Código de producto" maxlength="25" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="productAutoBarCode">CÓDIGO DE BARRAS</label>
                        <input class="form-control" id="productAutoBarCode" name="productAutoBarCode" placeholder="Código de barras" maxlength="25" />
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="selectBrand">MARCA DEL PRODUCTO</label>
                      <select id="brandId" name="brandId" class="form-control" >
                        @foreach ($jsonResponse->brands as $object)
                          <option value="{{ $object->id }}">{{ $object->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    <!-- (MAX 1Mb) -->
                      <label for="productImage">IMAGEN </label>
                      <input type="file" style="width:100%;" class="form-control" id="productImage" name="productImage" accept=".jpg, .jpeg, .png">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="productName">NOMBRE DEL PRODUCTO</label>
                  <input class="form-control" id="productName" name="productName" placeholder="Ingrese un nombre para el producto" maxlength="250" />
                </div>
                <div class="form-group">
                  <label for="productForeignName">NOMBRE EXTRANJERO DEL PRODUCTO</label>
                  <input class="form-control" id="productForeignName" name="productForeignName" placeholder="Ingrese un nombre extranjero para el producto" maxlength="250" />
                </div>
                <div class="form-group">
                  <label for="productModel">MODELO DEL PRODUCTO</label>
                  <input class="form-control" id="productModel" name="productModel" placeholder="Ingrese un modelo para el producto" maxlength="250" />
                </div>
                <div class="form-group">
                  <label for="selectWarehouse">{{ trans('message.warehouse_store') }}</label>
                  <select class="select2" multiple="multiple" data-placeholder="Seleccione uno o varios" id="warehouseId" name="warehouseId" style="width: 100%;">
                    @foreach ($jsonResponse->warehouses as $object)
                      <option value="{{ $object->id }}">{{ $object->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="productCategory">CATEGORÍA</label>
                        <select name="productCategory" id="productCategory" class="form-control">
                        @foreach ($jsonResponse->categories as $object)
                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="productFlagUniversalPromo">PROMOCIÓN UNIVERSAL</label>
                        <select name="productFlagUniversalPromo" id="productFlagUniversalPromo" class="form-control">
                          <option value="0">NO</option>
                          <option value="1">SÍ</option>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="productUnity">UNIDAD</label>
                      <select name="productUnity" id="productUnity" class="form-control">
                        <option value="700">UNIDAD</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="productType">TIPO</label>
                      <select name="productType" id="productType" class="form-control">
                        <option value="1">INVENTARIABLE</option>
                        <option value="2">NO INVENTARIABLE</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="productWeight">PESO UNITARIO</label>
                      <input type="number" value="1.00" style="width:100%;" min="0" max="9999999" class="form-control" id="productWeight" name="productWeight" placeholder="{{ trans('message.enter_amount') }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="productGeneralPrice">PRECIO GENERAL</label>
                      <input type="number" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productGeneralPrice" name="productGeneralPrice" placeholder="{{ trans('message.enter_amount') }}" value="0.00">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="productPriceCost">PRECIO COSTO</label>
                      <input type="number" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productPriceCost" name="productPriceCost" placeholder="INGRESE PRECIO COSTO" value="0.00">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>OPCIONES AVANZADAS</label><br>
                  <div class="form-group">
                    <button id="btnPriceList" class="btn btn-block btn-warning" onClick="priceListModal();" data-toggle="modal" data-target="#modal-price-list" data-backdrop="static" data-keyboard="false">ABRIR LISTA DE PRECIOS</button>
                  </div>
                  <div class="form-group">
                    <button id="btnFeatures" class="btn btn-block btn-info" onClick="openFeatures();" data-toggle="modal" data-target="#modal-features" data-backdrop="static" data-keyboard="false">ADMINISTRAR OPCIONES</button>
                  </div>
                  <div class="form-group">
                    <button id="btnWarehouses" class="btn btn-block btn-success" onClick="openWarehouses();" data-toggle="modal" data-target="#modal-warehouses" data-backdrop="static" data-keyboard="false">ADMINISTRAR STOCK</button>
                  </div>
                  <div class="form-group">
                    <button id="btnSaveChanges" class="btn btn-block btn-danger" onClick="createNewProduct();">CREAR PRODUCTO NUEVO</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--MODALS-->
          <div class="modal fade" id="modal-resume">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Resumen de registro de productos</h4>
                </div>
                <div class="col-md-12" id="productsResume">
                </div>
                <div class="modal-footer">
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
          <div class="modal fade" id="modal-warehouses">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Ingrese el stock de cada producto</h4>
                </div>
                <div class="col-md-12" id="warehousePrProducts">
                  <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead id="theadWarehouseProducts">
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
</section>				
@endsection
