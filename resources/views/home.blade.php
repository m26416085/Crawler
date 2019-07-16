@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
    <!-- filter -->
    <h5 class="filter-title">Filter</h5>
    <form class="filter" method="POST">
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
            <input class="form-check-input" type="text" id="harga-maks">
            <label class="form-check-label" for="harga-maks">Harga Maksimal</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="text" id="harga-min">
            <label class="form-check-label" for="harga-min">Harga Minimal</label>
        </div>
    </form>


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
    <form action="#" id="search" method="POST">
        @csrf
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-name" role="tabpanel" aria-labelledby="pills-name-tab">
                <div class="input-group search">
                    <input type="text" name="searchvalue" id="searchvalue" class="form-control input-search" placeholder="Nama Barang">
                    <button class="btn btn-default" id="search_button" name="search_button" type="submit"><img class="icon-search" src="./svg/magnifying-glass.svg"></button>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-link" role="tabpanel" aria-labelledby="pills-link-tab">
                <div class="input-group search">
                    <input type="text" class="form-control input-search" placeholder="Link Barang">
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
            @for ($i = 0; $i < 10; $i++)
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
                <div class="carousel-item col-md-3 active">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/f44242/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 1</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/418cf4/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 2</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/3ed846/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 3</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/42ebf4/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 4</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/f49b41/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 5</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/f4f141/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 6</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item col-md-3">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/800x600/8e41f4/fff">
                        <div class="card-body">
                            <h4 class="card-title">Card 7</h4>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text">This is a card content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev left" href="#Item-list-Shopee" role="button" data-slide="prev">
                <img class="icon-next" src="./svg/chevron-left.svg">
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next right" href="#Item-list-Shopee" role="button" data-slide="next">
                <img class="icon-next" src="./svg/chevron-right.svg">
                <span class="sr-only">Next</span>
            </a>
            <div id="postRequestData"></div>
        </div>
    </div>
</div>
<script src="js/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function(){
        $('.search_button').click(function(){
            var search = $('#searchvalue').val();
            $.ajax({
                type: "POST",
                url: "home",
                data: search,
            }).done(function(msg){
                alert('Data sent! ' + msg);
                
            });
        });
    });
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    // $(document).ready(function(){
    //     $('#search').submit(function(){
    //         var search = $('#searchvalue').val();
    //         $.ajax({
    //             type: "POST",
    //             url: "searchdata",
    //             data: search,
    //             success: function(data){
    //                 console.log(data)
    //                 $('#postRequestData').html(data);
    //             }
    //         });
    //     });
    // });
</script>
@endsection