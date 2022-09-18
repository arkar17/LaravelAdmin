<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    {{-- <!--Global CSS -->
    <link href="{{ asset('css/globals.css') }}" rel="stylesheet" />

    <!--referee css-->
    <link href="{{ asset('css/referee.css') }}" rel="stylesheet" />

    <!--refereedata css-->
    <link href="{{ asset('css/refereedata.css') }}" rel="stylesheet" />

    <!--refereeprofile css -->
    <link href="{{ asset('css/refereeprofile.css') }}" rel="stylesheet" />

    <!--refereeRequests css-->
    <link href="{{ asset('css/refereeRequests.css') }}" rel="stylesheet" />

    <!--permission css-->
    <link href="{{ asset('css/permission.css') }}" rel="stylesheet" />

    <!--create permission css-->
    <link href="{{ asset('css/createpermission.css') }}" rel="stylesheet" />

    <!--role-->
    <link href="{{ asset('css/role.css') }}" rel="stylesheet" />

    <!--create role-->
    <link href="{{ asset('css/createrole.css') }}" rel="stylesheet" />

    <!--role view detail-->
    <link href="{{ asset('css/roleviewdetail.css') }}" rel="stylesheet" /> --}}

    <!--agent css-->
    <link rel="stylesheet" href="">
    <link href="{{ asset('css/refereemanage/2dmanage.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/refereemanage/3d&lonepyinemanage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/agentdata.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/agentprofile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/agentrequestlist.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/cashincashout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/createpermission.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/createrole.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/dailysalebook.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/permission.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/referee.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/refereedata.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/refereeprofile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/refereeRequests.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/refreesale.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/role.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/roleviewdetail.css') }}">

    <link rel="stylesheet" href="{{ asset('css/refereemanage/dashboard.css') }}">




    <!-- MDB -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" /> --}}

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @yield('css')

    <!--iconify-->
    <script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Trail Blazers</title>
</head>

<body>

    <div class="parent-container">

        <!--side bar start-->
        @include('layouts.sidebar')
        <!--side bar end-->

        <!--left side main container start-->
        <div class="main-content-container">
            <!--top bar start-->
            @include('layouts.topbar')
            <!--top bar end-->

            <!--main content start-->
            <div class="main-content-parent-container">
                @yield('content')
            </div>
            <!--main content end-->

        </div>
        <!--left side main container end-->

    </div>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    <script src="{{ asset('jquery/refereemanage/referee.js') }}"></script>
    <script src="{{ asset('jquery/refereemanage/sidebar.js') }}"></script>
    <script src="{{ asset('jquery/refereemanage/cashincashout.js') }}"></script>
    {{-- <script src="{{ asset('js/refereemanage/chart.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('script')
</body>

</html>
