@extends('adminlte::layouts.app_products_dispatch')

@section('sidebar_products')
active
@endsection
@section('sidebar_products_1')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_8') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_8') }}
@endsection
@section('contentheader_description')	
{{ trans('message.sidebar_products_8') }}
@endsection

@section('main-content')
<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Homes</div> -->
					<div class="panel-body">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12" align="center">
                    <!-- ALMACENES/TIENDAS -->
                    <!-- RANGO DE FECHAS -->
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-search"></i>
                        </div>
                          <input type="text" class="form-control pull-left" size="22" id="dateRange">
                      </div>
                    <!-- BUSCADOR -->
                      <button id="searchButton" class="btn btn-success">{{ trans('message.search') }}</button>
                  </div>
                  <div class="col-sm-12">
                    <table id="dispatchs" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr role="row">
                          <th width="5%">{{ trans('message.id') }}</th>
                          <th width="10%">{{ trans('message.name') }}</th>
                          <th width="15%">FECHA</th>
                          <th width="15%">HORA</th>
                          <th width="10%">{{ trans('message.options') }}</th>
                        </tr>
                      </thead>
                      <tbody style="font-size:12px">
                      </tbody>
                    </table>
                  </div>
                  <div class="modal modal-danger fade" id="modal-danger">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">{{ trans('message.delete_document') }}</h4>
                        </div>
                        <div class="modal-body">
                          <p id="deletedSaleText"></p>
                          <br>
                          <input class="form-control" id="deleteSaleComment" size="50" type="text" maxlength="100" placeholder="{{ trans('message.write_reason') }}" />
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                            <button type="button" onClick="deleteSaleSubmit()" class="btn btn-outline">{{ trans('message.acept') }}</button>
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
