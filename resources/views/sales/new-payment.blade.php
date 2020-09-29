@extends('adminlte::layouts.app_new_payment')

@section('sidebar_payments')
active
@endsection
@section('sidebar_sales_without_payments')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_new_payments') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_new_payments') }}
@endsection

@section('main-content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <input type="hidden" id="genericCustomer" value="{{ json_encode($jsonResponse->genericCustomer) }}">
                    <input type="hidden" id="companyLoginData" value="{{ json_encode($jsonResponse->companyLoginData) }}">
                    <div id="mainheaderSearchBar" class="form-group">
                        <label for="selectWarehouse">BUSCAR CLIENTE</label>
                        <input type="text" autocomplete="off" class="form-control" onclick="this.select();" maxlength="50" id="inputSearchClient" placeholder="Buscar cliente...">
                    </div>
                    <div class="col-sm-12" style="padding:10px;" id="searchQuotationDataResponse" align="center">
                        <table id="searchQuotationTable" class="table">
                            <thead>
                                <th><input type="checkbox" onChange="searchQuotationCheckbox();" id="mainCheckbox"></th>
                                <th>TICKET</th>
                                <th>MONEDA</th>
                                <th>PAGADO</th>
                                <th>MONTO</th>
                                <th>FECHA</th>
                            </thead>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="button" disabled id="button" onclick="openModalCreateSinglePayment();" class="btn btn-primary">CONTINUAR</button>
                    </div>            
                </div>
            </div>
        </div>
        <!-- MODALS -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="box-body">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
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
                                <div class="modal fade" id="modal-on-load">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" align="center">
                                                <h1 class="modal-title">Procesando pago...</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal modal-success fade" id="modal-final-step">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 align="center" class="modal-title">PAGO EXITOSO</h4>
                                            </div>
                                            <div class="col-md-12">
                                            <br>
                                                <div class="col-md-6">
                                                    <button type="button" onClick="location.reload();" class="btn btn-warning">Nuevo pago</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" onClick="location = '/payments';" class="btn btn-warning">Ver lista de pagos</button>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
