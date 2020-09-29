@extends('adminlte::layouts.app_sales_new_sale')

@section('sidebar_sales')
active
@endsection
@section('sidebar_sales_0')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sales') }}
@endsection

@section('contentheader_title')
	{{ trans('message.new_sales_title') }}
@endsection
@section('contentheader_description')
	{{ trans('message.new_sales_description') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <!-- /input-group -->
                                    <label>Seleccione un cliente:</label>
                                    <div class="input-group input-group-sm">
                                        <input type="hidden" id="genericCustomer" value="{{ json_encode($jsonResponse->genericCustomer) }}">
                                        <input type="text" maxlength="100" class="form-control" autocomplete="off" id="inputSearchClient" placeholder="Ingrese dni o ruc">
                                        <span class="input-group-btn">
                                            <button type="button" id="clearClient" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                            <button type="button" id="searchClient" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                                            <button type="button" id="genericClient" class="btn btn-info btn-flat"><i class="fa fa-user"></i></button>
                                            <button type="button" id="newClient" data-toggle="modal" data-target="#modal-success" class="btn btn-warning btn-flat"><i class="fa fa-user-plus"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tipo de documento</label>
                                    <div class="input-group-sm">
                                        <select class="form-control" id="documentTp" style="width: 100%;">
                                            @foreach ($jsonResponse->documentTp as $documentTp)
                                                @if($documentTp->default)
                                                    <option value="{{ $documentTp->id }}" selected="selected">{{ $documentTp->name }}</option>
                                                @else
                                                    <option value="{{ $documentTp->id }}">{{ $documentTp->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tipo de pago</label>
                                    <div class="input-group-sm">
                                        <select class="select2" id="paymentTp" multiple="multiple" data-placeholder="Seleccione uno o varios" style="width: 100%;">
                                            @foreach ($jsonResponse->paymentTp as $paymentTp)
                                                <option value="{{ $paymentTp->id }}">{{ $paymentTp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- /.col -->
                                    <label>Listado de productos:</label>
                                    <div class="box-body">
                                        <div class="input-group-sm col-md-6">
                                            <select class="form-control" name="productCategories" id="productCategories" data-placeholder="Seleccione las categorías" style="width: 100%;">
                                                <option value="0">Seleccione una categoría</option>
                                                @foreach ($jsonResponse->categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group-sm col-md-6">
                                            <input type="text" class="form-control" maxlength="50" id="searchProduct" placeholder="Ingrese código de producto">
                                        </div>
                                        <div id="loadingDiv" class="col-md-12" align="center" style="display: none;">
                                            <div class="box-header">
                                                <h3 class="box-title">Cargando ...</h3>
                                                <i class="fa fa-refresh fa-spin"></i>
                                            </div>
                                            <!-- end loading -->
                                        </div>
                                        <div class="col-md-12 products-div-list" id="productsDivList">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- datatable of products -->
                                    <label>Productos seleccionados:</label>
                                    <!-- /.box-header -->
                                    <div class="box-body products-table-list">
                                        <table id="tableSelectedProducts" class="table ScrollX">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tBodyTableSelectedProducts"></tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="secondStepOfSale();" data-toggle="modal" data-target="#modal-default" class="btn btn-block btn-success">Continuar</button>
                                </div>

                                <div class="modal fade" id="modal-default">
                                        <form id="formSale" method="POST" action="sales">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                    <h4 align="center" class="modal-title">Resumen de la orden</h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="modal-body">
                                                            <!-- TABLA DE PRODUCTOS -->
                                                            <label>Detalle de productos</label>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Código</th>
                                                                        <th>Nombre</th>
                                                                        <th>Precio</th>
                                                                        <th>Cantidad</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tBodyTableProductsSummary"></tbody>
                                                            </table>
                                                            <!-- TABLA DE PRODUCTOS -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="modal-body">
                                                            <label>Cliente</label>
                                                            <p id="clientName"></p>                                                    
                                                            <!-- TABLA DE PRODUCTOS -->
                                                            <label>Tipo de pago</label>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Medio</th>
                                                                        <th>Cantidad (S/)</th>
                                                                        <th>Vuelto (S/)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tBodyTablePaymentSummary"></tbody>
                                                            </table>
                                                            <!-- TABLA DE PRODUCTOS -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="modal-body">
                                                        <label>Último paso</label>
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" maxlength="10" class="form-control" placeholder="Ingrese dscto general">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <input type="checkbox" class="flat-red" checked>
                                                                    </label>
                                                                    <label>
                                                                        <input type="checkbox" class="flat-red" checked>
                                                                    </label>
                                                                    <label>
                                                                        Enviar por correo | Imprimir
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
                                                    <button type="button" id="finishNewSale" class="btn btn-primary">Finalizar</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <div class="modal fade" id="modal-success">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Crear nuevo cliente</h4>
                                            </div>
                                            <div class="col-md-12">
                                                <!-- form start -->
                                                <div class="col-sm-12" id="divCustomerSearchInput">
                                                    <br>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" maxlength="11" id="searchClientSunat" placeholder="Buscar cliente por DNI o RUC">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-info btn-flat" id="searchClientSunatButton">Buscar</button>
                                                        </span>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div id="loadingDivCustomer" class="col-sm-12" align="center" style="display: none;">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Cargando ...</h3>
                                                        <i class="fa fa-refresh fa-spin"></i>
                                                    </div>
                                                    <!-- end loading -->
                                                </div>
                                                <div class="col-sm-12" id="clientDataResponse">
                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <br>
                                                <button type="button" id="dismissNewClient" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                                <button type="button" id="saveNewClient" class="btn btn-primary" disabled>Guardar</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            </div>
                        </div>
                        <!-- /.box-body -->
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
