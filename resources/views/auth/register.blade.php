@extends('layouts.app')

@section('content')
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
    <button type="submit" href="#" class="btn btn-danger btn-cancel">Cancel</button> 
</div>
@endsection