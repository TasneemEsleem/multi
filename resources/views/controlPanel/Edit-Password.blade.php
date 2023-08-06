@extends('parent')
@section('title','Dashboard')
@section('lg_title','Change Password')
@section('main_title','Profile')
@section('sm_title','Change Password')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Change Password</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
      @csrf
      <div class="card-body">
        <div class="form-group">
            <label for="password">Current Password</label>
            <input type="password" class="form-control" id="current_password" placeholder="Enter Your Password">
          </div>
          <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" id="new_password" placeholder="Enter Your Password">
          </div>
          <div class="form-group">
            <label for="name">Confirm Your Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" placeholder="Confirm Password">
          </div>
        <div class="card-footer">
          <button type="button" onclick="performStore()" class="btn btn-primary">Save</button>
        </div>
    </form>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script>
  function performStore() {

    let data = {
        password: document.getElementById('current_password').value,
        new_password: document.getElementById('new_password').value,
        new_password_confirmation: document.getElementById('new_password_confirmation').value,
    };
    axios.post('/Update-Password', data).then(function(response) {
            console.log('200');
            window.location.href = '/home';
        })
        .catch(function(error) {
            console.log(error);
            toastr.error(error.response.data.message)
        });
}
</script>
@endsection
