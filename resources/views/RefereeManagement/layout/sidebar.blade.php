      <!--side bar start-->
      <div class="side-bar-container">
        <div class="logo-container">
          LOGO
        </div>

        <div class="side-bar-links-container">

            <a class="side-bar-link" href="{{ route('refe-dashboard') }}">
              Dashboard
            </a>

            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                Request List
                <!-- <i class="fa-solid fa-angle-down side-bar-link-drop-down-icon"></i> -->
                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('agentRequestListForRefree')}}">Agent</a>

              </div>
            </div>
            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                2D / 3D
                <!-- <i class="fa-solid fa-angle-down side-bar-link-drop-down-icon"></i> -->
                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('2DManage')}}">2D Manage</a>
                <a class="side-bar-link-drop-down-link" href="{{route('3DManage')}}">Lone Pyine & 3D Manage</a>

                <!-- <a class="side-bar-link-drop-down-link" href="./lonepyinemanage.html">Lone Pyine Manage</a> -->
              </div>
            </div>

            {{-- <a class="side-bar-link" href="./maincash.html">
              Main Cash
            </a> --}}
            <a class="side-bar-link" href="{{ route('cashin') }}">
              Cash In / Cash Out
            </a>
            {{-- <a class="side-bar-link" href="./cashincashout.html">
               Winning Result
              </a> --}}


            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                Sale List

                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('dailysalebook')}}">Daily Sale Book</a>
                <a class="side-bar-link-drop-down-link" href="{{route('twoDSaleList')}}">2D Sale List</a>
                <a class="side-bar-link-drop-down-link" href="{{route('lonepyineSaleList')}}">Lone Pyine Sale List</a>
                <a class="side-bar-link-drop-down-link" href="{{route('threeDSaleList')}}">3D Sale List</a>
              </div>
            </div>



            <div class="side-bar-link-dropdown-container">
              <p class="side-bar-link-dropdown-header">
                Data

                <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
              </p>
              <div class="side-bar-link-drop-down">
                <a class="side-bar-link-drop-down-link" href="{{route('agentDataForRefree')}}">Agent Data</a>
                <!-- <a class="side-bar-link-drop-down-link" href="./agentdata.html">Agent Data</a> -->

              </div>
            </div>
        </div>
      </div>
      <!--side bar end-->
