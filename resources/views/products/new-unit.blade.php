@extends('adminlte::layouts.app_new-unit')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_config')
  active
@endsection
@section('sidebar_products_7')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_7') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_7') }}
@endsection
@section('contentheader_description')	
    {{ trans('message.new_unit') }}
@endsection

@section('main-content')
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <form id="form" role="form" action="/units" method="POST">
          <div class="box-body">
            <div class="form-group">
                <label for="unitName">{{ trans('message.name') }}</label>
                <input class="form-control" id="unitName" name="unitName" placeholder="{{ trans('message.name') }}">
            </div>
            <div class="box-footer">
              <button type="submit" id="button" onclick="formValidation();" class="btn btn-primary">{{ trans('message.save') }}</button>
            </div>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
    </div>
  </div>
</section>		
@endsection
