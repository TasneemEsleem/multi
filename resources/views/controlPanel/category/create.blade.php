@extends('parent')
@section('title','Dashboard')
@section('lg_title','Create Category||Subcategory')
@section('main_title','Category||Subcategory')
@section('sm_title','Create Category||Subcategory')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Create Category||Subcategory</h3>
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
          <label for="parent_id">No Parent</label>
          <select class="form-control" id="parent_id">
            <option value="">Select Category .....</option>
            @foreach ($parents as $parent )
            <option value="{{$parent->id}}">{{$parent->name}}</option>

            @endforeach
          </select>
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

    axios.post('/categories',{
        name: document.getElementById('name').value,
        parent_id: document.getElementById('parent_id').value ,
    })
      .then(function(response) {
        console.log(response);
        toastr.success(response.data.message);
        //  document.getElementById('create-form').reset();
        window.location.href = '/categories';
      })
      .catch(function(error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
      });
  }
</script>
@endsection
