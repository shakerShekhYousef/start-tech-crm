<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            user-select: none;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;

        }

        .sidebar {
            position: fixed;
            width: 120%;
            height: 100%;
            left: 0;
        }

        .sidebar .text {
            color: white;
            font-size: 25px;
            font-weight: 600;
            line-height: 65px;
            text-align: center;
            background: #70cacc;
            letter-spacing: 1px;
        }

        nav ul {
            background: #70cacc;
            height: 100%;
            width: 140%;
            list-style: none;
        }

        nav ul li {
            line-height: 60px;
            border-bottom: 1px solid rgb(255, 255, 255);
        }

        nav ul li:last-child {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05)
        }

        nav ul li a {
            position: relative;
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding-left: 20px;
            font-weight: 500;
            display: block;
            width: 100%;
            border-left: 3px solid transparent;
        }

        nav ul li.active a {
            color: cyan;
            background: #70cacc;
            border-left-color: cyan;
        }

        nav ul li.active ul li a {
            color: #e6e6e6;
            background: #70cacc;
            border-left-color: transparent;
        }

        nav ul ul li a:hover {
            color: cyan !important;
            background: #70cacc !important;
        }

        nav ul ul {
            position: static;
            display: none;
        }

        nav ul .leads-show.show {
            display: block;
            width: 100%
        }

        nav ul .asd-show.show {
            display: block;
            width: 100%
        }

        nav ul .report-show.show {
            display: block;
            width: 100%
        }

        nav ul .au-show.show {
            display: block;
            width: 100%
        }

        nav ul .pm-show.show {
            display: block;
            width: 100%
        }

        nav ul ul li {
            line-height: 42px;
            border-bottom: none;
        }

        nav ul ul li a {
            font-size: 14px;
            color: #e6e6e6;
            padding-left: 25px;
        }

        nav ul li a span {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translate(-50%);
            font-size: 22px;
            transition: transform 0.4s;
        }

        nav ul li a span.rotate {
            transform: translate(-50%) rotate(-180deg);
        }

        .selected {
            color: cyan;
        }

    </style>

    @stack('head')

</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div class="col-md-2">
            <nav class="sidebar">

                <!-- Divider -->
                <hr class="sidebar-divider my-0">
                <ul>
                    <li>
                        <div class="text">
                            <!-- Sidebar - Brand -->
                            <a class="sidebar-brand d-flex align-items-center justify-content-left"
                                href="{{ url('/dashboard') }}">
                                <div class="sidebar-brand-icon">
                                    <img src="adminLogin/logo.png" style="width: 4.4rem;" class="img-responsive"
                                        alt="">
                                    {{ Auth::user()->name }}
                                </div>
                            </a>
                        </div>
                    </li>
                    <li id="sbitem1">
                        <a href="#" class="leads-btn">Leads<span class="fas fa-caret-down first"></span></a>
                        <ul class="leads-show">
                            @if (Auth::user()->isadmin())
                                <li id="sbitem1_1"><a href="{{ route('leads_pool_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Leads pool</a></li>
                                <li id="sbitem1_2"><a href="{{ route('won_leads_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Won leads</a></li>
                                <li id="sbitem1_3"><a href="{{ route('dead_leads_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Dead leads</a></li>
                                <li id="sbitem1_5"><a href="{{ route('follow_up_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Follow up leads</a></li>
                            @endif
                            @if (Auth::user()->isadmin())
                                <li id="sbitem1_4"><a href="{{ route('qualified_leads_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Qualified leads</a></li>
                            @endif
                            @if (Auth::user()->isagent() || Auth::user()->isadmin())
                                <li id="sbitem1_6"><a href="{{ route('create_customer_index') }}"><i
                                            class="fas fa-ad"></i> Customer enquiry</a></li>
                            @endif
                            <li id="sbitem1_7"><a href="{{ route('home') }}"><i class="fas fa-fw fa-table"></i>
                                    Data</a></li>
                            @if (Auth::user()->isagent() || Auth::user()->isconsultant())
                                <li id="sbitem1_7_1"><a href="{{ route('index1') }}"><i
                                            class="fas fa-fw fa-table"></i>
                                        Commented data</a></li>
                            @endif
                            @if (Auth::user()->isadmin())
                                <li id="sbitem1_8"><a href="{{ route('agent_data') }}"><i
                                            class="fas fa-fw fa-table"></i> Agent data</a></li>
                                <li id="sbitem1_9"><a href="{{ route('map') }}"><i class="fas fa-fw fa-table"></i>
                                        Map</a>
                                </li>
                            @endif
                            @if (Auth::user()->isagent() || Auth::user()->isconsultant())
                                <li id="sbitem1_10"><a href="{{ route('qualified_user_home_index') }}"><i
                                            class="fas fa-fw fa-table"></i>
                                        Qualified data</a>
                                </li>
                                <li id="sbitem1_11"><a href="{{ route('show_qualified_data_comments_index') }}"><i
                                            class="fas fa-fw fa-table"></i>
                                        Qualified data comments</a>
                                </li>
                                <li id="sbitem1_12"><a href="{{ route('leads_pool_user_home_index') }}"><i
                                            class="fas fa-fw fa-table"></i>
                                        Leads pool data</a>
                                </li>
                                <li id="sbitem1_13"><a href="{{ route('show_leads_pool_data_comments_index') }}"><i
                                            class="fas fa-fw fa-table"></i>
                                        Leads pool data comments</a>
                                </li>
                                <li id="sbitem1_14"><a href="{{ route('follow_up_user_home_index') }}"><i
                                            class="fas fa-fw fa-table"></i>
                                        Follow up leads data</a>
                                </li>
                                <li id="sbitem1_15"><a href="{{ route('show_follow_up_data_comments_index') }}"><i
                                            class="fas fa-fw fa-table"></i>
                                        Follow up leads data comments</a>
                                </li>
                            @endif
                        </ul>
                    </li>


                    @if (Auth::user()->isadmin())
                        <li id="sbitem2">
                            <a href="#" class="asd-btn">Assign & show data<span
                                    class="fas fa-caret-down second"></span></a>
                            <ul class="asd-show">
                                <li id="sbitem2_1"><a href="{{ route('assign_agent_data_index') }}"><i
                                            class="fas fa-ad"></i> Assign agent data</a>
                                </li>
                                <li id="sbitem2_2"><a href="{{ route('assign_agent_qualified_data_index') }}"><i
                                            class="fas fa-ad"></i> Assign
                                        agent to qualified data</a></li>
                                <li id="sbitem2_3"><a href="{{ route('assign_agent_leads_pool_index') }}"><i
                                            class="fas fa-ad"></i> Assign agent to
                                        leads pool data</a></li>
                                <li id="sbitem2_4"><a href="{{ route('assign_agent_follow_up_index') }}"><i
                                            class="fas fa-ad"></i> Assign agent to
                                        follow up data</a></li>
                                <li id="sbitem2_4_1"><a href="{{ route('get_assigned_data_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Assigned data</a>
                                </li>
                                <li id="sbitem2_5"><a href="{{ route('show_assigned_agent_qualified_index') }}"><i
                                            class="fas fa-ad"></i> Assigned
                                        qualified data</a></li>
                                <li id="sbitem2_6"><a href="{{ route('show_assigned_agent_leads_pool_index') }}"><i
                                            class="fas fa-ad"></i> Assigned
                                        leads pool data</a></li>
                                <li id="sbitem2_7"><a href="{{ route('show_assigned_agent_follow_up_index') }}"><i
                                            class="fas fa-ad"></i> Assigned
                                        follow up leads data</a></li>
                                <li id="sbitem2_7_1"><a href="{{ route('show_commented_data') }}"><i
                                            class="fas fa-fw fa-table"></i> Commented data</a></li>
                                <li id="sbitem2_9"><a
                                        href="{{ route('show_user_qualified_data_comments_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Commented qualified
                                        data</a></li>
                                <li id="sbitem2_10"><a
                                        href="{{ route('show_user_leads_pool_data_comments_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Commented leads
                                        pool data</a></li>
                                <li id="sbitem2_11"><a
                                        href="{{ route('show_user_follow_up_data_comments_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Commented follow up
                                        leads data</a></li>
                            </ul>
                        </li>
                    @endif


                    @if (Auth::user()->isadmin())
                        <li id="sbitem3">
                            <a href="#" class="report-btn">Report<span class="fas fa-caret-down third"></span></a>
                            <ul class="report-show">
                                <li id="sbitem3_1"><a href="{{ route('getcharts') }}"><i
                                            class="fas fa-chart-pie"></i>
                                        Charts</a></li>
                                <li id="sbitem3_2"><a href="{{ route('geochart') }}"><i class="fas fa-chart-pie"></i>
                                        Geo
                                        chart</a></li>
                                <li id="sbitem3_5"><a href="{{ route('leader_board_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Leaderboard</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (Auth::user()->isadmin())
                        <li id="sbitem4">
                            <a href="#" class="au-btn">Admin & Users<span
                                    class="fas fa-caret-down fourth"></span></a>
                            <ul class="au-show">
                                <li id="sbitem4_1"><a href="{{ route('create_user_index') }}"><i
                                            class="fas fa-ad"></i> Create agent</a></li>
                                <li id="sbitem4_2"><a href="{{ route('assign_agent_for_landing') }}"><i
                                            class="fas fa-fw fa-table"></i> Assign agent for
                                        landing</a></li>
                                <li id="sbitem4_3"><a href="{{ route('list_users_index') }}"><i
                                            class="fas fa-fw fa-table"></i> List users</a></li>
                                <li id="sbitem4_4"><a href="{{ route('import_index') }}"><i
                                            class="fas fa-ad"></i>
                                        Import</a></li>
                                <li id="sbitem4_5"><a href="{{ route('uploadedFiles') }}"><i
                                            class="fas fa-ad"></i>
                                        Export & uploaded files</a>
                                </li>
                                {{-- <li id="sbitem4_6"><a href="{{ route('create_user_index') }}">Create users & admins</a>
                            </li> --}}
                                {{-- <li id="sbitem4_7"><a href="{{ route('update_user_index') }}">Profile</a></li> --}}
                            </ul>
                        </li>
                    @endif

                    <li id="sbitem5">
                        <a href="#" class="pm-btn">Property Management<span
                                class="fas fa-caret-down fifth"></span></a>
                        <ul class="pm-show">
                            @if (Auth::user()->isadmin())
                                <li id="sbitem5_1"><a href="{{ route('create_property_index') }}"><i
                                            class="fas fa-ad"></i> Create property</a>
                                </li>
                                <li id="sbitem5_2"><a href="{{ route('create_payment_index') }}"><i
                                            class="fas fa-ad"></i> Create payment</a></li>
                                <li id="sbitem5_3"><a href="{{ route('list_properties_index') }}"><i
                                            class="fas fa-fw fa-table"></i> List properties</a>
                                </li>
                            @endif
                            @if (Auth::user()->iscustomer() || Auth::user()->isadmin())
                                <li id="sbitem5_4"><a href="{{ route('list_payments_index') }}"><i
                                            class="fas fa-fw fa-table"></i> List payments</a></li>
                            @endif
                            @if (Auth::user()->isagent() || Auth::user()->isadmin())
                                <li id="sbitem5_5"><a href="{{ route('create_inventory_index') }}"><i
                                            class="fas fa-ad"></i> Create inventory</a>
                                </li>
                                <li id="sbitem5_6"><a href="{{ route('get_inventories_index') }}"><i
                                            class="fas fa-fw fa-table"></i> Show inventories</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Log Out --}}
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
        </div>

        <div class="col-md-10">
            @yield('wrapper_content')
        </div>

    </div>

    @yield('content')

    @stack('scripts')

    <script>
        $(window).on('load', function() {
            if (
                "{{ request()->route()->getName() }}" == 'follow_up_user_home_index' ||
                "{{ request()->route()->getName() }}" == 'show_follow_up_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_leads_pool_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'leads_pool_user_home_index' ||
                "{{ request()->route()->getName() }}" == 'show_qualified_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'qualified_user_home_index' ||
                "{{ request()->route()->getName() }}" == 'leads_pool_index' ||
                "{{ request()->route()->getName() }}" == 'won_leads_index' ||
                "{{ request()->route()->getName() }}" == 'dead_leads_index' ||
                "{{ request()->route()->getName() }}" == 'follow_up_index' ||
                "{{ request()->route()->getName() }}" == 'create_customer_index' ||
                "{{ request()->route()->getName() }}" == 'qualified_leads_index' ||
                "{{ request()->route()->getName() }}" == 'agent_data' ||
                "{{ request()->route()->getName() }}" == 'map' ||
                "{{ request()->route()->getName() }}" == 'agent_data' ||
                "{{ request()->route()->getName() }}" == 'index1' ||
                "{{ request()->route()->getName() }}" == 'home'
            ) {
                $('#sbitem1').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'leads_pool_index')
                    $('#sbitem1_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'won_leads_index')
                    $('#sbitem1_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'dead_leads_index')
                    $('#sbitem1_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'qualified_leads_index')
                    $('#sbitem1_4').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'follow_up_index')
                    $('#sbitem1_5').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_customer_index')
                    $('#sbitem1_6').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'home')
                    $('#sbitem1_7').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'index1')
                    $('#sbitem1_7_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'agent_data')
                    $('#sbitem1_8').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'map')
                    $('#sbitem1_9').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'qualified_user_home_index')
                    $('#sbitem1_10').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_qualified_data_comments_index')
                    $('#sbitem1_11').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'leads_pool_user_home_index')
                    $('#sbitem1_12').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_leads_pool_data_comments_index')
                    $('#sbitem1_13').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'follow_up_user_home_index')
                    $('#sbitem1_14').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_follow_up_data_comments_index')
                    $('#sbitem1_15').addClass('active');

                $('nav ul .leads-show').toggleClass('show');
                $('nav ul .asd-show').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .first').removeClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'assign_agent_data_index' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_qualified_data_index' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_leads_pool_index' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_follow_up_index' ||
                "{{ request()->route()->getName() }}" == 'show_assigned_agent_qualified_index' ||
                "{{ request()->route()->getName() }}" == 'show_assigned_agent_leads_pool_index' ||
                "{{ request()->route()->getName() }}" == 'show_assigned_agent_follow_up_index' ||
                "{{ request()->route()->getName() }}" == 'show_user_qualified_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_user_leads_pool_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'get_assigned_data_index' ||
                "{{ request()->route()->getName() }}" == 'show_commented_data' ||
                "{{ request()->route()->getName() }}" == 'show_user_follow_up_data_comments_index'
            ) {
                $('#sbitem2').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'assign_agent_data_index')
                    $('#sbitem2_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'assign_agent_qualified_data_index')
                    $('#sbitem2_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'assign_agent_leads_pool_index')
                    $('#sbitem2_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'assign_agent_follow_up_index')
                    $('#sbitem2_4').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_assigned_agent_qualified_index')
                    $('#sbitem2_5').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_assigned_agent_leads_pool_index')
                    $('#sbitem2_6').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_assigned_agent_follow_up_index')
                    $('#sbitem2_7').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_commented_data')
                    $('#sbitem2_7_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_user_qualified_data_comments_index')
                    $('#sbitem2_9').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_user_leads_pool_data_comments_index')
                    $('#sbitem2_10').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'get_assigned_data_index')
                    $('#sbitem2_4_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_user_follow_up_data_comments_index')
                    $('#sbitem2_11').addClass('active');

                $('nav ul .leads-show').removeClass('show');
                $('nav ul .asd-show').toggleClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .second').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'getcharts' ||
                "{{ request()->route()->getName() }}" == 'geochart' ||
                "{{ request()->route()->getName() }}" == 'leader_board_index'
            ) {
                $('#sbitem3').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'getcharts')
                    $('#sbitem3_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'geochart')
                    $('#sbitem3_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'leader_board_index')
                    $('#sbitem3_5').addClass('active');

                $('nav ul .leads-show').removeClass('show');
                $('nav ul .asd-show').removeClass('show');
                $('nav ul .report-show').toggleClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .third').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_user_index' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_for_landing' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_data_index' ||
                "{{ request()->route()->getName() }}" == 'list_users_index' ||
                "{{ request()->route()->getName() }}" == 'import_index' ||
                "{{ request()->route()->getName() }}" == 'uploadedFiles' ||
                "{{ request()->route()->getName() }}" == 'create_user_index' ||
                "{{ request()->route()->getName() }}" == 'update_user_index'
            ) {
                $('#sbitem4').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_user_index')
                    $('#sbitem4_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'assign_agent_for_landing')
                    $('#sbitem4_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_users_index')
                    $('#sbitem4_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'import_index')
                    $('#sbitem4_4').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'uploadedFiles')
                    $('#sbitem4_5').addClass('active');
                // else if ("{{ request()->route()->getName() }}" == 'create_user_index')
                //     $('#sbitem4_6').addClass('active');
                // else if ("{{ request()->route()->getName() }}" == 'update_user_index')
                //     $('#sbitem4_7').addClass('active');

                $('nav ul .leads-show').removeClass('show');
                $('nav ul .asd-show').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').toggleClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .fourth').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_property_index' ||
                "{{ request()->route()->getName() }}" == 'create_payment_index' ||
                "{{ request()->route()->getName() }}" == 'list_properties_index' ||
                "{{ request()->route()->getName() }}" == 'list_payments_index' ||
                "{{ request()->route()->getName() }}" == 'create_inventory_index' ||
                "{{ request()->route()->getName() }}" == 'get_inventories_index'
            ) {
                $('#sbitem5').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_property_index')
                    $('#sbitem5_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_payment_index')
                    $('#sbitem5_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_properties_index')
                    $('#sbitem5_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_payments_index')
                    $('#sbitem5_4').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_inventory_index')
                    $('#sbitem5_5').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'get_inventories_index')
                    $('#sbitem5_6').addClass('active');

                $('nav ul .leads-show').removeClass('show');
                $('nav ul .asd-show').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-show').toggleClass('show');
                $('nav ul .fifth').toggleClass('rotate');
            }
        })
    </script>

    <script>
        $('.leads-btn').click(function() {
            $('nav ul .leads-show').toggleClass('show');
            $('nav ul .asd-show').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .first').removeClass('rotate');
        });
        $('.asd-btn').click(function() {
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .asd-show').toggleClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .second').toggleClass('rotate');
        });
        $('.report-btn').click(function() {
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .asd-show').removeClass('show');
            $('nav ul .report-show').toggleClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .third').toggleClass('rotate');
        });
        $('.au-btn').click(function() {
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .asd-show').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').toggleClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .fourth').toggleClass('rotate');
        });
        $('.pm-btn').click(function() {
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .asd-show').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-show').toggleClass('show');
            $('nav ul .fifth').toggleClass('rotate');
        });
        $('nav ul li').click(function() {
            // $(this).addClass('active').siblings().removeClass('active');
        });
    </script>
</body>

</html>
