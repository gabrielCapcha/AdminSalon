<head>
    <meta charset="UTF-8">
        <link rel="icon" href="/img/new-login/iso_300_soft.png" type="image/x-icon" />
    <title> TumiPOS - @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/fonts/fonts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />

    <!-- jvectormap -->
    <!-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> -->
    <!-- Theme style -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>


        .steps-form-3 {
            width: 2px;
            height: 470px;
            position: relative;
            padding-left: 30px;
            padding-top: 25px;
        }
        .steps-form-3 .steps-row-3 {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column; 
        }
        .steps-form-3 .steps-row-3:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: "";
            width: 2px;
            height: 100%;
            background-color: #1e282c; 
        }
        .steps-form-3 .steps-row-3 .steps-step-3 {
            height: 125px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            text-align: center;
            position: relative; 
        }
        .steps-form-3 .steps-row-3 .steps-step-3.no-height {
            height: 50px; 
        }
        .steps-form-3 .steps-row-3 .steps-step-3 p {
            margin-top: 0.5rem; 
        }
        .steps-form-3 .steps-row-3 .steps-step-3 button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important; 
        }
        .steps-form-3 .steps-row-3 .steps-step-3 .btn-circle-3 {
            width: 60px;
            height: 60px;
            border: 2px solid #1e282c;
            background-color: white !important;
            color: #1e282c !important;
            border-radius: 50%;
            padding: 18px 18px 15px 15px;
            margin-top: -22px; 
        }
        .steps-form-3 .steps-row-3 .steps-step-3 .btn-circle-3:hover {
            border: 2px solid #fdbe15;
            color: #fdbe15 !important;
            background-color: white !important; 
        }
        .steps-form-3 .steps-row-3 .steps-step-3 .btn-circle-3 .fa {
            font-size: 1.7rem; 
        }
    </style>
</head>
