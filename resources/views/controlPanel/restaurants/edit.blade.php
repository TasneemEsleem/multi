@extends('parent')
@section('title','Dashboard')
@section('lg_title','Edit Restaurant')
@section('main_title','Restaurant')
@section('sm_title','Edit Restaurant')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Edit Restaurant</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter Name" value="{{$restaurant->name}}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" placeholder="Enter Address" value="{{$restaurant->address}}">
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter Email" value="{{$restaurant->email}}">
          </div>

          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" maxlength="10" pattern="\d{10}" id="phone" placeholder="Enter Phone" value="{{$restaurant->phone}}">
          </div>

          <div class="form-group">
            <label for="openingHours">Opening Hours</label>
            <input type="text" class="form-control" id="openingHours" placeholder="Enter openingHours" value="{{$restaurant->openingHours}}">
          </div>


        <div class="card-footer">
          <button type="button" onclick="performUpdate('{{$restaurant->id}}')" class="btn btn-primary">Save</button>
        </div>
    </form>
  </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script>
   function performUpdate(id) {
      axios.post('/restaurants/{{$restaurant->id}}',{
        _method: 'PUT',
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        openingHours: document.getElementById('openingHours').value ,
    })
      .then(function(response) {
        console.log(response);
        toastr.success(response.data.message);
        window.location.href = '/restaurants';
      })
      .catch(function(error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
      });
  }
</script>
@endsection
