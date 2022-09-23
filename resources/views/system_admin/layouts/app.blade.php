<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->

    <!--Global CSS -->
    <link href="{{ asset('css/systemadmin/globals.css') }}" rel="stylesheet" />

    <!--referee css-->
    <link href="{{ asset('css/systemadmin/referee.css') }}" rel="stylesheet" />

    <!--refereedata css-->
    <link href="{{ asset('css/systemadmin/refereedata.css') }}" rel="stylesheet" />

    <!--refereeprofile css -->
    <link href="{{ asset('css/systemadmin/refereeprofile.css') }}" rel="stylesheet" />

    <!--refereeRequests css-->
    <link href="{{ asset('css/systemadmin/refereeRequests.css') }}" rel="stylesheet" />

    <!--permission css-->
    <link href="{{ asset('css/systemadmin/permission.css') }}" rel="stylesheet" />

    <!--create permission css-->
    <link href="{{ asset('css/systemadmin/createpermission.css') }}" rel="stylesheet" />
    <!--create user-->
    <link href="{{ asset('css/systemadmin/createUser.css') }}" rel="stylesheet" />

    <!--role-->
    <link href="{{ asset('css/systemadmin/role.css') }}" rel="stylesheet" />

    <!--create role-->
    <link href="{{ asset('css/systemadmin/createrole.css') }}" rel="stylesheet" />

    <!--role view detail-->
    <link href="{{ asset('css/systemadmin/roleviewdetail.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/systemadmin/winning_result.css') }}" rel="stylesheet" />


    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/refereemanage/dashboard.css') }}">

    @yield('styles')


    <!-- CSS -->

    <!-- Referee Global CSS -->
    <link href="{{ asset('css/refereemanage/globals.css') }}" rel="stylesheet" />

    <!--agent css-->
    <link href="{{ asset('css/refereemanage/2dmanage.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/refereemanage/3d&lonepyinemanage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/agentdata.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/agentprofile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/agentrequestlist.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/app.css') }}">
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
    <link rel="stylesheet" href="{{ asset('css/refereemanage/cashincashout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/refereemanage/roleviewdetail.css') }}">
    {{-- 2D CSS --}}
    <link href="{{ asset('css/refereemanage/2dsalelist.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/refereemanage/dashboard.css') }}">
    {{-- dailysalelist --}}
    <link href="{{ asset('css/refereemanage/dailysalebook.css') }}" rel="stylesheet" />
    @yield('css')
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
    <!--iconify-->
    <script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <title>Trail Blazers</title>
</head>

<body>

    <div class="parent-container">

        <!--side bar start-->
        @include('system_admin.layouts.sidebar')
        <!--side bar end-->

        <!--left side main container start-->
        <div class="main-content-container">
            <!--top bar start-->
            @include('system_admin.layouts.topbar')
            <!--top bar end-->

            <!--main content start-->
            <div class="main-content-parent-container">
                @yield('content')
            </div>
            <!--main content end-->

        </div>
        <!--left side main container end-->

    </div>

    <script src="{{ asset('jquery/systemadmin/referee.js') }}"></script>
    <script src="{{ asset('jquery/systemadmin/createUser.js') }}"></script>
    <script src="{{ asset('jquery/systemadmin/sidebar.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

    <script src="{{ asset('jquery/refereemanage/cashincashout.js') }}"></script>

    <script>

console.log("Why always me?");

            var closeBtn = document.querySelector(".closeBtn");
            //let main_cash_alert = document.querySelector(".main-cash-alert");

            var hide = document.getElementById("hide");

            console.log(hide);

            closeBtn.addEventListener("click", function() {
                console.log("Hee Hee");
                // main_cash_alert.style.d = "red";
            hide.style.visibility = 'hidden';
                // hide.style.display = "none";
            });
    </script>
    @yield('script')
    @hasanyrole('referee')
        <script>




            var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });
            var id = window.userID = {{ auth()->user()->referee->id }};
            console.log(id);
            var channel = pusher.subscribe('betlist-channel.' + id);
            channel.bind('App\\Events\\NewBetList', function(data) {
                alert(data);
                console.log(data);
            });
        </script>
    @endhasanyrole
</body>

</html>
