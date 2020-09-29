@extends('adminlte::layouts.app_price-list_index')

@section('sidebar_sales')
active
@endsection
@section('sidebar_sales_4')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.price-list') }}
@endsection

@section('contentheader_title')
	{{ trans('message.price-list_title') }}
@endsection
@section('contentheader_description')
<a style="cursor:pointer;" onClick="createPriceList();"> {{ trans('message.create_new_price_list') }} </a>
@endsection

@section('main-content')
	<div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Homes</div> -->
					<div class="panel-body">
            <!-- /.box-header -->
            <div class="box-body" style="margin: 20px;">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12" style="padding: 10px;">
                    <table id="sale_index" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr role="row">
                          <th>{{ trans('message.name') }}</th>
                          <th>{{ trans('message.description') }}</th>
                          <th>MONEDA</th>
                          <th>{{ trans('message.principal') }}</th>
                          <th>{{ trans('message.status') }}</th>
                          <th>FECHA</th>
                          <th>HORA</th>
                          <th>{{ trans('message.options') }}</th>
                        </tr>
                      </thead>
                      <tbody style="font-size:12px">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <!-- modals -->
            <div class="modal modal-danger fade" id="modal-delete">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">ELIMINAR LISTA DE PRECIOS</h4>
                  </div>
                  <div class="modal-body">
                    <p id="deletedPriceListText"></p>
                    <br>
                    <input class="form-control" id="deletedPriceListComment" size="50" type="text" maxlength="100" placeholder="Escriba un motivo..." />
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                    <button type="button" onClick="deletePriceListSubmit()" data-dismiss="modal" class="btn btn-outline">{{ trans('message.acept') }}</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal modal-default fade" id="modal-edit">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">EDITAR LISTA DE PRECIOS</h4>
                  </div>
                  <div class="modal-body">
                    <label for="priceListCurrency">MONEDA</label>
                    <select class="form-control" name="priceListCurrencyUpdate" id="priceListCurrencyUpdate">
                      <option value="PEN">SOLES</option>
                      <option value="CLP">PESOS CHILENOS</option>
                      <option value="USD">DÓLARES</option>
                      <option value="EUR">EUROS</option>
                    </select>
                    <label for="priceListName">NOMBRE</label>
                    <input type="text" class="form-control" id="priceListNameUpdate">
                    <label for="priceListDescription">DESCRIPCIÓN</label>
                    <input type="text" class="form-control" id="priceListDescriptionUpdate">
                    <label for="priceListFlagDefault">¿ES PRINCIPAL?</label>
                    <select class="form-control" name="priceListFlagDefaultUpdate" id="priceListFlagDefaultUpdate">
                      <option value="SI">SÍ</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                    <button type="button" onClick="editPriceListSubmit()" data-dismiss="modal" class="btn btn-default">{{ trans('message.acept') }}</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal modal-default fade" id="modal-create">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">CREAR DE PRECIOS</h4>
                  </div>
                  <div class="modal-body">
                    <label for="priceListCurrency">MONEDA</label>
                    <select class="form-control" name="newPriceListCurrency" id="newPriceListCurrency">
                      <option selected value="PEN">SOLES</option>
                      <option value="CLP">PESOS CHILENOS</option>
                      <option value="USD">DÓLARES</option>
                      <option value="EUR">EUROS</option>
                    </select>
                    <label for="priceListName">NOMBRE</label>
                    <input type="text" class="form-control" id="newPriceListName">
                    <label for="priceListDescription">DESCRIPCIÓN</label>
                    <input type="text" class="form-control" id="newPriceListDescription">
                    <label for="priceListFlagDefault">¿ES PRINCIPAL?</label>
                    <select class="form-control" name="priceListFlagDefault" id="newPriceListFlagDefault">
                      <option value="SI">SÍ</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                    <button type="button" onClick="createPriceListSubmit()" data-dismiss="modal" class="btn btn-success">{{ trans('message.acept') }}</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- deletedPriceListText -->
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
