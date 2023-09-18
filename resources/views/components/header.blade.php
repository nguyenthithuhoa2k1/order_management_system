<div class="header">
    <div class="bars-btn"><i class="fa-solid fa-bars"></i></div>
    <div class="header-login-logout">
        @if(Auth::check())
            <a href="{{url('logout')}}">Logout</a>
            <p>{{ Auth::user()->username }}</p>
        @else
            <a href="{{url('login')}}">Login</a>
        @endif
    </div>
</div>
