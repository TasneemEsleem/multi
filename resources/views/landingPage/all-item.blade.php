@extends('landingPage.parent')
@section('contents')
    <div class="ps-blog-grid pt-80 pb-80">
        <div class="ps-container">
            <div class="row">
                <h2 style="text-align: center; color:darkolivegreen;">Items for : {{ $category->name }}</h2>
                @foreach ($category->items as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                        <div class="ps-post mb-30">
                            <div class="ps-post__thumbnail">
                                <a class="ps-post__overlay" href="{{ route('item.show', $item->id) }}"></a>
                                <img src="{{ Storage::url($item->image) }}" height="200" alt="">
                            </div>
                            <div class="ps-post__content"><a class="ps-post__title"
                                    href="{{ route('item.show', $item->id) }}">{{ $item->name }}</a>
                                </span>Price :: <span class="ml-5">{{ $item->price }}</span>
                                -<span class="ml-5">{{ $item->description ?? '' }}</span></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
