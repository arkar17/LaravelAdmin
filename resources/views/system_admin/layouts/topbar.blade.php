<div class="top-bar-container">
    <div class="top-bar-label-container">
    <i class="fa-solid fa-bars sider-bar-toggle" ></i>
    @hasanyrole('system_admin')
    <p class="top-bar-label">{{__('msg.system')}}</p>
    @endhasanyrole
    @hasanyrole('referee')
    <p class="top-bar-label">{{__('msg.referee')}}</p>
    @endhasanyrole
    </div>

    <div class="top-bar-right-container">
        <a href={{route('locale','en')}}>English</a> |
        <a href={{route('locale','mm')}}>Myanmar</a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">{{__('msg.logout')}}</button>
    </form>
    &nbsp;
    &nbsp;
    &nbsp;
    @hasanyrole('referee')
    <div class="top-bar-username-container">
        Coin Amount :
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
    @endhasanyrole
    @hasanyrole('system_admin')
    <div class="top-bar-username-container">
        <a class="side-bar-link" href="">
            <i class="fa-regular fa-user"></i>
            <p>{{auth()->user()->name}}</p>
        </a>
    </div>
    @endhasanyrole
    </div>
</div>
