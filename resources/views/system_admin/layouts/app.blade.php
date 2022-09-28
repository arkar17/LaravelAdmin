<!doctype html>
<html lang="en">
  <head>
    <style>
         .main-cash-alert {
            color: white;
            margin-left: 20px;
            background-color: rgb(12, 94, 12);
            border-radius: 5px;
            padding: 10px;
        }

        #hide {
            margin-top: 10px;
        }
        .closeBtn {
            color: #ddd;
            cursor: pointer;
            float: right;
        }
    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->

     <!--Global CSS -->
     <link href="{{asset('css/systemadmin/globals.css')}}" rel="stylesheet"/>

     <!--referee css-->
     <link href="{{asset('css/systemadmin/referee.css')}}" rel="stylesheet"/>

     <!--refereedata css-->
     <link href="{{asset('css/systemadmin/refereedata.css')}}" rel="stylesheet"/>

     <!--refereeprofile css -->
     <link href="{{asset('css/systemadmin/refereeprofile.css')}}" rel="stylesheet"/>

      <!--refereeRequests css-->
     <link href="{{asset('css/systemadmin/refereeRequests.css')}}" rel="stylesheet"/>

    <!--permission css-->
    <link href="{{asset('css/systemadmin/permission.css')}}" rel="stylesheet"/>

    <!--create permission css-->
    <link href="{{asset('css/systemadmin/createpermission.css')}}" rel="stylesheet"/>
    <!--create user-->
    <link href="{{asset('css/systemadmin/createUser.css')}}" rel="stylesheet"/>

    <!--role-->
    <link href="{{asset('css/systemadmin/role.css')}}" rel="stylesheet"/>

    <!--create role-->
    <link href="{{asset('css/systemadmin/createrole.css')}}" rel="stylesheet"/>

    <!--role view detail-->
    <link href="{{asset('css/systemadmin/roleviewdetail.css')}}" rel="stylesheet"/>

    <link href="{{asset('css/systemadmin/winning_result.css')}}" rel="stylesheet"/>


     <!-- font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/refereemanage/dashboard.css') }}">

    @yield('styles')

     <!--iconify-->
     <script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>
     {{-- MDB --}}
     {{-- <link
     href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css"
     rel="stylesheet"
   /> --}}


     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

    <script src="{{asset('jquery/systemadmin/referee.js')}}"></script>
    <script src="{{asset('jquery/systemadmin/createUser.js')}}"></script>
    <script src="{{asset('jquery/systemadmin/sidebar.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

var OriginalWidth=$('.side-bar-container').width();
            $(".sidebar-icon").hide()

            $('.sider-bar-toggle').click(function () {

            width = $(".side-bar-container").width();
            if (OriginalWidth == width){
                $(".side-bar-container").animate({ width: '100' });
                $(".main-content-container").animate({marginLeft: '-=120px'})
                $(".top-bar-container").animate({left:"-=120px"})
                $(".sidebar-icon").show()
                $(".side-bar-links-container span").hide()
            }

            else {
                $(".side-bar-container").animate({ width: OriginalWidth });
                $(".main-content-container").animate({marginLeft: '+=120px'})
                $(".top-bar-container").animate({left:"+=120px"})
                $(".sidebar-icon").hide()
                $(".side-bar-links-container span").show()
            }


        })
        let hide = document.getElementById("hide");
            hide.addEventListener("click", function() {
                hide.style.display = "none";
            });
    </script>
    @yield('script')
  </body>
</html>
