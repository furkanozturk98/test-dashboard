<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

    @stack('styles')

    @auth
        <script>
            window.api_token = '{{ auth()->user()->api_token  }}'
        </script>
    @endauth

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="dark-theme">
<div id="app">

    <div>
        <navbar app-name="{{ config('app.name', 'Laravel') }}" @auth username="{{ auth()->user()->name }}" @endauth />
    </div>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

</div>

<script src="{{ asset('js/app.js') }}"></script>

@stack('scripts')

</body>
</html>


