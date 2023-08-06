@extends('parent')
@section('title', 'Dashboard')
@section('lg_title', 'Edit Item')
@section('main_title', 'Item')
@section('sm_title', 'Edit Item')
@section('content')

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Item</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create-form">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="categories">Category</label>
                        <select class="form-control" name="categories[]" id="categories" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(in_array($category->id, $selectedCategories)) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name"
                            value="{{ $item->name }}">
                    </div>

                    <div class="form-group">
                        <label for="price">price</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter the Name"
                            value="{{ $item->price }}">
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image">
                    </div>
                    <img class="card-img img-fluid mb-1" style="height:150px; width: 150px; " src="{{Storage::url($item->image)}}">
                    </div>
                    </div>


                    <div class="card-footer">
                        <button type="button" onclick="performUpdate('{{ $item->id }}')"
                            class="btn btn-primary">Save</button>
                    </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        function performUpdate(id) {
            const selectedCategories = Array.from(document.querySelectorAll('#categories option:checked')).map(option => option.value);

            var formData = new FormData();
        formData.append('name',document.getElementById('name').value);
        formData.append('price',document.getElementById('price').value);
        formData.append('categories', JSON.stringify(selectedCategories));
        if (document.getElementById('image').files[0] != undefined) {
            formData.append('image', document.getElementById('image').files[0]);
        }
        formData.append('_method', 'PUT');
        axios.post('/items/{{ $item->id }}', formData)
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = '/items';
                })
                .catch(function(error) {
                    console.log(error.response);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
