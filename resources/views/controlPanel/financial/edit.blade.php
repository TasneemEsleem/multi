@extends('parent')
@section('title','Dashboard')
@section('lg_title','Edit Financial')
@section('main_title','Financial')
@section('sm_title','Edit Financial')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Edit Financial</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter Name" value="{{$financial->name}}">
        </div>

        <div class="form-group">
            <label for="name">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter Email" value="{{$financial->email}}">
          </div>


        <div class="card-footer">
          <button type="button" onclick="performUpdate('{{$financial->id}}')" class="btn btn-primary">Save</button>
        </div>
    </form>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script>
   function performUpdate(id) {
      axios.post('/financials/{{$financial->id}}',{
        _method: 'PUT',
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
    })
      .then(function(response) {
        console.log(response);
        toastr.success(response.data.message);
        window.location.href = '/financials';
      })
      .catch(function(error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
      });
  }
</script>
@endsection
