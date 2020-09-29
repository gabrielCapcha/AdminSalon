@extends('products.partials.app_products-movement')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_management')
active
@endsection

@section('sidebar_products_movement')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_movement') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_movement') }}
@endsection

@section('contentheader_description')
  <a href="/products-movement">CAMBIAR DE CATEGORÍA</a>
@endsection

@section('main-content')
	<div class="row">
		<div class="row">
            <div class="col-md-12">
                <input type="hidden" id="categoryId" value="{{ $jsonResponse->categoryId }}">
                <input type="text" placeholder="BUSCADOR DE PRODUCTOS..." class="form-control" id="searchInput" maxlength="50"/>
                <br>
            </div>
			<div class="col-md-12">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Homes</div> -->
					<div class="panel-body">
                        <!-- /.box-header -->
                        <div class="box-body withscroll">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div>
                                        <input type="hidden" id="warehousesJson" value="{{ json_encode($jsonResponse->warehouses) }}">
                                        <table id="inventoryData" class="table table-bordered table-striped table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>FECHA CREACIÓN</th>
                                                    <th>{{ trans('message.name') }}</th>
                                                    <th>{{ trans('message.code') }}</th>
                                                    <th>C.BARRAS</th>
                                                    <th>MONEDA</th>
                                                    <th>PRECIO GENERAL</th>
                                                    <th>PRECIO UNITARIO</th>
                                                    <th>CANTIDAD XMAYOR</th>
                                                    <th>PRECIO X MAYOR</th>
                                                    <th>PRECIO COSTO</th>
                                                    <th>PRECIO MÍNIMO</th>
                                                    <th>PRECIO MÁXIMO</th>
                                                    <th>SERIES</th>
                                                    @foreach ($jsonResponse->warehouses as $object)
                                                    <th>{{ $object->name }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody style="font-size:12px" id="tBodyData">
                                                @foreach ($jsonResponse->products as $object)
                                                    <tr>
                                                        <td>{{ $object->created_at }}</td>
                                                        <td style="cursor:pointer;" onClick="changeTdName({{ $object->id }});" id="tdName_{{ $object->id }}">{{ $object->name }}</td>
                                                        <td>{{ $object->code }}</td>
                                                        <td>{{ $object->auto_barcode }}</td>
                                                        <td style="cursor:pointer;" onClick="changeTdCurrency({{ $object->id }});" id="tdCurrency_{{ $object->id }}">{{ $object->currency }}</td>
                                                            <td style="cursor:pointer;" onClick="changeTdGeneralPrice({{ $object->id }});" id="tdGeneralPrice_{{ $object->id }}">{{ $object->price }}</td>
                                                            <td style="cursor:pointer;" onClick="changeTdUnitPrice({{ $object->id }});" id="tdUnitPrice_{{ $object->id }}">EDITAR</td>
                                                            <td style="cursor:pointer;" onClick="changeTdWholeSaleQuantity({{ $object->id }});" id="tdWholeSaleQuantity_{{ $object->id }}">EDITAR</td>
                                                            <td style="cursor:pointer;" onClick="changeTdWholeSalePrice({{ $object->id }});" id="tdWholeSalePrice_{{ $object->id }}">EDITAR</td>
                                                        <td style="cursor:pointer;" onClick="changeTdPCost({{ $object->id }});" id="tdPCost_{{ $object->id }}">{{ $object->price_cost }}</td>
                                                        <!-- MIN PRICE -->
                                                        <td style="cursor:pointer;" onClick="changeTdMinPrice({{ $object->id }});" id="tdMinPrice_{{ $object->id }}">{{ (is_null($object->min_price) ? 0.00 : $object->min_price) }}</td>
                                                        <!-- <td>
                                                            <input type="number" onClick="this.select();" step="0.1" value="{{ (is_null($object->min_price) ? 0.00 : $object->min_price) }}" id="minPrice_{{ $object->id }}">
                                                            <button class="info" onClick="updateMinPrice({{ $object->id }});" id="btnMinPrice_{{ $object->id }}"><i class="fa fa-check"></i></button>
                                                        </td> -->
                                                        <!-- MAX PRICE -->
                                                        <td style="cursor:pointer;" onClick="changeTdMaxPrice({{ $object->id }});" id="tdMaxPrice_{{ $object->id }}">{{ (is_null($object->max_price) ? 0.00 : $object->max_price) }}</td>
                                                        <!-- <td>
                                                            <input type="number" onClick="this.select();" step="0.1" value="{{ (is_null($object->max_price) ? 0.00 : $object->max_price) }}" id="maxPrice_{{ $object->id }}">
                                                            <button class="info" onClick="updateMaxPrice({{ $object->id }});" id="btnMaxPrice_{{ $object->id }}"><i class="fa fa-check"></i></button>
                                                        </td> -->
                                                        <td>
                                                            <input type="hidden" value="{{ json_encode($object->serials) }}" id="serials_{{ $object->id }}"><span></span>
                                                            <button class="default" onClick="serialManagement({{ $object->id }});" id="btnSerials_{{ $object->id }}">{{ count($object->serials) }} <i class="fa fa-key"></i></button>
                                                        </td>
                                                        @foreach ($object->warehousesDetail as $objectW)
                                                            @if (!is_null($objectW->id))
                                                                <!-- WAREHOUSE PRODUCT STOCK -->
                                                                <td style="cursor:pointer;" onClick="changeWPStock({{ $objectW->id }})" id="tdWPStock_{{ $objectW->id }}">{{ $objectW->stock }}</td>
                                                                <!-- <input type="number" onClick="this.select();" step="0.1" value="{{ $objectW->stock }}" id="wPStock_{{ $objectW->id }}">
                                                                <button class="info" onClick="updateWPStock({{ $objectW->id }});" id="btnWPStock_{{ $objectW->id }}"><i class="fa fa-check"></i></button> -->
                                                            @else
                                                                <td style="cursor:no-drop;">{{ $objectW->stock }}</td>
                                                                <!-- <input readonly type="number" onClick="this.select();" step="0.1" value="{{ $objectW->stock }}" id="wPStock_{{ $objectW->id }}">
                                                                <button disabled class="info" onClick="updateWPStock({{ $objectW->id }});" id="btnWPStock_{{ $objectW->id }}"><i class="fa fa-check"></i></button> -->
                                                            @endif
                                                        @endforeach
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
                </div>
            </div>
            <!--MODALS-->
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
                            <th>TIENDA</th>
                            <th>SERIE</th>
                            <th>IMEI</th>
                            <th>TIPO DE GARANTÍA</th>
                            <th>TIEMPO DE GARANTÍA</th>
                            <th>OPCIONES</th>
                        </tr>
                        </thead>
                        <tbody id="tableSerialResumeBodyNew">
                            <tr>
                                <td>
                                    <select class="form-control" id="warWarehousesId">
                                        @foreach ($jsonResponse->warehouses as $object)
                                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Ingrese serie" id="serial">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Ingrese imei" id="imei">
                                </td>
                                <td>
                                    <select class="form-control" id="typeWarranty">
                                        <option selected value="1">DÍAS</option>
                                        <option value="2">MESES</option>
                                        <option value="3">AÑOS</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control" style="width:100%;" placeholder="Ingrese cantidad" id="warranty">
                                </td>
                                <td>
                                    <button id="btnNewSerial" onClick="newSerial();" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody id="tableSerialResumeBody">
                        </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                    <button type="button" onClick="closeModal();" class="btn btn-outline pull-right">CERRAR</button>
                    </div>
                </div>
                </div>
            </div>
		</div>
	</div>
@endsection
