<aside class="main-sidebar">
    <section class="sidebar">
        @if (! Auth::guest())
            <div class="user-panel">
                <div align="center">
                    <h4 style="color: #fff; font-weight: bold;">{{ substr(Auth::user()->company_name, 0, 15) }}</h><br>
                </div>
            </div>
        @endif
        @if ( Auth::user()->id === 565)
            <ul class="sidebar-menu">
                <li><a href="{{ url('dashboard') }}"><i class='fa fa-bar-chart'></i> <span>{{ trans('message.sidebar_dashboard') }}</span></a></li>
                <li class="treeview @yield('sidebar_reports')">
                    <a href="#"><i class='fa fa-link'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="@yield('sidebar_reports_1')"><a href="{{ url('reports-patio-truck') }}">{{ trans('message.sidebar_reports_1') }}</a></li>
                    </ul>
                </li>
            </ul>
        @else
            @foreach (Auth::user()->roles_config as $roles)
                <!-- VENDEDORES url: dashboard -->
                @if ($roles['roles_id'] === 8 || $roles['roles_id'] === 10 || $roles['roles_id'] === 11 || $roles['roles_id'] === 17)
                    <ul class="sidebar-menu">
                        <li class="@yield('sidebar_dashboard')"><a href="{{ url('dashboard') }}"><i class='fa fa-dashboard'></i> <span>{{ trans('message.sidebar_dashboard') }}</span></a></li>
                        <li class="treeview @yield('sidebar_reports')">
                            <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                @if ($roles['apps_id'] !== 6)
                                    <li class="@yield('sidebar_reports_employee_documents')"><a href="{{ url('reports-employee-documents') }}">{{ trans('message.sidebar_reports_employee_documents') }}</a></li>
                                @endif
                                @if (Auth::user()->company_id === 527)
                                    <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                    <li class="@yield('sidebar_reports_sold_products')"><a href="{{ url('reports-sold-products') }}">{{ trans('message.sidebar_reports_sold_products') }}</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_sales')">
                            <a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('message.sidebar_sales') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_0')"><a href="{{ url('new-sale') }}">{{ trans('message.sidebar_sales_0') }}</a></li>
                                <li class="@yield('sidebar_sales_6')"><a href="{{ url('new-manual-sale/BLT') }}">{{ trans('message.sidebar_sales_6') }}</a></li>
                                <li class="@yield('sidebar_sales_7')"><a href="{{ url('new-manual-sale/FAC') }}">{{ trans('message.sidebar_sales_7') }}</a></li>
                                <li class="@yield('sidebar_sales_1')"><a href="{{ url('sales') }}">{{ trans('message.sidebar_sales_1') }}</a></li>
                                <li class="@yield('sidebar_sales_2')"><a href="{{ url('quotations') }}">{{ trans('message.sidebar_sales_2') }}</a></li>
                                <li class="@yield('received_payments')"><a href="{{ url('reports-received-payments') }}">{{ trans('message.received_payments') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_remission_guide')">
                            <a href="#"><i class='fa fa-list-alt'></i> <span>{{ trans('message.sidebar_remission_guide') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_remission_guide_new_process')"><a href="{{ url('new-remission-guide-process') }}">{{ trans('message.sidebar_remission_guide_new_process') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_new_reserved')"><a href="{{ url('new-remission-guide-reserved') }}">{{ trans('message.sidebar_remission_guide_new_reserved') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_list')"><a href="{{ url('remission-guides') }}">{{ trans('message.sidebar_remission_guide_list') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_cash_flow')">
                            <a href="#"><i class='fa glyphicon glyphicon-piggy-bank'></i> <span>{{ trans('message.sidebar_cash_flow') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_cash_flow_0')"><a href="{{ url('open-cash') }}">{{ trans('message.sidebar_cash_flow_0') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_1')"><a href="{{ url('incomes') }}">{{ trans('message.sidebar_cash_flow_1') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_2')"><a href="{{ url('outcomes') }}">{{ trans('message.sidebar_cash_flow_2') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_3')"><a href="{{ url('expenses') }}">{{ trans('message.sidebar_cash_flow_3') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_4')"><a href="{{ url('in-counts') }}">{{ trans('message.sidebar_cash_flow_4') }}</a></li>
                                <!-- <li class="@yield('sidebar_cash_flow_5')"><a href="{{ url('pre-closing') }}">{{ trans('message.sidebar_cash_flow_5') }}</a></li> -->
                                <li class="@yield('sidebar_cash_flow_6')"><a href="{{ url('cash-closing') }}">{{ trans('message.sidebar_cash_flow_6') }}</a></li>
                            </ul>
                        </li>
                        <li class="@yield('sidebar_customers')"><a href="{{ url('customers') }}"><i class='fa glyphicon glyphicon-heart'></i> <span>{{ trans('message.sidebar_clients') }}</span></a></li>
                        <li class="treeview @yield('sidebar_inventories')">
                            <a href="#"><i class='fa fa-cubes'></i> <span>{{ trans('message.sidebar_stocks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_transfer_by_code')"><a href="{{ url('new-transfer-by-code') }}">{{ trans('message.sidebar_new_transfer_by_code') }}</a></li>
                                <!-- <li class="@yield('sidebar_new_transfer')"><a href="{{ url('new-transfer') }}">{{ trans('message.sidebar_stocks_1') }}</a></li> -->
                                <li class="@yield('sidebar_inventory')"><a href="{{ url('inventories') }}">{{ trans('message.sidebar_stocks_2') }}</a></li>
                                <li class="@yield('sidebar_kardex')"><a href="{{ url('kardex') }}">{{ trans('message.sidebar_stocks_3') }}</a></li>
                                <li class="@yield('sidebar_transfers')"><a href="{{ url('transfers') }}">{{ trans('message.sidebar_stocks_4') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                    @break
                <!-- SUPER ADMINISTRADOR Y CAJA NUEVO url: dashboard -->
                @elseif (Auth::user()->company_id === 382 || Auth::user()->company_id === 321)
                    <ul class="sidebar-menu">
                        <li class="@yield('sidebar_dashboard')"><a href="{{ url('dashboard') }}"><i class='fa fa-dashboard'></i> <span>{{ trans('message.sidebar_dashboard') }}</span></a></li>
                        <li class="treeview @yield('sidebar_reports')">
                            <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="treeview @yield('sidebar_sale_reports')">
                                    <a href="#"><span>{{ trans('message.sidebar_sale_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                        <li class="@yield('sidebar_reports_sold_products')"><a href="{{ url('reports-sold-products') }}">{{ trans('message.sidebar_reports_sold_products') }}</a></li>
                                        <li class="@yield('sidebar_reports_sales_by_product')"><a href="{{ url('reports-sales-by-product') }}">{{ trans('message.sidebar_reports_sales_by_product') }}</a></li>
                                        <li class="@yield('sidebar_reports_sales_by_brand')"><a href="{{ url('reports-sales-by-brand') }}">{{ trans('message.sidebar_reports_sales_by_brand') }}</a></li>
                                        <li class="@yield('sidebar_reports_sales_by_client')"><a href="{{ url('reports-sales-by-client') }}">{{ trans('message.sidebar_reports_sales_by_client') }}</a></li>
                                        <li class="@yield('sidebar_products_by_day')"><a href="{{ url('reports-products-by-day') }}">{{ trans('message.sidebar_products_by_day') }}</a></li>
                                        <li class="@yield('sidebar_summary_ticket')"><a href="{{ url('reports-summary-ticket') }}">{{ trans('message.sidebar_summary_ticket') }}</a></li>
                                        <li class="@yield('sidebar_customers_ranking')"><a href="{{ url('reports-customers-ranking') }}">{{ trans('message.sidebar_customers_ranking') }}</a></li>
                                        @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                            <li class="@yield('sidebar_reports_orders')"><a href="{{ url('reports-orders') }}">{{ trans('message.sidebar_reports_orders') }}</a></li>
                                            <!-- <li class="@yield('sidebar_reports_tables')"><a href="{{ url('reports-tables-statistics') }}">{{ trans('message.sidebar_reports_tables') }}</a></li> -->
                                        @endif
                                    </ul>
                                </li>
                                <li class="treeview @yield('sidebar_user_reports')">
                                    <a href="#"><span>{{ trans('message.sidebar_user_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li class="@yield('sidebar_quotation_report')"><a href="{{ url('report-quotation') }}">{{ trans('message.sidebar_quotation_report') }}</a></li>
                                        <li class="@yield('sidebar_commission_report')"><a href="{{ url('report-commission') }}">{{ trans('message.sidebar_commission_report') }}</a></li>
                                        <!-- <li class="@yield('sidebar_reports_employee_assistance')"><a href="{{ url('reports-employee-assistance') }}">{{ trans('message.sidebar_reports_employee_assistance') }}</a></li> -->
                                        <li class="@yield('sidebar_reports_employee_documents')"><a href="{{ url('reports-employee-documents') }}">{{ trans('message.sidebar_reports_employee_documents') }}</a></li>
                                        <!-- <li class="@yield('sidebar_reports_fifo')"><a href="{{ url('reports-fifo') }}">{{ trans('message.sidebar_reports_fifo') }}</a></li> -->
                                        <li class="treeview @yield('sidebar_generic_kardex')">
                                            <a href="#"><span>{{ trans('message.sidebar_generic_kardex') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                            <ul class="treeview-menu">
                                                <li class="@yield('sidebar_kardex')"><a href="{{ url('kardex') }}">{{ trans('message.sidebar_stocks_3') }}</a></li>
                                                <li class="@yield('sidebar_kardex_warehouse')"><a href="{{ url('kardex-warehouse') }}">{{ trans('message.sidebar_kardex_warehouse') }}</a></li>
                                                <li class="@yield('sidebar_kardex_brand')"><a href="{{ url('kardex-brand') }}">{{ trans('message.sidebar_kardex_brand') }}</a></li>
                                                <li class="@yield('sidebar_kardex_cpp')"><a href="{{ url('kardex-cpp') }}">{{ trans('message.sidebar_kardex_cpp') }}</a></li>
                                                <li class="@yield('sidebar_kardex_allotment_cpp')"><a href="{{ url('kardex-allotment-cpp') }}">{{ trans('message.sidebar_kardex_allotment_cpp') }}</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="treeview @yield('sidebar_sunat_reports')">
                                    <a href="#"><span>{{ trans('message.sidebar_sunat_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li class="@yield('sidebar_supplier_movement')"><a href="{{ url('reports-supplier-movement') }}">{{ trans('message.sidebar_supplier_movement_pre') }}</a></li>
                                        <!-- <li class="@yield('sidebar_sales_supplier')"><a href="{{ url('reports-sales-supplier') }}">{{ trans('message.sidebar_sales_supplier') }}</a></li> -->
                                        <li class="@yield('sidebar_reports_fe')"><a href="{{ url('reports-fe') }}">{{ trans('message.sidebar_reports_fe') }}</a></li>
                                        <!-- <li class="@yield('sidebar_reports_concar')"><a href="{{ url('reports-concar') }}">{{ trans('message.sidebar_reports_concar') }}</a></li> -->
                                    </ul>
                                </li>
                                <li class="treeview @yield('sidebar_visual_reports')">
                                    <a href="#"><span>{{ trans('message.sidebar_visual_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li class="@yield('sidebar_store_ranking')"><a href="{{ url('store-ranking') }}">{{ trans('message.sidebar_store_ranking') }}</a></li>
                                        <li class="@yield('sidebar_salesman_ranking')"><a href="{{ url('salesman-ranking') }}">{{ trans('message.sidebar_salesman_ranking') }}</a></li>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_quotations')">
                            <a href="#"><i class='fa fa-paper-plane-o'></i> <span>{{ trans('message.sidebar_sales_2') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_quotation')"><a href="{{ url('new-quotation') }}">{{ trans('message.sidebar_new_quotation') }}</a></li>
                                <li class="@yield('sidebar_quotation_list')"><a href="{{ url('quotations') }}">{{ trans('message.sidebar_quotation_list') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_sales')">
                            <a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('message.sidebar_sales') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_0')"><a href="{{ url('new-sale') }}">{{ trans('message.sidebar_sales_0') }}</a></li>
                                <li class="@yield('new_sale_process')"><a href="{{ url('new-sale-process') }}">{{ trans('message.new_sale_process') }}</a></li>
                                <li class="@yield('new_sale_reserved')"><a href="{{ url('new-sale-reserved') }}">{{ trans('message.new_sale_reserved') }}</a></li>
                                <li class="@yield('sidebar_sales_6')"><a href="{{ url('new-manual-sale/BLT') }}">{{ trans('message.sidebar_sales_6') }}</a></li>
                                <li class="@yield('sidebar_sales_7')"><a href="{{ url('new-manual-sale/FAC') }}">{{ trans('message.sidebar_sales_7') }}</a></li>
                                <li class="@yield('sidebar_sales_1')"><a href="{{ url('sales') }}">{{ trans('message.sidebar_sales_1') }}</a></li>
                                
                                <li class="@yield('sidebar_sales_4')"><a href="{{ url('price-list') }}">{{ trans('message.sidebar_sales_4') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_cash_flow')">
                            <a href="#"><i class='fa glyphicon glyphicon-piggy-bank'></i> <span>{{ trans('message.sidebar_cash_flow') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_cash_flow_0')"><a href="{{ url('open-cash') }}">{{ trans('message.sidebar_cash_flow_0') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_1')"><a href="{{ url('incomes') }}">{{ trans('message.sidebar_cash_flow_1') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_2')"><a href="{{ url('outcomes') }}">{{ trans('message.sidebar_cash_flow_2') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_3')"><a href="{{ url('expenses') }}">{{ trans('message.sidebar_cash_flow_3') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_4')"><a href="{{ url('in-counts') }}">{{ trans('message.sidebar_cash_flow_4') }}</a></li>
                                <!-- <li class="@yield('sidebar_cash_flow_5')"><a href="{{ url('pre-closing') }}">{{ trans('message.sidebar_cash_flow_5') }}</a></li> -->
                                <li class="@yield('sidebar_cash_flow_6')"><a href="{{ url('cash-closing') }}">{{ trans('message.sidebar_cash_flow_6') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_products')">
                            <a href="#"><i class='fa fa-cube'></i> <span>{{ trans('message.sidebar_products') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_products_1')"><a href="{{ url('products') }}">{{ trans('message.sidebar_products_1') }}</a></li>
                                <li class="treeview @yield('sidebar_product_management')">
                                    <a href="#"><span>{{ trans('message.sidebar_product_management') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li class="@yield('sidebar_reports_stocks_products')"><a href="{{ url('reports-stocks-products') }}">{{ trans('message.sidebar_reports_stocks_products') }}</a></li>
                                        <!-- <li class="@yield('sidebar_new_transfer_by_code')"><a href="{{ url('new-transfer-by-code') }}">{{ trans('message.sidebar_new_transfer_by_code') }}</a></li> -->
                                        <!-- <li class="@yield('sidebar_new_transfer')"><a href="{{ url('new-transfer') }}">{{ trans('message.sidebar_stocks_1') }}</a></li> -->
                                        <li class="@yield('sidebar_transfers')"><a href="{{ url('transfers') }}">{{ trans('message.sidebar_stocks_4') }}</a></li>
                                        <!-- <li class="@yield('sidebar_products_2')"><a href="{{ url('products-income') }}">{{ trans('message.sidebar_products_2') }}</a></li>
                                        <li class="@yield('sidebar_products_10')"><a href="{{ url('products-outcome') }}">{{ trans('message.sidebar_products_10') }}</a></li> -->
                                        <li class="@yield('sidebar_products_3')"><a href="{{ url('incomes-history') }}">{{ trans('message.sidebar_products_3') }}</a></li>
                                        @if (Auth::user()->company_id === 510 || Auth::user()->company_id === 321)
                                            <li class="@yield('sidebar_products_movement')"><a href="{{ url('products-movement') }}">{{ trans('message.sidebar_products_movement') }}</a></li>
                                        @endif
                                    </ul>
                                </li>
                                <li class="@yield('sidebar_transfer_movement')"><a href="{{ url('reports-transfer-movement') }}">{{ trans('message.sidebar_transfer_movement') }}</a></li>
                                @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                    <li class="@yield('sidebar_recipies')"><a href="{{ url('recipies') }}">{{ trans('message.sidebar_recipies') }}</a></li>
                                @endif
                                <li class="treeview @yield('sidebar_product_config')">
                                    <a href="#"><span>{{ trans('message.sidebar_product_config') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li class="@yield('sidebar_allotments')"><a href="{{ url('allotments') }}">{{ trans('message.sidebar_allotments') }}</a></li>
                                        <li class="@yield('sidebar_serials')"><a href="{{ url('serials') }}">{{ trans('message.sidebar_serials') }}</a></li>
                                        <li class="@yield('sidebar_products_4')"><a href="{{ url('categories') }}">{{ trans('message.sidebar_products_4') }}</a></li>
                                        <li class="@yield('sidebar_products_5')"><a href="{{ url('brands') }}">{{ trans('message.sidebar_products_5') }}</a></li>
                                        <li class="@yield('sidebar_products_6')"><a href="{{ url('features') }}">{{ trans('message.sidebar_products_6') }}</a></li>
                                        <!-- <li class="@yield('sidebar_products_7')"><a href="{{ url('units') }}">{{ trans('message.sidebar_products_7') }}</a></li> -->
                                        
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_purchases')">
                            <a href="#"><i class='fa fa-shopping-cart'></i> <span>{{ trans('message.sidebar_purchases') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_purchase')"><a href="{{ url('new-purchase') }}">{{ trans('message.sidebar_new_purchase') }}</a></li>
                                <li class="@yield('sidebar_purchase_list')"><a href="{{ url('purchases') }}">{{ trans('message.sidebar_purchase_list') }}</a></li>
                                <li class="@yield('sidebar_due_bills')"><a href="{{ url('due-bills') }}">{{ trans('message.sidebar_due_bills') }}</a></li>
                                <li class="@yield('sidebar_pay_bills')"><a href="{{ url('pay-bills') }}">{{ trans('message.sidebar_pay_bills') }}</a></li>
                            </ul>
                        </li> -->
                        <li class="treeview @yield('sidebar_remission_guide')">
                            <a href="#"><i class='fa fa-list-alt'></i> <span>{{ trans('message.sidebar_remission_guide') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_remission_guide_new_process')"><a href="{{ url('new-remission-guide-process') }}">{{ trans('message.sidebar_remission_guide_new_process') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_new_reserved')"><a href="{{ url('new-remission-guide-reserved') }}">{{ trans('message.sidebar_remission_guide_new_reserved') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_list')"><a href="{{ url('remission-guides') }}">{{ trans('message.sidebar_remission_guide_list') }}</a></li>
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_transport')">
                            <a href="#"><i class='fa fa-truck'></i> <span>{{ trans('message.sidebar_transport') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_transport_company')"><a href="{{ url('transport-company') }}">{{ trans('message.sidebar_transport_company') }}</a></li>
                                <li class="@yield('sidebar_transport_driver')"><a href="{{ url('transport-driver') }}">{{ trans('message.sidebar_transport_driver') }}</a></li>
                                <li class="@yield('sidebar_transport_truck')"><a href="{{ url('transport-truck') }}">{{ trans('message.sidebar_transport_truck') }}</a></li>
                                <li class="@yield('sidebar_transport_truck_brand')"><a href="{{ url('transport-truck-brand') }}">{{ trans('message.sidebar_transport_truck_brand') }}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="treeview @yield('sidebar_payments')">
                            <a href="#"><i class='fa fa-money'></i> <span>{{ trans('message.sidebar_payments') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_without_payments')"><a href="{{ url('sales-without-payments') }}">{{ trans('message.sidebar_sales_without_payments') }}</a></li>
                                <li class="@yield('sidebar_payments_list')"><a href="{{ url('payments') }}">{{ trans('message.sidebar_payments_list') }}</a></li>
                                <li class="@yield('sidebar_pay_quotations')"><a href="{{ url('pay-quotations') }}">{{ trans('message.sidebar_pay_quotations') }}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="treeview @yield('sidebar_inventories')">
                            <a href="#"><i class='fa fa-cubes'></i> <span>{{ trans('message.sidebar_stocks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                            </ul>
                        </li> -->
                        <li class="treeview @yield('sidebar_confcompany')">
                            <a href="#"><i class='fa glyphicon glyphicon-briefcase'></i> <span>{{ trans('message.sidebar_confcompany') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_suppliers')"><a href="{{ url('suppliers') }}">  <span>{{ trans('message.sidebar_suppliers') }}</span></a></li>
                                <li class="@yield('sidebar_customers')"><a href="{{ url('customers') }}">  <span>{{ trans('message.sidebar_clients') }}</span></a></li>
                                <li class="@yield('sidebar_warehouses')"><a href="{{ url('warehouses') }}">  <span>{{ trans('message.sidebar_warehouse') }}</span></a></li>
                                <li class="@yield('sidebar_users')"><a href="{{ url('users') }}">  <span>{{ trans('message.sidebar_users') }}</span></a></li>
                                <!-- <li class="@yield('sidebar_printers')"><a href="{{ url('printers') }}">  <span>{{ trans('message.sidebar_printers') }}</span></a></li> -->
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_config')">
                            <a href="#"><i class='fa fa-gears'></i> <span>{{ trans('message.sidebar_config') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_terminals')"><a href="{{ url('terminals') }}">{{ trans('message.sidebar_terminals') }}</a></li>
                                <li class="@yield('sidebar_serie')"><a href="{{ url('series') }}">{{ trans('message.sidebar_serie') }}</a></li>
                                <li class="@yield('sidebar_printers')"><a href="{{ url('printers') }}">{{ trans('message.sidebar_printers') }}</a></li>
                                @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                    <li class="@yield('sidebar_tables')"><a href="{{ url('tables') }}">{{ trans('message.sidebar_tables') }}</a></li>
                                @endif
                            </ul>
                        </li> -->
                    </ul>
                    @break
                <!-- SUPER ADMINISTRADOR Y CAJA url:dashboard -->
                @elseif ($roles['roles_id'] === 1 || $roles['roles_id'] === 9 || $roles['roles_id'] === 3)
                    @if ($roles['apps_id'] === 6 && $roles['roles_id'] === 9)
                        <ul class="sidebar-menu">
                            <li class="@yield('sidebar_dashboard')"><a href="{{ url('dashboard') }}"><i class='fa fa-dashboard'></i> <span>{{ trans('message.sidebar_dashboard') }}</span></a></li>
                            <li class="treeview @yield('sidebar_reports')">
                                <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                    <li class="@yield('sidebar_commission_report')"><a href="{{ url('report-commission') }}">{{ trans('message.sidebar_commission_report') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview @yield('sidebar_sales')">
                                <a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('message.sidebar_sales') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li class="@yield('sidebar_sales_0')"><a href="{{ url('new-sale') }}">{{ trans('message.sidebar_sales_0') }}</a></li>
                                    <li class="@yield('sidebar_sales_6')"><a href="{{ url('new-manual-sale/BLT') }}">{{ trans('message.sidebar_sales_6') }}</a></li>
                                    <li class="@yield('sidebar_sales_7')"><a href="{{ url('new-manual-sale/FAC') }}">{{ trans('message.sidebar_sales_7') }}</a></li>
                                    <li class="@yield('sidebar_sales_1')"><a href="{{ url('sales') }}">{{ trans('message.sidebar_sales_1') }}</a></li>
                                    <li class="@yield('sidebar_sales_2')"><a href="{{ url('quotations') }}">{{ trans('message.sidebar_sales_2') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview @yield('sidebar_remission_guide')">
                                <a href="#"><i class='fa fa-list-alt'></i> <span>{{ trans('message.sidebar_remission_guide') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li class="@yield('sidebar_remission_guide_new_process')"><a href="{{ url('new-remission-guide-process') }}">{{ trans('message.sidebar_remission_guide_new_process') }}</a></li>
                                    <li class="@yield('sidebar_remission_guide_new_reserved')"><a href="{{ url('new-remission-guide-reserved') }}">{{ trans('message.sidebar_remission_guide_new_reserved') }}</a></li>
                                    <li class="@yield('sidebar_remission_guide_list')"><a href="{{ url('remission-guides') }}">{{ trans('message.sidebar_remission_guide_list') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview @yield('sidebar_cash_flow')">
                                <a href="#"><i class='fa glyphicon glyphicon-piggy-bank'></i> <span>{{ trans('message.sidebar_cash_flow') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li class="@yield('sidebar_cash_flow_0')"><a href="{{ url('open-cash') }}">{{ trans('message.sidebar_cash_flow_0') }}</a></li>
                                    <li class="@yield('sidebar_cash_flow_1')"><a href="{{ url('incomes') }}">{{ trans('message.sidebar_cash_flow_1') }}</a></li>
                                    <li class="@yield('sidebar_cash_flow_2')"><a href="{{ url('outcomes') }}">{{ trans('message.sidebar_cash_flow_2') }}</a></li>
                                    <li class="@yield('sidebar_cash_flow_3')"><a href="{{ url('expenses') }}">{{ trans('message.sidebar_cash_flow_3') }}</a></li>
                                    <li class="@yield('sidebar_cash_flow_4')"><a href="{{ url('in-counts') }}">{{ trans('message.sidebar_cash_flow_4') }}</a></li>
                                    <!-- <li class="@yield('sidebar_cash_flow_5')"><a href="{{ url('pre-closing') }}">{{ trans('message.sidebar_cash_flow_5') }}</a></li> -->
                                    <li class="@yield('sidebar_cash_flow_6')"><a href="{{ url('cash-closing') }}">{{ trans('message.sidebar_cash_flow_6') }}</a></li>
                                </ul>
                            </li>
                            <li class="@yield('sidebar_customers')"><a href="{{ url('customers') }}"><i class='fa glyphicon glyphicon-heart'></i> <span>{{ trans('message.sidebar_clients') }}</span></a></li>
                            <li class="treeview @yield('sidebar_inventories')">
                                <a href="#"><i class='fa fa-cubes'></i> <span>{{ trans('message.sidebar_stocks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li class="@yield('sidebar_new_transfer_by_code')"><a href="{{ url('new-transfer-by-code') }}">{{ trans('message.sidebar_new_transfer_by_code') }}</a></li>
                                    <!-- <li class="@yield('sidebar_new_transfer')"><a href="{{ url('new-transfer') }}">{{ trans('message.sidebar_stocks_1') }}</a></li> -->
                                    <li class="@yield('sidebar_inventory')"><a href="{{ url('inventories') }}">{{ trans('message.sidebar_stocks_2') }}</a></li>
                                    <li class="@yield('sidebar_kardex')"><a href="{{ url('kardex') }}">{{ trans('message.sidebar_stocks_3') }}</a></li>
                                    <li class="@yield('sidebar_transfers')"><a href="{{ url('transfers') }}">{{ trans('message.sidebar_stocks_4') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    @else
                    <ul class="sidebar-menu">
                        <li class="@yield('sidebar_dashboard')"><a href="{{ url('dashboard') }}"><i class='fa fa-dashboard'></i> <span>{{ trans('message.sidebar_dashboard') }}</span></a></li>
                        <li class="treeview @yield('sidebar_reports')">
                            <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                <li class="@yield('sidebar_quotation_report')"><a href="{{ url('report-quotation') }}">{{ trans('message.sidebar_quotation_report') }}</a></li>
                                <li class="@yield('sidebar_commission_report')"><a href="{{ url('report-commission') }}">{{ trans('message.sidebar_commission_report') }}</a></li>
                                <!-- <li class="@yield('sidebar_reports_employee_assistance')"><a href="{{ url('reports-employee-assistance') }}">{{ trans('message.sidebar_reports_employee_assistance') }}</a></li> -->
                                <li class="@yield('sidebar_reports_employee_documents')"><a href="{{ url('reports-employee-documents') }}">{{ trans('message.sidebar_reports_employee_documents') }}</a></li>
                                <li class="@yield('sidebar_reports_sales_by_brand')"><a href="{{ url('reports-sales-by-brand') }}">{{ trans('message.sidebar_reports_sales_by_brand') }}</a></li>
                                <li class="@yield('sidebar_reports_sales_by_product')"><a href="{{ url('reports-sales-by-product') }}">{{ trans('message.sidebar_reports_sales_by_product') }}</a></li>
                                <li class="@yield('sidebar_reports_sales_by_client')"><a href="{{ url('reports-sales-by-client') }}">{{ trans('message.sidebar_reports_sales_by_client') }}</a></li>
                                <li class="@yield('sidebar_reports_sold_products')"><a href="{{ url('reports-sold-products') }}">{{ trans('message.sidebar_reports_sold_products') }}</a></li>
                                <li class="@yield('sidebar_reports_stocks_products')"><a href="{{ url('reports-stocks-products') }}">{{ trans('message.sidebar_reports_stocks_products') }}</a></li>
                                <!-- <li class="@yield('sidebar_reports_fifo')"><a href="{{ url('reports-fifo') }}">{{ trans('message.sidebar_reports_fifo') }}</a></li> -->
                                <li class="@yield('sidebar_transfer_movement')"><a href="{{ url('reports-transfer-movement') }}">{{ trans('message.sidebar_transfer_movement') }}</a></li>
                                <li class="@yield('sidebar_supplier_movement')"><a href="{{ url('reports-supplier-movement') }}">{{ trans('message.sidebar_supplier_movement_pre') }}</a></li>
                                <li class="@yield('sidebar_products_by_day')"><a href="{{ url('reports-products-by-day') }}">{{ trans('message.sidebar_products_by_day') }}</a></li>
                                <li class="@yield('sidebar_summary_ticket')"><a href="{{ url('reports-summary-ticket') }}">{{ trans('message.sidebar_summary_ticket') }}</a></li>
                                <!-- <li class="@yield('sidebar_sales_supplier')"><a href="{{ url('reports-sales-supplier') }}">{{ trans('message.sidebar_sales_supplier') }}</a></li> -->
                                @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                    <li class="@yield('sidebar_reports_orders')"><a href="{{ url('reports-orders') }}">{{ trans('message.sidebar_reports_orders') }}</a></li>
                                    <!-- <li class="@yield('sidebar_reports_tables')"><a href="{{ url('reports-tables-statistics') }}">{{ trans('message.sidebar_reports_tables') }}</a></li> -->
                                @endif
                                <li class="@yield('sidebar_customers_ranking')"><a href="{{ url('reports-customers-ranking') }}">{{ trans('message.sidebar_customers_ranking') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_sunat_reports')">
                            <a href="#"><i class='fa fa-file-text-o'></i> <span>{{ trans('message.sidebar_sunat_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_reports_fe')"><a href="{{ url('reports-fe') }}">{{ trans('message.sidebar_reports_fe') }}</a></li>
                                <!-- <li class="@yield('sidebar_reports_concar')"><a href="{{ url('reports-concar') }}">{{ trans('message.sidebar_reports_concar') }}</a></li> -->
                                <!-- <li class="@yield('sidebar_kardex_cpp')"><a href="{{ url('kardex-cpp') }}">{{ trans('message.sidebar_kardex_cpp') }}</a></li>
                                <li class="@yield('sidebar_kardex_allotment_cpp')"><a href="{{ url('kardex-allotment-cpp') }}">{{ trans('message.sidebar_kardex_allotment_cpp') }}</a></li> -->
                                <li class="@yield('sidebar_electronic_book_sale')"><a href="{{ url('electronic-book-sale') }}">{{ trans('message.sidebar_electronic_book_sale') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_visual_reports')">
                            <a href="#"><i class='fa fa-bar-chart'></i> <span>{{ trans('message.sidebar_visual_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_store_ranking')"><a href="{{ url('store-ranking') }}">{{ trans('message.sidebar_store_ranking') }}</a></li>
                                <li class="@yield('sidebar_salesman_ranking')"><a href="{{ url('salesman-ranking') }}">{{ trans('message.sidebar_salesman_ranking') }}</a></li>
                                
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_sales')">
                            <a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('message.sidebar_sales') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_0')"><a href="{{ url('new-sale') }}">{{ trans('message.sidebar_sales_0') }}</a></li>
                                <li class="@yield('new_sale_process')"><a href="{{ url('new-sale-process') }}">{{ trans('message.new_sale_process') }}</a></li>
                                @if(Auth::user()->company_id === 666)
                                <li class="@yield('new_sale_reserved')"><a href="{{ url('new-sale-reserved') }}">{{ trans('message.new_sale_reserved') }}</a></li>
                                @endif
                                <li class="@yield('received_payments')"><a href="{{ url('reports-received-payments') }}">{{ trans('message.received_payments') }}</a></li>
                                <li class="@yield('sidebar_sales_6')"><a href="{{ url('new-manual-sale/BLT') }}">{{ trans('message.sidebar_sales_6') }}</a></li>
                                <li class="@yield('sidebar_sales_7')"><a href="{{ url('new-manual-sale/FAC') }}">{{ trans('message.sidebar_sales_7') }}</a></li>
                                <li class="@yield('sidebar_sales_1')"><a href="{{ url('sales') }}">{{ trans('message.sidebar_sales_1') }}</a></li>
                                <li class="@yield('sidebar_fe_documents')"><a href="{{ url('fe-documents') }}">{{ trans('message.sidebar_fe_documents') }}</a></li>
                                <!-- <li class="@yield('sidebar_communication')"><a href="{{ url('fe-ra-summary') }}">{{ trans('message.sidebar_communication') }}</a></li> -->
                                
                                <li class="@yield('sidebar_sales_4')"><a href="{{ url('price-list') }}">{{ trans('message.sidebar_sales_4') }}</a></li>
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_purchases')">
                            <a href="#"><i class='fa fa-shopping-cart'></i> <span>{{ trans('message.sidebar_purchases') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_purchase')"><a href="{{ url('new-purchase') }}">{{ trans('message.sidebar_new_purchase') }}</a></li>
                                <li class="@yield('sidebar_purchase_list')"><a href="{{ url('purchases') }}">{{ trans('message.sidebar_purchase_list') }}</a></li>
                                <li class="@yield('sidebar_due_bills')"><a href="{{ url('due-bills') }}">{{ trans('message.sidebar_due_bills') }}</a></li>
                                <li class="@yield('sidebar_pay_bills')"><a href="{{ url('pay-bills') }}">{{ trans('message.sidebar_pay_bills') }}</a></li>
                            </ul>
                        </li> -->
                        <li class="treeview @yield('sidebar_quotations')">
                            <a href="#"><i class='fa fa-paper-plane-o'></i> <span>{{ trans('message.sidebar_sales_2') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_quotation')"><a href="{{ url('new-quotation') }}">{{ trans('message.sidebar_new_quotation') }}</a></li>
                                <li class="@yield('sidebar_quotation_list')"><a href="{{ url('quotations') }}">{{ trans('message.sidebar_quotation_list') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_remission_guide')">
                            <a href="#"><i class='fa fa-list-alt'></i> <span>{{ trans('message.sidebar_remission_guide') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_remission_guide_new_process')"><a href="{{ url('new-remission-guide-process') }}">{{ trans('message.sidebar_remission_guide_new_process') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_new_reserved')"><a href="{{ url('new-remission-guide-reserved') }}">{{ trans('message.sidebar_remission_guide_new_reserved') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_list')"><a href="{{ url('remission-guides') }}">{{ trans('message.sidebar_remission_guide_list') }}</a></li>
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_transport')">
                            <a href="#"><i class='fa fa-truck'></i> <span>{{ trans('message.sidebar_transport') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_transport_company')"><a href="{{ url('transport-company') }}">{{ trans('message.sidebar_transport_company') }}</a></li>
                                <li class="@yield('sidebar_transport_driver')"><a href="{{ url('transport-driver') }}">{{ trans('message.sidebar_transport_driver') }}</a></li>
                                <li class="@yield('sidebar_transport_truck')"><a href="{{ url('transport-truck') }}">{{ trans('message.sidebar_transport_truck') }}</a></li>
                                <li class="@yield('sidebar_transport_truck_brand')"><a href="{{ url('transport-truck-brand') }}">{{ trans('message.sidebar_transport_truck_brand') }}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="treeview @yield('sidebar_payments')">
                            <a href="#"><i class='fa fa-money'></i> <span>{{ trans('message.sidebar_payments') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_without_payments')"><a href="{{ url('sales-without-payments') }}">{{ trans('message.sidebar_sales_without_payments') }}</a></li>
                                <li class="@yield('sidebar_payments_list')"><a href="{{ url('payments') }}">{{ trans('message.sidebar_payments_list') }}</a></li>
                                <li class="@yield('sidebar_pay_quotations')"><a href="{{ url('pay-quotations') }}">{{ trans('message.sidebar_pay_quotations') }}</a></li>
                            </ul>
                        </li> -->
                        <li class="treeview @yield('sidebar_cash_flow')">
                            <a href="#"><i class='fa glyphicon glyphicon-piggy-bank'></i> <span>{{ trans('message.sidebar_cash_flow') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_cash_flow_0')"><a href="{{ url('open-cash') }}">{{ trans('message.sidebar_cash_flow_0') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_1')"><a href="{{ url('incomes') }}">{{ trans('message.sidebar_cash_flow_1') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_2')"><a href="{{ url('outcomes') }}">{{ trans('message.sidebar_cash_flow_2') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_3')"><a href="{{ url('expenses') }}">{{ trans('message.sidebar_cash_flow_3') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_4')"><a href="{{ url('in-counts') }}">{{ trans('message.sidebar_cash_flow_4') }}</a></li>
                                <!-- <li class="@yield('sidebar_cash_flow_5')"><a href="{{ url('pre-closing') }}">{{ trans('message.sidebar_cash_flow_5') }}</a></li> -->
                                <li class="@yield('sidebar_cash_flow_6')"><a href="{{ url('cash-closing') }}">{{ trans('message.sidebar_cash_flow_6') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_inventories')">
                            <a href="#"><i class='fa fa-cubes'></i> <span>{{ trans('message.sidebar_stocks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_transfer_by_code')"><a href="{{ url('new-transfer-by-code') }}">{{ trans('message.sidebar_new_transfer_by_code') }}</a></li>
                                @if (Auth::user()->company_id === 630 )
                                    <li class="@yield('sidebar_new_transfer')"><a href="{{ url('new-transfer') }}">{{ trans('message.sidebar_stocks_1') }}</a></li>
                                @endif
                                <li class="@yield('sidebar_inventory')"><a href="{{ url('inventories') }}">{{ trans('message.sidebar_stocks_2') }}</a></li>
                                <li class="@yield('sidebar_kardex')"><a href="{{ url('kardex') }}">{{ trans('message.sidebar_stocks_3') }}</a></li>
                                <li class="@yield('sidebar_kardex_warehouse')"><a href="{{ url('kardex-warehouse') }}">{{ trans('message.sidebar_kardex_warehouse') }}</a></li>
                                <li class="@yield('sidebar_kardex_brand')"><a href="{{ url('kardex-brand') }}">{{ trans('message.sidebar_kardex_brand') }}</a></li>
                                <li class="@yield('sidebar_transfers')"><a href="{{ url('transfers') }}">{{ trans('message.sidebar_stocks_4') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_products')">
                            <a href="#"><i class='fa fa-cube'></i> <span>{{ trans('message.sidebar_products') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_products_1')"><a href="{{ url('products') }}">{{ trans('message.sidebar_products_1') }}</a></li>
                                <li class="@yield('sidebar_recipies')"><a href="{{ url('recipies') }}">{{ trans('message.sidebar_recipies') }}</a></li>
                                <li class="@yield('sidebar_products_2')"><a href="{{ url('products-income') }}">{{ trans('message.sidebar_products_2') }}</a></li>
                                @if (Auth::user()->company_id === 510 || Auth::user()->company_id === 321 || Auth::user()->company_id === 700)
                                    <li class="@yield('sidebar_products_movement')"><a href="{{ url('products-movement') }}">{{ trans('message.sidebar_products_movement') }}</a></li>
                                @endif
                                <li class="@yield('sidebar_products_10')"><a href="{{ url('products-outcome') }}">{{ trans('message.sidebar_products_10') }}</a></li>
                                <li class="@yield('sidebar_products_3')"><a href="{{ url('incomes-history') }}">{{ trans('message.sidebar_products_3') }}</a></li>
                                <li class="@yield('sidebar_allotments')"><a href="{{ url('allotments') }}">{{ trans('message.sidebar_allotments') }}</a></li>
                                <li class="@yield('sidebar_serials')"><a href="{{ url('serials') }}">{{ trans('message.sidebar_serials') }}</a></li>
                                <li class="@yield('sidebar_products_4')"><a href="{{ url('categories') }}">{{ trans('message.sidebar_products_4') }}</a></li>
                                <li class="@yield('sidebar_products_5')"><a href="{{ url('brands') }}">{{ trans('message.sidebar_products_5') }}</a></li>
                                <li class="@yield('sidebar_products_6')"><a href="{{ url('features') }}">{{ trans('message.sidebar_products_6') }}</a></li>
                                <!-- <li class="@yield('sidebar_products_7')"><a href="{{ url('units') }}">{{ trans('message.sidebar_products_7') }}</a></li> -->
                                
                                
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_confcompany')">
                            <a href="#"><i class='fa glyphicon glyphicon-briefcase'></i> <span>{{ trans('message.sidebar_confcompany') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_suppliers')"><a href="{{ url('suppliers') }}">  <span>{{ trans('message.sidebar_suppliers') }}</span></a></li>
                                <li class="@yield('sidebar_customers')"><a href="{{ url('customers') }}">  <span>{{ trans('message.sidebar_clients') }}</span></a></li>
                                <li class="@yield('sidebar_warehouses')"><a href="{{ url('warehouses') }}">  <span>{{ trans('message.sidebar_warehouse') }}</span></a></li>
                                <li class="@yield('sidebar_users')"><a href="{{ url('users') }}">  <span>{{ trans('message.sidebar_users') }}</span></a></li>
                                <!-- <li class="@yield('sidebar_printers')"><a href="{{ url('printers') }}">  <span>{{ trans('message.sidebar_printers') }}</span></a></li> -->
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_config')">
                            <a href="#"><i class='fa fa-gears'></i> <span>{{ trans('message.sidebar_config') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_terminals')"><a href="{{ url('terminals') }}">{{ trans('message.sidebar_terminals') }}</a></li>
                                <li class="@yield('sidebar_serie')"><a href="{{ url('series') }}">{{ trans('message.sidebar_serie') }}</a></li>
                                <li class="@yield('sidebar_printers')"><a href="{{ url('printers') }}">{{ trans('message.sidebar_printers') }}</a></li>
                                @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                    <li class="@yield('sidebar_tables')"><a href="{{ url('tables') }}">{{ trans('message.sidebar_tables') }}</a></li>
                                @endif
                            </ul>
                        </li> -->
                    </ul>
                    @endif
                    @break
                <!-- ALMACENERO url: reports-stocks-products --> 
                @elseif ($roles['roles_id'] === 4)
                    <ul class="sidebar-menu">
                        <li class="treeview @yield('sidebar_reports')">
                            <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_reports_stocks_products')"><a href="{{ url('reports-stocks-products') }}">{{ trans('message.sidebar_reports_stocks_products') }}</a></li>
                                <li class="@yield('sidebar_transfer_movement')"><a href="{{ url('reports-transfer-movement') }}">{{ trans('message.sidebar_transfer_movement') }}</a></li>
                                <li class="@yield('sidebar_supplier_movement')"><a href="{{ url('reports-supplier-movement') }}">{{ trans('message.sidebar_supplier_movement_pre') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_inventories')">
                            <a href="#"><i class='fa fa-cubes'></i> <span>{{ trans('message.sidebar_stocks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_transfer_by_code')"><a href="{{ url('new-transfer-by-code') }}">{{ trans('message.sidebar_new_transfer_by_code') }}</a></li>
                                @if (Auth::user()->company_id === 630 )
                                    <li class="@yield('sidebar_new_transfer')"><a href="{{ url('new-transfer') }}">{{ trans('message.sidebar_stocks_1') }}</a></li>
                                @endif
                                <li class="@yield('sidebar_inventory')"><a href="{{ url('inventories') }}">{{ trans('message.sidebar_stocks_2') }}</a></li>
                                <li class="@yield('sidebar_kardex')"><a href="{{ url('kardex') }}">{{ trans('message.sidebar_stocks_3') }}</a></li>
                                <li class="@yield('sidebar_kardex_warehouse')"><a href="{{ url('kardex-warehouse') }}">{{ trans('message.sidebar_kardex_warehouse') }}</a></li>
                                <li class="@yield('sidebar_kardex_brand')"><a href="{{ url('kardex-brand') }}">{{ trans('message.sidebar_kardex_brand') }}</a></li>
                                <li class="@yield('sidebar_transfers')"><a href="{{ url('transfers') }}">{{ trans('message.sidebar_stocks_4') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_products')">
                            <a href="#"><i class='fa fa-cube'></i> <span>{{ trans('message.sidebar_products') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_products_1')"><a href="{{ url('products') }}">{{ trans('message.sidebar_products_1') }}</a></li>
                                <li class="@yield('sidebar_recipies')"><a href="{{ url('recipies') }}">{{ trans('message.sidebar_recipies') }}</a></li>
                                <li class="@yield('sidebar_products_2')"><a href="{{ url('products-income') }}">{{ trans('message.sidebar_products_2') }}</a></li>
                                @if (Auth::user()->company_id === 510 || Auth::user()->company_id === 321 || Auth::user()->company_id === 700)
                                    <li class="@yield('sidebar_products_movement')"><a href="{{ url('products-movement') }}">{{ trans('message.sidebar_products_movement') }}</a></li>
                                @endif
                                <li class="@yield('sidebar_products_10')"><a href="{{ url('products-outcome') }}">{{ trans('message.sidebar_products_10') }}</a></li>
                                <li class="@yield('sidebar_products_3')"><a href="{{ url('incomes-history') }}">{{ trans('message.sidebar_products_3') }}</a></li>
                                <li class="@yield('sidebar_allotments')"><a href="{{ url('allotments') }}">{{ trans('message.sidebar_allotments') }}</a></li>
                                <li class="@yield('sidebar_serials')"><a href="{{ url('serials') }}">{{ trans('message.sidebar_serials') }}</a></li>
                                <li class="@yield('sidebar_products_4')"><a href="{{ url('categories') }}">{{ trans('message.sidebar_products_4') }}</a></li>
                                <li class="@yield('sidebar_products_5')"><a href="{{ url('brands') }}">{{ trans('message.sidebar_products_5') }}</a></li>
                                <li class="@yield('sidebar_products_6')"><a href="{{ url('features') }}">{{ trans('message.sidebar_products_6') }}</a></li>
                                <!-- <li class="@yield('sidebar_products_7')"><a href="{{ url('units') }}">{{ trans('message.sidebar_products_7') }}</a></li> -->
                                
                                
                            </ul>
                        </li>
                    </ul>
                    @break
                <!-- CONTADOR url: reports-fe -->
                @elseif ($roles['roles_id'] === 12)
                    <ul class="sidebar-menu">
                        <li class="treeview @yield('sidebar_sunat_reports')">
                            <a href="#"><i class='fa fa-file-text-o'></i> <span>{{ trans('message.sidebar_sunat_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_reports_fe')"><a href="{{ url('reports-fe') }}">{{ trans('message.sidebar_reports_fe') }}</a></li>
                                @if (Auth::user()->company_id === 527)
                                    <li class="@yield('sidebar_reports_sales_by_product')"><a href="{{ url('reports-sales-by-product') }}">{{ trans('message.sidebar_reports_sales_by_product') }}</a></li>
                                    <li class="@yield('sidebar_reports_stocks_products')"><a href="{{ url('reports-stocks-products') }}">{{ trans('message.sidebar_reports_stocks_products') }}</a></li>
                                @endif
                                <!-- <li class="@yield('sidebar_reports_concar')"><a href="{{ url('reports-concar') }}">{{ trans('message.sidebar_reports_concar') }}</a></li> -->
                                <!-- <li class="@yield('sidebar_kardex_cpp')"><a href="{{ url('kardex-cpp') }}">{{ trans('message.sidebar_kardex_cpp') }}</a></li>
                                <li class="@yield('sidebar_kardex_allotment_cpp')"><a href="{{ url('kardex-allotment-cpp') }}">{{ trans('message.sidebar_kardex_allotment_cpp') }}</a></li> -->
                                <li class="@yield('sidebar_electronic_book_sale')"><a href="{{ url('electronic-book-sale') }}">{{ trans('message.sidebar_electronic_book_sale') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_reports')">
                            <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_reports_sold_products')"><a href="{{ url('reports-sold-products') }}">{{ trans('message.sidebar_reports_sold_products') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                    @break
                <!-- ADMINISTRADOR DE TIENDA url: dashboard -->
                @elseif ($roles['roles_id'] === 13 || $roles['roles_id'] === 16)
                    <ul class="sidebar-menu">
                        <li class="@yield('sidebar_dashboard')"><a href="{{ url('dashboard') }}"><i class='fa fa-dashboard'></i> <span>{{ trans('message.sidebar_dashboard') }}</span></a></li>
                        <li class="treeview @yield('sidebar_reports')">
                            <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                <li class="@yield('sidebar_quotation_report')"><a href="{{ url('report-quotation') }}">{{ trans('message.sidebar_quotation_report') }}</a></li>
                                <li class="@yield('sidebar_commission_report')"><a href="{{ url('report-commission') }}">{{ trans('message.sidebar_commission_report') }}</a></li>
                                <!-- <li class="@yield('sidebar_reports_employee_assistance')"><a href="{{ url('reports-employee-assistance') }}">{{ trans('message.sidebar_reports_employee_assistance') }}</a></li> -->
                                <li class="@yield('sidebar_reports_employee_documents')"><a href="{{ url('reports-employee-documents') }}">{{ trans('message.sidebar_reports_employee_documents') }}</a></li>
                                <li class="@yield('sidebar_reports_fe')"><a href="{{ url('reports-fe') }}">{{ trans('message.sidebar_reports_fe') }}</a></li>
                                <li class="@yield('sidebar_reports_sales_by_brand')"><a href="{{ url('reports-sales-by-brand') }}">{{ trans('message.sidebar_reports_sales_by_brand') }}</a></li>
                                <li class="@yield('sidebar_reports_sales_by_product')"><a href="{{ url('reports-sales-by-product') }}">{{ trans('message.sidebar_reports_sales_by_product') }}</a></li>
                                <li class="@yield('sidebar_reports_sold_products')"><a href="{{ url('reports-sold-products') }}">{{ trans('message.sidebar_reports_sold_products') }}</a></li>
                                <li class="@yield('sidebar_reports_stocks_products')"><a href="{{ url('reports-stocks-products') }}">{{ trans('message.sidebar_reports_stocks_products') }}</a></li>
                                <!-- <li class="@yield('sidebar_reports_fifo')"><a href="{{ url('reports-fifo') }}">{{ trans('message.sidebar_reports_fifo') }}</a></li> -->
                                <li class="@yield('sidebar_transfer_movement')"><a href="{{ url('reports-transfer-movement') }}">{{ trans('message.sidebar_transfer_movement') }}</a></li>
                                <li class="@yield('sidebar_supplier_movement')"><a href="{{ url('reports-supplier-movement') }}">{{ trans('message.sidebar_supplier_movement_pre') }}</a></li>
                                <li class="@yield('sidebar_products_by_day')"><a href="{{ url('reports-products-by-day') }}">{{ trans('message.sidebar_products_by_day') }}</a></li>
                                <li class="@yield('sidebar_summary_ticket')"><a href="{{ url('reports-summary-ticket') }}">{{ trans('message.sidebar_summary_ticket') }}</a></li>
                                @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                    <li class="@yield('sidebar_reports_orders')"><a href="{{ url('reports-orders') }}">{{ trans('message.sidebar_reports_orders') }}</a></li>
                                    <!-- <li class="@yield('sidebar_reports_tables')"><a href="{{ url('reports-tables-statistics') }}">{{ trans('message.sidebar_reports_tables') }}</a></li> -->
                                @endif
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_sales')">
                            <a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('message.sidebar_sales') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_0')"><a href="{{ url('new-sale') }}">{{ trans('message.sidebar_sales_0') }}</a></li>
                                <li class="@yield('new_sale_process')"><a href="{{ url('new-sale-process') }}">{{ trans('message.new_sale_process') }}</a></li>
                                <li class="@yield('sidebar_credit_sale')"><a href="{{ url('new-credit-sale') }}">{{ trans('message.sidebar_credit_sale') }}</a></li>
                                <li class="@yield('new_sale_reserved')"><a href="{{ url('new-sale-reserved') }}">{{ trans('message.new_sale_reserved') }}</a></li>
                                <li class="@yield('sidebar_sales_6')"><a href="{{ url('new-manual-sale/BLT') }}">{{ trans('message.sidebar_sales_6') }}</a></li>
                                <li class="@yield('sidebar_sales_7')"><a href="{{ url('new-manual-sale/FAC') }}">{{ trans('message.sidebar_sales_7') }}</a></li>
                                <li class="@yield('sidebar_sales_1')"><a href="{{ url('sales') }}">{{ trans('message.sidebar_sales_1') }}</a></li>
                                <li class="@yield('sidebar_fe_documents')"><a href="{{ url('fe-documents') }}">{{ trans('message.sidebar_fe_documents') }}</a></li>
                                
                                <li class="@yield('sidebar_sales_4')"><a href="{{ url('price-list') }}">{{ trans('message.sidebar_sales_4') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_quotations')">
                            <a href="#"><i class='fa fa-paper-plane-o'></i> <span>{{ trans('message.sidebar_sales_2') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_quotation')"><a href="{{ url('new-quotation') }}">{{ trans('message.sidebar_new_quotation') }}</a></li>
                                <li class="@yield('sidebar_quotation_list')"><a href="{{ url('quotations') }}">{{ trans('message.sidebar_quotation_list') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_remission_guide')">
                            <a href="#"><i class='fa fa-list-alt'></i> <span>{{ trans('message.sidebar_remission_guide') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_remission_guide_new_process')"><a href="{{ url('new-remission-guide-process') }}">{{ trans('message.sidebar_remission_guide_new_process') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_new_reserved')"><a href="{{ url('new-remission-guide-reserved') }}">{{ trans('message.sidebar_remission_guide_new_reserved') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_list')"><a href="{{ url('remission-guides') }}">{{ trans('message.sidebar_remission_guide_list') }}</a></li>
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_transport')">
                            <a href="#"><i class='fa fa-truck'></i> <span>{{ trans('message.sidebar_transport') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_transport_company')"><a href="{{ url('transport-company') }}">{{ trans('message.sidebar_transport_company') }}</a></li>
                                <li class="@yield('sidebar_transport_driver')"><a href="{{ url('transport-driver') }}">{{ trans('message.sidebar_transport_driver') }}</a></li>
                                <li class="@yield('sidebar_transport_truck')"><a href="{{ url('transport-truck') }}">{{ trans('message.sidebar_transport_truck') }}</a></li>
                                <li class="@yield('sidebar_transport_truck_brand')"><a href="{{ url('transport-truck-brand') }}">{{ trans('message.sidebar_transport_truck_brand') }}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="treeview @yield('sidebar_payments')">
                            <a href="#"><i class='fa fa-money'></i> <span>{{ trans('message.sidebar_payments') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_without_payments')"><a href="{{ url('sales-without-payments') }}">{{ trans('message.sidebar_sales_without_payments') }}</a></li>
                                <li class="@yield('sidebar_payments_list')"><a href="{{ url('payments') }}">{{ trans('message.sidebar_payments_list') }}</a></li>
                            </ul>
                        </li> -->
                        <li class="treeview @yield('sidebar_cash_flow')">
                            <a href="#"><i class='fa glyphicon glyphicon-piggy-bank'></i> <span>{{ trans('message.sidebar_cash_flow') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_cash_flow_0')"><a href="{{ url('open-cash') }}">{{ trans('message.sidebar_cash_flow_0') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_1')"><a href="{{ url('incomes') }}">{{ trans('message.sidebar_cash_flow_1') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_2')"><a href="{{ url('outcomes') }}">{{ trans('message.sidebar_cash_flow_2') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_3')"><a href="{{ url('expenses') }}">{{ trans('message.sidebar_cash_flow_3') }}</a></li>
                                <li class="@yield('sidebar_cash_flow_4')"><a href="{{ url('in-counts') }}">{{ trans('message.sidebar_cash_flow_4') }}</a></li>
                                <!-- <li class="@yield('sidebar_cash_flow_5')"><a href="{{ url('pre-closing') }}">{{ trans('message.sidebar_cash_flow_5') }}</a></li> -->
                                <li class="@yield('sidebar_cash_flow_6')"><a href="{{ url('cash-closing') }}">{{ trans('message.sidebar_cash_flow_6') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_inventories')">
                            <a href="#"><i class='fa fa-cubes'></i> <span>{{ trans('message.sidebar_stocks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_transfer_by_code')"><a href="{{ url('new-transfer-by-code') }}">{{ trans('message.sidebar_new_transfer_by_code') }}</a></li>
                                <!-- <li class="@yield('sidebar_new_transfer')"><a href="{{ url('new-transfer') }}">{{ trans('message.sidebar_stocks_1') }}</a></li> -->
                                <li class="@yield('sidebar_inventory')"><a href="{{ url('inventories') }}">{{ trans('message.sidebar_stocks_2') }}</a></li>
                                <li class="@yield('sidebar_kardex_cpp')"><a href="{{ url('kardex-cpp') }}">{{ trans('message.sidebar_kardex_cpp') }}</a></li>
                                <li class="@yield('sidebar_kardex_allotment_cpp')"><a href="{{ url('kardex-allotment-cpp') }}">{{ trans('message.sidebar_kardex_allotment_cpp') }}</a></li>
                                <li class="@yield('sidebar_kardex')"><a href="{{ url('kardex') }}">{{ trans('message.sidebar_stocks_3') }}</a></li>
                                <li class="@yield('sidebar_kardex_warehouse')"><a href="{{ url('kardex-warehouse') }}">{{ trans('message.sidebar_kardex_warehouse') }}</a></li>
                                <li class="@yield('sidebar_kardex_brand')"><a href="{{ url('kardex-brand') }}">{{ trans('message.sidebar_kardex_brand') }}</a></li>
                                <li class="@yield('sidebar_transfers')"><a href="{{ url('transfers') }}">{{ trans('message.sidebar_stocks_4') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_products')">
                            <a href="#"><i class='fa fa-cube'></i> <span>{{ trans('message.sidebar_products') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_products_1')"><a href="{{ url('products') }}">{{ trans('message.sidebar_products_1') }}</a></li>
                                <li class="@yield('sidebar_products_2')"><a href="{{ url('products-income') }}">{{ trans('message.sidebar_products_2') }}</a></li>
                                <li class="@yield('sidebar_products_10')"><a href="{{ url('products-outcome') }}">{{ trans('message.sidebar_products_10') }}</a></li>
                                <li class="@yield('sidebar_products_3')"><a href="{{ url('incomes-history') }}">{{ trans('message.sidebar_products_3') }}</a></li>
                                <li class="@yield('sidebar_allotments')"><a href="{{ url('allotments') }}">{{ trans('message.sidebar_allotments') }}</a></li>
                                <li class="@yield('sidebar_serials')"><a href="{{ url('serials') }}">{{ trans('message.sidebar_serials') }}</a></li>
                                <li class="@yield('sidebar_products_4')"><a href="{{ url('categories') }}">{{ trans('message.sidebar_products_4') }}</a></li>
                                <li class="@yield('sidebar_products_5')"><a href="{{ url('brands') }}">{{ trans('message.sidebar_products_5') }}</a></li>
                                <li class="@yield('sidebar_products_6')"><a href="{{ url('features') }}">{{ trans('message.sidebar_products_6') }}</a></li>
                                <!-- <li class="@yield('sidebar_products_7')"><a href="{{ url('units') }}">{{ trans('message.sidebar_products_7') }}</a></li> -->
                                
                                
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_confcompany')">
                            <a href="#"><i class='fa glyphicon glyphicon-briefcase'></i> <span>{{ trans('message.sidebar_confcompany') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_suppliers')"><a href="{{ url('suppliers') }}">  <span>{{ trans('message.sidebar_suppliers') }}</span></a></li>
                                <li class="@yield('sidebar_customers')"><a href="{{ url('customers') }}">  <span>{{ trans('message.sidebar_clients') }}</span></a></li>
                                <li class="@yield('sidebar_warehouses')"><a href="{{ url('warehouses') }}">  <span>{{ trans('message.sidebar_warehouse') }}</span></a></li>
                                <li class="@yield('sidebar_users')"><a href="{{ url('users') }}">  <span>{{ trans('message.sidebar_users') }}</span></a></li>
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_config')">
                            <a href="#"><i class='fa fa-gears'></i> <span>{{ trans('message.sidebar_config') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_terminals')"><a href="{{ url('terminals') }}">{{ trans('message.sidebar_terminals') }}</a></li>
                                <li class="@yield('sidebar_serie')"><a href="{{ url('series') }}">{{ trans('message.sidebar_serie') }}</a></li>
                                <li class="@yield('sidebar_printers')"><a href="{{ url('printers') }}">{{ trans('message.sidebar_printers') }}</a></li>
                                @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                    <li class="@yield('sidebar_tables')"><a href="{{ url('tables') }}">{{ trans('message.sidebar_tables') }}</a></li>
                                @endif
                            </ul>
                        </li> -->
                    </ul>
                    @break
                <!-- COTIZADOR url: report-sales -->
                @elseif ($roles['roles_id'] === 15)
                    <ul class="sidebar-menu">
                        @if (Auth::user()->company_id === 321 || Auth::user()->company_id === 474)
                            <li class="treeview @yield('sidebar_reports')">
                                <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                    <li class="@yield('sidebar_quotation_report')"><a href="{{ url('report-quotation') }}">{{ trans('message.sidebar_quotation_report') }}</a></li>
                                    <!-- <li class="@yield('sidebar_reports_employee_assistance')"><a href="{{ url('reports-employee-assistance') }}">{{ trans('message.sidebar_reports_employee_assistance') }}</a></li> -->
                                    <li class="@yield('sidebar_reports_employee_documents')"><a href="{{ url('reports-employee-documents') }}">{{ trans('message.sidebar_reports_employee_documents') }}</a></li>
                                    <li class="@yield('sidebar_reports_fe')"><a href="{{ url('reports-fe') }}">{{ trans('message.sidebar_reports_fe') }}</a></li>
                                    <li class="@yield('sidebar_reports_sales_by_brand')"><a href="{{ url('reports-sales-by-brand') }}">{{ trans('message.sidebar_reports_sales_by_brand') }}</a></li>
                                    <li class="@yield('sidebar_reports_sales_by_product')"><a href="{{ url('reports-sales-by-product') }}">{{ trans('message.sidebar_reports_sales_by_product') }}</a></li>
                                    <li class="@yield('sidebar_reports_sold_products')"><a href="{{ url('reports-sold-products') }}">{{ trans('message.sidebar_reports_sold_products') }}</a></li>
                                    <li class="@yield('sidebar_reports_stocks_products')"><a href="{{ url('reports-stocks-products') }}">{{ trans('message.sidebar_reports_stocks_products') }}</a></li>
                                    @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                        <li class="@yield('sidebar_reports_orders')"><a href="{{ url('reports-orders') }}">{{ trans('message.sidebar_reports_orders') }}</a></li>
                                        <!-- <li class="@yield('sidebar_reports_tables')"><a href="{{ url('reports-tables-statistics') }}">{{ trans('message.sidebar_reports_tables') }}</a></li> -->
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <li class="treeview @yield('sidebar_quotations')">
                            <a href="#"><i class='fa fa-paper-plane-o'></i> <span>{{ trans('message.sidebar_sales_2') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_quotation')"><a href="{{ url('new-quotation') }}">{{ trans('message.sidebar_new_quotation') }}</a></li>
                                <li class="@yield('sidebar_quotation_list')"><a href="{{ url('quotations') }}">{{ trans('message.sidebar_quotation_list') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_confcompany')">
                            <a href="#"><i class='fa glyphicon glyphicon-briefcase'></i> <span>{{ trans('message.sidebar_confcompany') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_customers')"><a href="{{ url('customers') }}">  <span>{{ trans('message.sidebar_clients') }}</span></a></li>
                            </ul>
                        </li>
                    </ul>
                    @break
                <!-- SUPER ADMINISTRADOR 2 url: dashboard -->
                @elseif ($roles['roles_id'] === 18)
                    <ul class="sidebar-menu">
                        <li class="@yield('sidebar_dashboard')"><a href="{{ url('dashboard') }}"><i class='fa fa-dashboard'></i> <span>{{ trans('message.sidebar_dashboard') }}</span></a></li>
                        <li class="treeview @yield('sidebar_products')">
                            <a href="#"><i class='fa fa-cube'></i> <span>{{ trans('message.sidebar_products') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_products_1')"><a href="{{ url('products') }}">{{ trans('message.sidebar_products_1') }}</a></li>
                                <li class="@yield('sidebar_recipies')"><a href="{{ url('recipies') }}">{{ trans('message.sidebar_recipies') }}</a></li>
                                <li class="@yield('sidebar_products_2')"><a href="{{ url('products-income') }}">{{ trans('message.sidebar_products_2') }}</a></li>
                                <li class="@yield('sidebar_products_10')"><a href="{{ url('products-outcome') }}">{{ trans('message.sidebar_products_10') }}</a></li>
                                <li class="@yield('sidebar_products_3')"><a href="{{ url('incomes-history') }}">{{ trans('message.sidebar_products_3') }}</a></li>
                                <!-- <li class="@yield('sidebar_allotments')"><a href="{{ url('allotments') }}">{{ trans('message.sidebar_allotments') }}</a></li>
                                <li class="@yield('sidebar_serials')"><a href="{{ url('serials') }}">{{ trans('message.sidebar_serials') }}</a></li> -->
                                <li class="@yield('sidebar_products_4')"><a href="{{ url('categories') }}">{{ trans('message.sidebar_products_4') }}</a></li>
                                <li class="@yield('sidebar_products_5')"><a href="{{ url('brands') }}">{{ trans('message.sidebar_products_5') }}</a></li>
                                <!-- <li class="@yield('sidebar_products_6')"><a href="{{ url('features') }}">{{ trans('message.sidebar_products_6') }}</a></li>
                                <li class="@yield('sidebar_products_7')"><a href="{{ url('units') }}">{{ trans('message.sidebar_products_7') }}</a></li> -->
                                
                                
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_inventories')">
                            <a href="#"><i class='fa fa-cubes'></i> <span>{{ trans('message.sidebar_stocks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_transfer_by_code')"><a href="{{ url('new-transfer-by-code') }}">{{ trans('message.sidebar_new_transfer_by_code') }}</a></li>
                                <li class="@yield('sidebar_inventory')"><a href="{{ url('inventories') }}">{{ trans('message.sidebar_stocks_2') }}</a></li>
                                <li class="@yield('sidebar_kardex_cpp')"><a href="{{ url('kardex-cpp') }}">{{ trans('message.sidebar_kardex_cpp') }}</a></li>
                                <li class="@yield('sidebar_kardex')"><a href="{{ url('kardex') }}">{{ trans('message.sidebar_stocks_3') }}</a></li>
                                <li class="@yield('sidebar_kardex_warehouse')"><a href="{{ url('kardex-warehouse') }}">{{ trans('message.sidebar_kardex_warehouse') }}</a></li>
                                <li class="@yield('sidebar_transfers')"><a href="{{ url('transfers') }}">{{ trans('message.sidebar_stocks_4') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_sales')">
                            <a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('message.sidebar_sales') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_0')"><a href="{{ url('new-sale') }}">{{ trans('message.sidebar_sales_0') }}</a></li>
                                <li class="@yield('sidebar_sales_1')"><a href="{{ url('sales') }}">{{ trans('message.sidebar_sales_1') }}</a></li>
                            </ul>
                        </li>
                        <!-- <li class="treeview @yield('sidebar_quotations')">
                            <a href="#"><i class='fa fa-paper-plane-o'></i> <span>{{ trans('message.sidebar_sales_2') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_new_quotation')"><a href="{{ url('new-quotation') }}">{{ trans('message.sidebar_new_quotation') }}</a></li>
                                <li class="@yield('sidebar_quotation_list')"><a href="{{ url('quotations') }}">{{ trans('message.sidebar_quotation_list') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_remission_guide')">
                            <a href="#"><i class='fa fa-list-alt'></i> <span>{{ trans('message.sidebar_remission_guide') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_remission_guide_new_process')"><a href="{{ url('new-remission-guide-process') }}">{{ trans('message.sidebar_remission_guide_new_process') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_new_reserved')"><a href="{{ url('new-remission-guide-reserved') }}">{{ trans('message.sidebar_remission_guide_new_reserved') }}</a></li>
                                <li class="@yield('sidebar_remission_guide_list')"><a href="{{ url('remission-guides') }}">{{ trans('message.sidebar_remission_guide_list') }}</a></li>
                            </ul>
                        </li> -->
                        <li class="treeview @yield('sidebar_reports')">
                            <a href="#"><i class='fa fa-database'></i> <span>{{ trans('message.sidebar_reports') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_sales_report')"><a href="{{ url('report-sales') }}">{{ trans('message.sidebar_sales_report') }}</a></li>
                                <li class="@yield('sidebar_reports_fe')"><a href="{{ url('reports-fe') }}">{{ trans('message.sidebar_reports_fe') }}</a></li>
                                <li class="@yield('sidebar_supplier_movement')"><a href="{{ url('reports-supplier-movement') }}">{{ trans('message.sidebar_supplier_movement_pre') }}</a></li>
                                <li class="@yield('sidebar_products_by_day')"><a href="{{ url('reports-products-by-day') }}">{{ trans('message.sidebar_products_by_day') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_transport')">
                            <a href="#"><i class='fa fa-truck'></i> <span>{{ trans('message.sidebar_transport') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_transport_company')"><a href="{{ url('transport-company') }}">{{ trans('message.sidebar_transport_company') }}</a></li>
                                <li class="@yield('sidebar_transport_driver')"><a href="{{ url('transport-driver') }}">{{ trans('message.sidebar_transport_driver') }}</a></li>
                                <li class="@yield('sidebar_transport_truck')"><a href="{{ url('transport-truck') }}">{{ trans('message.sidebar_transport_truck') }}</a></li>
                                <li class="@yield('sidebar_transport_truck_brand')"><a href="{{ url('transport-truck-brand') }}">{{ trans('message.sidebar_transport_truck_brand') }}</a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_confcompany')">
                            <a href="#"><i class='fa glyphicon glyphicon-briefcase'></i> <span>{{ trans('message.sidebar_confcompany') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_suppliers')"><a href="{{ url('suppliers') }}">  <span>{{ trans('message.sidebar_suppliers') }}</span></a></li>
                                <li class="@yield('sidebar_customers')"><a href="{{ url('customers') }}">  <span>{{ trans('message.sidebar_clients') }}</span></a></li>
                                <li class="@yield('sidebar_warehouses')"><a href="{{ url('warehouses') }}">  <span>{{ trans('message.sidebar_warehouse') }}</span></a></li>
                                <li class="@yield('sidebar_users')"><a href="{{ url('users') }}">  <span>{{ trans('message.sidebar_users') }}</span></a></li>
                            </ul>
                        </li>
                        <li class="treeview @yield('sidebar_config')">
                            <a href="#"><i class='fa fa-gears'></i> <span>{{ trans('message.sidebar_config') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li class="@yield('sidebar_terminals')"><a href="{{ url('terminals') }}">{{ trans('message.sidebar_terminals') }}</a></li>
                                <li class="@yield('sidebar_serie')"><a href="{{ url('series') }}">{{ trans('message.sidebar_serie') }}</a></li>
                                <!-- <li class="@yield('sidebar_printers')"><a href="{{ url('printers') }}">{{ trans('message.sidebar_printers') }}</a></li> -->
                                @if (Auth::user()->company_area_code === 'FAS' || Auth::user()->company_area_code === 'FOO')
                                    <li class="@yield('sidebar_tables')"><a href="{{ url('tables') }}">{{ trans('message.sidebar_tables') }}</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @break

                

                @endif
            @endforeach
        @endif
    </section>
</aside>
