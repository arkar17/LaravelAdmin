<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!--
        * @Package: Multipurpose Dashboard
        * @Version: 1.0.0
    -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/images/favicon.png') }}">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('assets/images/apple-touch-icon-114-precomposed.png') }}">
    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/images/apple-touch-icon-72-precomposed.png') }}">
    <!-- For iPad Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('assets/images/apple-touch-icon-144-precomposed.png') }}">

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/webfont/cryptocoins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css') }}" rel="stylesheet" type="text/css"
        media="screen">
    <link href="{{ asset('assets/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" media="screen">
    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE CSS TEMPLATE - START -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->


</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body>

    @yield('content')

    <!-- CORE JS FRAMEWORK - START -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/viewport/viewportchecker.js') }}"></script>
    <script>
        window.jQuery || document.write('<script src="{{ asset("assets/js/jquery.min.js") }}"><\/script>');
    </script>
    <!-- CORE JS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <script src="{{ asset('assets/plugins/icheck/icheck.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/chartjs-chart/Chart.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/morris-chart/js/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/plugins/morris-chart/js/morris.min.js') }}"></script>
    <script src="{{ asset('assets/js/app-dashboard.js') }}"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE TEMPLATE JS - START -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- END CORE TEMPLATE JS - END -->

</body>

</html>
