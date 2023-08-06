@extends('landingPage.parent')
@section('contents')
<div class="ps-blog-grid pt-80 pb-80">
    <div class="ps-container">
      <div class="row">
        @foreach ($restaurants as $restaurant)
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
              <div class="ps-post mb-30">
                <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="{{route('restaurant.category' , $restaurant->id )}}"></a>
                    <img src="{{asset('assets/images/background/356587-PBGO2Y-542.jpg')}}" height="100" alt="">
                </div>
                <div class="ps-post__content"><a class="ps-post__title" href="{{route('restaurant.category' , $restaurant->id )}}">{{ $restaurant->name }}</a>
                  <p class="ps-post__meta"><span>Address:<a class="mr-5" href="{{route('restaurant.category' , $restaurant->id )}}">{{ $restaurant->address }}</a>
                </span>- Gmail:<span class="ml-5">{{$restaurant->email}}</span>
                - Phone: <span class="ml-5">{{$restaurant->phone}}</span></p>
                  <p>Opening Hours :{{$restaurant->openingHours}}</p>
                  </div>
              </div>
            </div>
            @endforeach
      </div>
    </div>
</div>



@endsection
