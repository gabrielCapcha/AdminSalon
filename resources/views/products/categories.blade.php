@extends('adminlte::layouts.app_products_categories')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_config')
  active
@endsection
@section('sidebar_products_4')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_4') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_4') }}
@endsection
@section('contentheader_description')	
<a href="/new-category"> {{ trans('message.create-new-category') }} </a>
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
                          <input type="text" class="form-control pull-left" size="22" id="searchInput" placeholder="Buscar categoría...">
                      </div>
                    <!-- BUSCADOR -->
                      <button id="searchButton" class="btn btn-success">{{ trans('message.search') }}</button>
                  </div>
                  <div style="padding-left:10px;padding-right:10px;" class="col-sm-12">
                    <table id="categories" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr role="row">
                          <th>{{ trans('message.name') }}</th>
                          <th>{{ trans('message.status') }}</th>
                          <th>¿ES ADICIONAL?</th>
                          <th>FECHA</th>
                          <th>HORA</th>
                          <th>{{ trans('message.options') }}</th>
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
                            <h4 class="modal-title">ELIMINAR CATEGORÍA</h4>
                        </div>
                        <div class="modal-body">
                          <p id="deletedCategoryText"></p>
                          <br>
                          <input class="form-control" id="deleteCategoryComment" size="50" type="text" maxlength="100" placeholder="{{ trans('message.write_reason') }}" />
                        </div>
                        <div class="modal-footer">
                        <br>
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ trans('message.cancel') }}</button>
                            <button type="button" onClick="deleteCategorySubmit()" data-dismiss="modal" class="btn btn-outline">{{ trans('message.acept') }}</button>
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
