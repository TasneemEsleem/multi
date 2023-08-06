@extends('landingPage.parent')
@section('contents')

<div class="ps-content pt-80 pb-80">
    <div class="ps-container">
      <div class="ps-cart-listing">
        <table class="table ps-cart__table">
          <thead>
            <tr>
              <th>All Items</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cart as $item )
            <tr>
              <td><a class="ps-product__preview" href="{{route('item.show', $item->item->id)}}"><img class="mr-10" height="100" src="{{Storage::url($item->item->image)}}" alt="">{{$item->item->name}} </a></td>
              <td>${{$item->item->price}}</td>
              <td>
                <div class="form-group--number">
                  <button class="minus"><span>-</span></button>
                  <input class="form-control" type="text" value="{{$item->quantity}}">
                  <button class="plus"><span>+</span></button>
                </div>
              </td>
              <td>${{$item->quantity * $item->item->price}}</td>
              <td>
                <div class="ps-remove"></div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="ps-cart__actions">
          <div class="ps-cart__promotion">
            <div class="form-group">
              <div class="ps-form--icon"><i class="fa fa-angle-right"></i>
                <input class="form-control" type="text" placeholder="Promo Code">
              </div>
            </div>
            <div class="form-group">
              <a class="ps-btn ps-btn--gray" href="{{route('OrderItem')}}">Continue Shopping</a>
            </div>
          </div>
          <div class="ps-cart__total">
            <h3>Total Price: <span> {{$total_amount}} $</span></h3><a class="ps-btn" href="{{route('ViewCheckout')}}">Process to checkout<i class="ps-icon-next"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>



@endsection
