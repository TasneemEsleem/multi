@extends('landingPage.parent')
@section('title','Register')
@section('contents')


<div class="slider-wrap">
    <div class="slider-item" style="background-image: url('{{asset('assets/img/hero_1.jpg')}}">

      <div class="container">
        <div class="row slider-text align-items-center justify-content-center">
          <div class="col-md-8 text-center col-sm-12 ">
            <h1 data-aos="fade-up">Register in the Vendor Restaurant</h1>
           </div>
        </div>
      </div>

    </div>
  <!-- END slider -->
  </div>


  <section class="section  pt-5 top-slant-white2 relative-higher bottom-slant-gray">

    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <form id="create-form">
            @csrf
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control ">
              </div>
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
                <button type="button" class="btn btn-primary" onclick="performStore()" >Register</button>
                {{-- <button type="button"  value="Register" class="btn btn-primary"> --}}
              </div>
              <p class="mb-0"> You Have Account??
                <span style="color: blue;"> <a href="{{route('loginCustomer')}}" class="text-center">Login</a>
              </p>
            </div>

          </form>
          @if (session('resent'))
          <div class="alert alert-success" role="alert">
              {{ __('A fresh verification link has been sent to your email address.') }}
          </div>
      @endif
        </div>

      </div>
    </div>

  </section>

  <script>
    function performStore() {
        var formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
        axios.post('/register', formData)
            .then(function(response) {
                console.log(response);
                toastr.success(response.data.message);
           })
            .catch(function(error) {
                console.log(error.response);
                toastr.error(error.response.data.message);
            });
    }
</script>

@endsection
