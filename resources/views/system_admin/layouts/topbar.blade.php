<div class="top-bar-container">
    <div class="top-bar-label-container">
    <i class="fa-solid fa-bars sider-bar-toggle" ></i>
    @hasanyrole('system_admin')
    <p class="top-bar-label">{{__('msg.system')}}</p>
    @endhasanyrole
    @hasanyrole('phasetwo_admin')
    <p class="top-bar-label">Phase Two Admin</p>
    @endhasanyrole
    </div>



    <div class="top-bar-right-container">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">{{__('msg.logout')}}</button>
        </form>
        <div class="language-container">
            <a href={{route('locale','en')}}>English</a>
            <a href={{route('locale','mm')}}>Myanmar</a>
        </div>



    <div class="top-bar-username-container">
        <a class="profile-link" href="{{route('porfile-admin')}}">
            <i class="fa-regular fa-user"></i>
            <p>{{auth()->user()->name}}</p>
        </a>
    </div>

    </div>
</div>
