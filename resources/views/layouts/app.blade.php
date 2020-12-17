<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Event Management @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="container-fluid d-flex">
        <!-- Header -->
        @yield('sidebar')
        <!-- End Header -->

        <div id="content" class="sidebar-open">
            <!-- Header -->
            @yield('header')
            <!-- End Header -->

            <main class="py-4 main-content mt-5" id="page-content-wrapper">
                <!-- Main content -->
                @yield('content')
                <!-- End main content -->
            </main>
        </div>

        <el-backtop target="#content" :visibility-height="50"></el-backtop>
    </div>
</body>
</html>

