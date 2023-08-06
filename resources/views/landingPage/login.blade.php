@extends('landingPage.parent')
@section('title','Login')
@section('contents')
<div class="slider-wrap">
    <div class="slider-item" style="background-image: url('{{asset('assets/img/hero_1.jpg')}}">

      <div class="container">
        <div class="row slider-text align-items-center justify-content-center">
          <div class="col-md-8 text-center col-sm-12 ">
            <h1 data-aos="fade-up">Login  in the Vendor Restaurant</h1>
           </div>
        </div>
      </div>

    </div>
  <!-- END slider -->
  </div>
<div class="ps-products-wrap pt-80 pb-80">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <form id="create-form">
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control ">
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control ">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                <button type="button" class="btn btn-primary" onclick="login()" >Login</button>
                {{-- <button type="button"  value="Register" class="btn btn-primary"> --}}
              </div>
              <p>You Dont Have Account ?? <span style="color: green;"><a href="{{route('register')}}">Register Now</span></p>
            </div>
          </form>
        </div>

      </div>
    </div>
</div>
  <script>
      function login() {
          let data = {
              email: document.getElementById('email').value,
              password: document.getElementById('password').value,
          };
          axios.post('/login', data).then(function(response) {
                 console.log(response);
                 toastr.success(response.data.message);
                 window.location.href = '/home';
              })
              .catch(function(error) {
                  console.log(error);
                  toastr.error(error.response.data.message)
              });
      }
  </script>

@endsection
