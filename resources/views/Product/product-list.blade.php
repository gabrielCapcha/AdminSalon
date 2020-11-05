@extends('Product.partials.app-product')
@section('main-content')
<div style="padding: 20px">
    <button class="btn btn-primary" onClick="createProduct()">Crear nuevo producto</button>
</div>
<input type="hidden" value="{{ json_encode($jsonResponse->products) }}" id="listOfProducts"></input>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-hover dataTable">
            <thead>
            <tr role="row">
                <th class="sorting_asc">Nombres</th>
                <th class="sorting_asc">Código</th>
                <th class="sorting_asc">Precio</th>
                <th class="sorting_asc">Fecha de ingreso</th>
                <th class="sorting_asc">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($jsonResponse->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->register_date }}</td>
                    <td>
                        <button class="btn btn-info btn-xs" onClick="infoProduct({{ $product->id }});" style="width: 25px">
                        <i class="fas fa-info"></i>
                        </button>
                        <button class="btn btn-warning btn-xs" onClick="editProductModal({{ $product->id }});" style="width: 25px">
                        <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-xs" onClick="deleteProduct({{ $product->id }});" style="width: 25px">
                        <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
</div>
<!-- Modals -->
<!-- Create product modal -->
<div class="modal fade show" id="modal-new-product">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Agregar nuevo producto</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-6" style="padding-right: 30px; padding-left: 20px">
                    <label for="productName">NOMBRE</label>
                    <input class="form-control" type="text" id="productName" name="productName" placeholder="Ingrese nombre del producto">
                    <br>
                    <label for="productName">PRECIO</label>
                    <input class="form-control" type="number" id="productPrice" name="productPrice" placeholder="Ingrese el precio del producto">
                </div>
                <div class="col-xs-6">
                    <label for="productName">CÓDIGO</label>
                    <input class="form-control" type="number" id="productCode" name="productCode" placeholder="Ingrese código del producto">
                    <br>
                    <label for="productName">FECHA</label>
                    <input class="form-control" type="date" id="productDate" name="productDate">
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-default" style="float: left; float: left!important;" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="createNewProduct();">Guardar</button>
        </div>
      </div>
  </div>
</div>
<!-- info product modal -->
<div class="modal fade show" id="modal-info-product">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #00c0ef">
            <h4 class="modal-title">Información del producto</h4>
        </div>
        <div class="modal-body" style="background-color: #00c0ef">
            <div class="row">
                <div class="col-xs-6" style="padding-right: 30px; padding-left: 20px">
                    <label for="productName">NOMBRE</label>
                    <input class="form-control" type="text" readOnly id="infoProductName" name="productName">
                    <br>
                    <label for="productName">PRECIO</label>
                    <input class="form-control" type="number" readOnly id="infoProductPrice" name="productPrice">
                </div>
                <div class="col-xs-6">
                    <label for="productName">CÓDIGO</label>
                    <input class="form-control" type="number" readOnly id="infoProductCode" name="productCode">
                    <br>
                    <label for="productName">FECHA</label>
                    <input class="form-control" type="date" readOnly id="infoProductDate" name="productDate">
                </div>
            </div>
        </div>
        <div class="modal-footer" style="background-color: #00c0ef">
            <button type="button" class="btn btn-default" style="float: left; float: left!important;" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
  </div>
</div>
<!-- edit product modal -->
<div class="modal fade show" id="modal-edit-product">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #00c0ef">
            <h4 class="modal-title">Información del producto</h4>
        </div>
        <div class="modal-body" style="background-color: #00c0ef">
            <div class="row">
                <div class="col-xs-6" style="padding-right: 30px; padding-left: 20px">
                    <label for="productName">NOMBRE</label>
                    <input class="form-control" type="text" id="editProductName" name="productName">
                    <br>
                    <label for="productName">PRECIO</label>
                    <input class="form-control" type="number" id="editProductPrice" name="productPrice">
                </div>
                <div class="col-xs-6">
                    <label for="productName">CÓDIGO</label>
                    <input class="form-control" type="number" id="editProductCode" name="productCode">
                    <br>
                    <label for="productName">FECHA</label>
                    <input class="form-control" type="date" readOnly id="editProductDate" name="productDate">
                </div>
            </div>
        </div>
        <div class="modal-footer" style="background-color: #00c0ef">
            <button type="button" class="btn btn-default" style="float: left; float: left!important;" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-default" onClick="saveProduct(id);" style="float: left; float: left!important;" data-dismiss="modal">Guardar</button>
        </div>
      </div>
  </div>
</div>
@endsection
