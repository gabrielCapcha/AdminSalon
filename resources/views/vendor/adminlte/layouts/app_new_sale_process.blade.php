<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('adminlte::layouts.partials.htmlheader_new_sale_process')
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
<body class="skin-blue fixed sidebar-collapse" style="background-color: #fdbe15;">
<div id="app">
    <div class="wrapper">
        @include('adminlte::layouts.partials.mainheader_new_sale_process')
        <div class="content-wrapper">
            @yield('main-content')
        </div>
        @include('adminlte::layouts.partials.controlsidebar')
    </div>
</div>
@section('scripts')
    @include('adminlte::layouts.partials.scripts_new_sale_process')
@show
</body>
</html>