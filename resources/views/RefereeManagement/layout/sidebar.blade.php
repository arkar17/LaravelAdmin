      <!--side bar start-->
      <div class="side-bar-container">
        <div class="logo-container">
          LOGO
        </div>

        <div class="side-bar-links-container">

            <a class="side-bar-link" href="{{ url('refe-dashboard') }}">
                {{__('msg.home')}}
            </a>

            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                {{__('msg.Request List')}}
                <!-- <i class="fa-solid fa-angle-down side-bar-link-drop-down-icon"></i> -->
                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('agentRequestListForRefree')}}">{{__('msg.Agent')}}</a>

              </div>
            </div>
            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                {{__('msg.2D')}} / {{__('msg.3D')}}
                <!-- <i class="fa-solid fa-angle-down side-bar-link-drop-down-icon"></i> -->
                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('2DManage')}}">{{__('msg.2D Manage')}}</a>
                <a class="side-bar-link-drop-down-link" href="{{route('3DManage')}}">{{__('msg.Lone Pyine & 3D Manage')}}</a>

                <!-- <a class="side-bar-link-drop-down-link" href="./lonepyinemanage.html">Lone Pyine Manage</a> -->
              </div>
            </div>

            {{-- <a class="side-bar-link" href="./maincash.html">
              Main Cash
            </a> --}}
            <a class="side-bar-link" href="{{ route('cashin') }}">
              {{__('msg.Cash In / Cash Out')}}
            </a>
            {{-- <a class="side-bar-link" href="./cashincashout.html">
               Winning Result
              </a> --}}


            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                {{__('msg.Sale List')}}

                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('dailysalebook')}}">{{__('msg.Daily Sale Book')}}</a>
                <a class="side-bar-link-drop-down-link" href="{{route('twoDSaleList')}}">{{__('msg.2D Sale List')}}</a>
                <a class="side-bar-link-drop-down-link" href="{{route('lonepyineSaleList')}}">{{__('msg.Lone Pyine Sale List')}}</a>
                <a class="side-bar-link-drop-down-link" href="{{route('threeDSaleList')}}">{{__('msg.3D Sale List')}}</a>
              </div>
            </div>



            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                {{__('msg.data')}}

                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('agentDataForRefree')}}">{{__('msg.Agent Data')}}</a>
                <!-- <a class="side-bar-link-drop-down-link" href="./agentdata.html">Agent Data</a> -->

              </div>
            </div>
        </div>
      </div>
      <!--side bar end-->
