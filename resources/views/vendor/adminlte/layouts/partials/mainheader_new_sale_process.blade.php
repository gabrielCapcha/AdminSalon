<!-- Main Header -->
<div id="promotionLoadingTrue" class="loadingTrue" style="display:none;">APLICANDO PROMOCIONES</div>
<div id="promotionLoadingFalse" class="loadingFalse" style="display:none;">QUITANDO PROMOCIONES</div>
<header class="main-header">
    <!-- Logo -->
    <link rel="icon" href="/img/new-login/iso_300_soft.png" type="image/x-icon" />
    <a href="{{ url('/home') }}" class="logo" style="padding-left: 0px;padding-right: 0px;width: 150px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
            <span class="logo-mini">
                <img src="/img/logo_tumi/favicon_tumifood_low.png" width="40px"/>
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <img src="/img/logo_tumi/sidebar_food_logo.png"  height="30px"/>
            </span>
        @elseif (Auth::user()->company_area_code === 'STY')
            <span class="logo-mini">
                <img src="/img/new-login/iso_300_soft.png" width="40px"/>
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <img src="/img/logo_tumi/sidebar_stylish_logo.png"  height="25px"/>
            </span>
        @else
            <span class="logo-mini">
                <img src="/img/new-login/iso_300_soft.png" width="40px"/>
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <img src="/img/logo_tumi/sidebar_logo.png"  height="25px"/>
            </span>
        @endif
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="margin-left: 150px;">
        <!-- Sidebar toggle button-->
        <div id="mainheaderSearchBar" style="position:relative; margin-left: 10px;" class="col-md-12">
            <div class="col-md-2 input-group-sm" style="margin-top:0.75em;padding-left: 0px;">
                <input type="text" class="form-control" onclick="this.select();" maxlength="25" id="searchProductBarCode" placeholder="Lector de barras...">
            </div>
            <div class="col-md-2 input-group-sm" style="margin-top:0.75em;padding-left: 0px;">
                <input type="text" class="form-control" onclick="this.select();" maxlength="50" id="searchProduct" placeholder="Buscador de productos...">
            </div>
            <div class="col-md-2 input-group-sm" style="margin-top:0.75em;padding-left: 0px;padding-right: 0px;">
                <input type="hidden" id="genericCustomer" value="{{ json_encode($jsonResponse->genericCustomer) }}">
                <input type="hidden" id="companyLoginData" value="{{ json_encode($jsonResponse->companyLoginData) }}">
                <input type="hidden" id="promotionsData" value="{{ json_encode($jsonResponse->promotions) }}">                
                <input type="text" class="form-control" onclick="this.select();" maxlength="50" autocomplete="off" id="inputSearchClient" placeholder="Buscar cliente..." value="">
            </div>
            <div class="col-md-6 input-group-sm" style="margin-top:0.6em;padding-right: 15px;padding-left: 0px;" align="right">
                <!-- Default checked -->
                <input type="checkbox" id="toggle-two" onchange="promoChangePrices(this);" data-toggle="toggle" data-on="CON PROMO" data-off="SIN PROMO">
                <button  id="searchSaleForm" onclick="searchSaleForm();" type="button" title="Copiar desde guías de remisión" class="btn btn-danger"><i class="fa fa-plus-square"></i></button>
                <button onclick="newSettingsForm();" type="button" title="Opciones adicionales de venta" class="btn btn-primary"><i class="fa fa-gears"></i></button>
                <!-- <button onclick="newUserForm();" type="button" title="Crear cliente sin documento" class="btn btn-primary"><i class="fa fa-user-plus"></i></button> -->
                <!-- <button onclick="newDriverForm();" type="button" title="Asignar un conductor" class="btn btn-primary"><i class="fa fa-truck"></i></button> -->
                <span style="margin-right:1em;"> </span>
                <button disabled type="button" class="btn btn-default">VENTA DE FLUJO</button>
                <!-- <img id="typePayment_1" onclick="typePayments(1);" class="payment-1-selected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
                <img id="typePayment_2" onclick="typePayments(2);" class="payment-2-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
                <img id="typePayment_3" onclick="typePayments(3);" class="payment-3-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
                <img id="typePayment_6" onclick="typePayments(6);" class="payment-6-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
                <img id="typePayment_8" onclick="typePayments(8);" class="payment-8-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
                <img id="typePayment_9" onclick="typePayments(9);" class="payment-9-unselected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/> -->
                <!-- <input type="button" style="margin-left:1em;" type="button" id="buttonPaymentAmount " class="btn btn-danger" value="S/ 0.00" /> -->
            </div>
        </div>
        
    </nav>
</header>
