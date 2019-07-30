@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
   <h3>Profile</h3>
   <div class="item-container">
      <label for="Name" style="padding-right: 50px">Nama<p>{{ $user->name }}</p></label>
      <label for="Email" style="padding-right: 50px">Email<p>{{ $user->email }}</p></label>
      <label for="Username" style="padding-right: 50px">Username<p>{{ $user->username }}</p></label>
      <label for="Phone" style="padding-right: 50px">Nomor Telepon<p>{{ isset($user->phone)?$user->phone:"-" }}</p></label>
      <label for="Address" style="padding-right: 50px">Alamat<p>{{ isset($user->address)?$user->address:"-" }}</p></label>
   </div>
</div>

@endsection