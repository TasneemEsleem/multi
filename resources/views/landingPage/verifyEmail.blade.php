@extends('landingPage.parent')
@section('title','VerifyEmail')
@section('contents')

<section class="section  pt-5 top-slant-white2 relative-higher bottom-slant-gray">

    <div class="container">
      <div class="row">
        <div class="col-lg-6">
            <div class="row">

              <div class="col-md-6 form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control ">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                <button type="button" class="btn btn-primary" onclick="verify()" >Verify Email</button>
              </div>
            </div>
        </div>
      </div>
    </div>

  </section>
  <script>
    function verify() {
        axios.get('/send-verification')
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
