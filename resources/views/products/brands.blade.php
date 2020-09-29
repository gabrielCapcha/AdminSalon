@extends('adminlte::layouts.app_products_brands')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_config')
  active
@endsection
@section('sidebar_products_5')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_5') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_5') }}
@endsection
@section('contentheader_description')	
<a href="/new-brand"> {{ trans('message.create_new_brand') }} </a>
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
                  <div style="padding-left:10px;padding-right:10px;" class="col-sm-12">
                    <table id="brands" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr role="row">
                          <th>{{ trans('message.id') }}</th>
                          <th>{{ trans('message.name') }}</th>
                          <th>{{ trans('message.code') }}</th>
                          <th>FECHA</th>
                          <th>HORA</th>
                          <th>{{ trans('message.options') }}</th>
                        </tr></thead>
                      <tbody style="font-size:12px">
                      </tbody>
                    </table>
                  </div>
                  <div class="modal modal-default fade" id="modal-edit-brand">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">EDITAR MARCA</h4>
                        </div>
                        <div class="modal-body">
                          <div class="col-ms-12">
                            <label for="">Nombre de marca</label>
                            <br>
                            <input class="form-control" id="editBrandName" size="50" type="text" maxlength="100" placeholder="Ingrese nombre de marca" />                          
                            <br>
                          </div>
                          <div class="col-ms-12"><br>
                            <label for="">Código de marca</label>
                            <br>
                            <input class="form-control" id="editBrandCode" size="50" type="text" maxlength="100" placeholder="Ingrese código de marca" />
                          </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                            <button type="button" onClick="editDocumentSubmit()" class="btn btn-default">{{ trans('message.acept') }}</button>
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
