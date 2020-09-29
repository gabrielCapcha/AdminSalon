<head>
    <meta charset="UTF-8">
        <link rel="icon" href="/img/new-login/iso_300_soft.png" type="image/x-icon" />
    <title> TumiPOS - @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugins/fonts/fonts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/lightSlider.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ asset('/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Datatales -->
    <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .example-modal .modal {
            position: relative;
            top: auto;
            bottom: auto;
            right: auto;
            left: auto;
            display: block;
            z-index: 1;
        }

        .example-modal .modal {
            background: transparent !important;
        }
        
    	ul{
			list-style: none outside none;
		    padding-left: 0;
		}
		.content-slider li{
		    background-color: #fdbe15;
		    text-align: center;
		    color: #FFF;
		}
		.content-slider h3 {
		    margin: 0;
		    padding: 20px 0;
		}
    </style>
</head>
