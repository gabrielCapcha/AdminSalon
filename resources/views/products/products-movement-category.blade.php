@extends('products.partials.app_products-movement')

@section('sidebar_products')
active
@endsection
@section('sidebar_product_management')
active
@endsection

@section('sidebar_products_movement')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_products_movement') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_products_movement') }}
@endsection

@section('contentheader_description')	
  {{ trans('message.sidebar_products_movement_description') }}
@endsection

@section('main-content')
<div class="row">
		<div class="row">
            <div class="col-sm-12" align="center">
				<input type="hidden" id="warehousesJson" value="[]">
				<select id="categoryId" class="form-control" onChange="goToProductMovement();">
					<option selected value="0">SELECCIONE UNA CATEGORÍA</option>
					@foreach ($jsonResponse->categories as $object)
						<option value="{{ $object->id }}">{{ $object->name }}</option>
					@endforeach
				</select>
            </div>
		</div>
	</div>
@endsection
