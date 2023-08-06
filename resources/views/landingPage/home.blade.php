@extends('landingPage.parent')
@section('title', 'Home')
@section('cart-content')
<div class="ps-cart"><a class="ps-cart__toggle" href="{{route('chat.view')}}"><span><i>{{ $cart->count() }}</i></span>
    <i class="fa-brands fa-rocketchat"></i></a>
</div>

    <div class="ps-cart"><a class="ps-cart__toggle" href="#"><span><i>{{ $cart->count() }}</i></span>
            <i class="ps-icon-shopping-cart"></i></a>
        <div class="ps-cart__listing">
            <div class="ps-cart__content">
                @foreach ($cart as $item)
                    <div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>
                        <div class="ps-cart-item__thumbnail"><a href="{{ route('item.show', $item->item->id) }}"></a>
                            <img src="{{ Storage::url($item->item->image) }}" alt="">
                        </div>
                        <div class="ps-cart-item__content"><a class="ps-cart-item__title"
                                href="{{ route('item.show', $item->item->id) }}">{{ $item->item->name }}</a>
                            <p><span>Quantity:<i>{{ $item->quantity }}</i></span><span>Total:<i>£
                                @php
                                    $amount = $item->quantity * $item->item->price;
                                @endphp {{ $amount }}</i></span></p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="ps-cart__total">
                <p>Number of items:<span>{{ $cart->count() }}</span></p>
                <p>Item Total:<span>£{{ $total_amount }}</span></p>
            </div>
            <div class="ps-cart__footer"><a class="ps-btn" href="{{ route('ViewCheckout') }}">Check out<i
                        class="ps-icon-arrow-left"></i></a></div>
        </div>
    </div>

@endsection


