@extends('landingPage.parent')
@section('contents')
<div class="test">
    <div class="container">
      <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 ">
            </div>
      </div>
    </div>
  </div>
  <div class="ps-product--detail pt-60">
    <div class="ps-container">
      <div class="row">
        <div class="col-lg-10 col-md-12 col-lg-offset-1">
          <div class="ps-product__thumbnail">

            <div class="ps-product__image">
              <div class="item"><img class="zoom" height="300" width="200" src="{{ Storage::url($item->image) }}" alt="" ></div>
              </div>
          </div>

          <div class="ps-product__info">

            <h1>{{$item->name}}</h1>
            <p class="ps-product__category"><a href="#">
                @foreach ($item->categories as $category)
                <a href="#">{{ $category->name }} ,
                @endforeach </a>
           </p>
            <h3 class="ps-product__price">£ {{$item->price}} </h3>
            <div class="ps-product__block ps-product__quickview">
              <h4>Description Of Item</h4>
              <p>{{$item->description ?? ''}}</p>
            </div>
            <form>
                @csrf
            <div class="form-group">
                <label>Quantity </label>
                <input type="number" class="form-control" id="quantity">
            </div>
            <input type="hidden" id="item_id" value="{{$item->id}}">
            <div class="ps-product__shopping">
                <button type="button" class="ps-btn mb-10" onclick="PerformStore()">Add to cart<i class="ps-icon-next"></i></button>
            </div>

            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="clearfix"></div>

<script>
function PerformStore() {
            axios.post('/cart/store', {
                    item_id: document.getElementById('item_id').value,
                    quantity: document.getElementById('quantity').value,
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = '/cart';
                })
                .catch(function(error) {
                    console.log(error.response);
                    toastr.error(error.response.data.message);
                });
        }
    </script>

@endsection
