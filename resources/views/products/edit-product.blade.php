@extends('adminlte::layouts.app_products_edit_product')

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
  EDITAR PRODUCTO
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
                  <div class="form-group col-md-6" style="padding-left: 0px;">
                    <label for="productCode">CÓDIGO INTERNO</label>
                    <input type="hidden" id="productId" value="{{ $jsonResponse->productInfo->id }}" disabled/>
                    <input class="form-control" id="productCode" name="productCode" placeholder="Código de producto" maxlength="25" value="{{ $jsonResponse->productInfo->code }}"/>
                  </div>
                  <div class="form-group col-md-6" style="padding-left: 0px;">
                    <label for="productAutoBarCode">CÓDIGO DE BARRAS</label>
                    <input class="form-control" id="productAutoBarCode" name="productAutoBarCode" placeholder="Código de barras" maxlength="25" value="{{ $jsonResponse->productInfo->autoBarcode }}"/>
                  </div>
                  <!-- <div class="form-group col-md-6" style="padding-left: 0px;">
                    <label for="productSerial">CÓDIGO SERIAL</label>
                    <input class="form-control" id="productSerial" name="productSerial" placeholder="Código de producto" maxlength="25" value="{{ $jsonResponse->productInfo->serial }}"/>
                  </div>
                  <div class="form-group col-md-6" style="padding-left: 0px;">
                    <label for="productImei">CÓDIGO IMEI</label>
                    <input class="form-control" id="productImei" name="productImei" placeholder="Código de barras" maxlength="25" value="{{ $jsonResponse->productInfo->imei }}"/>
                  </div> -->
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                  <!-- (MAX 1Mb) -->
                    <label for="productImage">IMAGEN </label>
                    <input type="file" style="width:100%;" class="form-control" id="productImage" name="productImage" accept=".jpg, .jpeg, .png">
                  </div>
                </div>
                <div class="form-group">
                  <label for="productName">NOMBRE DEL PRODUCTO</label>
                  <input class="form-control" id="productName" name="productName" placeholder="Ingrese un nombre para el producto" maxlength="250" value="{{ $jsonResponse->productInfo->name }}"/>
                </div>
                <div class="form-group">
                  <label for="productForeignName">NOMBRE EXTRANJERO DEL PRODUCTO</label>
                  <input class="form-control" id="productForeignName" name="productForeignName" placeholder="Ingrese un nombre extranjero para el producto" maxlength="250" value="{{ $jsonResponse->productInfo->foreignName }}"/>
                </div>
                <div class="form-group">
                  <label for="productModel">MODELO DEL PRODUCTO</label>
                  <input class="form-control" id="productModel" name="productModel" placeholder="Ingrese un modelo para el producto" maxlength="250" value="{{ $jsonResponse->productInfo->model }}"/>
                </div>
                <div class="form-group">
                  <label for="productDescription">DESCRIPCIÓN DEL PRODUCTO</label>
                  <input class="form-control" id="productDescription" name="productDescription" placeholder="Ingrese un modelo para el producto" maxlength="250" value="{{ $jsonResponse->productInfo->description }}"/>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-body">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="allotmentType">GESTIÓN DE ARTÍCULO</label>
                    <select disabled name="allotmentType" id="allotmentType" class="form-control">
                      @if ($jsonResponse->productInfo->allotmentType === 0)
                        <option selected value="0">GESTIÓN LIBRE</option>
                      @else
                        <option value="0">GESTIÓN LIBRE</option>
                      @endif
                      @if ($jsonResponse->productInfo->allotmentType === 1)
                        <option selected value="1">GESTIÓN POR LOTES</option>
                      @else
                        <option value="1">GESTIÓN POR LOTES</option>
                      @endif
                      @if ($jsonResponse->productInfo->allotmentType === 2)
                        <option selected value="2">GESTIÓN POR SERIES</option>
                      @else
                        <option value="2">GESTIÓN POR SERIES</option>
                      @endif
                    </select>
                  </div>
                <div class="col-md-12">
                  <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                      <label for="productUnity">TIPO DE OPERACIÓN</label>
                      <select disabled name="productTypeOperation" id="productTypeOperation" class="form-control">
                        @if ($jsonResponse->productInfo->flagOperation === 1)
                          <option selected value="1">COMPRA</option>
                          <option value="2">VENTA</option>
                          <option value="3">COMPRA/VENTA</option>
                        @elseif ($jsonResponse->productInfo->flagOperation === 2)
                          <option value="1">COMPRA</option>
                          <option selected value="2">VENTA</option>
                          <option value="3">COMPRA/VENTA</option>
                        @else
                          <option value="1">COMPRA</option>
                          <option value="2">VENTA</option>
                          <option selected value="3">COMPRA/VENTA</option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                      <label for="productType">TIPO DE ITEM</label>
                      <select disabled name="productType" id="productType" class="form-control">
                        @if ($jsonResponse->productInfo->type === 1)
                          <option selected value="1">INVENTARIABLE</option>
                          <option value="2">NO INVENTARIABLE</option>
                        @else
                          <option value="1">INVENTARIABLE</option>
                          <option selected value="2">NO INVENTARIABLE</option>
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                  <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                        <label for="productCategory">CATEGORÍA</label>
                        <select name="productCategory" id="productCategory" class="form-control">
                        @foreach ($jsonResponse->categories as $object)
                          @if ($object->id === $jsonResponse->productInfo->categoryId)
                            <option selected value="{{ $object->id }}">{{ $object->name }}</option>
                          @else
                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                          @endif
                        @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                        <label for="productFlagUniversalPromo">PROMOCIÓN UNIVERSAL</label>
                        <select name="productFlagUniversalPromo" id="productFlagUniversalPromo" class="form-control">
                          @if (0 === $jsonResponse->productInfo->flagUniversalPromo)
                            <option selected value="0">NO</option>
                            <option value="1">SÍ</option>
                          @else
                            <option value="0">NO</option>
                            <option selected value="1">SÍ</option>
                          @endif
                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                      <label for="productWeight">PESO (Kg)</label>
                      <input type="number" value="{{ $jsonResponse->productInfo->weigth }}" style="width:100%;" min="0" max="9999999" class="form-control" id="productWeight" name="productWeight" placeholder="{{ trans('message.enter_amount') }}">
                    </div>
                  </div>
                  <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                      <label for="productGeneralPrice">PRECIO GENERAL</label>
                      <input type="number" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productGeneralPrice" name="productGeneralPrice" placeholder="{{ trans('message.enter_amount') }}" value="{{ $jsonResponse->productInfo->price }}">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group col-md-6" style="padding-left: 0px;">
                      <label for="productCurrency">MONEDA POR DEFECTO</label>
                      <select name="productCurrency" id="productCurrency" class="form-control">
                        @if ($jsonResponse->productInfo->currency === 'PEN')
                          <option selected value="PEN">PEN (S/)</option>
                          <option value="USD">USD ($)</option>
                        @else
                          <option value="PEN">PEN (S/)</option>
                          <option selected value="USD">USD ($)</option>
                        @endif
                      </select>
                  </div>
                  <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                      <label for="productUnity">UNIDAD</label>
                      <select name="productUnity" id="productUnity" class="form-control">
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <button id="btnSaveChanges" class="btn btn-block btn-danger" onClick="createNewProduct();">GUARDAR</button>
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
