@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
   <h3>List Barang</h3>
   {{ dd($cartCollection) }}
</div>
@endsection