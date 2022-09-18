<!--top bar start-->
 <div class="top-bar-container">
    <div class="top-bar-label-container">
      <i class="fa-solid fa-bars sider-bar-toggle" ></i>
      <p class="top-bar-label">Referee</p>
    </div>

    <div class="top-bar-right-container">
        Coin Amount : {{auth()->user()->referee->main_cash}}
      <div class="top-bar-searchbox-container">
        <i class="fa-solid fa-magnifying-glass " ></i>
        <input type="text" placeholder="Search..."/>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Log out</button>
    </form>

      <i class="fa-regular fa-bell"></i>

      <div class="top-bar-username-container">
        <i class="fa-regular fa-user"></i>
        <p>{{auth()->user()->name}}</p>
    </div>
    </div>
  </div>
<!--top bar end-->
