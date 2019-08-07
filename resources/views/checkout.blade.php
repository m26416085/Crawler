@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
    <h3>Keranjang</h3>
    @if(count($cartCollection) > 1)
    <!-- data from cart -->
    <div class="item-container-cart">
        <h1 class="text-center mb-3">Tekan simpan untuk melanjutkan</h1>
        <div id="Item-list-cart" class="carousel slide" data-interval="false" data-ride="carousel">
            <?php $counter = 0; ?>
            <!-- Cards -->
            <div class="carousel-inner row mx-auto">
                @foreach ($cartCollection as $cart)
                @if ($cart['name'] != 'asdfghjklkjgfds123890ythbnvdkodetokopediafwgheu3yr2t3r64ortfg')
                @if ($counter==0)
                <div class="carousel-item carousel-item-list col-md-3 active">
                    <?php $counter = 1; ?>
                    @elseif ($counter==1)
                    <div class="carousel-item carousel-item-list col-md-3">
                        @endif
                        <a target="_blank" href="{{$cart['attributes']['product_url']}}">
                            <div class="card item">
                                <img class="card-img-top img-fluid" src="{{$cart['attributes']['image_url']}}">
                                <div class="card-body">
                                    <h4 class="card-title">{{$cart['name']}}</h4>
                                    <p class="card-text">Rp. {{number_format($cart['price'],0,",",".")}}</p>
                                    <p class="card-text">{{$cart['attributes']['shop_name']}}</p>
                                    <p class="card-text">{{$cart['attributes']['shop_location']}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#Item-list-cart" role="button" data-slide="prev">
                    <img class="icon-prev" src="./svg/chevron-left.svg">
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#Item-list-cart" role="button" data-slide="next">
                    <img class="icon-next" src="./svg/chevron-right.svg">
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <form method="POST" action="/itemlist">
            @csrf
            <button class="btn btn-primary btn-save" name="save" type="submit">Simpan</button>
        </form>
    </div>
    @endif
</div>
</div>
</div>


@endsection