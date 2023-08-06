@extends('parent')
@section('title','Dashboard')
@section('lg_title','Edit Data Entry')
@section('main_title','Data Entry')
@section('sm_title','Edit Data Entry')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Edit Data Entry</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter Name" value="{{$dataentry->name}}">
        </div>

        <div class="form-group">
            <label for="name">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter Email" value="{{$dataentry->email}}">
          </div>


        <div class="card-footer">
          <button type="button" onclick="performUpdate('{{$dataentry->id}}')" class="btn btn-primary">Save</button>
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
      axios.post('/dataentries/{{$dataentry->id}}',{
        _method: 'PUT',
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
    })
      .then(function(response) {
        console.log(response);
        toastr.success(response.data.message);
        window.location.href = '/dataentries';
      })
      .catch(function(error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
      });
  }
</script>
@endsection
