<div class="top-right-buttons">
    @auth
        <a href="{{ route('logout') }}" class="btn btn-logout"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            登出
        </a>
        <a href="#" class="btn btn-notifications">
            <i class="fas fa-bell"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-login">登入</a>
        <a href="{{ route('register') }}" class="btn btn-register">註冊</a>
    @endauth
</div>