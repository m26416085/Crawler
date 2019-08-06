@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
   <h3>Profile</h3>
   <div class="item-container">
      <label for="Name" style="padding-right: 50px">Nama<p>{{ $user->name }}</p></label>
      <label for="Email" style="padding-right: 50px">Email<p>{{ $user->email }}</p></label>
      <label for="Username" style="padding-right: 50px">Username<p>{{ $user->username }}</p></label>
      <label for="Phone" style="padding-right: 50px">Nomor Telepon<p>{{ isset($user->phone)?$user->phone:'-' }}</p></label>
      <label for="Address" style="padding-right: 50px">Alamat<p>{{ isset($user->address)?$user->address:'-' }}</p></label>
      <br>

      <form action="/profile" method="POST">
      @csrf
      <input type="text" name="name" value="{{ $user->name }}"><br>
      <input type="text" name="phone" value="{{ isset($user->phone)?$user->phone:'-' }}"><br>
      <input type="text" name="address" value="{{ isset($user->address)?$user->address:'-' }}"><br>
      <input type="submit" name="save" value="Save">

      </form>
      
      

   </div>
</div>

@endsection