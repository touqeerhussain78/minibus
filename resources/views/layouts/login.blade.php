<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('/frontend/images/favicon.ico')}}" sizes="32x32"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="hidden" id="url" value="{{ url('/')}}">
    
    <title>
        <?=((isset($title))?$title:'Minibus - Login');?>
    </title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700,300" rel="stylesheet">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/hover-min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/animate.css')}}">
    <link href="{{ asset('/frontend/fonts/fontawesome/css/all.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/frontend/css/mega-menu.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/frontend/css/datatables.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/frontend/css/style.css')}}" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="{{ asset('/frontend/js/jquery.min.js')}}"></script>
    <style>
        .pac-container{
            z-index:9999;
        }

        .blockUI.blockMsg.blockElement {
            width: 100px !important;
            height: 100px !important;
            border-radius: 50%;
            color: transparent !important;
            background-color: transparent !important;
            transform: translateX(-50%) translateY(-50%);
            top: 50% !important;
            left: 50% !important;
            border-color: white !important;
            border-top-color: #f7941e !important;
            animation: spinner 1.2s ease-in-out infinite;
        }

        @keyframes spinner {
            0% {
                transform: translateX(-50%) translateY(-50%) rotate(0deg);
            }
            100% {
                transform: translateX(-50%) translateY(-50%) rotate(360deg);
            }
        }
        </style>
</head>

<body id="my-body">
    <!--Views start here-->

    @yield('content')

    <!--Views end here-->


<script src="{{ asset('/frontend/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHPUufTlBkF5NfBT3uhS9K4BbW2N-mkb4&libraries=places"></script>
<script src="{{ asset('/frontend/js/app.js') }}"></script>
<script src="{{ asset('/frontend/js/function.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script src="{{ asset('/frontend/js/auth.js') }}"></script>

<script src="{{asset('frontend/js/jquery.disable-autofill.js')}}"></script>
<script>
  $('input[autofill="off"]').disableAutofill();
</script>
</body>
</html>
