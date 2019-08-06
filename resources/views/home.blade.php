@extends('layouts.app')

@section('content')
<div class="container justify-content-center content" id="content">
    <!-- Tabs -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-name-tab" data-toggle="pill" href="#pills-name" role="tab">Nama</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-link-tab" data-toggle="pill" href="#pills-link" role="tab">Link</a>
        </li>
    </ul>

    <!-- Search -->
    <form action="/home" method="POST" id="filter_form">
        @csrf  
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-name" role="tabpanel" aria-labelledby="pills-name-tab">

            <!-- filter -->
            <table>
            <tr>
                <td><h5 class="filter-title">Filter</h5></td>
            </tr>
            <tr>
                <td><label class="label-filter">Jumlah Barang</label></td>
                <td>
                <div class="form-check form-check-inline">
                    <select name="limit" class="form-control filter-limit">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>
                </div>
                </td>
            </tr>
            <tr>
                <td><label class="label-filter">Lokasi</label></td>
                <td>
                <div class="form-check form-check-inline">
                <select class="form-control filter-kota" name="location">
                    @foreach($city_data['city'] as $city)
                        <option value="{{ $city['value_tokopedia'] }}|{{ $city['value_shopee'] }}|{{ $city['name'] }}">{{ $city['name'] }}</option>
                    @endforeach
                </select>
                </div>
                </td>
            </tr>
            <tr>
                <?php
                    if(empty($data_arr))
                    {
                        $keyword_value=$dataShopee_arr['data'][0]['keyword'];
                        $keymax_value=$dataShopee_arr['data'][0]['keyword_max'];
                        $keymin_value=$dataShopee_arr['data'][0]['keyword_min'];
                    }
                    else
                    {
                        $keyword_value=$data_arr['data'][0]['keyword'];
                        $keymax_value=$data_arr['data'][0]['keyword_max'];
                        $keymin_value=$data_arr['data'][0]['keyword_min'];
                    }
                ?>
                <td> <label>Harga Maksimal</label> </td>
                <td> <input class="form-control" type="number" name="harga_maks" id="harga-maks" value="{{ $keymax_value }}"> </td>
             
                <td> <label>Harga Minimal</label> </td>
                <td> <input class="form-control" type="number" name="harga_min" id="harga-min" value="{{ $keymin_value }}"> </td>
            </tr>
            </table>
                <div class="input-group search">
                    <input type="text" name="text_value" class="form-control input-search" placeholder="Nama Barang" value="{{str_replace('%20', ' ', $keyword_value)}}">

                    <button class="btn btn-default" name="find" type="submit"><img class="icon-search" src="./svg/magnifying-glass.svg"></button>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-link" role="tabpanel" aria-labelledby="pills-link-tab">
                <div class="input-group search">
                    <input type="text" name="search_link" class="form-control input-search" placeholder="Link Detail Barang"  value="{{str_replace('%20', ' ', $keyword_value)}}">
                    <button class="btn btn-default" name="find_link" type="submit"><img class="icon-search" src="./svg/magnifying-glass.svg"></button>
                </div>
            </div>
        </div>
    </form>

    <!-- List-Items-Added -->
    <div class="item-container-add">
        @foreach($cartCollection as $cart)
        @if($cart['name'] != 'asdfghjklkjgfds123890ythbnvdkodetokopediafwgheu3yr2t3r64ortfg')
            <div class="row row-add mr-1">
            <form action="/home" method="POST" class="form-cart">
            @csrf
                <div class="col-sm-4">
                    <img class="item-add-img" src="{{ $cart['attributes']['image_url'] }}">
                </div>
                <div class="col-sm-6">
                    <input type="hidden" name="id_delete" value="{{ $cart['id'] }}">

                    <p class="text-namabarang-add">{{ $cart['name'] }}</p>
                    <p class="text-harga-add">{{ $cart['attributes']['price_format'] }}</p>
                    <p class="text-namatoko-add">{{ $cart['attributes']['shop_name'] }}</p>

                    <p class="text-lokasitoko-add">{{ $cart['attributes']['shop_location'] }}</p>
                    <input type="hidden" name="shop_location" value="{{ $cart['attributes']['shop_location'] }}">

                    <input type="hidden" name="text_value" value="{{ $cart['attributes']['keyword'] }}">

                    <input type="hidden" name="keyword_value_location_tokopedia" value="{{ $cart['attributes']['keyword_value_location_tokopedia'] }}">
                    <input type="hidden" name="keyword_value_location_shopee" value="{{ $cart['attributes']['keyword_value_location_shopee'] }}">

                    <input type="hidden" name="keyword_max" value="{{ $cart['attributes']['keyword_max'] }}">
                    <input type="hidden" name="keyword_min" value="{{ $cart['attributes']['keyword_min'] }}">
                
                </div>
                <div class="col-sm-2 border-cart">
                    <!-- <a class="item-deletebtn" ><img class="icon-delete" src="./svg/delete.svg"></a> -->
                    <button class="btn btn-del" name="delete_button" type="submit">Hapus<img class="icon-delete" src="./svg/delete.svg"></button>
                </div>
                </form>
            </div>
        @endif
        @endforeach

    </div>
    @if($tokpedisempty==false)
    <!-- List-Items-Searched-Tokopedia -->
    <div class="item-container-search-Tokopedia">
        <h1 class="text-center mb-3">List Barang Tokopedia</h1>
        <div id="Item-list-Tokopedia" class="carousel slide" data-interval="false" data-ride="carousel">
            <!-- Cards -->
            <div class="carousel-inner row mx-auto">
   
            @if ($counttokped==0)
            <div class="carousel-item col-md-3 active">
            <a target="_blank" href="{{ $data_arr['data'][0]['product_url'] }}">
                <div class="card item">
                    <form action="/home" method="POST" id="list_tokopedia_form">
                        @csrf
                        <input type="hidden" name="product_url" value="{{$data_arr['data'][0]['product_url']}}">
                        <img class="card-img-top img-fluid" src="{{$data_arr['data'][0]['image_url']}}">
                        <input type="hidden" name="image_url" value="{{$data_arr['data'][0]['image_url']}}">
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{$data_arr['data'][0]['id']}}">

                            <h4 class="card-title">{{$data_arr['data'][0]['product_name']}}</h4>
                            <input type="hidden" name="product_name" value="{{$data_arr['data'][0]['product_name']}}">

                            <p class="card-text">{{$data_arr['data'][0]['price_format']}}</p>
                            <input type="hidden" name="price_format" value="{{$data_arr['data'][0]['price_format']}}">

                            <p class="card-text" hidden>{{$data_arr['data'][0]['price']}}</p>
                            <input type="hidden" name="price" value="{{$data_arr['data'][0]['price']}}">

                            <p class="card-text card-text-namatoko">{{$data_arr['data'][0]['shop_name']}}</p>
                            <input type="hidden" name="shop_name" value="{{$data_arr['data'][0]['shop_name']}}">

                            <p class="card-text">{{$data_arr['data'][0]['shop_location']}}</p>
                            <input type="hidden" name="shop_location" value="{{$data_arr['data'][0]['shop_location']}}">

                            <input type="hidden" name="text_value" value="{{ $data_arr['data'][0]['keyword'] }}">
                            
                            <input type="hidden" name="keyword_value_location_tokopedia" value="{{ $data_arr['data'][0]['keyword_value_location_tokopedia'] }}">
                            <input type="hidden" name="keyword_value_location_shopee" value="{{ $data_arr['data'][0]['keyword_value_location_shopee'] }}">

                            <input type="hidden" name="keyword_max" value="{{ $data_arr['data'][0]['keyword_max'] }}">
                            <input type="hidden" name="keyword_min" value="{{ $data_arr['data'][0]['keyword_min'] }}">

                            <button class="btn btn-add" name="add_button" type="submit" onclick="submitForms()">Tambah<img class="icon-add" src="./svg/plus.svg"></button>

                        </div>
                    </form>
                </div>
            </a>
            </div>
            @elseif ($counttokped>0)
            @for ($i = 0; $i < $counttokped; $i++)
                @if ($i == 0)
                    <div class="carousel-item col-md-3 active">
                @elseif ($i > 0)
                    <div class="carousel-item col-md-3">
                        @endif
                        <a target="_blank" href="{{ $data_arr['data'][$i]['product_url'] }}">
                            <div class="card item">
                                <form action="/home" method="POST" id="list_tokopedia_form">
                                    @csrf
                                    <input type="hidden" name="product_url" value="{{$data_arr['data'][$i]['product_url']}}">
                                    <img class="card-img-top img-fluid" src="{{$data_arr['data'][$i]['image_url']}}">
                                    <input type="hidden" name="image_url" value="{{$data_arr['data'][$i]['image_url']}}">
                                    <div class="card-body">
                                        <input type="hidden" name="id" value="{{$data_arr['data'][$i]['id']}}">

                                        <h4 class="card-title">{{$data_arr['data'][$i]['product_name']}}</h4>
                                        <input type="hidden" name="product_name" value="{{$data_arr['data'][$i]['product_name']}}">

                                        <p class="card-text">{{$data_arr['data'][$i]['price_format']}}</p>
                                        <input type="hidden" name="price_format" value="{{$data_arr['data'][$i]['price_format']}}">

                                        <p class="card-text" hidden>{{$data_arr['data'][$i]['price']}}</p>
                                        <input type="hidden" name="price" value="{{$data_arr['data'][$i]['price']}}">

                                        <p class="card-text card-text-namatoko">{{$data_arr['data'][$i]['shop_name']}}</p>
                                        <input type="hidden" name="shop_name" value="{{$data_arr['data'][$i]['shop_name']}}">

                                        <p class="card-text">{{$data_arr['data'][$i]['shop_location']}}</p>
                                        <input type="hidden" name="shop_location" value="{{$data_arr['data'][$i]['shop_location']}}">

                                        <input type="hidden" name="text_value" value="{{ $data_arr['data'][$i]['keyword'] }}">
                                        
                                        <input type="hidden" name="keyword_value_location_tokopedia" value="{{ $data_arr['data'][$i]['keyword_value_location_tokopedia'] }}">
                                        <input type="hidden" name="keyword_value_location_shopee" value="{{ $data_arr['data'][$i]['keyword_value_location_shopee'] }}">

                                        <input type="hidden" name="keyword_max" value="{{ $data_arr['data'][$i]['keyword_max'] }}">
                                        <input type="hidden" name="keyword_min" value="{{ $data_arr['data'][$i]['keyword_min'] }}">

                                        <button class="btn btn-add" name="add_button" type="submit" onclick="submitForms()">Tambah<img class="icon-add" src="./svg/plus.svg"></button>
                                        
                                    </div>
                                </form>
                            </div>
                        </a>
                    </div>
            @endfor
            @endif
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
    @endif
    <!-- List-Items-Searched-Shopee -->
    @if ($shopeeisempty==false)
    <div class="item-container-search-Shopee">
        <h1 class="text-center mb-3">List Barang Shopee</h1>
        <div id="Item-list-Shopee" class="carousel slide" data-interval="false" data-ride="carousel">
            <div class="carousel-inner row mx-auto">
            <!-- Cards -->
            @if($countshopee==0)
            <div class="carousel-item col-md-3 active">
            <a target="_blank" href="{{$dataShopee_arr['data'][0]['product_url']}}">
                <div class="card item">
                    <form action="/home" method="POST">
                    @csrf
                        <input type="hidden" name="product_url" value="{{ $dataShopee_arr['data'][0]['product_url'] }}">
                        <img class="card-img-top img-fluid" src="{{$dataShopee_arr['data'][0]['image_url']}}">
                        <input type="hidden" name="image_url" value="{{ $dataShopee_arr['data'][0]['image_url'] }}">
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $dataShopee_arr['data'][0]['id'] }}">

                            <h4 class="card-title">{{$dataShopee_arr['data'][0]['product_name']}}</h4>
                            <input type="hidden" name="product_name" value="{{ $dataShopee_arr['data'][0]['product_name'] }}">
    
                            <p class="card-text">{{$dataShopee_arr['data'][0]['price_format']}}</p>
                            <input type="hidden" name="price_format" value="{{ $dataShopee_arr['data'][0]['price_format'] }}">
                            <input type="hidden" name="price" value="{{$dataShopee_arr['data'][0]['price']}}">

                            <p class="card-text card-text-namatoko">{{$dataShopee_arr['data'][0]['shop_name']}}</p>
                            <input type="hidden" name="shop_name" value="{{ $dataShopee_arr['data'][0]['shop_name'] }}">

                            <p class="card-text">{{$dataShopee_arr['data'][0]['shop_location']}}</p>
                            <input type="hidden" name="shop_location" value="{{ $dataShopee_arr['data'][0]['shop_location'] }}">

                            <input type="hidden" name="text_value" value="{{ $dataShopee_arr['data'][0]['keyword'] }}">
                            
                            <input type="hidden" name="keyword_value_location_tokopedia" value="{{ $cartCollection[9999]['attributes']['keyword_value_location_tokopedia'] }}">
                            <input type="hidden" name="keyword_value_location_shopee" value="{{ $cartCollection[9999]['attributes']['keyword_value_location_shopee'] }}">
                            
                            <input type="hidden" name="keyword_max" value="{{ $cartCollection[9999]['attributes']['keyword_max'] }}">
                            <input type="hidden" name="keyword_min" value="{{ $cartCollection[9999]['attributes']['keyword_min'] }}">

                            <button class="btn btn-add" name="add_button" type="submit" onclick="submitForms()">Tambah<img class="icon-add" src="./svg/plus.svg"></button>
                        </div>
                    </form>
                </div>
            </a>
            </div>
            @elseif ($countshopee>0)
            @for ($x = 0; $x < $countshopee; $x++)
            @if ($x == 0)
            <div class="carousel-item col-md-3 active">
            @elseif ($x > 0)
            <div class="carousel-item col-md-3">
            @endif
            <a target="_blank" href="{{ $dataShopee_arr['data'][$x]['product_url'] }}">
                <div class="card item">
                    <form action="/home" method="POST">
                    @csrf
                        <input type="hidden" name="product_url" value="{{ $dataShopee_arr['data'][$x]['product_url'] }}">
                        <img class="card-img-top img-fluid" src="{{$dataShopee_arr['data'][$x]['image_url']}}">
                        <input type="hidden" name="image_url" value="{{ $dataShopee_arr['data'][$x]['image_url'] }}">
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $dataShopee_arr['data'][$x]['id'] }}">

                            <h4 class="card-title">{{$dataShopee_arr['data'][$x]['product_name']}}</h4>
                            <input type="hidden" name="product_name" value="{{ $dataShopee_arr['data'][$x]['product_name'] }}">

                            <p class="card-text">Rp {{number_format($dataShopee_arr['data'][$x]['price_format'],0,",",".")}}</p>
                            <input type="hidden" name="price_format" value="{{ $dataShopee_arr['data'][$x]['price_format'] }}">
                            <input type="hidden" name="price" value="{{$dataShopee_arr['data'][$x]['price']}}">

                            <p class="card-text card-text-namatoko">{{$dataShopee_arr['data'][$x]['shop_name']}}</p>
                            <input type="hidden" name="shop_name" value="{{ $dataShopee_arr['data'][$x]['shop_name'] }}">

                            <p class="card-text">{{$dataShopee_arr['data'][$x]['shop_location']}}</p>
                            <input type="hidden" name="shop_location" value="{{ $dataShopee_arr['data'][$x]['shop_location'] }}">

                            <input type="hidden" name="text_value" value="{{ $dataShopee_arr['data'][$x]['keyword'] }}">

                            <input type="hidden" name="keyword_value_location_tokopedia" value="{{ $data_arr['data'][$x]['keyword_value_location_tokopedia'] }}">
                            <input type="hidden" name="keyword_value_location_shopee" value="{{ $data_arr['data'][$x]['keyword_value_location_shopee'] }}">
                            
                            <input type="hidden" name="keyword_max" value="{{ $data_arr['data'][$x]['keyword_max'] }}">
                            <input type="hidden" name="keyword_min" value="{{ $data_arr['data'][$x]['keyword_min'] }}">

                            <button class="btn btn-add" name="add_button" type="submit" onclick="submitForms()">Tambah<img class="icon-add" src="./svg/plus.svg"></button>
                        </div>
                    </form>
                </div>
            </a>
            </div>
            @endfor
            @endif
            </div>
            <a class="carousel-control-prev left" href="#Item-list-Shopee" role="button" data-slide="prev">
                <img class="icon-next" src="./svg/chevron-left.svg">
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next right" href="#Item-list-Shopee" role="button" data-slide="next">
                <img class="icon-next" src="./svg/chevron-right.svg">
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    @endif
</div>
<div id="loader"></div>
<script>
    submitForms = function(){
        document.getElementById('filter_form')
    }
    var myVar;
    function myFunction() {
        myVar = setTimeout(showPage, 1000);
    }
    function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("content").style.display = "block";
    }
</script>
@endsection