<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>日盛國際理財</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="navbar-links">
                @auth
                    <a href="{{ route('logout') }}" class="btn btn-logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        登出
                    </a>
                    <a href="#" class="btn btn-notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">0</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login">登入</a>
                    <a href="{{ route('register') }}" class="btn btn-register">註冊</a>
                @endauth
            </div>
        </div>
    </nav>
    <div class="overlay"></div>
    <x-auth-buttons />
</body>

</html>