<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('sales.partials.htmlheader_new_credit_sale')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue fixed sidebar-collapse">
<div id="app">
    <div class="">
        @include('sales.partials.mainheader_new_credit_sale')
        <div class="" style="padding-top:260px; z-index:0; position: absolute; width:100%;">
            @yield('main-content')
        </div>
    </div>
        <div class="modal modal-warning fade" id="modal-quotation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 align="center" class="modal-title">RESUMEN DE COTIZACIÓN</h4>
                    </div>
                    <div class="modal-body">
                        <!-- <table id="tableSelectedProducts" class="table"> -->
                        <table id="tableSelectedProducts">
                            <thead class="static-table-head-responsive">
                                <tr>
                                    <th class="static-table-th-responsive">Código</th>
                                    <th class="static-table-th-responsive">Nombre</th>
                                    <th class="static-table-th-responsive">Precio</th>
                                    <th class="static-table-th-responsive">Cantidad</th>
                                    <th class="static-table-th-responsive">Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="static-table-body" id="tBodyTableSelectedProducts"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">REGRESAR</button>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">GUARDAR</button>
                    </div>
                </div>
            </div>
        </div>
</div>
@section('scripts')
    @include('sales.partials.scripts_new_credit_sale')
@show
</body>
</html>