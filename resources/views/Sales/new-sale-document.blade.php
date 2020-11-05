@extends('Sales.partials.app-new-sale-document')
@section('main-content')
<style>
    .box {
        background-color: #B2D0EF;
        border-radius: 5px;
        width: 30%;
        padding:12px;
        text-align: center;
        margin: 0 auto;
    }
    .card {
        font-family: 'Exo 2', sans-serif;
        border: 1px;
        background-color: #F2E9BB;
        text-align: center;
    }
    .tittle {
        font-family: 'Exo 2', sans-serif;
        padding-top: 5px;
        font-size:12px;
        font-weight:bold;
        text-align: center;
    }
</style>
    <div class="row">
    <input type="hidden" id="arrayProducts" value="{{ json_encode($jsonResponse->products) }}">
        <div class="col-md-8">
            <div class="container" style="background-color: #343a40">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box">
                            Productos
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box">
                            Servicios
                            </div>
                        </div>
                    </div>
                    <br>
                    <input id="listOfProducts" type="hidden" value="{{ json_encode($jsonResponse->products) }}">
                    <div class="row">
                        @foreach($jsonResponse->products as $product)
                            <div class="col-md-3">
                                <div class="card" id="product_{{ $product['id'] }}" onClick="addSelectedProduct({{ $product['id'] }})">
                                    <div align="center" style="padding-top: 5px"><img src="img/producto.png" width="100px" height="90px"></div>
                                    <div>
                                        <hr style="margin-top:5px;margin-bottom:0px; border-top: 1px solid #121210; width:90%">
                                        <h5 class="tittle">{{ $product->name }}</h5>
                                        <h5 class="tittle">S/. {{ $product->price }}</h5>
                                        <h5 class="tittle">(Stock: {{ $product->stock }})</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 ">
            <div class="container" style="background-color: #526273; text-align: center; height: 550px">
                <table class="table">
                    <thead class="static-table-head">
                        <tr>
                            <th class="static-table-th">Código</th>
                            <th class="static-table-th">Nombre</th>
                            <th class="static-table-th">Precio</th>
                            <th class="static-table-th">Cantidad</th>
                            <th class="static-table-th">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="saleTbody">

                    </tbody>
                </table>
            </div>
            <div class="container" style="background-color: #343a40; text-align: center;">
                <h3 style="color: #e6e6e6;">TIPOS DE PAGO:</h3>
                <div style="padding: 2px">
                    <img id="typePayment_1" onclick="typePayments(1);" class="payment-1-selected"/> <!-- title="PAGO EN EFECTIVO"/> -->
                    <img id="typePayment_2" onclick="typePayments(2);" class="payment-2-unselected"/> <!-- title="PAGO EN VISA"/> -->
                    <img id="typePayment_3" onclick="typePayments(3);" class="payment-3-unselected"/> <!-- title="PAGO EN MASTERCARD"/> -->
                    <img id="typePayment_6" onclick="typePayments(6);" class="payment-6-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                    <img id="typePayment_10" onclick="typePayments(10);" class="payment-10-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                    <img id="typePayment_12" onclick="typePayments(12);" class="payment-12-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                    <img id="typePayment_13" onclick="typePayments(13);" class="payment-13-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                    </div>
                    <div style="padding: 5px">
                    <img id="typePayment_14" onclick="typePayments(14);" class="payment-14-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                    <img id="typePayment_15" onclick="typePayments(15);" class="payment-15-unselected"/> <!-- title="PAGO LUKITA"/> -->
                    <img id="typePayment_16" onclick="typePayments(16);" class="payment-16-unselected"/> <!-- title="PAGO YAPE"/> -->
                    <img id="typePayment_17" onclick="typePayments(17);" class="payment-17-unselected"/> <!-- title="PAGO YAPE"/> -->
                    <img id="typePayment_18" onclick="typePayments(18);" class="payment-18-unselected"/> <!-- title="PAGO YAPE"/> -->
                    <img id="typePayment_19" onclick="typePayments(19);" class="payment-19-unselected"/> <!-- title="PAGO YAPE"/> -->
                </div>
                <div class="container" style="padding: 10px">
                    <h3 style="color: #e6e6e6;">OPCIONES DE VENTA</h3>
                    <button class="delete-products" title="Eliminar todos los productos" onClick="clearAllSelectedProduct();"><i class="fas fa-trash"></i></button>
                    <button  title="Finalizar venta" class="pay-button"><i class="fa"></i></button>
                </div>
                
            </div>
        </div>
    </div>
@endsection('main-content')