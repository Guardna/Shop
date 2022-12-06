@extends('layouts.front')

@section('title')
    Contact
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
    <!-- Sadrzaj -->
    <div class="col-md-8">
    <br>
    @if(count($cartItems) == 0)
        <div class="container">
            <p class="lead">Your cart is empty.</p>
        </div>
    @else

            <div class="row">
                <div class="col-md-8 cart">
                    <div class="title">
                        <div class="row">
                            <div class="col">
                                <h4><b>Shopping Cart</b></h4>
                            </div>
                        </div>
                    </div>

                    @foreach($cartItems as $c)
                        <div class="row border-top border-bottom" id="cart_item_{{ $c->postId }}">
                            <div class="row main align-items-center">
                                <div class="col-2"><img class="img-fluid" src="{{ asset('/').$c->image }}"></div>
                                <div class="col">
                                    <div class="row text-muted">Name</div>
                                    <div class="row">{{ $c->name }}</div>
                                </div>
                                <div class="col"><input onchange="changeQuantity(this,{{ $c->price }}, {{ $c->postId }})" type="number" value="{{ $c->quantity }}"> </div>
                                <div class="col">&euro; <span class="product_price" id="span_price_{{ $c->postId }}">{{ $c->price * $c->quantity }}</span> <span onclick="removeFromCart({{$c->postId}})" class="close">&#10005;</span></div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="col-md-4 summary">
                    <div>
                        <h5><b>Summary</b></h5>
                    </div>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TOTAL PRICE</div>
                        <div class="col text-right">&euro; <span id="totalPrice"> </span></div>
                    </div> <button onclick="checkout(this)" class="btn">CHECKOUT</button>
                </div>
            </div>

    @endif
    <br>
    <br>
    <br>
    </div>
    <!--// Sadrzaj -->
@endsection
