@extends('sales.partials.app-fe-documents')

@section('sidebar_sales')
active
@endsection

@section('sidebar_fe_documents')
active
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_fe_documents') }}
@endsection

@section('contentheader_description')
@endsection

@section('main-content')
	<div class="row">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
                        <div class="box-body" style="margin: 10px;">
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
                                        <!-- RAZONES SOCIALES -->
                                        <select id="rzSocial" class="form-control">
                                            @foreach ($jsonResponse->rzSocials as $object)
                                                <option value="{{ $object['ruc'] }}">{{ $object['ruc'] }} - {{ $object['rz_social'] }}</option>
                                            @endforeach
                                        </select>
                                        <!-- BUSCAR -->
                                        <button id="searchButton" class="btn btn-success">{{ trans('message.search') }}</button>
                                    </div>
                                    <div class="col-sm-12" align="center">
                                        <br>
                                        {{ trans('message.message_fe_documents') }}
                                    </div>
                                    <div class="col-sm-12" align="center" style="padding: 10px;">
                                        <table id="sale_index" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row">
                                                <th style="vertical-align:top;">{{ trans('message.code_fe_documents') }}</th>
                                                <!-- <th >CONDICIÓN</th> -->
                                                <th style="vertical-align:top;">{{ trans('message.ruc') }}</th>
                                                <th style="vertical-align:top;">{{ trans('message.process_type_fe_documents') }}</th>
                                                <!-- <th style="vertical-align:top;">CLIENTE</th> -->
                                                <th style="vertical-align:top;">{{ trans('message.vouchers_fe_documents') }}</th>
                                                <th style="vertical-align:top;">{{ trans('message.state') }}</th>
                                                <th style="vertical-align:top;">{{ trans('message.creation_date_fe_documents') }}</th>
                                                <th style="vertical-align:top;">{{ trans('message.send_date') }}</th>
                                                <th style="vertical-align:top;">{{ trans('message.options') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody style="font-size:12px; vertical-align: center;">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal fade" id="modal-on-load">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" align="center">
                                                    <h1 class="modal-title">{{ trans('message.wait_message_fe_documents') }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade bd-example-modal-lg" id="modal-summary-documents-detail">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header" align="center">
                                                    <h1 class="modal-title">{{ trans('message.diary_summary_fe_documents') }}<strong id="summaryDocumentText"></strong></h4>
                                                </div>
                                                <div class="modal-body" align="center">
                                                    <table class="table">
                                                        <thead>
                                                            <th>{{ trans('message.ruc') }}</th>
                                                            <th>{{ trans('message.document_code_fe_documents') }}</th>
                                                            <th>{{ trans('message.report') }}</th>
                                                            <th>{{ trans('message.customer_type') }}</th>
                                                            <th>{{ trans('message.customer') }}</th>
                                                            <th>{{ trans('message.subtotal') }}</th>
                                                            <th>{{ trans('message.igv') }}</th>
                                                            <th>{{ trans('message.total') }}</th>
                                                            <th>STATUS</th>
                                                        </thead>
                                                        <tbody id="summaryDocumentBody"></tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" data-dismiss="modal" class="btn btn-info">REGRESAR</button>
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
                                </div>
                            </div>
                        </div>
					</div>
					<!-- modals -->
				</div>
			</div>
		</div>
	</div>
@endsection
