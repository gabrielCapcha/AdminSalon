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
                <input type="text" class="form-control" onclick="this.select();" maxlength="50" autocomplete="off" id="inputSearchClient" placeholder="Buscar cliente...">
            </div>
            <div class="col-md-6 input-group-sm" style="margin-top:0.6em;padding-right: 15px;padding-left: 0px;" align="right">
                <!-- Default checked -->
                <button id="searchSaleForm" onclick="searchSaleForm();" type="button" title="Copiar desde cotizaciones" class="btn btn-danger"><i class="fa fa-plus-square"></i></button>
                <button onclick="newSettingsForm();" type="button" title="Opciones adicionales" class="btn btn-primary"><i class="fa fa-gears"></i></button>
                <!-- <button onclick="newUserForm();" type="button" title="Crear cliente sin documento" class="btn btn-primary"><i class="fa fa-user-plus"></i></button> -->
                <!-- <button onclick="newDriverForm();" type="button" title="Asignar un conductor" class="btn btn-primary"><i class="fa fa-truck"></i></button> -->
                <span style="margin-right:1em;"> </span>
                <button disabled type="button" class="btn btn-default">FLUJO - GUÍA DE REMISIÓN</button>
                <!-- <input type="button" style="margin-left:1em;" type="button" id="buttonPaymentAmount " class="btn btn-danger" value="S/ 0.00" /> -->
            </div>
        </div>
    </nav>
</header>
