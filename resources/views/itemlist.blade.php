@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
   <h3>List Barang</h3>
   
   <div class="item-container-search-Tokopedia">
        <h1 class="text-center mb-3">{{$keyword}}</h1>
        <div id="Item-list-Tokopedia" class="carousel slide" data-ride="carousel">

            <!-- Cards -->
            <div class="carousel-inner row mx-auto">
            @foreach ($cartCollection as $cart)
                @if($cart['name'] != 'asdfghjklkjgfds123890ythbnvdkodetokopediafwgheu3yr2t3r64ortfg')
                  <div class="carousel-item col-md-3 active">
                     <a target="_blank" href="{{ $cart['attributes']['product_url'] }}">
                           <div class="card item">
                              <form action="/home" method="POST" id="list_tokopedia_form">
                                 @csrf
                                 <input type="hidden" name="product_url" value="{{$cart['attributes']['product_url']}}">
                                 <img class="card-img-top img-fluid" src="{{$cart['attributes']['image_url']}}">
                                 <input type="hidden" name="image_url" value="{{$cart['attributes']['image_url']}}">
                                 <div class="card-body">
                                       <input type="hidden" name="id" value="{{$cart['id']}}">

                                       <h4 class="card-title">{{$cart['name']}}</h4>
                                       <input type="hidden" name="product_name" value="{{$cart['name']}}">

                                       <p class="card-text">{{$cart['attributes']['price_format']}}</p>
                                       <input type="hidden" name="price_format" value="{{$cart['attributes']['price_format']}}">

                                       <p class="card-text" hidden>{{$cart['price']}}</p>
                                       <input type="hidden" name="price" value="{{$cart['price']}}">

                                       <p class="card-text">{{$cart['attributes']['shop_name']}}</p>
                                       <input type="hidden" name="shop_name" value="{{$cart['attributes']['shop_name']}}">

                                       <p class="card-text">{{$cart['attributes']['shop_location']}}</p>
                                       <input type="hidden" name="shop_location" value="{{$cart['attributes']['shop_location']}}">

                                       <input type="hidden" name="text_value" value="{{ $cart['attributes']['keyword'] }}">
                                       
                                       <input type="hidden" name="keyword_value_location_tokopedia" value="{{ $cart['attributes']['keyword_value_location_tokopedia'] }}">
                                       <input type="hidden" name="keyword_value_location_shopee" value="{{ $cart['attributes']['keyword_value_location_shopee'] }}">

                                       <input type="hidden" name="keyword_max" value="{{ $cart['attributes']['keyword_max'] }}">
                                       <input type="hidden" name="keyword_min" value="{{ $cart['attributes']['keyword_min'] }}">
                                 </div>
                              </form>
                           </div>
                     </a>
                  </div>
            @endif
            @endforeach
            </div>
            <a class="carousel-control-prev" href="#Item-list-Tokopedia" role="button" data-slide="prev">
                <img class="icon-prev" src="./svg/chevron-left.svg">
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#Item-list-Tokopedia" role="button" data-slide="next">
                <img class="icon-next" src="./svg/chevron-right.svg">
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
@endsection