@extends('adminlte::layouts.app_new-brand')

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
  {{ trans('message.new_brand') }}
@endsection

@section('main-content')
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">
          <div class="form-group">
              <label for="brandName">{{ trans('message.name') }}</label>
              <input class="form-control" id="brandName" name="brandName" placeholder="{{ trans('message.name') }}" required>
          </div>
          <div class="form-group">
              <label for="brandCode">{{ trans('message.code') }}</label>
              <input type="text" style="width:100%;" class="form-control" id="brandCode" name="brandCode" placeholder="{{ trans('message.code') }}" required>
          </div>
          <div class="box-footer">
            <button type="submit" id="button" onclick="formValidation();" class="btn btn-primary">{{ trans('message.save') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>			
@endsection
