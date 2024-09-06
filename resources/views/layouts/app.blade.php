<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '日盛國際' }}</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="top-right-buttons">
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
    </nav>

    <div class="container">
        <x-menu />
        <div class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOMContentLoaded event fired');

            document.querySelectorAll('.menu-link').forEach(function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    let url = this.getAttribute('data-url');
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('.content').innerHTML = html;
                        })
                        .catch(error => console.error('Error loading content:', error));
                });
            });

            document.querySelector('.close-banner').addEventListener('click', function () {
                document.querySelector('.top-banner').style.display = 'none';
            });
        });
    </script>
</body>

</html>