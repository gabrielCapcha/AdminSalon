@extends('sales.partials.app_pay_quotations')

@section('sidebar_payments')
active
@endsection
@section('sidebar_pay_quotations')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_pay_quotations') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_pay_quotations') }}
@endsection
@section('contentheader_description')
    {{ trans('message.sidebar_pay_quotations_description') }}
@endsection

@section('main-content')
	
<div class="row">
	<div class="col-md-4 new-sale-custom-left-total">
		<div class="form-group col-md-12">
			<br>
			<label>AGREGAR VENTAS AL CRÉDITO</label>
			<br>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-calendar"></i>
				</div>
				<input type="text" class="form-control pull-left" size="22" id="dateRange" autocomplete="off">
			</div>
			<br>
			<button class="btn btn-danger" id="searchSaleForm" onClick="searchSaleForm();" style="width:100%;">BUSCAR COTIZACIONES</button>
		</div>
		<div class="form-group col-md-12">
			<br>
			<label>ESCOGER TIPOS DE PAGO</label>
			<br>
			<input type="hidden" id="genericCustomer" value="{{ json_encode($jsonResponse->genericCustomer) }}">
			<input type="hidden" id="companyLoginData" value="{{ json_encode($jsonResponse->companyLoginData) }}">
			@if (isset($jsonResponse->saleJson))
				<input type="hidden" id="saleJson" value="{{ json_encode($jsonResponse->saleJson) }}" />
			@endif
			<!-- Default checked -->
			<img id="typePayment_1" onclick="typePayments(1);" class="payment-1-selected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
			<img id="typePayment_2" onclick="typePayments(2);" class="payment-2-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
			<img id="typePayment_3" onclick="typePayments(3);" class="payment-3-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
			<img id="typePayment_6" onclick="typePayments(6);" class="payment-6-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
			<img id="typePayment_8" onclick="typePayments(8);" class="payment-8-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
			<img id="typePayment_9" onclick="typePayments(9);" class="payment-9-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
		</div>
		<div class="form-group col-md-12">
			<br>
			<label>CONFIGURACIONES ADICIONALES DE VENTA</label>
			<br>
			<button onclick="newSettingsForm();" type="button" title="Opciones adicionales de venta" class="btn btn-primary"><i class="fa fa-gears"></i></button>
			<button onclick="newUserForm();" type="button" title="Crear cliente sin documento" class="btn btn-primary"><i class="fa fa-user-plus"></i></button>
		</div>
		<div class="form-group col-md-12">
			<br>
			<br>
			<br>
			<label>ESCOGER CLIENTE RECEPTOR</label>
			<br>
			<div id="mainheaderSearchBar2">
				<input type="text" autocomplete="off" name="inputSearchClient2" id="inputSearchClient2" class="form-control" placeholder="INGRESE UN CLIENTE">
			</div>
			<br>
			<button class="btn btn-danger" onClick="openTypeDocument();" style="width:100%;">SELECCIONE UN TIPO DE DOCUMENTO</button>
		</div>
	</div>
	<div class="col-md-8 new-sale-custom-right-total">
		<div class="col-md-12" style="margin-top:20px; padding-top:10px; background: #2c3b41;">
			<table class="table">
				<thead class="static-table-head-total">
					<th class="static-table-th-responsive">CLIENTE</th>
					<th class="static-table-th-responsive">CÓDIGO</th>
					<th class="static-table-th-responsive">NOMBRE</th>
					<th class="static-table-th-responsive">PRECIO</th>
					<th class="static-table-th-responsive">CANTIDAD</th>
					<th class="static-table-th-responsive">OPCIÓN</th>
				</thead>
			</table>
		</div>
		<div class="col-md-12" style="margin-top:-20px; background: #2c3b41; height:363px; overflow:auto;">
			<!-- /.box-header -->
			<table id="tableSelectedProducts" class="table">
				<tbody id="tBodyTableSelectedProducts"></tbody>
			</table>
		</div>
		<div class="col-md-12" style="background: #1e282c;">
		<br>
			<div class="keypad" align="center" style="float:none; padding:0px;">
				<div class='keys col-md-12'>
					<div class='row' style="padding-bottom:20px; vertical-align: middle;">
						<button id="genericClient"><i class='fa fa-users'></i></button>
						<button id="priceList" data-toggle="modal" data-target="#modal-price-list"><i class='fa fa-usd'></i></button>
						<button id="buttonTypeDocument" onClick="openTypeDocument();">P</button>
						<button id='keypad-clear' onClick="clearAllSelectedProduct();"><i class='fa fa-trash'></i></button>
						<button onclick="secondStepOfSale();" data-toggle="modal" data-target="#modal-second-step"  class="pay-button">.</button>
					</div>
				</div>
			</div>
		</div>
		<!--MODALS-->
		<div class="modal fade" id="modal-type-document">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 align="center" class="modal-title">Seleccione un tipo de documento</h4>
					</div>
					<div class="modal-body">
						<div align="center" id="typeDocumentsList">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-price-list">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 align="center" class="modal-title">Seleccione una lista de precios</h4>
					</div>
					<div class="modal-body">
						<ul id="priceListUl">
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" id="closePriceListModal" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="modal fade" id="modal-search-client">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Seleccionar cliente</h4>
					</div>
					<div class="col-md-12"  style="padding:10px;">
						<!-- form start -->
						<div class="col-sm-12" id="divCustomerSearchInput">
							<br>
							<div class="input-group">
								<input type="text" class="form-control" maxlength="11" id="searchClientSunat" placeholder="Buscar cliente por DNI, RUC">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-flat" id="searchClientSunatButton">Buscar</button>
								</span>
							</div>
							<br>
						</div>
						<div id="loadingDivCustomer" class="col-sm-12" align="center" style="display: none;">
							<div class="box-header">
								<h3 class="box-title">Cargando ...</h3>
								<i class="fa fa-refresh fa-spin"></i>
							</div>
							<!-- end loading -->
						</div>
						<div class="col-sm-12" id="clientDataResponse">
						</div>
					</div>
					<div class="modal-footer">
						<br>
						<button type="button" id="dismissClient" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
						<button type="button" id="chooseClientOld" class="btn btn-primary" data-dismiss="modal" disabled>Elegir</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="modal fade" id="modal-new-client">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">No se encontró al cliente. ¿Desea agregar uno nuevo?</h4>
					</div>
					<div class="col-md-12"  style="padding:10px;">
						<!-- form start -->
						<div class="col-sm-12" id="divNewCustomerSearchInput">
							<br>
							<div class="input-group">
								<input type="text" class="form-control" maxlength="11" id="searchNewClientSunat" placeholder="Buscar cliente por DNI, RUC">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-flat" id="searchNewClientSunatButton">Buscar</button>
								</span>
							</div>
							<br>
						</div>
						<div id="loadingDivNewCustomer" class="col-sm-12" align="center" style="display: none;">
							<div class="box-header">
								<h3 class="box-title">Cargando ...</h3>
								<i class="fa fa-refresh fa-spin"></i>
							</div>
							<!-- end loading -->
						</div>
						<div class="col-sm-12" id="newClientDataResponse">
						</div>
					</div>
					<div class="modal-footer">
						<br>
						<button type="button" id="dismissNewClient" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
						<button type="button" id="saveNewClient" onClick="this.disabled=true;" class="btn btn-primary" disabled>Guardar</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="modal fade" id="modal-new-client-simple">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">¿Desea agregar un cliente nuevo sin número DNI?</h4>
					</div>
					<div class="col-md-12">
						<!-- form start -->
						<div class="col-sm-12" id="newClientSimpleDataResponse">
						</div>
					</div>
					<div class="modal-footer">
						<br>
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
						<button type="button" id="saveNewSimpleClient" onClick="this.disabled=true; saveNewSimpleClient();" class="btn btn-primary">Guardar</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="modal fade" id="modal-second-step">
			<form id="formSale" method="POST" action="sales">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 align="center" id="totalResumeAmount" class="modal-title"></h4>
						</div>
						<div class="col-md-12">
							<div class="col-md-12" align="center">
								<br>
								<p id="clientName"></p>
							</div>
							<div class="col-md-6">
								<div class="modal-body">
									<!-- TABLA DE PRODUCTOS -->
									<label>Detalle de productos</label>
									<table class="table static-table-body-summary">
										<thead>
											<tr>
												<th>Código</th>
												<th>Nombre</th>
												<th>Precio</th>
												<th>Cant.</th>
											</tr>
										</thead>
										<tbody id="tBodyTableProductsSummary"></tbody>
									</table>
									<!-- TABLA DE PRODUCTOS -->
								</div>
							</div>
							<div class="col-md-6">
								<div class="modal-body">
									<!-- TABLA DE PRODUCTOS -->
									<label>Cotizaciones afectadas</label>
									<table class="table static-table-body-summary">
										<thead>
											<tr>
												<th>Ticket</th>
												<th>Fecha</th>
												<th>Productos</th>
												<th>Afectados</th>
											</tr>
										</thead>
										<tbody id="tBodyTableQuotationSummary"></tbody>
									</table>
									<!-- TABLA DE PRODUCTOS -->
								</div>
							</div>
							<div class="col-md-6" style="display:none;">
								<div class="modal-body">
									<!-- TABLA DE PAGOS -->
									<label>Servicio</label>
									<table class="table" style="margin-bottom:0px;">
										<tbody id="tBodyTableServicesSummary">
											<tr>
												<td width="50%"> {{ $jsonResponse->service_percent }} % <input type="hidden" id="servicePercentValue" value="{{ $jsonResponse->service_percent }}"></td>
												<td><input type="number" class="form-control" readonly style="width: 100px;" id="generalService" value="0"/></td>
											</tr>
										</tbody>
									</table>
									<label>Vueltos y descuentos</label>
									<table class="table" style="margin-bottom:0px;">
										<tbody>
											<tr>
												<td width="50%">Dscto general <select id="typeGeneralDiscount"><option value="0">S/</option><option value="1">%</option></select></td>
												<td><input type="number" class="form-control" onClick="this.select();" style="width: 100px;" id="generalDiscount" value="0"/></td>
											</tr>
											<tr>
												<td width="50%">Vuelto</td>
												<td><input type="number" class="form-control" style="width: 100px;" id="cashInputExchange" value="0" readonly/></td>
											</tr>
											<tr>
												<td width="50%">Promociones</td>
												<td><input type="number" class="form-control" style="width: 100px;" id="promotionDiscount" value="0" readonly/></td>
											</tr>
										</tbody>
									</table>
									<label>Tipos de pago</label>
									<table class="table" style="margin-bottom:0px;">
										<tbody id="tBodyTablePaymentSummary"></tbody>
									</table>
									<!-- TABLA DE PAGOS -->
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<br>
							<div class="col-md-4" align="center">
								<p class="form-control" id="finalStepPrevSubtotal">SUBTOTAL: S/ 0.00</p>
							</div>
							<div class="col-md-4" align="center">
								<p class="form-control" id="finalStepPrevIgv">IGV: S/ 0.00</p>
							</div>
							<div class="col-md-4" align="center">
								<p class="form-control" id="finalStepPrevTotal">TOTAL: S/ 0.00</p>
							</div>
							<br>
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
							<p id="saleErrorMessage" class="btn btn-default pull-center">Validación correcta</p>
							<button type="button" id="finishNewSale" onClick="this.disabled=true;" class="btn btn-primary" data-dismiss="modal">Finalizar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="modal modal-success fade" id="modal-final-step">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 align="center" class="modal-title">VENTA EXITOSA</h4>
					</div>
					<div class="col-md-12">
						<br>
						<div class="col-md-3">
							<button type="button" id="printSalePdf" class="btn btn-warning">Generar pdf</button>
						</div>
						<div class="col-md-3">
							<button type="button" id="sendSaleEmail" class="btn btn-warning">Enviar por correo</button>
						</div>
						<div class="col-md-3">
							<button type="button" id="salesList" class="btn btn-warning">Lista de ventas</button>
						</div>
						<div class="col-md-3">
							<button type="button" id="newSaleButton" class="btn btn-warning">Nueva venta</button>
						</div>
					</div>
					<div class="modal-footer">
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="modal modal-danger fade" id="modal-error-step">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 align="center" class="modal-title">Hubo un problema en la venta</h4>
					</div>
					<div class="modal-footer">
						<button type="button" onClick="newSaleButtonN();" class="btn btn-primary">Nueva venta</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="modal fade" id="modal-new-settings">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">DATOS ADICIONALES DE VENTA</h4>
					</div>
					<div class="col-md-12" style="padding:10px;">
						<!-- form start -->
						<div class="col-sm-12">
							<br>
							<label for="remission_guide">Documentos asociados</label>
							<input type="text" id="remission_guide" class="form-control" placeholder="Ingrese guía de remisión (Máximo 30 caracteres)" maxlength='30'>
							<br>
							<label for="sale_order">Orden de compra</label>
							<input type="text" id="sale_order" class="form-control" placeholder="Ingrese orden de compra">
							<br>
							<label for="advertisement">Aviso</label>
							<input type="text" id="advertisement" class="form-control" placeholder="Ingrese aviso">
							<br>
							<label for="commentary">Comentario interno</label>
                            <input type="text" id="commentary" class="form-control" placeholder="Ingrese un comentario">
                            <br>
                            <label for="commentary_extra">Comentario externo</label>
                            <input type="text" id="commentary_extra" class="form-control" placeholder="Ingrese un comentario">
                            <br>
							<label for="new_user_assignment">Asignar usuario</label>
							<select name="new_user_assignment" id="new_user_assignment" class="form-control">
								<option value="0">SELECCIONE UN USUARIO</option>
								@foreach ($jsonResponse->users as $user)
									<option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
								@endforeach
							</select>
							<br>
						</div>
					</div>
					<div class="modal-footer">
						<br>
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
						<button type="button" id="saveNewSettings" onClick="saveNewSettings();" class="btn btn-primary" data-dismiss="modal">Guardar</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
		</div>
		<div class="modal fade" id="modal-on-load">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" align="center">
						<h1 class="modal-title">Procesando venta...</h4>
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
						<div class="col-md-6">
							<label for="">CÓDIGO DE PRODUCTO</label>
							<p id="productDetailCode"></p>
							<label for="">CÓDIGO DE BARRA</label>
							<p id="productDetailAutoBarCode"></p>
							<label for="">CATEGORÍA</label>
							<p id="productDetailCategory"></p>
						</div>
						<div class="col-md-6">
							<label for="">MODELO</label>
							<p id="productDetailModel"></p>
							<label for="">MARCA</label>
							<p id="productDetailBrand"></p>
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
		<div class="modal fade" id="modal-search-sale">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="col-md-12" style="padding:10px;">
						<div class="col-sm-12" id="searchQuotationDataDetail" align="center">
						</div>
						<div class="col-sm-12" style="padding:10px;" id="searchQuotationDataResponse" align="center">
							<table id="searchQuotationTable" class="table">
								<thead>
									<th>OPCIÓN</th>
									<th>CLIENTE</th>
									<th>TICKET</th>
									<th>#ITEMS</th>
									<th>MONEDA</th>
									<th>MONTO</th>
									<th>FECHA</th>
								</thead>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<br>
						<button type="button" id="dismissSearchQuotation" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
						<button type="button" id="saveSearchQuotation" onClick="saveSearchQuotationSubmit();" class="btn btn-primary">Guardar</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="modal fade" id="modal-new-driver-form">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">DATOS DEL CONDUCTOR</h4>
					</div>
					<div class="col-md-12" style="padding:10px;">
						<!-- form start -->
						<div class="col-sm-6">
							<label for="rzSocialTransportCompany">Razón social de empresa de transporte</label>
							<input type="text" id="rzSocialTransportCompany" class="form-control" placeholder="Ingrese razón social de empresa de transporte" maxlength='250'>
							<br>
							<label for="rucTransportCompany">Ruc de empresa de transporte</label>
							<input type="number" id="rucTransportCompany" class="form-control" style="width: 100%;" placeholder="Ingrese ruc de empresa de transporte" maxlength='11'>
							<br>
							<label for="truckBrandName">Marca del camión</label>
							<input type="text" id="truckBrandName" class="form-control" placeholder="Ingrese la marca del medio de transporte" maxlength='100'>
							<br>
							<label for="truckNumberCode">Número de placa</label>
							<input type="text" id="truckNumberCode" class="form-control" placeholder="Ingrese número de placa del medio de transporte" maxlength='8'>
							<br>
						</div>
						<div class="col-sm-6">
							<label for="driverName">Nombres del conductor</label>
							<input type="text" id="driverName" class="form-control" placeholder="Ingrese nombres del conductor" maxlength='100'>
							<br>
							<label for="driverLastname">Apellidos del conductor</label>
							<input type="text" id="driverLastname" class="form-control" placeholder="Ingrese apellidos del conductor" maxlength='100'>
							<br>
							<label for="driverLicense">Número de licencia del conductor</label>
							<input type="text" id="driverLicense" class="form-control" placeholder="Ingrese número de licencia del conductor" maxlength='100'>
							<br>
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
		<!--MODALS-->
	</div>
</div>
@endsection
