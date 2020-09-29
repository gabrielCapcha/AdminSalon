@extends('adminlte::layouts.app_dashboard')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
	{{ trans('message.dashboard_title') }}
@endsection
@section('contentheader_description')
	{{ trans('message.dashboard_description') }}
@endsection

@section('sidebar_dashboard')
active
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body" style="padding: 15px;">
						<p>Bienvenidos al panel administrador de TumiPOS</p>
						<input type="hidden" id="jsonResponse" value="{{ json_encode($jsonResponse) }}" />
					</div>
					<!-- modals -->
					<div class="modal fade" id="exchangeRateModal" tabindex="-1" role="dialog" aria-labelledby="exchangeRateModalTitle" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">TIPO DE CAMBIO DEL DÍA</h5>
								</div>
								<div class="modal-body">
									<label for="currency">MONEDA</label>
									<input type="text" class="form-control" id="currency" value="USD" readonly>
									<br>
									<label for="currency">VALOR</label>
									<input type="number" step="0.1" class="form-control" style="width:100%;" onClick="this.select();" id="exchangeRateAmount" value="0.00">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" id="btnSaveExchangeRate" onClick="saveExchangeRate();">CARGANDO DATOS DE SUNAT</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
