@extends('parent')
@section('title','Dashboard')
@section('lg_title','Edit Role')
@section('main_title','Role')
@section('sm_title','Edit Role')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Edit Role</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter Name" value="{{$role->name}}">
        </div>

        <div class="form-group">
            <label for="guard">User Type</label>
            <select class="form-control" id="guard">
              <option>Select Type Of User</option>
              <option value="user" @selected($role->guard_name == 'user')>User</option>
            </select>
          </div>


        <div class="card-footer">
          <button type="button" onclick="performUpdate('{{$role->id}}')" class="btn btn-primary">Save</button>
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
      axios.post('/roles/{{$role->id}}',{
        _method: 'PUT',
        name: document.getElementById('name').value,
        guard: document.getElementById('guard').value ,
    })
      .then(function(response) {
        console.log(response);
        toastr.success(response.data.message);
        window.location.href = '/roles';
      })
      .catch(function(error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
      });
  }
</script>
@endsection
