@extends('adminlte::layouts.app_remission_guides_new')

@section('sidebar_remission_guide')
active
@endsection
@section('sidebar_remission_guide_new')
active
@endsection

@section('htmlheader_title')
	{{ trans('message.sidebar_remission_guide_new') }}
@endsection

@section('contentheader_title')
	{{ trans('message.sidebar_remission_guide_new') }}
@endsection
@section('contentheader_description')
 <!-- <a href="/new-quotation"> {{ trans('message.create_new_quotation') }} </a> -->
@endsection

@section('main-content')
    <button id="newClient" data-toggle="modal" data-target="#modal-new-client" style="display:none;"></button>
    <div class="row" style="height:95vh;">
        <div class="col-md-8 new-sale-custom-left" style="border:1px solid black;">
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
            <div class="col-md-12" style="border:1px solid black; padding-top:10px; height: 90%; display: block;">
                <!-- /.box-header -->
                <table id="tableSelectedProducts" class="table">
                    <thead class="static-table-head">
                        <tr>
                            <th class="static-table-th-grm">Código</th>
                            <th class="static-table-th-grm">Nombre</th>
                            <th class="static-table-th-grm">Cantidad</th>
                            <th class="static-table-th-grm">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="static-table-body-grm" id="tBodyTableSelectedProducts">
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="height: 10%; background: #1e282c;">
                <div align="center">
                    <button class="btn btn-block btn-warning" style="width: 300px;margin-top: 3%;" onclick="secondStepOfSale();" data-toggle="modal" data-target="#modal-second-step">CONTINUAR</button>
                </div>
            </div>
            <!--MODALS-->
            <input type="hidden" value="{{ json_encode($jsonResponse->users) }}" id="listOfUsers"></input>
            <div class="modal fade" id="modal-type-document">
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
            </div>
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
                        <div class="col-md-12"  style="padding:10px;">
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
                        <div class="col-md-12"  style="padding:10px;">
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
                            <button type="button" id="saveNewClient" onClick="this.disabled=true;" class="btn btn-primary" disabled>Guardar</button>
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
                            <button type="button" id="saveNewSimpleClient" onClick="this.disabled=true; saveNewSimpleClient();" class="btn btn-primary">Guardar</button>
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
                                        <label>Detalle de productos seleccionados</label>
                                        <table class="table static-table-body-summary">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
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
                                        <!-- TABLA DE PRODUCTOS -->
                                        <label>Cotizaciones afectadas</label>
                                        <table class="table static-table-body-summary">
                                            <thead>
                                                <tr>
                                                    <th>Ticket</th>
                                                    <th>Fecha</th>
                                                    <th>Productos</th>
                                                    <th>Afectados</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tBodyTableQuotationSummary"></tbody>
                                        </table>
                                        <!-- TABLA DE PRODUCTOS -->
                                    </div>
                                </div>
                                <div class="col-md-6" style="display:none;">
                                    <div class="modal-body">
                                        <!-- TABLA DE PAGOS -->
                                        <label>Servicio</label>
                                        <table class="table" style="margin-bottom:0px;">
                                            <tbody id="tBodyTableServicesSummary">
                                                <tr>
                                                    <td width="50%"> {{ $jsonResponse->service_percent }} % <input type="hidden" id="servicePercentValue" value="{{ $jsonResponse->service_percent }}"></td>
                                                    <td><input type="number" class="form-control" readonly style="width: 100px;" id="generalService" value="0"/></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <label>Vueltos y descuentos</label>
                                        <table class="table" style="margin-bottom:0px;">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">Dscto general <select id="typeGeneralDiscount"><option value="0">S/</option><option value="1">%</option></select></td>
                                                    <td><input type="number" class="form-control" onClick="this.select();" style="width: 100px;" id="generalDiscount" value="0"/></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Vuelto</td>
                                                    <td><input type="number" class="form-control" style="width: 100px;" id="cashInputExchange" value="0" readonly/></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Promociones</td>
                                                    <td><input type="number" class="form-control" style="width: 100px;" id="promotionDiscount" value="0" readonly/></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <label>Tipos de pago</label>
                                        <table class="table" style="margin-bottom:0px;">
                                            <tbody id="tBodyTablePaymentSummary"></tbody>
                                        </table>
                                        <!-- TABLA DE PAGOS -->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
                                <p id="saleErrorMessage" class="btn btn-default pull-center">Validación correcta</p>
                                <button type="button" id="finishNewSale" onClick="this.disabled=true;" class="btn btn-primary" data-dismiss="modal">Finalizar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal modal-success fade" id="modal-final-step">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 align="center" class="modal-title">GUÍA DE REMISIÓN EXITOSA</h4>
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
                                <button type="button" id="salesList" class="btn btn-warning">Lista de guías</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="newSaleButton" class="btn btn-warning">Nueva guía de remisión</button>
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
                            <h4 align="center" class="modal-title">Hubo un problema en la guía de remisión</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onClick="newSaleButtonN();" class="btn btn-primary">Nueva guía de remisión</button>
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
                            <h4 class="modal-title">DATOS ADICIONALES DE LA GUÍA DE REMISIÓN</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <!-- form start -->
                            <div class="col-sm-6">
                                <label for="startPoint">Punto de partida</label>
                                <select id="startPoint" class="form-control">
                                    @foreach ($jsonResponse->warehouses as $object)
                                        @if (!is_null($object->address))
                                            <option value="{{ $object->address }}"> {{ $object->name }} - {{ $object->address }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                <br>
                                <label for="startDate">Fecha de inicio del traslado</label>
                                <input type="text" id="startDate" class="form-control" style="width: 100%;" placeholder="Ingrese una fecha de inicio del traslado" value="{{ date('d-m-Y') }}" maxlength='11'>
                                <br>
                                <label for="orderNumber">Nº de orden de compra</label>
                                <input type="text" id="orderNumber" class="form-control" placeholder="Ingrese un nº de orden de compra" maxlength='100'>
                                <br>
                                <label for="remissionGuideType">Tipo de traslado</label>
                                <select id="remissionGuideType" class="form-control">
                                    <option value="1"> VENTA </option>
                                    <option value="2"> VENTA SUJETA A CONFIRMAR </option>
                                    <option value="3"> CONSIGNACIÓN </option>
                                    <option value="4"> DEVOLUCIÓN </option>
                                    <option value="5"> ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA </option>
                                    <option value="6"> PARA TRANSFORMACIÓN </option>
                                    <option value="7"> RECOJO DE BIENES TRANSFORMADOS </option>
                                    <option value="8"> EMISOR ITINERANTE </option>
                                    <option value="9"> ZONA PRIMARIA </option>
                                    <option value="10"> IMPORTACIÓN </option>
                                    <option value="11"> EXPORTACIÓN </option>
                                    <option value="12"> OTROS </option>
                                </select>
                                <br>
                                <label for="commentary">Comentario/Observación</label>
                                <input type="text" id="commentary" class="form-control" placeholder="Observación de guía de remisión" maxlength='250'>
                                <br>
                            </div>
                            <div class="col-sm-6">
                                <label for="endPoint">Punto de llegada</label>
                                <select id="endPoint" class="form-control">
                                    <option value="0"> Seleccione una sucursal de cliente </option>
                                </select>
                                <br>
                                <label for="receiverName">Encargado de recepción</label>
                                <input type="text" id="receiverName" class="form-control" placeholder="Ingrese un destinatario" maxlength='250'>
                                <br>
                                <label for="rucNumber">Número de RUC o DNI</label>
                                <input type="text" id="rucNumber" class="form-control" placeholder="Ingrese número de RUC" maxlength='11'>
                                <br>
                                <label for="typeDocument">TIPO DE DOCUMENTOS</label>
                                <select id="typeDocument" class="form-control">
                                    <!-- <option value="GRM"> GUÍA DE REMISIÓN TRANSPORTISTA</option> -->
                                    @if ($jsonResponse->companyId != 474)
                                        <option selected value="GRR"> GUÍA DE REMISIÓN REMITENTE</option>
                                    @endif
                                    <option value="GRI"> GUÍA DE REMISIÓN INTERNA </option>
                                </select>
                                <br>
                                <label for="noUpdateStock">¿DESCONTAR STOCK?</label>
                                <select id="noUpdateStock" class="form-control">
                                    @if ($jsonResponse->companyId == 474 || $jsonResponse->companyId == 608 || $jsonResponse->companyId == 448)
                                        <option value="0"> NO DESCONTAR STOCK</option>
                                        <option selected value="1"> SI DESCONTAR STOCK </option>
                                    @else
                                        <option selected value="0"> NO DESCONTAR STOCK</option>
                                        <option value="1"> SI DESCONTAR STOCK </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" onClick="saveNewSettings();" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="modal-new-driver-form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">DATOS DE LA EMPRESA DE TRANSPORTE Y EL CONDUCTOR</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <!-- form start -->
                            <div class="col-sm-6">
                                <select id="traCompany" onChange="traCompanyChange();" class="form-control">
                                    <option value="0">SELECCIONE UNA EMPRESA</option>
                                    @foreach ($jsonResponse->traCompanies as $object)
                                        <option value="{{ $object->id }}"> {{ $object->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select id="traDriver" class="form-control">
                                    <option value="0">SELECCIONE UN CONDUCTOR</option>
                                </select>
                            </div>
                            <hr>
                            <div class="col-sm-6">
                                <select id="traTruckBrand" onChange="traTruckBrandChange();" class="form-control">
                                    <option value="0">SELECCIONE UNA MARCA</option>
                                    @foreach ($jsonResponse->traTruckBrands as $object)
                                        <option value="{{ $object->id }}"> {{ $object->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select id="traTruck" class="form-control">
                                    <option value="0">SELECCIONE UN CAMIÓN</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-danger">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">NO SE PUEDE PROCESAR LA GUÍA DE REMISIÓN</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="form-control" id="modalDangerValidationText"></ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default">REGRESAR</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-on-load">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" align="center">
                            <h1 class="modal-title">Procesando guía de remisión...</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-promotions-active">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">PROMOCIONES ACTIVADAS</h4>
                        </div>
                        <div class="col-md-12">
                            <!-- form start -->
                            <div class="col-sm-12">
                                <ul style="margin:10px;" id="promotionsActive"></ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>
            <div class="modal fade" id="modal-promotions-inactive">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" align="center">
                            <h4 class="modal-title" id="messagePromotionsInactive">SE RETIRARON LAS PROMOCIONES</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-product-detail">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" align="center">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="productDetailHeader">DETALLE DE PRODUCTO</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <blockquote>
                                <p id="productDetailDescription"></p>
                            </blockquote>
                            <div class="col-md-6">
                                <label for="">CÓDIGO DE PRODUCTO</label>
                                <p id="productDetailCode"></p>
                                <label for="">CÓDIGO DE BARRA</label>
                                <p id="productDetailAutoBarCode"></p>
                                <label for="">CATEGORÍA</label>
                                <p id="productDetailCategory"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="">MODELO</label>
                                <p id="productDetailModel"></p>
                                <label for="">MARCA</label>
                                <p id="productDetailBrand"></p>
                            </div>
                            <div class="col-md-12" align="center">
                            <hr>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ALMACÉN</th>
                                            <th>UBICACIÓN</th>
                                            <th>STOCK</th>
                                            <th>P.UNITARIO</th>
                                            <th>CANTIDAD</th>
                                            <th>P.XMAYOR</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productDetailStockPriceListTBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>
            <div class="modal fade" id="modal-search-sale">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="col-md-12" style="padding:10px;">
                            <div class="col-sm-12" id="searchQuotationDataDetail" align="center">
                            </div>
                            <div class="col-sm-12" style="padding:10px;" id="searchQuotationDataResponse" align="center">
                                <table id="searchQuotationTable" class="table">
                                    <thead>
                                        <th>OPCIÓN</th>
                                        <th>TICKET</th>
                                        <th>O.COMPRA</th>
                                        <th>#ITEMS</th>
                                        <th>MONEDA</th>
                                        <th>MONTO</th>
                                        <th>FECHA</th>
                                        <th>DIRECCIÓN</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" id="dismissSearchQuotation" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="saveSearchQuotation" onClick="saveSearchQuotationSubmit();" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal modal-primary fade" id="modal-allotment">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 align="center" class="modal-title" id="allotmentModalTitle">Asignación de Lotes a producto: </h4>
                        <h4 align="center" class="modal-title"><strong>Presione el botón VALIDAR CANTIDADES para agregar el registro</strong></h4>
                    </div>
                    <div class="modal-body-5" id="allotmentResume">
                    <table id="tableAllotmentProduct" class="table">
                        <thead>
                        <tr>
                            <th>PRODUCTO</th>
                            <th>LOTE</th>
                            <th>CANTIDAD</th>
                            <th>DISPONIBLE</th>
                            <th>INGRESO</th>
                            <th>FECHA EXPIRACIÓN</th>
                        </tr>
                        </thead>
                        <tbody id="tableAllotmentProductBody">
                        </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" onClick="allotmentValidation();" class="btn btn-default">Validar cantidades</button>
                    <button type="button" id="allotmentButtonSubmit" disabled onClick="allotmentSubmit();" class="btn btn-outline pull-right" data-dismiss="modal">Guardar</button>
                    </div>
                </div>
                </div>
            </div>
            <!--MODALS-->
        </div>
    </div>
@endsection
