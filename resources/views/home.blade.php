@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
   
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
    <form action="/home" method="POST">
        @csrf
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-name" role="tabpanel" aria-labelledby="pills-name-tab">
            <!-- filter -->
            <h5 class="filter-title">Filter</h5>
            <label class="label-filter">Jumlah Barang</label>
            <div class="form-check form-check-inline">

                <select name="limit" class="filter-limit">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                </select>

                </div>
                <label class="label-filter">Location</label>
                <div class="form-check form-check-inline">

                    <select class="filter-kota">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>

                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="number" name="harga_maks" id="harga-maks">
                    <label class="form-check-label" for="harga-maks">Harga Maksimal</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="number" name="harga_min" id="harga-min">
                    <label class="form-check-label" for="harga-min">Harga Minimal</label>
                </div>
                <div class="input-group search">
                    <input type="text" name="search_barang" class="form-control input-search" placeholder="Nama Barang">
                    <button class="btn btn-default" name="find" type="submit"><img class="icon-search" src="./svg/magnifying-glass.svg"></button>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-link" role="tabpanel" aria-labelledby="pills-link-tab">
                <div class="input-group search">
                    <input type="text" name="search_link" class="form-control input-search" placeholder="Link Barang">
                    <button class="btn btn-default" type="button"><img class="icon-search" src="./svg/magnifying-glass.svg"></button>
                </div>
            </div>
        </div>
    </form>

    <!-- List-Items-Added -->
    <div class="item-container-add">
        <div class="row row-add">
            <div class="col-sm-4">
                <img class="item-add-img" src="./svg/person.svg">
            </div>
            <div class="col-sm-7">
                <p class="text-namabarang-add">Nama Barang</p>
                <p class="text-harga-add">50000000000</p>
                <p class="text-namatoko-add">Nama Toko</p>
                <p class="text-lokasitoko-add">Lokasi Toko</p>
            </div>
            <div class="col-sm-1">
                <a class="item-deletebtn" href="#"><img class="icon-delete" src="./svg/delete.svg"></a>
            </div>
        </div>
    </div>

    <!-- List-Items-Searched-Tokopedia -->
    <div class="item-container-search-Tokopedia">
        <h1 class="text-center mb-3">List Barang Tokopedia</h1>
        <div id="Item-list-Tokopedia" class="carousel slide" data-ride="carousel">

            <!-- Cards -->
            <div class="carousel-inner row mx-auto">
           
            
            <!-- coba for print dalamnya php-->
            @for ($i = 0; $i < $counttokped; $i++)
                @if ($i == 0)
                    <div class="carousel-item col-md-3 active">
                @elseif ($i > 0)
                    <div class="carousel-item col-md-3">
                @endif
                    <a href="#">
                        <div class="card item">
                            <img class="card-img-top img-fluid" src="{{$data_arr['data'][$i]['image_url']}}">
                            <div class="card-body">
                                <h4 class="card-title">{{$data_arr['data'][$i]['product_name']}}</h4>
                                <p class="card-text">{{$data_arr['data'][$i]['price_format']}}</p>
                                <p class="card-text">{{$data_arr['data'][$i]['shop_name']}}</p>
                                <p class="card-text">{{$data_arr['data'][$i]['shop_location']}}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endfor
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

    <!-- List-Items-Searched-Shopee -->
    <div class="item-container-search-Shopee">
        <h1 class="text-center mb-3">List Barang Shopee</h1>
        <div id="Item-list-Shopee" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner row mx-auto">

            <!-- Cards -->
            @for ($x = 0; $x < $countshopee; $x++)
            @if ($x == 0)
            <div class="carousel-item col-md-3 active">
            @elseif ($x > 0)
            <div class="carousel-item col-md-3">
            @endif
            <a href="#">
                <div class="card item">
                    <img class="card-img-top img-fluid" src="{{$dataShopee_arr['data'][$x]['image_url']}}">
                    <div class="card-body">
                        <h4 class="card-title">{{$dataShopee_arr['data'][$x]['product_name']}}</h4>
                        <p class="card-text">{{$dataShopee_arr['data'][$x]['price_format']}}</p>
                        <p class="card-text">{{$dataShopee_arr['data'][$x]['shop_name']}}</p>
                        <p class="card-text">{{$dataShopee_arr['data'][$x]['shop_location']}}</p>
                    </div>
                </div>
            </a>
            </div>
            @endfor

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
</div>
@endsection