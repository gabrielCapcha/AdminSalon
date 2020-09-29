<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
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
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" id="dataToggleOff" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            @if (!is_null(Auth::user()->url_image))
                                <img src="{{ Auth::user()->url_image }}" class="user-image" alt="User Image"/>
                            @else
                                <img src="/img/new_ic_logo_short.png" class="user-image" alt="User Image"/>
                            @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header" class="p_profile" style="background-color: #1e282c;">
                                @if (!is_null(Auth::user()->url_image))
                                    <img src="{{ Auth::user()->url_image }}" class="img-circle" alt="User Image" />
                                @else
                                    <img src="/img/new_ic_logo_short.png" class="img-circle" alt="User Image"/>
                                @endif
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>{{ Auth::user()->role_name }}</small>
                                    <small>{{ Auth::user()->war_warehouses_name }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <!-- <div class="pull-left">
                                    <a href="{{ url('/new-sale') }}" class="btn btn-default btn-flat">CREAR VENTA</a>
                                </div> -->
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
