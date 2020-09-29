@extends('products.partials.app_products_income_from_purchase')

@section('sidebar_products')
active
@endsection

@section('sidebar_products_2')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_2') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_2') }}
@endsection

@section('contentheader_description')	
  NUEVO INGRESO DE MERCADERÍA DESDE COMPRA
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
                    <input type="hidden" id="purchaseItems" value="{{ json_encode($jsonResponse->items_for_income) }}">
                    <input type="hidden" id="purchaseId" value="{{ $jsonResponse->id }}">
                    <!-- LECTOR -->
                    <div class="col-md-4" style="position:relative;z-index:1;">
                      <input type="text" readonly class="form-control pull-left" size="25" style="width:100%;" placeholder="Lector de códigos..." id="searchProductAutoBarCode">
                    </div>
                    <!-- BUSCADOR -->
                    <div class="col-md-4" id="mainheaderSearchBar" style="position:relative;z-index:1;">
                      <input type="text" readonly class="form-control pull-left" size="25" style="width:100%;" placeholder="Buscar producto..." id="searchProduct">
                    </div>
                    <!-- ALMACENES/TIENDAS -->
                    <div class="col-md-4">
                      <!-- LISTA DE PRECIOS -->
                      <input type="hidden" id="priceLists" value="{{ json_encode($jsonResponse->priceLists) }}" />
                      <select id="warehouseId" class="form-control" style="width:100%" onChange="callStockProducts();" readonly>
                        <option value="{{ $jsonResponse->war_warehouses_id }}">{{ $jsonResponse->warehouse_name }}</option>
                      </select>
                    </div>
                    <hr>
                    <!-- SERIE -->
                    <div class="col-md-4">
                      <input type="text" readonly value="{{ $jsonResponse->purchase_serie }}" class="form-control pull-left" size="25" style="width:100%;" placeholder="Ingrese serie de compra" maxlength="4" id="purchaseSerie">
                    </div>
                    <!-- NUMERO -->
                    <div class="col-md-4">
                      <input type="number" readonly value="{{ $jsonResponse->purchase_number }}" class="form-control pull-left" size="25" style="width:100%;" placeholder="Ingrese correlativo de compra" maxlength="8" id="purchaseNumber">
                    </div>
                    <!-- PROVEEDOR -->
                    <div class="col-md-4" id="mainheaderSearchBarSupplier" style="position:relative;z-index:1;">
                        @if ((int)$jsonResponse->suppliers_flag_type_person === 2)
                            <input type="text" readonly value="{{ $jsonResponse->suppliers_rz_social }}" class="form-control pull-left" size="25" style="width:100%;" placeholder="Buscar proveedor..." id="supplierId" onClick="this.select();" autocomplete="off">
                        @else
                            <input type="text" readonly value="{{ $jsonResponse->suppliers_name }} {{ $jsonResponse->suppliers_lastname }}" class="form-control pull-left" size="25" style="width:100%;" placeholder="Buscar proveedor..." id="supplierId" onClick="this.select();" autocomplete="off">
                        @endif
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <!-- BOTÓN -->
                    <br>
                      <button id="saveButton" onClick="validateIncome();" class="btn btn-block btn-danger">PRESIONE AQUÍ PARA VALIDAR INGRESO <br> <b>PRECIO COSTO TOTAL: S/ 0.00<b></button>
                    <br>
                    <table id="inventoryData" class="table table-bordered" style="height:350px; width:100%;">
                      <thead>
                        <tr>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">{{ trans('message.name') }}</th>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">C.BARRAS</th>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">{{ trans('message.code') }}</th>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">{{ trans('message.quantity') }}</th>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">{{ trans('message.location') }}</th>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">STOCK MÍNIMO</th>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">P.COSTO UNITARIO</th>
                          <th style="vertical-align: top; /*background:#1e282c; color:white;*/">{{ trans('message.options') }}</th>
                        </tr>
                      </thead>
                      <tbody style="font-size:12px" id="tBodyData">
                        @foreach ($jsonResponse->items_for_income as $items_for_income)
                            <tr>
                                <td style="vertical-align: middle;">{{ $items_for_income->product->name }}</td>
                                <td style="vertical-align: middle;">{{ $items_for_income->product->auto_barcode }}</td>
                                <td style="vertical-align: middle;">{{ $items_for_income->product->code }}</td>
                                <td style="vertical-align: middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="quantity_{{ $items_for_income->war_products_id }}" type="number" value="{{ (float)$items_for_income->quantity - (float)$items_for_income->quantity_dispatch }}" /></td>
                                <td style="vertical-align: middle;"><input class="form-control" onClick="this.select();" id="location_{{ $items_for_income->war_products_id }}" type="text" value="" placeholder="¿Ub.física?" style="width:100%;"/></td>
                                <td style="vertical-align: middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="minStock_{{ $items_for_income->war_products_id }}" type="number" value="0" /></td>
                                <td style="vertical-align: middle;"><input class="form-control" style="width:75px;" onClick="this.select();" id="priceUnitCost_{{ $items_for_income->war_products_id }}" type="number" value="{{ (float)$items_for_income->price }}" step="0.1" readonly/></td>
                                <td style="vertical-align: middle;">
                                @if ($items_for_income->product->allotment_type == 1) {
                                  <button style="padding-left: 4px; padding-right: 4px;" type="button" onclick="openAllotmentModal({{ $items_for_income->war_products_id }});" class="btn btn-primary btn-flat"><i class="fa fa-cubes"></i></button><span> </span>
                                @elseif ($items_for_income->product->allotment_type == 2) {
                                  <button style="padding-left: 4px; padding-right: 4px;" type="button" onclick="openSerialModal({{ $items_for_income->war_products_id }});" class="btn btn-success btn-flat"><i class="fa fa-key"></i></button><span> </span>
                                @else
                                  SIN OPCIONES
                                @endif
                                </td>
                            </tr>
                        @endforeach
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
                  <button type="button" onClick="goToAllotments();" class="btn btn-primary pull-left" data-dismiss="modal">Registro de lotes</button>
                  <button type="button" onClick="goToSerials();" class="btn btn-primary pull-left" data-dismiss="modal">Registro de series</button>
                  <button type="button" onClick="goToProducts();" class="btn btn-success pull-right" data-dismiss="modal">Historial de movimientos</button>
                  <button type="button" onClick="goToPurchases();" class="btn btn-success pull-right" data-dismiss="modal">Historial de compras</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal modal-primary fade" id="modal-allotment">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 align="center" class="modal-title">Asignación de Lotes</h4>
                  <h4 align="center" class="modal-title"><strong>Presione la tecla ENTER para agregar el registro</strong></h4>
                </div>
                <div class="modal-body-5" id="allotmentResume">
                  <table id="tableAllotmentResume" class="table">
                    <thead>
                      <tr>
                        <th>PRODUCTO</th><th>LOTE</th><th>CANTIDAD</th><th>FECHA EXPIRACIÓN</th>
                      </tr>
                    </thead>
                    <tbody id="tableAllotmentResumeBody">
                      <tr>
                        <td id="productAllotmentDetail"> - </td>
                        <td><input id="allotmentCode_0" maxlength="10" type="text" class="form-control" placeholder="Código de lote"></td>
                        <td><input id="allotmentQuantity_0" type="number" class="form-control" placeholder="Cantidad" style="width:100%;"></td>
                        <td><input id="allotmentExpirationDate_0" type="date" class="form-control"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" onClick="allotmentSubmit();" class="btn btn-outline pull-right" data-dismiss="modal">Guardar</button>
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
                      <tr>
                        <th>SERIE</th>
                        <th>IMEI</th>
                        <th>TIPO DE GARANTÍA</th>
                        <th>TIEMPO DE GARANTÍA</th>
                      </tr>
                    </thead>
                    <tbody id="tableSerialResumeBody">
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer">
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
