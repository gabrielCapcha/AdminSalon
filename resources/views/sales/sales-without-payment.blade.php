@extends('adminlte::layouts.app_sales_without_payments')

@section('sidebar_payments')
  active
@endsection

@section('sidebar_sales_without_payments')
  active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_payments') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_sales_without_payments') }}
@endsection

@section('contentheader_description')
  <a href="/new-payment">Crear nuevo pago</a>
@endsection


@section('main-content')
	<div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
                        <div class="box-body" style="margin: 15px;">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12" align="center">
                                        <!-- RANGO DE FECHAS -->
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-left" size="22" id="dateRange">
                                        </div>
                                        <!-- ALMACENES/TIENDAS -->
                                        <select id="warehouseId" class="form-control">                        
                                            @foreach ($jsonResponse->warehouses as $object)
                                                @if ($jsonResponse->warehouseId === $object->id)
                                                    <option selected value="{{ $object->id }}">{{ $object->name }}</option>
                                                @else
                                                    <option value="{{ $object->id }}">{{ $object->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <!-- ESTADOS DE VENTAS -->
                                        <select id="stateSaleId" class="form-control">
                                            <option value="0">{{ trans('message.document_state') }}</option>
                                            @foreach ($jsonResponse->saleStates as $object)
                                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                                            @endforeach
                                        </select>
                                        <!-- TIPOS DE PAGO -->
                                        <select id="paymentId" class="form-control">
                                            <option value="0">{{ trans('message.type_payment') }}</option>
                                            @foreach ($jsonResponse->paymentsTp as $object)
                                            <option value="{{ $object->id }}">{{ $object->name }}</option>
                                            @endforeach
                                        </select>
                                        <!-- <select id="typeDocument" class="form-control">
                                            <option value="0">TIPO DE DOCUMENTO</option>
                                            <option value="NVT">PRECUENTA</option>
                                            <option value="BLT">BOLETA</option>
                                            <option value="FAC">FACTURA</option>
                                            <option value="NCT">N.CRÉDITO BLT</option>
                                            <option value="NCF">N.CRÉDITO FAC</option>
                                        </select> -->
                                        <!-- BUSCADOR -->
                                        <input id="searchInput" class="form-control" type="text" placeholder="{{ trans('message.ndoc_customer') }}" />
                                        <hr style="margin: 5px;">
                                        <button id="typeDocument_2" onClick="selectTypeDocument(2);" class="btn btn-default">FACTURA</button>
                                        <button id="typeDocument_1" onClick="selectTypeDocument(1);" class="btn btn-default">BOLETA</button>
                                        <button id="typeDocument_5" onClick="selectTypeDocument(5);" class="btn btn-default">PRECUENTA</button>
                                        <button id="typeDocument_9" onClick="selectTypeDocument(9);" class="btn btn-default">NC.BOLETA</button>
                                        <button id="typeDocument_10" onClick="selectTypeDocument(10);" class="btn btn-default">NC.FACTURA</button>
                                        <button id="searchButton" class="btn btn-success">{{ trans('message.search') }}</button>
                                    </div>
                                    <div class="col-sm-12" align="center" style="padding: 10px;">
                                        <table id="sale_index" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                        <thead>
                                            <tr role="row">
                                            <th >Nº DOC</th>
                                            <th >CONDICIÓN</th>
                                            <th >{{ trans('message.warehouse_store') }}</th>
                                            <th >{{ trans('message.ruc_dni') }}</th>
                                            <th >{{ trans('message.state') }}</th>
                                            <th >MONTO</th>
                                            <th >PAGADO</th>
                                            <th >FECHA</th>
                                            <th >HORA</th>
                                            <th >{{ trans('message.options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:12px; vertical-align: center;">
                                        </tbody>
                                        </table>
                                    </div>
                                    <!-- MODALS -->
                                    <div class="modal fade" id="modal-on-load">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" align="center">
                                                    <h1 class="modal-title">Procesando pago...</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal modal-danger fade" id="modal-danger">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ trans('message.delete_sale') }}</h4>
                                            </div>
                                            <div class="modal-body">
                                            <p id="deletedSaleText"></p>
                                            <br>
                                            <input class="form-control" id="deleteSaleComment" size="50" type="text" maxlength="100" placeholder="Escriba un motivo..." />
                                            </div>
                                            <div class="modal-footer">
                                            <br>
                                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                                                <button type="button" onClick="deleteSaleSubmit()" data-dismiss="modal" class="btn btn-outline">{{ trans('message.acept') }}</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="modal modal-primary fade" id="modal-send-mail">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ trans('message.send_email_sale') }}</h4>
                                            </div>
                                            <div class="modal-body">
                                            <p id="sendEmailText"></p>
                                            <br>
                                            <input class="form-control" id="sendEmailComment" size="50" type="email" maxlength="100" placeholder="Escriba un correo electrónico" />
                                            </div>
                                            <div class="modal-footer">
                                            <br>
                                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                                                <button type="button" id="buttonSendMail" onClick="sendEmailSubmit()" class="btn btn-outline">{{ trans('message.acept') }}</button>
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
                                                <h4 class="modal-title" id="detailSaleCreatedAt">{{ trans('message.sale_detail') }}</h4>
                                            </div>
                                            <div class="modal-body-5">
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
                                            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">{{ trans('message.back') }}</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="modal modal-warning fade" id="modal-credit-note">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">GENERAR NOTA DE CREDITO</h4>
                                            </div>
                                            <div class="modal-body-5">
                                            <div class="body">
                                                <div align="left" id="detailSaleCreditNote">
                                                </div>
                                                <div align="center">
                                                <table id="quotationProducts" class="table table-bordered table-striped dataTable" role="grid">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" id="checkedAllButton" onClick="checkedAll();" checked></th>
                                                            <th>Producto</th>
                                                            <th>Estado</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="quotationProductsBody"></tbody>
                                                </table>
                                                </div>
                                                <br>
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.back') }}</button>
                                            <button type="button" onClick="convertToCreditNoteSubmit();" class="btn btn-outline pull-right" data-dismiss="modal">{{ trans('message.continue') }}</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="modal modal-primary fade" id="modal-create-single-payment">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="detailSaleCreatedAtMct">CREAR NUEVO PAGO</h4>
                                                </div>
                                                <div class="modal-body-5">
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a href="#tab_4" data-toggle="tab" aria-expanded="false">EFECTIVO</a></li>
                                                            <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="true">CHEQUE</a></li>
                                                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">TRANSFERENCIA</a></li>
                                                            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">VISA</a></li>
                                                            <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">MASTERCARD</a></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="tab_4" align="center">
                                                                <div class="form-group">
                                                                    <label for="tabCurrency">MONEDA</label>
                                                                    <br>
                                                                    <select class="form-control" name="tabCurrency" id="tabCurrency">
                                                                        <option selected value="PEN">SOLES</option>
                                                                        <!-- <option value="USD">DÓLARES</option>
                                                                        <option value="EUR">EUROS</option> -->
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cashReference">REFERENCIA</label>
                                                                    <br>
                                                                    <input type="text" id="cashReference" class="form-control" placeholder="Ingrese REFERENCIA">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="totalCash">TOTAL</label>
                                                                    <br>
                                                                    <input type="number" onClick="this.select();" id="totalCash" class="form-control" placeholder="Ingrese TOTAL" value="0.00">
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="tab_1" align="center">
                                                                <div class="form-group">
                                                                    <label for="tabCurrency">MONEDA</label>
                                                                    <br>
                                                                    <select class="form-control" name="tabCurrency" id="tabCurrency">
                                                                        <option selected value="PEN">SOLES</option>
                                                                        <!-- <option value="USD">DÓLARES</option>
                                                                        <option value="EUR">EUROS</option> -->
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="checkCode">BANCO</label>
                                                                    <br>
                                                                    <input type="text" id="checkCode" class="form-control" placeholder="Ingrese BANCO">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="checkReference">REFERENCIA</label>
                                                                    <br>
                                                                    <input type="text" id="checkReference" class="form-control" placeholder="Ingrese REFERENCIA">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dateCheckCharged">FECHA DEPÓSITO</label>
                                                                    <br>
                                                                    <input type="text" class="form-control pull-left" size="22" id="dateCheckCharged">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="totalCheck">TOTAL</label>
                                                                    <br>
                                                                    <input type="number" onClick="this.select();" id="totalCheck" class="form-control" placeholder="Ingrese TOTAL" value="0.00">
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="tab_2" align="center">
                                                                <div class="form-group">
                                                                    <label for="tabCurrency">MONEDA</label>
                                                                    <br>
                                                                    <select class="form-control" name="tabCurrency" id="tabCurrency">
                                                                        <option selected value="PEN">SOLES</option>
                                                                        <!-- <option value="USD">DÓLARES</option>
                                                                        <option value="EUR">EUROS</option> -->
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="majorAccountTransfer">BANCO</label>
                                                                    <br>
                                                                    <input type="text" id="majorAccountTransfer" class="form-control" placeholder="Ingrese BANCO">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dateTransfer">FECHA DEPÓSITO</label>
                                                                    <br>
                                                                    <input type="text" class="form-control pull-left" size="22" id="dateTransfer">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="transferReference">REFERENCIA</label>
                                                                    <br>
                                                                    <input type="text" id="transferReference" class="form-control" placeholder="Ingrese REFERENCIA">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="totalTransfer">TOTAL</label>
                                                                    <br>
                                                                    <input type="number" onClick="this.select();" id="totalTransfer" class="form-control" placeholder="Ingrese TOTAL" value="0.00">
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="tab_3" align="center">
                                                                <div class="form-group">
                                                                    <label for="dateVisa">FECHA DE PAGO</label>
                                                                    <br>
                                                                    <input type="text" class="form-control pull-left" size="22" id="dateVisa">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="visaCode">CÓDIGO (4 dígitos)</label>
                                                                    <br>
                                                                    <input type="text" id="visaCode" class="form-control" placeholder="Ingrese 4 últimos dígitos">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="totalVisa">TOTAL</label>
                                                                    <br>
                                                                    <input type="number" onClick="this.select();" id="totalVisa" class="form-control" placeholder="Ingrese TOTAL" value="0.00">
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="tab_5" align="center">
                                                                <div class="form-group">
                                                                    <label for="dateMastercard">FECHA DE PAGO</label>
                                                                    <br>
                                                                    <input type="text" class="form-control pull-left" size="22" id="dateMastercard">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="mastercardCode">CÓDIGO (4 dígitos)</label>
                                                                    <br>
                                                                    <input type="text" id="mastercardCode" class="form-control" placeholder="Ingrese 4 últimos dígitos">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="totalMastercard">TOTAL</label>
                                                                    <br>
                                                                    <input type="number" onClick="this.select();" id="totalMastercard" class="form-control" placeholder="Ingrese TOTAL" value="0.00">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-3 col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="totalImport">IMPORTE TOTAL <b id="selectedCurrency">(PEN)</b></label>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label for="outOfRangeImport">SALDO VENCIDO <b id="selectedCurrency">(PEN)</b></label>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label for="bankingCharges">GASTOS BANCARIOS <b id="selectedCurrency">(PEN)</b></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 col-sm-3">
                                                                <div class="form-group">
                                                                    <input type="number" onClick="this.select();" id="totalImport" class="form-control" readonly>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <input type="number" onClick="this.select();" id="outOfRangeImport" class="form-control" readonly>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <input type="number" onClick="this.select();" id="bankingCharges" class="form-control" value="0.00">
                                                                </div>
                                                            </div>
                                                            <div class="col-3 col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="flagSunat">MEDIO DE PAGO (SUNAT)</label>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label for="typeCharge">TIPO OPERACIÓN COBRO</label>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label for="PaymentFinish">PAGADO <b id="selectedCurrency">(PEN)</b></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3 col-sm-3">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="flagSunat" id="flagSunat">                
                                                                        <option selected value="0">NO</option>
                                                                        <option value="1">SÍ</option>
                                                                    </select>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="typeCharge" id="typeCharge">
                                                                        <option selected value="0">NINGUNO</option>
                                                                        <option value="1">RETENCIÓN</option>
                                                                    </select>
                                                                </div>
                                                                <br>
                                                                <br>
                                                                <div class="form-group">
                                                                    <input type="text" id="PaymentFinish" class="form-control" value="0.00" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <br>
                                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.back') }}</button>
                                                    <button id="buttonModalSubmit" type="button" class="btn btn-outline pull-right" onClick="submitNewPayment();" data-dismiss="modal">CONTINUAR</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
