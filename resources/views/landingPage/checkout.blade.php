@extends('landingPage.parent')
@section('contents')
<div class="ps-checkout pt-80 pb-80">
    <div class="ps-container">
      <form class="ps-checkout__form">
        @csrf
        <div class="row">
              <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                <div class="ps-checkout__billing">
                  <h3>Billing Detail</h3>
                        <div class="form-group form-group--inline">
                          <label>First Name<span>*</span>
                          </label>
                          <input class="form-control" value="{{old('first_name' ,$user->name)}}" type="text" id="first_name">
                        </div>
                        <div class="form-group form-group--inline">
                          <label>Last Name<span>*</span>
                          </label>
                          <input class="form-control" value="{{old('last_name' ,$user->name)}}" type="text" id="last_name">
                        </div>

                        <div class="form-group form-group--inline">
                          <label>Email Address<span>*</span>
                          </label>
                          <input class="form-control" value="{{old('email' ,$user->email)}}" type="email" id="email">
                        </div>

                        <div class="form-group form-group--inline">
                          <label>Phone<span>*</span>
                          </label>
                          <input class="form-control" value="{{old('phone')}}" type="text" id="phone">
                        </div>
                        <div class="form-group form-group--inline">
                          <label>Address<span>*</span>
                          </label>
                          <input class="form-control" value="{{old('address')}}" type="text" id="address">
                        </div>
                  {{-- <div class="form-group">
                    <div class="ps-checkbox">
                      <input class="form-control" type="checkbox" id="cb01">
                      <label for="cb01">Create an account?</label>
                    </div>
                  </div> --}}
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                <div class="ps-checkout__order">
                  <header>
                    <h3>Your Order</h3>
                  </header>
                  <div class="content">
                    <table class="table ps-checkout__products">
                      <thead>
                        <tr>
                          <th class="text-uppercase">Product</th>
                          <th class="text-uppercase">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($cart as $item )
                        <tr>
                          <td>{{$item->item->name}} x {{$item->quantity}}</td>
                          @php
                              $amount = $item->quantity * $item->item->price;
                          @endphp
                          <td>{{$amount}}$</td>
                        </tr>
                        @endforeach
                        <tr>
                          <td>Order Total</td>
                          <td>{{$total_amount}}$</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <footer>
                    <h3>Payment Method</h3>

                    <div class="form-group paypal">
                      <div class="ps-radio ps-radio--inline">
                        <label for="rdo02">Strip</label>
                      </div>

                      <button type="button" onclick="PerformStore()" class="ps-btn ps-btn--fullwidth">Place Order<i class="ps-icon-next"></i></button>
                    </div>
                  </footer>
                </div>

              </div>
        </div>
      </form>
    </div>
  </div>
  <script>
    function PerformStore() {
        let data = {
            email: document.getElementById('email').value,
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
        };
        axios.post('/checkout/store', data)
        .then(function(response) {
               console.log(response);
               toastr.success(response.data.message);
               const order_id = response.data.order_id;
               window.location.href = '/order/' + order_id + '/payment';
            })
            .catch(function(error) {
                console.log(error);
                toastr.error(error.response.data.message)
            });
    }
</script>










@endsection
