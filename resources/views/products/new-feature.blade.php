@extends('adminlte::layouts.app_new-feature')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_config')
  active
@endsection
@section('sidebar_products_6')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_6') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_6') }}
@endsection
@section('contentheader_description')	
    {{ trans('message.new_feature') }}
@endsection

@section('main-content')
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-body">
          <div class="form-group">
            <label for="featureName">{{ trans('message.name') }}</label>
            <input class="form-control" id="featureName" name="featureName" placeholder="INGRESE NOMBRE DE CARACTERÍSTICA" required>
          </div>
          <div class="form-group">
            <label for="featureName">OPCIONES</label>
            <table id="table" class="table">
              <thead>
                <tr>
                  <th>SELECCIÓN</th><th>IDENTIFICADOR</th><th>Nombre del identificador</th>
                </tr>
              </thead>
              <tbody id="featureTableBody">
                <tr>
                  <td><input id="featureCategoryCheckbox_0" type="checkbox" class="minimal" checked></td><td><input id="featureCategoryId_0" type="text" class="form-control"></td><td><input id="featureCategoryName_0" type="text" class="form-control"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" id="button" onclick="formValidation();" class="btn btn-block btn-danger">{{ trans('message.save') }}</button>
        </div>
		  </div>
      <!-- /.box-body -->
    </div>
  </div>
</section>
@endsection
