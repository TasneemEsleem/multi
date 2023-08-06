@extends('parent')
@section('title','Dashboard')
@section('lg_title','Edit Category||Subcategory')
@section('main_title','Category||Subcategory')
@section('sm_title','Edit Category||Subcategory')
@section('content')

<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Edit Category||Subcategory</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter Name" value="{{$category->name}}">
        </div>

        <div class="form-group">
            <label for="parent_id"> Parent</label>
            <select class="form-control" id="parent_id">
                <option value="">No Parent</option>
                @foreach ($parents as $parent)
                <option value="{{$parent->id}}" @selected($parent->id == old('parent_id', $category->parent_id))>{{$parent->name}}</option>

              @endforeach
            </select>
          </div>

        <div class="card-footer">
          <button type="button" onclick="performUpdate('{{$category->id}}')" class="btn btn-primary">Save</button>
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
      axios.post('/categories/{{$category->id}}',{
        _method: 'PUT',
        name: document.getElementById('name').value,
        parent_id: document.getElementById('parent_id').value ,
    })
      .then(function(response) {
        console.log(response);
        toastr.success(response.data.message);
        window.location.href = '/categories';
      })
      .catch(function(error) {
        console.log(error.response);
        toastr.error(error.response.data.message);
      });
  }
</script>
@endsection
