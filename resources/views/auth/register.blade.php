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
<body>
<div class="container justify-content-center container-regis">
    <h3 class="page-title">Registrasi Akun</h3>
    <form class="regis-form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <img class= "icon-input" src="./svg/person.svg"><input type="text" name="name" id="name" class="input-name input-regis @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Nama">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <img class= "icon-input" src="./svg/envelope-closed.svg"><input type="email" name="email" id="email" class="input-email input-regis @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email" placeholder="Email">
                    
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <img class= "icon-input" src="./svg/person.svg"><input type="text" name="username" id="username" class="input-username input-regis @error('username') is-invalid @enderror" value="{{ old('username') }}" autocomplete="username" placeholder="Username">
            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <img class= "icon-input" src="./svg/lock-locked.svg"><input type="password" id="password" class="input-password input-regis @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password">
                    
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <img class= "icon-input" src="./svg/lock-locked.svg"><input id="password-confirm" type="password" class="input-password input-regis" name="password_confirmation" autocomplete="new-password" placeholder="Ketik Ulang Password">
        </div>
        <div class="form-group">
            <img class= "icon-input" src="./svg/phone.svg"><input type="tel"  id="handphone" class="input-hp input-regis @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone" placeholder="Nomor HP">
                    
            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <img class= "icon-input" src="./svg/home.svg"><input type="text"  id="address" class="input-address input-regis @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="address" placeholder="Alamat">
                    
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-dark btn-regis">Register</button>
    </form>
    <a href="/" ><button type="submit" class="btn btn-danger btn-cancel">Cancel</button></a> 
</div>
</body>
</html>