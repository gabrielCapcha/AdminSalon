@extends('sales.partials.app_new_sale_stylish')

@section('sidebar_sales')
active
@endsection
@section('sidebar_sales_0')
active
@endsection

@section('htmlheader_title')
    @if (isset($jsonResponse->bladeName))
        {{ $jsonResponse->bladeName }}
    @else
	    {{ trans('message.new_sales_title') }}
    @endif
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
            @if(count($jsonResponse->categories) > 5)
                <div id="demo" class="col-md-12" style="height:94px;">
                @foreach ($jsonResponse->categories as $category)
                    <button class="new-sale-custom-category-button" style="background-color: #9daeb8; padding:10px;" id="buttonCategory-{{ $category->id }}">
                        <span onclick="loadProducts({{ $category->id }})" class="info-box-text">{{ $category->name }}</span>
                        <span class="info-box-number">
                            Productos: {{ $category->productsCount }}
                        </span>
                    </button>
                @endforeach
                </div>
            @else
                <div align="center" class="col-md-12" style="margin: 15px; height:94px;">
                @foreach ($jsonResponse->categories as $category)
                    <button class="new-sale-custom-category-button" style="background-color: #9daeb8; width:150px; padding:10px;" id="buttonCategory-{{ $category->id }}">
                        <span onclick="loadProducts({{ $category->id }})" class="info-box-text">{{ $category->name }}</span>
                        <span class="info-box-number">
                            Productos: {{ $category->productsCount }}
                        </span>
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
                @if(isset($jsonResponse->documentTp[0]['code']))
                    <input type="hidden" value="{{ $jsonResponse->documentTp[0]['code'] }}" id="isQuotation"></input>
                @else
                    <input type="hidden" value="BOLETA" id="isQuotation"></input>
                @endif
                <table id="tableSelectedProducts" class="table">
                    <thead class="static-table-head">
                        <tr>
                            <th class="static-table-th">Código</th>
                            <th class="static-table-th">Nombre</th>
                            <th class="static-table-th">Precio</th>
                            <th class="static-table-th">Dscto</th>
                            <th class="static-table-th">Cantidad</th>
                            <th class="static-table-th">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="static-table-body" id="tBodyTableSelectedProducts"></tbody>
                </table>
            </div>
            <div class="col-md-12" style="height: 43.25%; background: #1e282c;">
                <div class='keypad' align="center">
                    <div class='keys col-md-12'>
                        <div class="row">
                            <h3 style="color: #e6e6e6;">TIPOS DE PAGO:</h3>
                            <button id="newClient" data-toggle="modal" data-target="#modal-new-client" style="display:none;"></button>
                            <img id="typePayment_1" onclick="typePayments(1);" class="payment-1-selected"/> <!-- title="PAGO EN EFECTIVO"/> -->
                            <img id="typePayment_2" onclick="typePayments(2);" class="payment-2-unselected"/> <!-- title="PAGO EN VISA"/> -->
                            <img id="typePayment_3" onclick="typePayments(3);" class="payment-3-unselected"/> <!-- title="PAGO EN MASTERCARD"/> -->
                            <img id="typePayment_6" onclick="typePayments(6);" class="payment-6-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                            <img id="typePayment_10" onclick="typePayments(10);" class="payment-10-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                            <!-- <img id="typePayment_11" onclick="typePayments(11);" class="payment-11-unselected"/> title="PAGO EN DEPOSITO"/> -->
                            <img id="typePayment_12" onclick="typePayments(12);" class="payment-12-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                            <img id="typePayment_13" onclick="typePayments(13);" class="payment-13-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                            <br>
                            <br>
                            <img id="typePayment_14" onclick="typePayments(14);" class="payment-14-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                            <img id="typePayment_15" onclick="typePayments(15);" class="payment-15-unselected"/> <!-- title="PAGO LUKITA"/> -->
                            <img id="typePayment_16" onclick="typePayments(16);" class="payment-16-unselected"/> <!-- title="PAGO YAPE"/> -->
                            <img id="typePayment_17" onclick="typePayments(17);" class="payment-17-unselected"/> <!-- title="PAGO YAPE"/> -->
                            <img id="typePayment_18" onclick="typePayments(18);" class="payment-18-unselected"/> <!-- title="PAGO YAPE"/> -->
                            <img id="typePayment_19" onclick="typePayments(19);" class="payment-19-unselected"/> <!-- title="PAGO YAPE"/> -->
                            <img id="typePayment_8" onclick="typePayments(8);" class="payment-8-unselected"/>
                            <!-- <img id="typePayment_9" onclick="typePayments(9);" class="payment-9-unselected"/> -->
                            <!-- <input type="button" style="margin-left:1em;" type="button" id="buttonPaymentAmount " class="btn btn-danger" value="S/ 0.00" /> -->
                        </div>
                    </div>
                    <div class='keys col-md-12'>
                        <div class='row'>
                            <h3 style="color: #e6e6e6;">OPCIONES DE VENTA</h3>
                            <button id="partialPercentDiscountButtonPad" title="Aplicar descuento en porcentaje" onClick="optionPad(3);">%</button>
                            <button id="partialCashDiscountButtonPad" title="Aplicar descuento en dinero" onClick="optionPad(2);"><i class="fa fa-money"></i></button>
                            <button id='keypad-clear' title="Eliminar todos los productos" onClick="clearAllSelectedProduct();"><i class='fa fa-trash'></i></button>
                            <button id="priceList" title="Cambiar lista de precios" data-toggle="modal" data-target="#modal-price-list"><i class='fa fa-usd'></i></button>
                            <button onclick="newSettingsForm();" title="Opciones adicionales de venta"><i class="fa fa-gears"></i></button>
                            <button onclick="secondStepOfSale();" title="Finalizar venta" class="pay-button"><i class="fa"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!--MODALS-->
            <input type="hidden" value="{{ json_encode($jsonResponse->users) }}" id="listOfUsers"></input>
            <input type="hidden" id="preAddProductId"></input>
            <!-- $jsonResponse->user['roles_config'][0]['apps_id'] -->
            <div class="modal fade" id="modal-select-employee">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeEmployeeModal()">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">EMPLEADOS A COMISIONAR</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <!-- form start -->
                            <div id="employeeSelector"></div>
                            <br>
                            <div class='row' id='detailEmployee' align="center">
                                <div class="col-md-12" style="padding:5px;">
                                <div class="col-md-4">EMPLEADO</div>
                                <div class="col-md-4">PRODUCTO</div>
                                <div class="col-md-4">PRECIO</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button id="employeeCancel" type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="removeEmployeeModal()">Cancelar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addAllCommissions()">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>

            <div class="modal fade" id="modal-customer-subsidiary">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 id="customerSubsidiaryText" class="modal-title">SUCURSALES DE CLIENTE - LUGARES DE DESPACHO</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <!-- form start -->
                            <div id="rowsCustomerSubsidiaries" align="center">

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
                            <h4 class="modal-title">¿Desea registrar un cliente nuevo?</h4>
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
            <div class="modal fade" id="modal-subcategories">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 id="subCategoryModalText" class="modal-title">SUBCATEGORÍAS DISPONIBLES</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <!-- form start -->
                            <div id="rowSubCategories" align="center">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">REGRESAR</button>
                            <button type="button" class="btn btn-primary" onClick="loadProductsSubcategory();" data-dismiss="modal">FILTRAR</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="modal-second-step">
                <div class="modal-dialog modal-lg" style="width:1250px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 align="center" id="totalResumeAmount" class="modal-title"></h4>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="modal-body">
                                    <!-- TABLA DE PRODUCTOS -->
                                    <label id="productDetailsLabel">DETALLE DE PRODUCTOS</label>
                                    <table class="table static-table-body-summary">
                                        <thead>
                                            <tr>
                                                <th>CÓDIGO</th>
                                                <th>NOMBRE</th>
                                                <th>PRECIO</th>
                                                <th>CANT.</th>
                                                <th>OPCIÓN</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tBodyTableProductsSummary"></tbody>
                                    </table>
                                    <!-- TABLA DE PRODUCTOS -->
                                </div>
                            </div>
                            <div class="col-md-4" style="padding:0px;">
                                <div class="modal-body">
                                    <!-- TABLA DE MONEDAS -->
                                    <!-- <label>MONEDA DE PAGO - TIPO DE CAMBIO</label>
                                    <table class="table" style="margin-bottom:0px;">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    <select id="generalCurrency">
                                                        <option value="PEN">PEN S/</option>
                                                        <option value="USD">USD $</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" onClick="loadChangeRate();" class="btn btn-success"><i id="faRefresh" class="fa fa-refresh"></i></button>
                                                        </div>
                                                        <input type="number" class="form-control" step="0.1" onClick="this.select();" style="width: 100%;" id="generalCurrencyConvertionRv" value="1.00"/>
                                                        <div class="input-group-btn">
                                                            <button type="button" onClick="changeRate();" class="btn btn-info"><i class="fa fa-check"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> -->
                                    <!-- TABLA DE MONEDAS -->
                                    <label>SERVICIOS</label>
                                    <table class="table" style="margin-bottom:0px;">
                                        <tbody id="tBodyTableServicesSummary">
                                            <tr>
                                                <td style="vertical-align: middle;" width="50%"> {{ $jsonResponse->service_percent }} % <input type="hidden" id="servicePercentValue" value="{{ $jsonResponse->service_percent }}"></td>
                                                <td><input type="number" class="form-control" readonly style="width: 100%;" id="generalService" value="0"/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <label>PROMOCIONES</label>
                                    <table class="table" style="margin-bottom:0px;">
                                        <tbody id="tBodyTableServicesSummary">
                                            <tr>
                                                <td style="vertical-align: middle;" width="50%">Promociones</td>
                                                <td><input type="number" class="form-control" style="width: 100%;" id="promotionDiscount" value="0" readonly/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <label>DESCUENTOS</label>
                                    <table class="table" style="margin-bottom:0px;">
                                        <tbody id="tBodyTableServicesSummary">
                                            <tr>
                                                <td width="50%" style="vertical-align: middle;"><select id="typeGeneralDiscount"><option value="0">DINERO</option><option value="1">PORCENTAJE</option></select></td>
                                                <td><input type="number" class="form-control" onClick="this.select();" style="width: 100%;" id="generalDiscount" value="0"/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <label>COMENTARIO INTERNO</label>
                                    <textarea name="commentaryST" id="commentaryST" class="form-control" placeholder="Ingrese un comentario interno"></textarea>
                                    <label>COMENTARIO EXTERNO</label>
                                    <textarea name="commentaryEXT" id="commentaryEXT" class="form-control" placeholder="Ingrese un comentario externo"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="modal-body">
                                    <!-- TABLA DE PAGOS -->
                                    <label id="labelTotalAmount">TOTAL A PAGAR - S/ 0.00</label>
                                    <table class="table" style="margin-bottom:0px;">
                                        <tbody id="tBodyTablePaymentSummary"></tbody>
                                    </table>
                                    <label>VUELTOS</label>
                                    <table class="table" style="margin-bottom:0px;">
                                        <tbody id="tBodyTableServicesSummary">
                                            <tr>
                                                <td style="vertical-align: middle;" width="50%">Vuelto</td>
                                                <td><input type="number" class="form-control" style="width: 100%;" id="cashInputExchange" value="0" readonly/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- TABLA DE PAGOS -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevExoneradas"><b>OP.EXONERADAS: 0.00</b></p>
                            </div>
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevInafectas"><b>OP.INAFECTAS: 0.00</b></p>
                            </div>
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevGratuitas"><b>OP.GRATUITAS: 0.00</b></p>
                            </div>
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevSubtotal"><b>OP.GRAVADAS: 0.00</b></p>
                            </div>
                            
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevBag"><b>PRECIO BOLSAS: 0.00</b></p>
                            </div>
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevIcbper"><b>ICBPER: 0.00</b></p>
                            </div>
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevIgv"><b>IGV: 0.00</b></p>
                            </div>
                            <div class="col-md-3" align="center">
                                <p class="form-control" id="finalStepPrevTotal"><b>TOTAL: 0.00</b></p>
                            </div>
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Regresar</button>
                            <button disabled type="button" id="saleErrorMessage" class="btn btn-default pull-center">Validación correcta</button>
                            <button type="button" id="btnFinishNewSale" onClick="validateSale();" class="btn btn-primary" >VALIDAR</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-cash-management">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" align="center" id="tdMultCurTotal">GESTIÓN DE EFECTIVO</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <table class="table">
                                <thead>
                                    <th>MONEDA</th>
                                    <th>MONTO INGRESADO</th>
                                    <th>T/C</th>
                                    <th>TOTAL</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>PEN - S/</td>
                                        <td><input type="number" id="cashManagementInputPEN" step="0.1" onClick="this.select();" class="form-control" style="width: 100px;" value="0.00"/></td>
                                        <td id="tdMultCurConvertion_PEN"></td>
                                        <td id="tdMultCurTotal_PEN">S/ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td>USD - $</td>
                                        <td><input type="number" id="cashManagementInputUSD" step="0.1" onClick="this.select();" class="form-control" style="width: 100px;" value="0.00"/></td>
                                        <td id="tdMultCurConvertion_USD"></td>
                                        <td id="tdMultCurTotal_USD">$ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">TOTAL EN SOLES - (PEN S/)</td>
                                        <td id="cashManagementTotal">S/ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">VUELTO EN SOLES - (PEN S/)</td>
                                        <td id="cashManagementExchange">S/ 0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="saveCashPaymentManagement" onClick="validateCashPaymentManagement();" class="btn btn-primary">VALIDAR</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
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
            <div class="modal modal-warning fade" id="modal-final-step">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 align="center" class="modal-title" style="color: black;">{{ $jsonResponse->bladeSingularName }} EXITOSA</h3>
                        </div>
                        <div class="col-md-12">
                            <br>
                                <div class="col-md-4">
                                    <button type="button" onClick="salesList({{ $jsonResponse->bladeFunctionList }});" class="btn" style="width:100%">LISTADO DE {{ $jsonResponse->bladePluralName }}</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="newSaleButton" class="btn" style="width:100%">NUEVA {{ $jsonResponse->bladeSingularName }}</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" onClick="salesReport();" class="btn" style="width:100%">REPORTE DE {{ $jsonResponse->bladePluralName }}</button>
                                </div>
                            <hr>
                                <div class="col-md-6">
                                    <button type="button" id="printSalePdf" class="btn" style="width:100%">GENERAR TICKET</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" id="printSalePdfA4" class="btn" style="width:100%">GENERAR PDF-A4</button>
                                </div>
                            <hr><br>
                            <div class="col-md-8">
                                <input type="text" id="sendSaleEmailAddress" class="form-control" style="width:100%"/>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="sendSaleEmail" class="btn" style="width:100%">ENVIAR POR CORREO</button>
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
                            <h4 class="modal-title">DATOS ADICIONALES DE VENTA</h4>
                        </div>
                        <div class="col-md-12" style="padding:10px;">
                            <!-- form start -->
                            <div class="col-sm-6">
                                <label for="new_user_assignment">Asignar usuario</label>
                                <select name="new_user_assignment" id="new_user_assignment" class="form-control">
                                    <option value="0">SELECCIONE UN USUARIO</option>
                                    @foreach ($jsonResponse->users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <label for="sale_terminal_id">TERMINAL DE VENTA</label>
                                <select name="sale_terminal_id" id="sale_terminal_id" class="form-control">
                                    <option value="0">VENTA EN TIENDA</option>
                                    <option value="1">VENTA EN WEB</option>
                                    <option value="2">VENTA POR REDES SOCIALES</option>
                                </select>
                                <br>
                                <label for="company_ruc">RUCS DISPONIBLES</label>
                                <select name="company_ruc" id="company_ruc" class="form-control">
                                    <option selected value="0">SELECCIONE UN RUC</option>
                                    @foreach ($jsonResponse->companyLoginData->companyRucs as $rucs)
                                        <option value="{{ $rucs->ruc }}">({{ $rucs->ruc }}) {{ $rucs->rzsocial }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <label for="quotationTypeDocument">DOCUMENTO A CONVERTIR</label>
                                <select name="quotationTypeDocument" id="quotationTypeDocument" class="form-control">
                                    <option selected value="0">SELECCIONE UN TIPO DE DOCUMENTO</option>
                                    <option value="2">BOLETA</option>
                                    <option value="3">FACTURA</option>
                                    <option value="1">PRECUENTA</option>
                                </select>
                                <br>
                                <label for="typeCurrency">DIVISA</label>
                                <select name="typeCurrency" id="typeCurrency" class="form-control" onChange="callChangeCurrency();">
                                    <option value="PEN">SOL PERUANO</option>
                                    <option value="USD">DÓLARES</option>
                                    <option value="EUR">EUROS</option>
                                    <option value="CLP">PESO CHILENO</option>
                                </select>
                                <br>
                            </div>
                            <div class="col-sm-6">
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
            </div>
            <div class="modal fade" id="modal-on-load">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" align="center">
                            <h1 class="modal-title">Procesando venta...</h4>
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
                            <div class="col-md-5">
                                <label for="">CÓDIGO DE PRODUCTO</label>
                                <p id="productDetailCode"></p>
                                <label for="">CÓDIGO DE BARRA</label>
                                <p id="productDetailAutoBarCode"></p>
                                <label for="">CATEGORÍA</label>
                                <p id="productDetailCategory"></p>
                                <label for="">MODELO</label>
                                <p id="productDetailModel"></p>
                                <label for="">MARCA</label>
                                <p id="productDetailBrand"></p>
                            </div>
                            <div class="col-md-3">
                                <label for="">PRECIO MÍNIMO</label>
                                <p id="productMinPrice"></p>
                                <label for="">PRECIO MÁXIMO</label>
                                <p id="productMaxPrice"></p>
                            </div>
                            <div class="col-md-4">
                                <img id="productDetailImage" src="/img/new_ic_logo_short.png" style="height:150px;" height="150px"/>
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
                                            <th>P.MIN</th>
                                            <th>P.MAX</th>
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
            <div class="modal modal-primary fade" id="modal-serial">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 align="center" id="productSerialDetail" class="modal-title">Asignación de Series</h4>
                    </div>
                    <div class="modal-body-5" id="serialResume">
                    <table id="tableSerialResume" class="table">
                        <thead>
                            <th>OPCIÓN</th>
                            <th>SERIE</th>
                            <th>IMEI</th>
                        </thead>
                        <tbody id="tableSerialResumeBody">
                        </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline pull-left">CANCELAR</button>
                        <button type="button" id="btnSerialSubmit" onClick="validateSerialSubmit();" class="btn btn-outline pull-right">VALIDAR</button>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-detail-commentary">
                <div class="modal-dialog">
                    <div class="modal-content" style="padding:10px;">
                        <h4>DETALLE A MOSTRAR</h4>
                        <input type="text" class="form-control" onClick="this.select();" placeholder="INGRESE UN NOMBRE" id="detailCommentary">
                        <br>
                        <button onClick="closeDetailCommentary();" class="btn btn-default">REGRESAR</button>
                        <button onClick="detailCommentarySubmit();" class="btn btn-success">GUARDAR</button>
                    </div>
                </div>
            </div>
            <!-- CREDITS -->
            <div class="modal modal-default fade" id="modal-new-credit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="titleModalCredit">LISTA DE CRÉDITOS DEL CLIENTE</h4>
                        </div>
                        <div class="modal-body" style="height: 400px;">
                            <div class="col-sm-12">
                                <div class="col-sm-9">
                                    <table class="table" id="creditTable">
                                        <thead>
                                            <th>DETALLE</th>
                                            <th>CRÉDITO</th>
                                            <th>DEUDA</th>
                                            <th>DISPONIBLE</th>
                                            <th>APLICAR</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="col-sm-3">
                                    <label for="creditDetail">REGISTRAR CRÉDITOS</label>
                                    <hr>
                                    <select id="creditCurrency" class="form-control" style="width:100%;">
                                    <option value="PEN">SOLES</option>
                                    <option value="USD">DÓLARES</option>
                                    </select>
                                    <br>
                                    <input type="text" class="form-control" placeholder="Detalle" style="width:100%" id="creditDetail">
                                    <br>
                                    <input type="number" class="form-control" placeholder="Monto de crédito" step="0.1" style="width:100%" id="creditAmount">
                                    <br>
                                    <input type="number" class="form-control" placeholder="Periodo en días" style="width:100%" id="creditPeriod">
                                    <br>
                                    <button class="btn btn-success" onClick="newCreditSubmit()" id="btnNewCreditSubmit">REGISTRAR</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('message.back') }}</button>
                            <button type="button" class="btn btn-success pull-right" onClick="validateCredit();">{{ trans('message.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--MODALS-->
        </div>
    </div>
@endsection
