<!-- Main Header -->
<div id="promotionLoadingTrue" class="loadingTrue" style="display:none;">APLICANDO PROMOCIONES</div>
<div id="promotionLoadingFalse" class="loadingFalse" style="display:none;">QUITANDO PROMOCIONES</div>
<header class="main-header">
    <!-- Logo -->
    <link rel="icon" href="/img/new-login/iso_300_soft.png" type="image/x-icon" />
    <a href="{{ url('/home') }}" class="logo" style="padding-left: 0px;padding-right: 0px;width: 150px; height:59px; padding-top:5px;">
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
                <img src="/img/logo_tumi/sidebar_stylish_logo.png"  width="150px" height="20px"/>
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
            <div class="col-md-2 form-group" style="margin-top:0.75em;padding-left: 0px;">
                <input type="text" class="form-control" onclick="this.select();" maxlength="25" id="searchProductBarCode" placeholder="Lectora de códigos...">
            </div>
            <div class="col-md-2 form-group" style="margin-top:0.75em;padding-left: 0px;">
                <input type="text" class="form-control" onclick="this.select();" maxlength="50" id="searchProduct" placeholder="Buscar productos...">
            </div>
            <div class="col-md-2 form-group" style="margin-top:0.75em;padding-left: 0px;">
                <input type="hidden" id="genericCustomer" value="{{ json_encode($jsonResponse->genericCustomer) }}">
                <input type="hidden" id="companyLoginData" value="{{ json_encode($jsonResponse->companyLoginData) }}">
                <input type="hidden" id="promotionsData" value="{{ json_encode($jsonResponse->promotions) }}">
                <input type="hidden" id="userObject" value="{{ json_encode($jsonResponse->user) }}">
                @if (isset($jsonResponse->saleJson))
                    <input type="hidden" id="saleJson" value="{{ json_encode($jsonResponse->saleJson) }}" />
                @endif
                <input type="text" class="form-control" onclick="this.select();" maxlength="50" autocomplete="off" id="inputSearchClient" placeholder="Buscar cliente..." value="">
            </div>
            <div class="col-md-2 form-group" style="margin-top:0.75em;padding-left: 0px;">
                <button onclick="pickCustomerSubsidiary();" type="button" id="pickCustomerSubsidiary" title="Seleccionar dirección de entrega" class="btn btn-default" style="width:20%; background: #f1d14f;"><i class="fa fa-map-o"></i></button>
                <button onclick="genericClient();" title="Seleccionar cliente genérico" class="btn btn-default" style="width:78%; background: #f1d14f;">CLIENTE GENÉRICO</button>
            </div>
            <div class="col-md-2 form-group" style="margin-top:0.75em;padding-left: 0px;">
                <button onclick="newUserForm();" title="Crear cliente simple" class="btn btn-default" style="width:100%; background: #5ba8af;">CARNET EXTRANJERÍA</button>
            </div>
            <div class="col-md-2 form-group" style="margin-top:0.75em;padding-left: 0px;">
                @php
                    if (count($jsonResponse->documentTp) > 0) {
                        $typeDocumentsName = [];
                        $typeDocuments = [];
                        foreach ($jsonResponse->documentTp as $documentTp) {
                            $typeDocumentsName[$documentTp["id"]] = $documentTp["name"];
                            array_push($typeDocuments, $documentTp["id"]);
                        }                        
                    } else {
                        $typeDocuments = explode(',', $jsonResponse->companyLoginData->type_documents);
                        $typeDocumentsName = [];
                        $typeDocumentsName[1] = 'BOLETA';
                        $typeDocumentsName[2] = 'FACTURA';
                        $typeDocumentsName[5] = 'PRECUENTA';
                    }
                @endphp
                <select class="form-control" name="typeDocument" id="typeDocument" onChange="changeTypeDocument(0);" style="text-align-last: center;">
                    @foreach ($typeDocuments as $typeDocument)
                        @if ((int)$typeDocument === 5)
                            <option selected value="{{ $typeDocument }}">{{ $typeDocumentsName[$typeDocument] }}</option>
                        @else
                            <option value="{{ $typeDocument }}">{{ $typeDocumentsName[$typeDocument] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        
    </nav>
</header>
