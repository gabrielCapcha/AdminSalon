<!-- Main Header -->
<div id="promotionLoadingTrue" class="loadingTrue" style="display:none;">APLICANDO PROMOCIONES</div>
<div id="promotionLoadingFalse" class="loadingFalse" style="display:none;">QUITANDO PROMOCIONES</div>
<header class="main-header">
    <!-- Logo -->
    <link rel="icon" href="/img/new-login/iso_300_soft.png" type="image/x-icon" />
    <div>
        <a href="{{ url('/home') }}" class="logo" style="padding-left: 0px;padding-right: 0px;width: 100%;">
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
    </div>
    <!-- Sidebar toggle button-->
    <div id="mainheaderSearchBar" class="col-xs-12" style="background:#2c3b41; position:fixed;">
        <div class="col-xs-6" style="margin-top:0.75em;">
            <input type="text" class="form-control" onclick="this.select();" maxlength="25" id="searchProductBarCode" placeholder="Código de barras">
        </div>
        <div class="col-xs-6" style="margin-top:0.75em;">
            <input type="text" class="form-control" onclick="this.select();" maxlength="50" id="searchProduct" placeholder="Buscador general">
        </div>
        <div class="col-xs-12" style="margin-top:0.75em;">
            <input type="hidden" id="genericCustomer" value="{{ json_encode($jsonResponse->genericCustomer) }}">
            <input type="hidden" id="companyLoginData" value="{{ json_encode($jsonResponse->companyLoginData) }}">
            <input type="hidden" id="promotionsData" value="{{ json_encode($jsonResponse->promotions) }}">                
            <input type="text" class="form-control" onclick="this.select();" maxlength="50" autocomplete="off" id="inputSearchClient" placeholder="Buscar cliente..." value="CLIENTE GENERICO">
        </div>
        <div class="col-xs-12" style="margin-top:0.75em; padding-bottom:70px;">
            <button class="btn btn-block btn-danger" onClick="showQuotation();">
                CONTINUAR
            </button>
        </div>
    </div>
    <div id="demo" align="center" class="col-xs-12">
        @foreach ($jsonResponse->categories as $category)
            <button class="new-sale-custom-category-button" style="background-color: #9daeb8; width:150px; " id="buttonCategory-{{ $category->id }}" onclick="loadProducts({{ $category->id }})">
                <span class="info-box-text">{{ $category->name }}</span>
                <span class="info-box-number">Productos: {{ $category->productsCount }}</span>
            </button>
        @endforeach
    </div>
    <br>
</header>
