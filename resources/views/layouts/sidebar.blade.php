<div class="side-bar-container fl-5">
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
            <a class="side-bar-link-drop-down-link" href="{{route('refereerequests')}}">Referee</a>
            <a class="side-bar-link-drop-down-link" href="{{route('operationstaffrequests')}}">Operation Staff</a>
          </div>
        </div>
        <div class="side-bar-link-dropdown-container">
          <p class="side-bar-link-dropdown-header">
            Role & Permission
            <!-- <i class="fa-solid fa-angle-down side-bar-link-drop-down-icon"></i> -->
            <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
          </p>
          <div class="side-bar-link-drop-down">
            <a class="side-bar-link-drop-down-link" href="{{route('role.index')}}">Role</a>
            <a class="side-bar-link-drop-down-link" href="{{route('permission.index')}}">Permission</a>
          </div>
        </div>

        <a class="side-bar-link" href="{{route('referee.index')}}">
          Referee
        </a>
        <a class="side-bar-link" href="{{route('operation-staff.index')}}">
          Operation Staff
        </a>
        <a class="side-bar-link" href="{{ route('cashin') }}">
            Cash In / Cash Out
        </a>
        <a class="side-bar-link" href="{{ route('winningresult') }}">
           Add Winning Result
        </a>

        <!-- <div class="side-bar-link-dropdown-container">
          <p class="side-bar-link-dropdown-header">
            Sale List

            <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
          </p>
          <div class="side-bar-link-drop-down">
            <a class="side-bar-link-drop-down-link" href="./salelist/twod.html">2D</a>
            <a class="side-bar-link-drop-down-link" href="./salelist/lonepyine.html">Lone Pyine</a>
            <a class="side-bar-link-drop-down-link" href="./salelist/lonepyine.html">3D</a>
          </div>
        </div> -->

        <div class="side-bar-link-dropdown-container">
          <p class="side-bar-link-dropdown-header">
            Data

            <i class="fa-solid fa-angle-left side-bar-link-drop-down-icon"></i>
          </p>
          <div class="side-bar-link-drop-down">
            <a class="side-bar-link-drop-down-link" href="{{route('refereedata')}}">Refree Data</a>

          </div>
        </div>
    </div>
  </div>
