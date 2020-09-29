@extends('adminlte::layouts.app_products_index')

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
  <a href="/new-product"> {{ trans('message.products_new_title') }} </a>
@endsection

@section('main-content')
<input type="hidden" id="app_id" value="{{ json_encode($jsonResponse->app_id) }}"/>
  <div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
            <div class="box-body" style="margin: 10px;">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12" align="center">
                    <!-- PADRE/HIJO -->
                    <select id="parent" class="form-control">
                      <option value="0">TIPO</option>
                      <option value="1">PADRE</option>
                      <option value="2">HIJO</option>
                    </select>
                    <select id="stateId" class="form-control">
                      <option value="2">ESTADO</option>
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
                    </select>
                    <!-- CATEGORÍA -->
                    <select id="categoryId" class="form-control">
                      <option value="0">CATEGORÍAS</option>
                      @foreach ($jsonResponse->categories as $object)
                      <option value="{{ $object->id }}">{{ $object->name }}</option>
                      @endforeach
                    </select>
                    <!-- MARCA -->
                    <select id="brandId" class="form-control">
                      <option value="0">MARCAS</option>
                      @foreach ($jsonResponse->brands as $object)
                      <option value="{{ $object->id }}">{{ $object->name }}</option>
                      @endforeach
                    </select>
                    <!-- BUSCADOR -->
                    <input id="searchInput" class="form-control" type="text" placeholder="Buscar producto..." />
                    <button id="searchButton" class="btn btn-success">Buscar</button>
                  </div>
                  <div class="col-sm-12" align="center">
                    <br>
                    <table id="products_index" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr role="row">
                          <th><input type="checkbox" id="checkedAllButton" onClick="checkedAll();"></th>
                          <th>CATEGORÍA</th>
                          <th>MARCA</th>
                          <th>TIPO</th>
                          <th>CÓDIGO</th>
                          <th>C.BARRAS</th>
                          <th>G.ARTÍCULO</th>
                          <th>NOMBRE</th>
                          <th>DESCRIPCIÓN</th>
                          <th>P.COSTO</th>
                          <th>T.AFECTACIÓN</th>
                          <th>FECHA</th>
                          <th>HORA</th>
                          <th width="15%">OPCIONES</th>
                        </tr>
                      </thead>
                      <tbody style="font-size:12px;   vertical-align: center;">
                      </tbody>
                    </table>
                  </div>
                  <!-- MODALS -->
                  <div class="modal modal-danger fade" id="modal-danger">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">ELIMINAR PRODUCTO</h4>
                        </div>
                        <div class="modal-body">
                          <p id="deletedSaleText"></p>
                          <br>
                          <input class="form-control" id="deleteComment" size="50" type="text" maxlength="100" placeholder="Escriba un motivo..." />
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CANCELAR</button>
                            <button type="button" onClick="deleteProductSubmit()" class="btn btn-outline">ACEPTAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-warning fade" id="modal-info">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="detailSaleCreatedAt">DETALLE DE PRODUCTO</h4>
                        </div>
                        <div class="modal-body">
                          <div class="body">
                              <div align="center" id="detailSaleItemsTable">
                              </div>
                              <br>
                              <div align="right" id="detailSalePaymentTable">
                              </div>
                              <br>
                          </div>
                          <div class="footer">
                              <div align="center" id="detailSaleEmployeeName">
                              </div>
                          </div>
                          <p id="saleDetailText"></p>
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">REGRESAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-default fade" id="modal-price-list">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center">ADMINISTRAR PRECIOS POR PRODUCTO</h4>
                        </div>
                        <div class="modal-body" align="center">
                          <br>
                          <!-- ALMACENES/TIENDAS -->
                          <label>TIENDA DE DESTINO</label>
                          <br>
                          <input type="hidden" id="warehouseId" value="{{ $jsonResponse->warehouseId }}">
                          <select id="warehouseDestiny" class="form-control">
                            @foreach ($jsonResponse->warehouses as $object)
                              {{-- @if ($object->id !== 0) --}}
                                @if($object->id === $jsonResponse->warehouseId)
                                  <option selected value="{{ $object->id }}">{{ $object->name }}</option>
                                @else
                                  <option value="{{ $object->id }}">{{ $object->name }}</option>
                                @endif
                              {{-- @endif --}}
                            @endforeach
                          </select>
                          <button type="button" class="btn btn-success" id="btnSearchWarehousePriceList" onClick="searchWarehousePriceList();">BUSCAR</button>
                          <br>
                          <br>
                          <br>
                          <table class="table" id="tablePriceList">
                            <thead>
                              <tr>
                                <td>NOMBRE</td>
                                <td>PRECIO POR MENOR</td>
                                <td>CANTIDAD POR MAYOR</td>
                                <td>PRECIO POR MAYOR</td>
                              </tr>
                            </thead>
                            <tbody>
                              <input type="hidden" id="priceListValues" value="{{ json_encode($jsonResponse->priceList) }}"/>
                              @foreach ($jsonResponse->priceList as $object)
                                <tr>
                                  <td>{{ $object->currency }} ({{ $object->symbol_code }}) - {{ $object->name }}</td>
                                  <td><input onClick="this.select();" type="number" id="price_{{ $object->id }}" style="width:100%;" class="form-class" value="0"></td>
                                  <td><input onClick="this.select();" type="number" id="quantity_{{ $object->id }}" style="width:100%;" class="form-class" value="0"></td>
                                  <td><input onClick="this.select();" type="number" id="wholeSalePrice_{{ $object->id }}" style="width:100%;" class="form-class" value="0"></td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                            <button type="button" id="btnPricelist" class="btn btn-success pull-rigth" data-dismiss="modal" onClick="priceListSubmit()">GUARDAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-default fade" id="modal-type-affection">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center">ADMINISTRAR TIPOS DE AFECTACION</h4>
                        </div>
                        <div class="modal-body" align="center">
                          <select name="multipleTypeAffection" id="multipleTypeAffection" class="form-control">
                            <option selected value="0">Seleccione un tipo de afectación</option>
                            <option value="10">Gravado - Operación Onerosa</option>
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
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                            <button type="button" id="btnMultipleTypeAffection" class="btn btn-success pull-rigth" onClick="multipleTypeAffectionSubmit();">GUARDAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-default fade" id="modal-massive-price">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center">ADMINISTRAR PRECIOS</h4>
                        </div>
                        <div class="modal-body" align="center">
                          <select name="massivePriceWarehouse" id="massivePriceWarehouse" class="form-control">
                            <option selected value="0">TODAS LAS TIENDAS</option>
                            @foreach ($jsonResponse->warehouses as $object)
                              @if($object->id !== 0)
                                @if($object->id === $jsonResponse->warehouseId)
                                  <option selected value="{{ $object->id }}">{{ $object->name }}</option>
                                @else
                                  <option value="{{ $object->id }}">{{ $object->name }}</option>
                                @endif
                              @endif
                            @endforeach
                          </select>
                          <br>
                          <table class="table" id="tablePriceListMassive">
                            <thead>
                              <tr>
                                <td>NOMBRE</td>
                                <td>PRECIO POR MENOR</td>
                                <td>CANTIDAD POR MAYOR</td>
                                <td>PRECIO POR MAYOR</td>
                              </tr>
                            </thead>
                            <tbody>
                              <input type="hidden" id="priceListValuesMassive" value="{{ json_encode($jsonResponse->priceList) }}"/>
                              @foreach ($jsonResponse->priceList as $object)
                                <tr>
                                  <td>{{ $object->currency }} ({{ $object->symbol_code }}) - {{ $object->name }}</td>
                                  <td><input onClick="this.select();" type="number" id="massive_price_{{ $object->id }}" style="width:100%;" class="form-class" value="0"></td>
                                  <td><input onClick="this.select();" type="number" id="massive_quantity_{{ $object->id }}" style="width:100%;" class="form-class" value="0"></td>
                                  <td><input onClick="this.select();" type="number" id="massive_wholeSalePrice_{{ $object->id }}" style="width:100%;" class="form-class" value="0"></td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <br>
                        </div>
                        <div class="modal-footer">
                        <br>
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                          <button type="button" id="btnPriceManagement" class="btn btn-success pull-rigth" onClick="priceManagementSubmit();">GUARDAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="employeesJson" value="{{ json_encode($jsonResponse->employees) }}">
                  <div class="modal modal-default fade" id="modal-commission-conf">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center">CREAR COMISIONES A TRABAJADORES</h4>
                        </div>
                          <div class="modal-body" align="left">
                            <div class="form-group" id="searchBar">
                              <input autocomplete="off" type="text" style="padding: 6px 98px"class="form-control" onclick="this.select();" maxlength="50" id="searchProduct" placeholder="Buscador de productos..." value="">
                            </div>
                            <div>
                              <br>
                            </div>
                            <div class='row' align="center">
                              <div style="float: left; padding-left: 110px">PRODUCTOS</div>
                              <div style="float: left; padding-left: 170px">TRABAJADORES</div>
                              <div style="float: left; padding-left: 90px">COMISIONES</div>
                              <div style="float: left; padding-left: 40px">OPCIONES</div>
                            </div>
                            <div class='row' align="center">
                              <div style="float: left" id="commisionProducts"></div>
                              <div style="float: left; padding-left: 20px" id="commisionEmployees"></div>
                              <div style="float: left; padding-left: 10px" id="commisionDetails"></div>
                              <div style="float: left; padding-left: 10px" id="commisionOptions"></div>
                            </div>
                          </div>
                        <div class="modal-footer">
                        <br>
                          <button type="button" onClick="commissionDeleteAll();" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                          <button id="submitButton" type="button" onClick="commissionSubmit();" class="btn btn-success pull-right">GUARDAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-default fade" id="modal-area-product">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center">MANEJAR ÁREAS DE PRODUCTO</h4>
                        </div>
                          <div class="col-sm-12 modal-body" align="center">
                            <div class="col-sm-12">
                              <!-- ALMACENES/TIENDAS -->
                              <label id="areaProductLabelName">PRODUCTO: </label>
                            </div>
                            <div class="col-sm-6">
                              <label>TIENDA DE DESTINO</label>
                              <br>
                              <input type="hidden" id="warehouseIdArea" value="{{ $jsonResponse->warehouseId }}">
                              <select id="warehouseDestinyArea" class="form-control">
                                @foreach ($jsonResponse->warehouses as $object)
                                  @if($object->id !== 0)
                                    @if($object->id === $jsonResponse->warehouseId)
                                      <option selected value="{{ $object->id }}">{{ $object->name }}</option>
                                    @else
                                      <option value="{{ $object->id }}">{{ $object->name }}</option>
                                    @endif
                                  @endif
                                @endforeach
                              </select>
                            </div>
                            <div class="col-sm-6">
                              <!-- AREAS -->
                              <label>ÁREA DE DESTINO</label>
                              <br>
                              <select id="areaId" class="form-control">
                                @foreach ($jsonResponse->areas as $object)
                                  <option value="{{ $object->id }}">{{ $object->name }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                            <button type="button" id="btnAreaProduct" class="btn btn-success pull-rigth" onClick="areaProductSubmit()">GUARDAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-default fade" id="modal-ecommerce">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center" id="ecommerceProductLabel">CONFIGURACION ECOMMERCE DE PRODUCTO</h4>
                        </div>
                        <div class="modal-body" align="center">
                          <br>
                          <!-- ALMACENES/TIENDAS -->
                          <label>TIENDA VIRTUAL</label>
                          <br>
                          <input type="hidden" id="warehouseEcommerceId" value="{{ $jsonResponse->warehouseId }}">
                          <select id="warehouseEcommerceDestiny" class="form-control">
                            <option value="1153">rebelsclo.com</option>
                            <option value="1153">mehperu.com</option>
                          </select>
                          <button type="button" class="btn btn-success" id="btnWarehouseEcommerce" onClick="searchEcommerceByWarehouse();">CARGAR</button>
                          <br>
                          <br>
                          <br>
                          <table class="table" id="tablePriceList">
                            <thead>
                              <tr>
                                <td>LLAVE</td>
                                <td>VALOR</td>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td>ID DE PRODUCTO</td>
                                  <td><input onClick="this.select();" type="number" id="ecommerce_productId" style="width:100%;" class="form-class" value="0"></td>
                                </tr>
                                <tr>
                                  <td>ID DE VARIANTE</td>
                                  <td><input onClick="this.select();" type="number" id="ecommerce_variantId" style="width:100%;" class="form-class" value="0"></td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                            <button type="button" id="btnPricelist" class="btn btn-success pull-rigth" data-dismiss="modal" onClick="updateEcommerceSubmit()">ACTUALIZAR Y GUARDAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="modal-product-detail">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header" align="center">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="productDetailHeader">DETALLE DE PRODUCTO</h4>
                              </div>
                              <div class="col-md-12" style="padding:10px;">
                                  <blockquote>
                                      <p id="productDetailDescription"></p>
                                  </blockquote>
                                  <div class="col-md-5">
                                      <label for="">CÓDIGO DE PRODUCTO</label>
                                      <p id="productDetailCode"></p>
                                      <label for="">CÓDIGO DE BARRA</label>
                                      <p id="productDetailAutoBarCode"></p>
                                      <label for="">CATEGORÍA</label>
                                      <p id="productDetailCategory"></p>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="">MODELO</label>
                                      <p id="productDetailModel"></p>
                                      <label for="">MARCA</label>
                                      <p id="productDetailBrand"></p>
                                  </div>
                                  <div class="col-md-4">
                                      <img id="productDetailImage" src="/img/new_ic_logo_short.png" style="height:150px;" height="150px"/>
                                  </div>
                                  <div class="col-md-12" align="center">
                                  <hr>
                                      <table class="table">
                                          <thead>
                                              <tr>
                                                  <th>ALMACÉN</th>
                                                  <th>UBICACIÓN</th>
                                                  <th>STOCK</th>
                                                  <th>P.UNITARIO</th>
                                                  <th>CANTIDAD</th>
                                                  <th>P.XMAYOR</th>
                                                  <th>P.MIN</th>
                                                  <th>P.MAX</th>
                                              </tr>
                                          </thead>
                                          <tbody id="productDetailStockPriceListTBody">
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <br>
                                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
                              </div>
                          </div>
                          <!-- /.modal-content -->
                      </div>
                  </div>
                  <div class="modal modal-default fade bd-example-modal-lg" id="modal-edit-product">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center">ACTUALIZAR PRODUCTO</h4>
                        </div>
                        <div class="modal-body" align="center">
                          <div class="col-md-12">
                            <div class="col-md-6">
                              <div class="box box-primary">
                                <div class="box-body">
                                  <div class="col-md-12">
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <label for="productCode">CÓDIGO INTERNO</label>
                                      <input class="form-control" id="productCode" name="productCode" placeholder="Código de producto" maxlength="25" value=""/>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <label for="productAutoBarCode">CÓDIGO DE BARRAS</label>
                                      <input class="form-control" id="productAutoBarCode" name="productAutoBarCode" placeholder="Código de barras" maxlength="25" value=""/>
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <br>
                                    <label for="productImage">IMAGEN </label>
                                    <input type="file" style="width:100%;" class="form-control" id="productImage" name="productImage" accept=".jpg, .jpeg, .png">
                                  </div>
                                  <div class="col-md-12">
                                    <br>
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <label for="productName">NOMBRE DEL PRODUCTO</label>
                                      <input class="form-control" style="width:100%;" id="productName" name="productName" placeholder="Ingrese un nombre para el producto" maxlength="250" value=""/>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <label for="productForeignName">NOMBRE EXTRANJERO</label>
                                      <input class="form-control" style="width:100%;" id="productForeignName" name="productForeignName" placeholder="Ingrese un nombre extranjero para el producto" maxlength="250" value=""/>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                        <br>
                                        <label for="productCategory">CATEGORÍA</label>
                                        <select style="width:100%;" name="productCategory" id="productCategory" class="form-control">
                                          @foreach ($jsonResponse->categoriesU as $object)
                                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                        <br>
                                        <label for="productBrand">MARCA</label>
                                        <select style="width:100%;" name="productBrand" id="productBrand" class="form-control">
                                          @foreach ($jsonResponse->brands as $object)
                                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <br>
                                    <label for="productModel">MODELO DEL PRODUCTO</label>
                                    <input class="form-control" id="productModel" name="productModel" placeholder="Ingrese un modelo para el producto" maxlength="250" value="" style="width:100%;" />
                                  </div>
                                  <div class="form-group col-md-12">
                                    <br>
                                    <label for="productDescription">DESCRIPCIÓN DEL PRODUCTO</label>
                                    <input class="form-control" style="width:100%;" id="productDescription" name="productDescription" placeholder="Ingrese una descripción para el producto" maxlength="250" value=""/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="box box-primary">
                                <div class="box-body">
                                  <div class="col-md-12">
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                        <label for="allotmentType">GESTIÓN DE ARTÍCULO</label>
                                        <select style="width:100%;" name="allotmentType" id="allotmentType" class="form-control">
                                          <option value="0">GESTIÓN LIBRE</option>
                                          <option value="1">GESTIÓN POR LOTES</option>
                                          <option value="2">GESTIÓN POR SERIES</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                        <label for="productTaxExemptionReasonCode">AFECTACIÓN DEL IGV</label>
                                        <select style="width:100%;" name="productTaxExemptionReasonCode" id="productTaxExemptionReasonCode" class="form-control">
                                          <option value="10">Gravado - Operación Onerosa</option>
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
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                        <br>
                                        <label for="productUnity">TIPO DE OPERACIÓN</label>
                                        <select style="width:100%;" name="productTypeOperation" id="productTypeOperation" class="form-control">
                                            <option value="1">COMPRA</option>
                                            <option value="2">VENTA</option>
                                            <option value="3">COMPRA/VENTA</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                        <br>
                                        <label for="productType">TIPO DE ITEM</label>
                                        <select style="width:100%;" name="productType" id="productType" class="form-control">
                                          <option value="2">NO INVENTARIABLE</option>
                                          <option value="1">INVENTARIABLE</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                      <br>
                                        <label for="productPriceCost">PRECIO COSTO</label>
                                        <input type="number" onClick="this.select();" style="width:100%;" min="0" max="9999999" class="form-control" id="productPriceCost" name="productPriceCost" placeholder="INGRESE PRECIO COSTO" value="0.00">
                                      </div>
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                        <br>
                                        <label for="productFlagUniversalPromo">PROMOCIÓN UNIVERSAL</label>
                                        <select style="width:100%;" name="productFlagUniversalPromo" id="productFlagUniversalPromo" class="form-control">
                                          <option value="1">SÍ</option>
                                          <option value="0">NO</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                      <br>
                                        <label for="productMinPrice">PRECIO MÍNIMO</label>
                                        <input type="number" value="" min="0" max="9999999" class="form-control" id="productMinPrice" name="productMinPrice" placeholder="Ingrese precio mínimo" style="width:100%;" onCLick="this.select();">
                                      </div>
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;">
                                      <div class="form-group">
                                      <br>
                                        <label for="productMaxPrice">PRECIO MÁXIMO</label>
                                        <input type="number" value="" min="0" max="9999999" class="form-control" id="productMaxPrice" name="productMaxPrice" placeholder="Ingrese precio máximo" style="width:100%;" onCLick="this.select();">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <br>
                                      <label for="productCurrency">MONEDA POR DEFECTO</label>
                                      <select style="width:100%;" name="productCurrency" id="productCurrency" class="form-control">
                                        <option value="USD">USD ($)</option>
                                        <option value="PEN">PEN (S/)</option>
                                      </select>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <br>
                                      <label for="productUnity">UNIDAD</label>
                                      <select style="width:100%;" name="productUnity" id="productUnity" class="form-control">
                                        @foreach ($jsonResponse->units as $object)
                                          <option value="{{ $object->id }}">{{ $object->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <br>
                                      <label for="productWeight">PESO (Kg)</label>
                                      <input type="number" value="" min="0" max="9999999" class="form-control" id="productWeight" name="productWeight" placeholder="Ingrese peso en Kg" style="width:100%;">
                                    </div>
                                    <div class="form-group col-md-6" style="padding-left: 0px;">
                                      <br>
                                      <label for="productFlagActive">ESTADO</label>
                                      <select style="width:100%;" name="productFlagActive" id="productFlagActive" class="form-control">
                                        <option value="1">ACTIVO</option>
                                        <option value="0">INACTIVO</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>
                          <button type="button" id="btnEditProduct" class="btn btn-success pull-rigth" onClick="editProductSubmit()">ACTUALIZAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-default fade" id="modal-serials">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">SERIES DE PRODUCTO</h4>
                        </div>
                        <div class="modal-body">
                          <table class="table">
                            <thead>
                              <th>SERIE</th>
                              <th>IMEI</th>
                            </thead>
                            <tbody id="tBodySerials">
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">REGRESAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
					</div>
				</div>
			</div>
      <div class="modal fade" id="modal-on-load">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header" align="center">
                      <h1 class="modal-title">Estamos procesando su información. Por favor, espere...</h4>
                  </div>
              </div>
          </div>
      </div>
      <div id="loadingDivCustomer" class="col-sm-12" align="center" style="display: none;">
        <div class="box-header">
          <h3 class="box-title">Cargando ...</h3>
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- end loading -->
      </div>
		</div>
	</div>
@endsection
