@extends('landingPage.parent')
@section('contents')
    <div class="ps-products-wrap pt-80 pb-80">
        <div class="ps-products" data-mh="product-listing">
            <div class="ps-product-action">
                <div class="ps-product__filter">
                    <form id="searchForm" method="GET" action="{{ route('OrderItem') }}">
                        <select class="ps-select selectpicker" name="restaurant_id">
                            <option value="">All Restaurants</option>
                            @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" @if ($selected_restaurant == $restaurant->id) selected @endif>
                                    {{ $restaurant->name }}
                                </option>
                            @endforeach
                        </select>
                        <button class="ps-btn ps-btn--fullwidth" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="ps-product__columns">
                @foreach ($items as $item)
               <div class="ps-product__column">
                            <div class="ps-shoe mb-20">
                                <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="{{route('item.show' , $item->id)}}"><i
                                            class="ps-icon-shopping-cart"></i></a>
                                            <a  href="{{route('item.show' , $item->id)}}">  <img src="{{ Storage::url($item->image) }}" alt=""></a>
                                <a class="ps-shoe__overlay"
                                        href="{{route('item.show' , $item->id)}}"></a>
                                </div>
                                <div class="ps-shoe__content">
                                    <div class="ps-shoe__detail"><a class="ps-shoe__name"
                                            href="{{route('item.show' , $item->id)}}">{{ $item->name }}</a>

                                        <p class="ps-shoe__categories">
                                            @foreach ($item->categories as $category)
                                                <a href="#">{{ $category->name }}</a>
                                            @endforeach
                                        </p><span class="ps-shoe__price">{{ $item->price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>


   </script>
@endsection
