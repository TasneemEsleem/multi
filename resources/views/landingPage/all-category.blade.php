@extends('landingPage.parent')
@section('contents')
    <div class="ps-blog-grid pt-80 pb-80">
        <h1 style="text-align: center; color:darkolivegreen;">Categories for {{ $restaurant->name }}</h1>
        <div class="ps-container">
            <div class="row">
                @foreach ($restaurant->categories as $category)
                    @if ($category->items->count() > 0)
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                            <div class="ps-post mb-30">
                                <div class="ps-post__thumbnail"><a class="ps-post__overlay"
                                        href="{{ route('category.item', $category->id) }}"></a>
                                        <img src="{{ asset('assets/images/background/dinner-table-salads-steaks-fries.jpg') }}"
                                         alt="Image" style="width: 80px; height: 80px; border-radius: 50%;">

                                </div>
                                <div class="ps-post__content"><a class="ps-post__title"
                                        href="{{ route('category.item', $category->id) }}">{{ $category->name }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
