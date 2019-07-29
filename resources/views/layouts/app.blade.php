<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cari.css') }}" rel="stylesheet">
    <link href="{{ asset('css/listbarang.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>
<body onload="myFunction()">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
                <!-- Navbar -->
                <div class="sidenav">
                    <a class="navbar-brand" href="/home"><img class="logo" src="icon/logo.png"></a>
                    <div class="container-link-1stitem">
                        <a href="/home">Cari Barang</a>
                    </div>
                    <div class="container-link">
                        <a href="/itemlist">List Barang</a>
                    </div>
                    <div class="container-link">
                        <a href="/profile">Profile</a>
                    </div>
                    <div class="container-link">
                        @guest
                        @else
                            <a class="btn-logout" href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); 
                            document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>                    
                        @endguest
                    </div>
                </div>
                <!-- Navbar-End -->
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
