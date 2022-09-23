<!--top bar start-->
@hasanyrole('referee')
<div class="top-bar-container">
    <div class="top-bar-label-container">
      <i class="fa-solid fa-bars sider-bar-toggle" ></i>
      <p class="top-bar-label">{{__('msg.referee')}}</p>
    </div>

    <div class="top-bar-right-container">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">{{__('msg.logout')}}</button>
      </form>
      &nbsp;
      &nbsp;
      &nbsp;

      <a href={{route('locale','en')}}>English</a> |
    <a href={{route('locale','mm')}}>Myanmar</a>

    </form>

      {{-- <i class="fa-regular fa-bell"></i> --}}

      <div class="top-bar-username-container">
       {{__('msg.Coin Amount')}} :
        @if(auth()->user()->referee->main_cash != 0)
        {{auth()->user()->referee->main_cash}}
        @elseif (auth()->user()->referee->main_cash == 0 )
        0
        @endif

        &nbsp;
        &nbsp;
        &nbsp;
        <a class="side-bar-link" href="{{route('porfile-referee')}}">
        <i class="fa-regular fa-user"></i>
        <p>{{auth()->user()->name}}</p>
        </a>

    </div>
    </div>
  </div>
@endhasanyrole
@hasanyrole('system_admin')
<div class="top-bar-container">
    <div class="top-bar-label-container">
      <i class="fa-solid fa-bars sider-bar-toggle" ></i>
      <p class="top-bar-label">{{__('msg.system')}}</p>
    </div>

    <div class="top-bar-right-container">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">{{__('msg.logout')}}</button>
      </form>
      &nbsp;
      &nbsp;
      &nbsp;

      <a href={{route('locale','en')}}>English</a> |
    <a href={{route('locale','mm')}}>Myanmar</a>

    </form>

      {{-- <i class="fa-regular fa-bell"></i> --}}

      <div class="top-bar-username-container">
        &nbsp;
        &nbsp;
        &nbsp;
        <a class="side-bar-link" href="{{route('porfile-admin')}}">
        <i class="fa-regular fa-user"></i>
        <p>{{auth()->user()->name}}</p>
        </a>

    </div>
    </div>
  </div>
@endhasanyrole
  <!--top bar end-->
