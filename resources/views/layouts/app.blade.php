<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '日盛國際' }}</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>

<body>
    <div>
        <div class="container">
            <div class="x-auth-buttons">
                <x-auth-buttons />
            </div>
            <div class="content-wrapper">
                <x-menu />
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
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
    });
</script>

</html>