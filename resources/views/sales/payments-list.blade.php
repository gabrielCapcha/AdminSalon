@extends('adminlte::layouts.app_payments_index')

@section('sidebar_payments')
  active
@endsection

@section('sidebar_payments_list')
  active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_payments') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_payments_list') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
            <div class="box-body" style="margin: 2px;">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12" align="center" >
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
                    <!-- BUSCADOR -->
                        <button id="searchButton" class="btn btn-success">{{ trans('message.search') }}</button>
                  </div>
                  <div class="col-sm-12" align="center" style="padding: 10px;">
                    <table id="sale_index" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr role="row">
                          <th >CÓDIGO</th>
                          <th >VENTA</th>
                          <th >CLIENTE</th>
                          <th >DNI</th>
                          <th >RUC</th>
                          <th >{{ trans('message.warehouse_store') }}</th>
                          <th >TIPO DE PAGO</th>
                          <th >MONEDA</th>
                          <th >{{ trans('message.amount') }}</th>
                          <th >ESTADO</th>
                          <th >FECHA</th>
                          <th >HORA</th>
                          <th >OPCIONES</th>
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
                                <h4 class="modal-title">ELIMINAR PAGO</h4>
                            </div>
                            <div class="modal-body">
                            <p id="deletedSaleText"></p>
                            <br>
                            <input class="form-control" id="deleteSaleComment" size="50" type="text" maxlength="100" placeholder="Escriba un motivo..." />
                            </div>
                            <div class="modal-footer">
                            <br>
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                                <button type="button" onClick="deletePaymentSubmit()" data-dismiss="modal" class="btn btn-outline">{{ trans('message.acept') }}</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal modal-primary fade" id="modal-payment-detail">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="paymentDetailMessage">DETALLE DE PAGO</h4>
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
                                    <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">CONTINUAR</button>
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
