<!-- Main Header -->
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
    <nav class="navbar navbar-static-top" role="navigation" style="margin-left: 150px; background-color: brown;">
        <!-- Sidebar toggle button-->
        <div id="mainheaderSearchBar" style="position:relative; margin-left: 10px;" class="col-md-12">
            <div class="col-md-2 input-group-sm" style="margin-top:0.75em;padding-left: 0px;">
                <input type="text" class="form-control" onClick="this.select();" maxlength="25" id="searchProductBarCode" placeholder="Lector de barras...">
            </div>
            <div class="col-md-2 input-group-sm" style="margin-top:0.75em;padding-left: 0px;">
                <input type="text" class="form-control" onClick="this.select();" maxlength="50" id="searchProduct" placeholder="Buscador de productos...">
            </div>
            <div class="col-md-1 input-group-sm" style="margin-top:0.75em;padding-left: 0px;padding-right: 0px;">
                <input type="hidden" id="genericCustomer" value="{{ json_encode($jsonResponse->genericCustomer) }}">
                <input type="hidden" id="companyLoginData" value="{{ json_encode($jsonResponse->companyLoginData) }}">
                <input type="text" class="form-control" onClick="this.select();" maxlength="50" autocomplete="off" id="inputSearchClient" placeholder="Buscar cliente..." value="CLIENTE GENERICO">
            </div>
            <div class="col-md-7 input-group-sm" style="margin-top:0.6em;padding-right: 15px;padding-left: 0px;" align="right">
                <button onClick="newSettingsForm();" type="button" title="Opciones adicionales de venta" class="btn btn-primary"><i class="fa fa-gears"></i></button>
                <button onClick="newUserForm();" type="button" title="Crear cliente sin documento" class="btn btn-primary"><i class="fa fa-user-plus"></i></button>
                <span style="margin-right:1em;"> </span>
                <img id="typePayment_1" onclick="typePayments(1);" class="payment-1-selected" data-dismiss="modal" data-tooltip="Lorem ipsum dolor sit amet"/>
                <img id="typePayment_2" onclick="typePayments(2);" class="payment-2-unselected"/> <!-- title="PAGO EN VISA"/> -->
                <img id="typePayment_3" onclick="typePayments(3);" class="payment-3-unselected"/> <!-- title="PAGO EN MASTERCARD"/> -->
                <img id="typePayment_6" onclick="typePayments(6);" class="payment-6-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                <img id="typePayment_10" onclick="typePayments(10);" class="payment-10-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                <img id="typePayment_11" onclick="typePayments(11);" class="payment-11-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                <img id="typePayment_12" onclick="typePayments(12);" class="payment-12-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                <img id="typePayment_13" onclick="typePayments(13);" class="payment-13-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                <img id="typePayment_14" onclick="typePayments(14);" class="payment-14-unselected"/> <!-- title="PAGO EN DEPOSITO"/> -->
                <img id="typePayment_8" onclick="typePayments(8);" class="payment-8-unselected"/>
                <input type="button" style="margin-left:1em;" type="button" id="buttonPaymentAmount" class="btn btn-danger" value="S/ 0.00" />
            </div>
        </div>
        
    </nav>
</header>
