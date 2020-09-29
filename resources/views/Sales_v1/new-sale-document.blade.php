@extends('Sales.partials.app-new-sale-document')
@section('main-content')
<div class="col-md-4">
<div class="modal-body">
    <!-- TABLA DE PRODUCTOS -->
    <label id="productDetailsLabel">DETALLE DE PRODUCTOS</label>
    <table id="tableProductsResume" class="table">
        <thead>
            <th>CÓDIGO</th>
            <th>NOMBRE</th>
            <th>PRECIO</th>
        </thead>
    <tbody id="tableSerialResumeBody">
    </tbody>
    </table>
    <!-- TABLA DE PRODUCTOS -->
</div>
</div>
@endsection('main-content')