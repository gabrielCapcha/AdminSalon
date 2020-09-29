@extends('products.partials.app_recipies')

@section('sidebar_products')
  active
@endsection

@section('sidebar_recipies')
  active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_recipies') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_recipies') }}
@endsection

@section('contentheader_description')
	{{ trans('message.sidebar_recipies_description') }}
@endsection

@section('main-content')
  <div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
            <div class="box-body" style="margin: 10px;">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12" align="center">
                    <!-- CATEGORÍA -->
                    <select id="categoryId" class="form-control">
                      <option value="0">CATEGORÍAS</option>
                      @foreach ($jsonResponse->categories as $object)
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
                          <th>CATEGORÍA</th>
                          <th>CÓDIGO</th>
                          <th>OPERACIÓN</th>
                          <th>C.BARRAS</th>
                          <th>NOMBRE</th>
                          <th>DESCRIPCIÓN</th>
                          <th>RECETA</th>
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
                          <input class="form-control" id="deleteSaleComment" size="50" type="text" maxlength="100" placeholder="Escriba un motivo..." />
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">CANCELAR</button>
                            <button type="button" onClick="deleteSaleSubmit()" class="btn btn-outline">ACEPTAR</button>
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
                  <div class="modal fade bd-example-modal-lg" id="modal-product-recipie">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header" align="center">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="productRecipieHeader">RECETAS DE PRODUCTO</h4>
                              </div>
                              <div class="col-md-12" style="padding:10px;">
                                <div id="mainheaderSearchBar" style="position:relative;" class="col-md-12" align="center">
                                    <input type="text" class="form-control" onclick="this.select();" maxlength="50" id="searchProduct" placeholder="Buscador de productos..." style="width:100%;">
                                </div>
                                <div class="col-md-12" align="center">
                                <hr>
                                    <table class="table" style="font-size:12px;">
                                        <thead>
                                            <tr>
                                                <th>CATEGORÍA</th>
                                                <th>CÓDIGO</th>
                                                <th>OPERACIÓN</th>
                                                <th>C.BARRAS</th>
                                                <th>NOMBRE</th>
                                                <th>UNIDAD</th>
                                                <th>CANTIDAD</th>
                                                <th>OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productRecipiesTBody">
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
                </div>
              </div>
            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
