@extends('adminlte::layouts.app_remission_guides_index')

@section('sidebar_remission_guide')
active
@endsection
@section('sidebar_remission_guide_list')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_remission_guide') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_remission_guide_list_2') }}
@endsection
@section('contentheader_description')
 <!-- <a href="/new-quotation"> {{ trans('message.create_new_quotation') }} </a> -->
@endsection

@section('main-content')
	<div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Homes</div> -->
					<div class="panel-body">
            <!-- /.box-header -->
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
                    <!-- USUARIO -->
                      <select id="employeeId" class="form-control">
                        @foreach ($jsonResponse->employees as $object)
                          @if ($object->id === 0)
                            <option selected value="{{ $object->id }}">{{ $object->name . " " . @$object->lastname }}</option>
                          @else
                            <option value="{{ $object->id }}">{{ $object->name . " " . @$object->lastname }}</option>
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
                    <!-- BUSCADOR -->
                      <input id="searchInput" class="form-control" type="text" placeholder="#Documento" />
                      <hr style="margin:5px;">
                      <button id="searchButton" class="btn btn-success">{{ trans('message.search') }}</button>
                  </div>
                  <div class="col-sm-12" style="padding:10px;">
                    <table id="sale_index" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr>
                          <th >Nº DOC</th>
                          <th >{{ trans('message.warehouse_store') }}</th>
                          <th >DOC. REFERENCIADO</th>
                          <th >DNI/RUC CLIENTE</th>
                          <th >NOMBRE CLIENTE</th>
                          <th >{{ trans('message.state') }}</th>
                          <th >{{ trans('message.payment_amount') }}</th>
                          <th >FECHA</th>
                          <th >HORA</th>
                          <th >{{ trans('message.options') }}</th>
                        </tr>
                      </thead>
                      <tbody style="font-size:12px; vertical-align: center;">
                      </tbody>
                    </table>
                  </div>
                  <div class="modal modal-danger fade" id="modal-danger">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">ELIMINAR GUÍA DE REMISIÓN</h4>
                        </div>
                        <div class="modal-body">
                          <p id="deletedSaleText"></p>
                          <br>
                          <input class="form-control" id="deleteSaleComment" size="50" type="text" maxlength="100" placeholder="Escriba un motivo..." />
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                            <button id="deleteRemissionGuideBtn" type="button" onClick="deleteSaleSubmit()" class="btn btn-outline">{{ trans('message.acept') }}</button>
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
                  <div class="modal modal-warning fade" id="modal-converto-to">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="detailSaleCreatedAtMct">{{ trans('message.sale_detail') }}</h4>
                        </div>
                        <div class="modal-body-5">
                          <div class="body">
                              <div align="center" id="detailSaleItemsTableMct">
                              </div>
                          </div>
                          <div class="footer">
                              <div align="center" id="detailSaleEmployeeNameMct">
                              </div>
                          </div>
                          <p id="saleDetailText"></p>
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.back') }}</button>
                            <button id="buttonModalSubmit" type="button" class="btn btn-outline pull-right" onClick="submitConvertToDirectInvoice();" data-dismiss="modal">CONTINUAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal modal-warning fade" id="modal-close-remission-guide">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="closeRemissionGuideTitle">¿Desea cerrar esta guía de remisión?</h4>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">NO</button>
                          <button type="button" class="btn btn-outline pull-right" onClick="closeRemissionGuideSubmit();">SI</button>
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
