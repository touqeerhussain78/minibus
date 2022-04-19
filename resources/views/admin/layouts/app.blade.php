
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{config('app.name')}} - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('/frontend/images/favicon.ico')}}" sizes="32x32"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/administrator/app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/administrator/app-assets/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/administrator/assets/css/style.css') }}">
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded " data-open="click" data-menu="vertical-menu" data-col="2-columns">

<!--register page start here-->

<section class="register loginn">
    @yield('content')
</section>

<script src="{{ asset('/administrator/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/administrator/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('/administrator/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/administrator/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHPUufTlBkF5NfBT3uhS9K4BbW2N-mkb4&libraries=places"></script>

</body>
</html>
