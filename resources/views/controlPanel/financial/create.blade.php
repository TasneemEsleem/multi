@extends('parent')
@section('title','Dashboard')
@section('lg_title','Create Financial')
@section('main_title','Financial')
@section('sm_title','Create Financial')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Create Financial</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
      @csrf
      <div class="card-body">

        <div class="form-group">
            <label for="name">name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter the Name" value="{{old('name')}}">
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter the Email" value="{{old('email')}}">
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

    axios.post('/financials',{
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
    })
      .then(function(response) {
        console.log(response);
        toastr.success(response.data.message);
        //  document.getElementById('create-form').reset();
        window.location.href = '/financials';
      })
      .catch(function(error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
      });
  }
</script>
@endsection
