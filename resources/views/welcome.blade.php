@extends('layouts.app')

@section('content')
<img class="logo-login" src="icon/logo.png">
<!-- Login-Form -->
<div class="container justify-content-center container-login">
    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input id="email" type="email" class="input-username input-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <input id="password" type="password" class="input-password input-login @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-dark btn-login">Login</button>

    </form>
    @if (Route::has('register'))
    <a class="btn-register" href="{{ route('register') }}">Tidak punya akun silahkan Register disini.</a>
    @endif

</div>
<!-- Login-Form-End -->
@endsection