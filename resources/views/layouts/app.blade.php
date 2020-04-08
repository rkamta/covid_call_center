<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/style.css') }}" rel="stylesheet">
    @yield('after_style')
</head>
<body>
    @include('layouts.partials.preloader')
    <div id="app">
        <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
            
            @include('layouts.partials.navbar')

            @auth
            @include('layouts.partials.sidebar')
            @endauth

            <main>
                <div class="page-wrapper">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>
    <!-- Scripts -->
    @yield('before_script')

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/pages/app-style-switcher.js') }}"></script>
    <script src="{{ asset('js/pages/feather.min.js') }}"></script>
    <script src="{{ asset('lib/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('js/pages/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/pages/custom.js') }}"></script>

    @yield('after_script')
    @include('flashy::message')
</body>
</html>
