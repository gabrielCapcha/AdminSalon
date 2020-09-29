@extends('adminlte::layouts.app_edit_category')

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
    EDITAR CATEGORÍA
@endsection

@section('main-content')
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <!-- <form id="form" role="form" action="/categories" method="POST"> -->
          <div class="box-body">
            <div class="form-group">
              <label for="categoryName">{{ trans('message.name') }}</label>
              <input type="hidden" id="jsonResponse" value="{{ json_encode($jsonResponse) }}" />
              <input class="form-control" id="categoryName" name="categoryName" placeholder="INGRESE NOMBRE DE CATEGORÍA" value="{{ $jsonResponse->categoryInfo->name }}">
            </div>
			      <div class="form-group">
              <label for="selectWarehouse">{{ trans('message.warehouse_store') }}</label>
              <select id="warehouseId" name="warehouseId" class="form-control">
                <option value="0">{{ trans('message.select_warehouse_store') }}</option>
                @foreach ($jsonResponse->warehouses as $object)
                  @if ($object->id == $jsonResponse->categoryInfo->warehouseId)
                    <option selected value="{{ $object->id }}">{{ $object->name }}</option>
                  @else
                    <option value="{{ $object->id }}">{{ $object->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
                <label for="selectFeature">{{ trans('message.features1') }}</label>
                {{ $condition = false }}
                <select class="select2" multiple="multiple" data-placeholder="Seleccione uno o varios" id="featureId" name="featureId" style="width: 100%;">
                  <option></option>
                  @foreach ($jsonResponse->features as $object)
                    <option value="{{ $object->id }}">{{ $object->name }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
              <button type="submit" id="button" onclick="formValidation();" class="btn btn-block btn-danger">{{ trans('message.save') }}</button>
            </div>
          </div>
          <!-- /.box-body -->
        <!-- </form> -->
      </div>
    </div>
  </div>
</section>
@endsection
