@extends('adminlte::layouts.app_sales_index')

@section('sidebar_sales')
  active
@endsection

@section('sidebar_sales_1')
  active
@endsection

@section('htmlheader_title')
	{{ trans('message.sales') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sales_title') }}
@endsection

@section('contentheader_description')
  <a href="/new-sale">Crear nueva venta</a>
@endsection

@section('main-content')
	<div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="box-body" style="margin: 15px;">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
              <div class="row">
                <input type="hidden" id="userObject" value="{{ json_encode($jsonResponse->user) }}">
                <div class="col-sm-12" align="center">
                  <!-- RANGO DE FECHAS -->
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                        <input type="text" class="form-control pull-left" size="22" id="dateRange" autocomplete="off">
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
                    <input type="hidden" id="adminPrivilege" value="{{ $jsonResponse->adminPrivilege }}" />
                    <input type="hidden" id="summaryDocumentSync" value="{{ $jsonResponse->summaryDocumentSync }}" />
                    <!-- <select id="typeDocument" class="form-control">
                      <option value="0">TIPO DE DOCUMENTO</option>
                      <option value="NVT">PRECUENTA</option>
                      <option value="BLT">BOLETA</option>
                      <option value="FAC">FACTURA</option>
                      <option value="NCT">N.CRÉDITO BLT</option>
                      <option value="NCF">N.CRÉDITO FAC</option>
                    </select> -->
                  <!-- TIPOS DE PAGO -->
                    <select id="sunatStatus" class="form-control">
                      <option value="0">{{ trans('message.sunat_state') }}</option>
                      <option value="1">{{ trans('message.approved') }}</option>
                      <option value="2">{{ trans('message.w_out_information') }}</option>
                    </select>
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
                        <th style="vertical-align:top;">Nº DOC</th>
                        <th style="vertical-align:top;">FECHA</th>
                        <th style="vertical-align:top;">HORA</th>
                        <!-- <th >CONDICIÓN</th> -->
                        <th style="vertical-align:top;">{{ trans('message.warehouse_store') }}</th>
                        <th style="vertical-align:top;">{{ trans('message.ruc_dni') }} Y CLIENTE</th>
                        <!-- <th style="vertical-align:top;">CLIENTE</th> -->
                        <th style="vertical-align:top;">{{ trans('message.state') }}</th>
                        <th style="vertical-align:top;">{{ trans('message.sunat_state') }}</th>
                        <th style="vertical-align:top;">{{ trans('message.payment_amount') }}</th>
                        <th style="vertical-align:top;">{{ trans('message.options') }}</th>
                        <th style="vertical-align:top;">PDF</th>
                        <th style="vertical-align:top;">XML</th>
                        <th style="vertical-align:top;">CDR</th>
                      </tr>
                    </thead>
                    <tbody style="font-size:12px; vertical-align: center;">
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
                <div class="modal modal-warning fade bd-example-modal-lg" id="modal-credit-note">
                  <div class="modal-dialog modal-lg" style="width:90%;">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title" id="ncTitle">GENERAR NOTA DE CREDITO</h4>
                      </div>
                      <div class="modal-body-5" style="padding-top:5px; padding-bottom:2px;">
                        <div class="body">
                          <div align="left" id="detailSaleCreditNote">
                          </div>
                          <div align="center">
                            <table id="quotationProducts" class="table table-bordered table-striped dataTable" role="grid">
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.back') }}</button>
                        <button type="button" onClick="convertToCreditNotePreview();" class="btn btn-outline pull-right">{{ trans('message.continue') }}</button>
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
                                        <th>CANTIDAD MÁXIMA</th>
                                        <th>INGRESO</th>
                                        <th>FECHA EXPIRACIÓN</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableAllotmentProductBody">
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-left" onClick="closeAllotmentModal();">Cancelar</button>
                                <button type="button" onClick="allotmentValidation();" class="btn btn-default">Validar cantidades</button>
                                <button type="button" id="allotmentButtonSubmit" disabled onClick="allotmentSubmit();" class="btn btn-outline pull-right" data-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal modal-warning fade" id="modal-credit-note-resume">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title">RESUMEN DE NOTA DE CREDITO</h4>
                      </div>
                      <div class="modal-body-5">
                        <div class="body">
                          <div align="left" id="detailSaleCreditNoteResume">
                            <ul>
                              <li id="ncTypeResume">TIPO DE NOTA DE CRÉDITO: </li>
                              <li id="ncPercentResume">PORCENTAJE DE GIRO (%): </li>
                              <li id="ncShowProducts">MOSTRAR PRODUCTOS: SI</li>
                              <li id="ncAmountResume">MONTO DE NOTA DE CRÉDITO: </li>
                            </ul>
                          </div>
                          <div align="center">
                            <table id="quotationProductsResume" class="table table-bordered table-striped dataTable" role="grid">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Estado</th>
                                        <th>Cantidad</th>
                                        <th>Moneda</th>
                                        <th>P.Unitario</th>
                                    </tr>
                                </thead>
                                <tbody id="quotationProductsBodyResume"></tbody>
                            </table>
                          </div>
                          <br>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.back') }}</button>
                        <button type="button" onClick="convertToCreditNoteSubmit();" class="btn btn-outline pull-right">{{ trans('message.save') }}</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="modal-on-load">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" align="center">
                                <h1 class="modal-title">Sincronizando con SUNAT...</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-summary-document">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" align="center">
                                <h3 class="modal-title">Por disposición de la <strong>SUNAT</strong>. Todos las <strong>BOLETAS</strong> serán enviadas desde el módulo de <strong>Resumen de Boletas</strong>. De manera opcional, usted podrá editar el límite de estos resúmenes entre un mínimo de 100 y un máximo de 500 unidades.</h3>
                            </div>
                            <div class="modal-footer">
                              <button type="button" onClick="goToSummaryDocuments();" class="btn btn-info pull-left">IR A RESUMEN DE BOLETAS</button>
                              <button type="button" data-dismiss="modal" class="btn btn-info pull-right">REGRESAR</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-sunat-log">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body" align="center">
                          <h3 id="div-sunat-log"></h3>
                        </div>
                        <div class="modal-footer">
                          <br>
                          <button type="button" class="btn pull-right" data-dismiss="modal">REGRESAR</button>
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
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
	</div>
@endsection
