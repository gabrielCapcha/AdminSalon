@extends('adminlte::layouts.app_sales_new_manual_sale')

@section('sidebar_sales')
active
@endsection
@section('sidebar_sales_6')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.new_sales_title') }}
@endsection

@section('contentheader_title')
	{{ trans('message.new_sales_title') }}
@endsection
@section('contentheader_description')
	{{ trans('message.new_sales_description') }}
@endsection

@section('main-content')
    <div class="row" style="height:95vh;">
        <div class="col-md-8 new-sale-custom-left" style="border:1px solid black;">
            <input type="hidden" id="typeDoc" value="{{ $jsonResponse->typeDoc }}">
            <input type="hidden" id="typeDocName" value="{{ $jsonResponse->typeDocName }}">
            @if(count($jsonResponse->categories) > 5)
                <div id="demo" class="col-md-12" style="height:94px;">
                @foreach ($jsonResponse->categories as $category)
                    <button class="new-sale-custom-category-button" style="background-color: #9daeb8; padding:10px;" id="buttonCategory-{{ $category->id }}" onclick="loadProducts({{ $category->id }})">
                        <span class="info-box-text">{{ $category->name }}</span>
                        <span class="info-box-number">Productos: {{ $category->productsCount }}</span>
                    </button>
                @endforeach
                </div>
            @else
                <div align="center" class="col-md-12" style="margin: 15px; height:94px;">
                @foreach ($jsonResponse->categories as $category)
                    <button class="new-sale-custom-category-button" style="background-color: #9daeb8; width:150px; padding:10px;" id="buttonCategory-{{ $category->id }}" onclick="loadProducts({{ $category->id }})">
                        <span class="info-box-text">{{ $category->name }}</span>
                        <span class="info-box-number">Productos: {{ $category->productsCount }}</span>
                    </button>
                @endforeach
                </div>
                <br>
                <br>
                <br>
                <br>
            @endif
            <br>
            <div id="loadingDiv" class="col-md-12" align="center" style="display: none;">
                    <h3 class="box-title">Cargando ...</h3>
                    <i class="fa fa-refresh fa-spin"></i>
                <!-- end loading -->
            </div>
            <div class="products-div-list-custom" id="productsDivList" style="display: none;">
            </div>
        </div>
        <div class="new-sale-custom-right">
            <div class="col-md-12" style="border:1px solid black; padding-top:10px;">
                <!-- /.box-header -->
                <table id="tableSelectedProducts" class="table">
                    <thead class="static-table-head">
                        <tr>
                            <th class="static-table-th">Código</th>
                            <th class="static-table-th">Nombre</th>
                            <th class="static-table-th">Precio</th>
                            <th class="static-table-th">Dscto</th>
                            <th class="static-table-th">Cantidad</th>
                            <th class="static-table-th">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="static-table-body" id="tBodyTableSelectedProducts"></tbody>
                </table>
            </div>
            <div class="col-md-12" style="height: 43.25%; background: #1e282c;">
                <div class='keypad' align="center">
                    <div class='keys col-md-3'>
                        <div class='row'>
                            <button id="genericClient"><i class='fa fa-users'></i></button>
                            <button id="priceList" data-toggle="modal" data-target="#modal-price-list"><i class='fa fa-usd'></i></button>
                            <!-- <button id="buttonTypeDocument" onClick="openTypeDocument();">P</button> -->
                            <button class="pay-button-lng" onclick="secondStepOfSale();" data-toggle="modal" data-target="#modal-second-step" style="height: 102px;"></button>
                            <button id="newClient" data-toggle="modal" data-target="#modal-new-client" style="display:none;"></button>
                        </div>
                    </div>
                    <div class='keys col-md-9'>
                        <div class='row'>
                            <button onClick="setPadNumber(1);">1</button>
                            <button onClick="setPadNumber(2);">2</button>
                            <button onClick="setPadNumber(3);">3</button>
                            <button id="quantityButtonPad" onClick="optionPad(1);"><i class="fa fa-clone"></i></button>
                        </div>
                        <div class='row'>
                            <button onClick="setPadNumber(4);">4</button>
                            <button onClick="setPadNumber(5);">5</button>
                            <button onClick="setPadNumber(6);">6</button>
                            <button id="partialPercentDiscountButtonPad" onClick="optionPad(3);">%</button>
                        </div>
                        <div class='row'>
                            <button onClick="setPadNumber(7);">7</button>
                            <button onClick="setPadNumber(8);">8</button>
                            <button onClick="setPadNumber(9);">9</button>
                            <button id="partialCashDiscountButtonPad" onClick="optionPad(2);"><i class="fa fa-money"></i></button>
                        </div>
                        <div class='row'>
                            <button onClick="clearPadNumber();" id='keypad-change-operation'><i class="fa fa-eraser"></i></button>
                            <button onClick="setPadNumber(0);">0</button>
                            <button onClick="setPadNumber(.);">.</button>
                            <button id='keypad-clear' onClick="clearAllSelectedProduct();"><i class='fa fa-trash'></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!--MODALS-->
            <!-- <div class="modal fade" id="modal-type-document">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 align="center" class="modal-title">Seleccione un tipo de documento</h4>
                        </div>
                        <div class="modal-body">
                            <div align="center" id="typeDocumentsList">
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="modal fade" id="modal-price-list">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 align="center" class="modal-title">Seleccione una lista de precios</h4>
                        </div>
                        <div class="modal-body">
                            <ul id="priceListUl">
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closePriceListModal" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="modal-search-client">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Seleccionar cliente</h4>
                        </div>
                        <div class="col-md-12">
                            <!-- form start -->
                            <div class="col-sm-12" id="divCustomerSearchInput">
                                <br>
                                <div class="input-group">
                                    <input type="text" class="form-control" maxlength="11" id="searchClientSunat" placeholder="Buscar cliente por DNI, RUC">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-info btn-flat" id="searchClientSunatButton">Buscar</button>
                                    </span>
                                </div>
                                <br>
                            </div>
                            <div id="loadingDivCustomer" class="col-sm-12" align="center" style="display: none;">
                                <div class="box-header">
                                    <h3 class="box-title">Cargando ...</h3>
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                                <!-- end loading -->
                            </div>
                            <div class="col-sm-12" id="clientDataResponse">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" id="dismissClient" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="chooseClientOld" class="btn btn-primary" data-dismiss="modal" disabled>Elegir</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="modal-new-client">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">No se encontró al cliente. ¿Desea agregar uno nuevo?</h4>
                        </div>
                        <div class="col-md-12">
                            <!-- form start -->
                            <div class="col-sm-12" id="divNewCustomerSearchInput">
                                <br>
                                <div class="input-group">
                                    <input type="text" class="form-control" maxlength="11" id="searchNewClientSunat" placeholder="Buscar cliente por DNI, RUC">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-info btn-flat" id="searchNewClientSunatButton">Buscar</button>
                                    </span>
                                </div>
                                <br>
                            </div>
                            <div id="loadingDivNewCustomer" class="col-sm-12" align="center" style="display: none;">
                                <div class="box-header">
                                    <h3 class="box-title">Cargando ...</h3>
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                                <!-- end loading -->
                            </div>
                            <div class="col-sm-12" id="newClientDataResponse">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" id="dismissNewClient" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="saveNewClient" class="btn btn-primary" disabled>Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="modal-new-client-simple">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">¿Desea agregar un cliente nuevo sin número DNI?</h4>
                        </div>
                        <div class="col-md-12">
                            <!-- form start -->
                            <div class="col-sm-12" id="newClientSimpleDataResponse">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="saveNewSimpleClient" onClick="saveNewSimpleClient();" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="modal-second-step">
                <form id="formSale" method="POST" action="sales">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                                <h4 align="center" id="totalResumeAmount" class="modal-title"></h4>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12" align="center">
                                    <br>
                                    <p id="clientName"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-body">
                                        <!-- TABLA DE PRODUCTOS -->
                                        <label>Detalle de productos</label>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tBodyTableProductsSummary"></tbody>
                                        </table>
                                        <!-- TABLA DE PRODUCTOS -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="modal-body">
                                        <!-- TABLA DE PAGOS -->
                                        <label>Vueltos y descuentos</label>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">Dscto general <select id="typeGeneralDiscount"><option value="0">S/</option><option value="1">%</option></select></td>
                                                    <td><input type="number" class="form-control" onClick="this.select();" style="width: 100px;" id="generalDiscount" value="0"/></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Vuelto</td>
                                                    <td><input type="number" class="form-control" style="width: 100px;" id="cashInputExchange" value="0" readonly/></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <label>Tipos de pago</label>
                                        <table class="table">
                                            <tbody id="tBodyTablePaymentSummary"></tbody>
                                        </table>
                                        <!-- TABLA DE PAGOS -->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
                                <p id="saleErrorMessage" class="btn btn-default pull-center">Validación correcta</p>
                                <button type="button" id="finishNewSale" class="btn btn-primary" data-dismiss="modal">Finalizar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal modal-success fade" id="modal-final-step">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 align="center" class="modal-title">VENTA EXITOSA</h4>
                        </div>
                        <div class="col-md-12">
                        <br>
                            <div class="col-md-3">
                                <button type="button" id="printSalePdf" class="btn btn-warning">Generar pdf</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="sendSaleEmail" class="btn btn-warning">Enviar por correo</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="salesList" class="btn btn-warning">Lista de ventas</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="newSaleButton" class="btn btn-warning">Nueva venta</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal modal-danger fade" id="modal-error-step">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 align="center" class="modal-title">Hubo un problema en la venta</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onClick="newSaleButtonN();" class="btn btn-primary">Nueva venta</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="modal-new-settings">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align="center">{{$jsonResponse->typeDocName}} MANUAL</h4>
                        </div>
                        <div class="col-md-12">
                            <!-- form start -->
                            <div class="col-sm-12" style="padding:20px;">
                                <br>
                                <label for="serie">Series</label>
                                <select class="form-control" name="serie" id="serie">
                                    <option value="">SELECCIONA UNA SERIE</option>
                                    @foreach ($jsonResponse->series as $serie)
                                        <option value="{{ $serie->serie }}">{{ $serie->serie }} - (Correlativo actual: {{ $serie->number }})</option>
                                    @endforeach
                                </select>
                                <br>
                                <label for="number">Correlativo</label>
                                <input type="number" style="width:100%;" id="number" class="form-control" placeholder="Ingrese correlativo de documento" maxlength="8">
                                <br>
                                <label for="remission_guide">Guía de remisión</label>
                                <input type="text" id="remission_guide" class="form-control" placeholder="Ingrese guía de remisión (Máximo 30 caracteres)" maxlength='30'>
                                <br>
                                <label for="sale_order">Orden de compra</label>
                                <input type="text" id="sale_order" class="form-control" placeholder="Ingrese orden de compra">
                                <br>
                                <label for="advertisement">Aviso</label>
                                <input type="text" id="advertisement" class="form-control" placeholder="Ingrese aviso">
                                <br>
                                <label for="commentary">Comentario interno</label>
                                <input type="text" id="commentary" class="form-control" placeholder="Ingrese un comentario">
                                <br>
                                <label for="commentary_extra">Comentario externo</label>
                                <input type="text" id="commentary_extra" class="form-control" placeholder="Ingrese un comentario">
                                <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="saveNewSettings" onClick="saveNewSettings();" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--MODALS-->
            <button type="button" id="successSale" style="display:none;" data-toggle="modal" data-target="#modal-final-step" data-backdrop="static" data-keyboard="false"></button>
            <button type="button" id="errorSale" style="display:none;" data-toggle="modal" data-target="#modal-error-step"></button>
        </div>
    </div>
@endsection
