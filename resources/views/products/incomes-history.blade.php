@extends('adminlte::layouts.app_products_incomes_history')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_management')
active
@endsection
@section('sidebar_products_3')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_3') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_3') }}
@endsection
@section('contentheader_description')	
	<a href="/products-income">{{ trans('message.new-products-income') }}</a> &nbsp;&nbsp; <a href="/products-outcome">{{ trans('message.new-products-outcome') }}</a>
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
										<table id="inventoryRecords" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
											<thead>
												<tr role="row">
													<th>ÓRDEN</th>
													<th>Nº DOC</th>
													<th>ALMACÉN/TIENDA</th>
													<th>MOVIMIENTO</th>
													<th>COMENTARIO</th>
													<th>FECHA REGISTRO</th>
													<th>HORA REGISTRO</th>
													<!-- <th>FECHA INGRESO</th>
													<th>HORA INGRESO</th> -->
													<th># Productos</th>
													<th>{{ trans('message.options') }}</th>
												</tr>
											</thead>
											<tbody style="font-size:12px" id="tBodyData">
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<!--MODALS-->
						<div class="modal fade" id="modal-resume">
							<div class="modal-dialog" style="width:900px;">
							<div class="modal-content">
								<div class="modal-header">
								<h4 align="center" class="modal-title" id="inventoryTitleDetail">Detalle de ingresos y salidas</h4>
								</div>
								<div class="col-md-12" id="transfersPrProduct">
									<div class="box-body">
										<input type="hidden" id="totalCostValue" value="0">
										<table id="example1" class="table table-bordered table-striped">
											<thead id="theadTransfersPrProduct">
												<tr>
													<td>PRODUCTO</td>
													<td>CÓDIGO</td>
													<td>C. BARRAS</td>
													<td>CANTIDAD</td>
													<td>DEVOLUCIÓN</td>
													<td>P.UNITARIO</td>
													<td>P.COSTO</td>
													<!-- <td>DEVOLUCIÓN</td> -->
													<td>OPCIONES</td>
												</tr>
											</thead>
											<tbody id="tbodyTransfersPrProduct">
											</tbody>
										</table>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-success pull-right" data-dismiss="modal">Regresar</button>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
