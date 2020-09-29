@extends('adminlte::layouts.app_products_outcome')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_management')
active
@endsection

@section('sidebar_products_10')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_10') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_10') }}
@endsection

@section('contentheader_description')	
  {{ trans('message.new-products-outcome') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Homes</div> -->
					<div class="panel-body">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12">
                    <!-- LECTOR -->
                    <div class="col-md-4" style="position:relative;z-index:1;">
                      <input type="text" class="form-control pull-left" size="25" placeholder="Lector de códigos..." id="searchProductAutoBarCode" style="width:100%">
                    </div>
                    <!-- BUSCADOR -->
                    <div class="col-md-4" id="mainheaderSearchBar" style="position:relative;z-index:1;">
                      <input type="text" class="form-control pull-left" size="25" placeholder="Buscar producto..." id="searchProduct" style="width:100%">
                    </div>
                    <!-- ALMACENES/TIENDAS -->
                    <div class="col-md-4">
                      <input type="hidden" id="priceLists" value="{{ json_encode($jsonResponse->priceLists) }}" />
                      <select id="warehouseId" class="form-control" style="width:100%">
                        @foreach ($jsonResponse->warehouses as $object)
                          @if ($jsonResponse->warehouseId === $object->id)
                            <option selected value="{{ $object->id }}">{{ $object->name }}</option>
                          @else
                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <hr>
                    <!-- ALMACENES/TIENDAS -->
                    <div class="col-md-4">
                      <select id="typeKardexMovementId" class="form-control" style="width:100%">
                        <option selected value="SMI">SALIDA GENERAL</option>
                        <option value="SMM">SALIDA POR MERMA</option>
                        <option value="SMV">SALIDA POR VENTA</option>
                      </select>
                    </div>
                    <!-- ALMACENES/TIENDAS -->
                    <div class="col-md-4">
                      <select id="userId" class="form-control" style="width:100%">
                        @foreach ($jsonResponse->employees as $object)
                          @if ($jsonResponse->userId === $object->id)
                            <option selected value="{{ $object->id }}">{{ $object->name }} {{ $object->lastname }}</option>
                          @else
                            <option value="{{ $object->id }}">{{ $object->name }} {{ $object->lastname }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <!-- comentario -->
                    <div class="col-md-4">
                      <input type="text" class="form-control pull-left" size="25" placeholder="Ingrese un comentario..." id="commentary" style="width:100%">
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- BOTÓN -->
                    <br>
                    <button id="saveButton" onClick="validateInventory();" class="btn btn-block btn-danger">VALIDAR</button>
                    <br>
                  </div>
                  <div class="col-sm-12">
                    <table id="inventoryData" class="table table-bordered table-striped table-responsive">
                      <thead>
                        <tr>
                          <th>{{ trans('message.name') }}</th>
                          <th>MARCA</th>
                          <th>C.BARRAS</th>
                          <th>{{ trans('message.code') }}</th>
                          <th>UNIDAD</th>
                          <th>{{ trans('message.stock') }}</th>
                          <th>{{ trans('message.quantity') }}</th>
                          <th>{{ trans('message.options') }}</th>
                        </tr>
                      </thead>
                      <tbody style="font-size:12px" id="tBodyData">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
					</div>
          <!--MODALS-->
          <div class="modal fade" id="modal-resume">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Resumen de registro de inventariado</h4>
                </div>
                <div class="col-md-12" id="productsResume" style="padding:10px;">
                </div>
                <div class="modal-footer">
                  <button type="button" onClick="goToProducts();" class="btn btn-success pull-right" data-dismiss="modal">Historial de movimientos</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal modal-primary fade" id="modal-allotment">
              <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                    <h4 align="center" class="modal-title" id="allotmentModalTitle">Asignación de Lotes a producto: </h4>
                    <h4 align="center" class="modal-title"><strong>Presione el botón VALIDAR CANTIDADES para agregar el registro</strong></h4>
                  </div>
                  <div class="modal-body-5" id="allotmentResume">
                  <table id="tableAllotmentProduct" class="table">
                      <thead>
                      <tr>
                          <th>PRODUCTO</th>
                          <th>LOTE</th>
                          <th>CANTIDAD</th>
                          <th>DISPONIBLE</th>
                          <th>INGRESO</th>
                          <th>FECHA EXPIRACIÓN</th>
                      </tr>
                      </thead>
                      <tbody id="tableAllotmentProductBody">
                      </tbody>
                  </table>
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                  <button type="button" onClick="allotmentValidation();" class="btn btn-default">Validar cantidades</button>
                  <button type="button" id="allotmentButtonSubmit" disabled onClick="allotmentSubmit();" class="btn btn-outline pull-right" data-dismiss="modal">Guardar</button>
                  </div>
              </div>
              </div>
          </div>
          <div class="modal modal-primary fade" id="modal-serial">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                  <h4 align="center" id="productSerialDetail" class="modal-title">Asignación de Series</h4>
                  </div>
                  <div class="modal-body-5" id="serialResume">
                  <table id="tableSerialResume" class="table">
                      <thead>
                          <th>OPCIÓN</th>
                          <th>SERIE</th>
                          <th>IMEI</th>
                      </thead>
                      <tbody id="tableSerialResumeBody">
                      </tbody>
                  </table>
                  </div>
                  <div class="modal-footer">
                      <button type="button" data-dismiss="modal" class="btn btn-outline pull-left">CANCELAR</button>
                      <button type="button" id="btnSerialSubmit" onClick="validateSerialSubmit();" class="btn btn-outline pull-right">VALIDAR</button>
                  </div>
              </div>
            </div>
          </div>
				</div>
			</div>
		</div>
	</div>
@endsection
