
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="a-base-url" content="{{ url('admin') }}">
    <link rel="shortcut icon" href="{{ asset('/frontend/images/favicon.ico')}}" sizes="32x32" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link href="{{ asset('administrator/css/app.css') }}" rel="stylesheet">
    <style>
        .loading-indicator:before {
            content: '';
            background: #000000cc;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 10000;
        }

        .loading-indicator:after {
            content: 'Loading ...';
            background: ("../image/loader.gif") no-repeat;
            position: fixed;
            width: 100%;
            top: 50%;
            left: 0;
            z-index: 10001;
            color:white;
            text-align:center;
            font-weight:bold;
            font-size:1.5rem;
        }

    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns fixed-navbar  menu-expanded pace-done menu-hide" data-open="click" data-menu="vertical-menu" data-col="2-columns" cz-shortcut-listen="true">

<div id="app"></div>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/react/16.10.2/cjs/react.production.min.js"></script>--}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHPUufTlBkF5NfBT3uhS9K4BbW2N-mkb4&libraries=places"></script>
<script type="text/javascript">
        window.base_url = "{{ url('/') }}";
        window.asset_url = "{{ url('/') }}/administrator/";
        window.user = @json(auth()->guard('admin')->user());
</script>
<script src="{{ asset('administrator/js/app.js') }}"></script>
</body>
</html>
