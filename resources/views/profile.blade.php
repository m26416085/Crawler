@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
   <h3>Profile</h3>
   <div class="container-data-profile">
   Nama:<p class="data-profile">{{ $user->name }}</p>
   Email:<p class="data-profile">{{ $user->email }}</p>
   Username:<p class="data-profile">{{ $user->username }}</p>
   Nomor Telp:<p class="data-profile">{{ isset($user->phone)?$user->phone:'-' }}</p>
   Alamat:<p class="data-profile">{{ isset($user->address)?$user->address:'-' }}</p>
   </div>
   <button type="button" class="btn btn-default btn-update-profile" data-toggle="collapse" data-target="#demo">Edit Profile</button>
   <div id="demo" class="collapse">
      <form action="/profile" method="POST" class="form-edit-profile">
         @csrf
         Nama: <input class="form-control" type="text" name="name" value="{{ $user->name }}"><br>
         No Telp: <input class="form-control" type="text" name="phone" value="{{ isset($user->phone)?$user->phone:'-' }}"><br>
         Alamat: <input class="form-control" type="text" name="address" value="{{ isset($user->address)?$user->address:'-' }}"><br>
         <input class="btn btn-default btn-update-profile" type="submit" name="save" value="Save">
      </form>
   </div>
   
</div>

@endsection