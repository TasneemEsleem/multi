@extends('parent')
@section('title', 'Dashboard')
@section('lg_title', 'Create Item')
@section('main_title', 'Item')
@section('sm_title', 'Create Item')
@section('content')

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Item</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create-form" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="categories[]" id="categories" multiple>
                            <option>Select Category</option>
                            @foreach ($categories as $category)
                            @if ($category->children->isNotEmpty())
                            @continue
                                {{-- @foreach ($category->children as $child) --}}
                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                {{-- @endforeach --}}
                                @endif
                                <option value="{{$category->id}}">{{ $category->name }}</option>
                        @endforeach
                        </select>
                    </div>
                        </div>
                        <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter the Name"
                            value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="price">price</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter the Name"
                            value="{{ old('name') }}">
                    </div>
                        </div>
                        <div class="col-sm-6 col-12">

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" value="{{ old('image') }}">
                    </div>
                        </div>
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
    <script src="{{ asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script type="text/javascript">
    function performStore() {
        const selectedCategories = Array.from(document.querySelectorAll('#categories option:checked')).map(option => option.value);
        var formData = new FormData();
        formData.append('name',document.getElementById('name').value);
        formData.append('price',document.getElementById('price').value);
        formData.append('categories', JSON.stringify(selectedCategories));
        if (document.getElementById('image').files[0] != undefined) {
            formData.append('image', document.getElementById('image').files[0]);
        }
        axios.post('/items', formData)
            .then(function(response) {
                console.log(response);
                toastr.success(response.data.message);
                //  document.getElementById('create-form').reset();
                window.location.href = '/items';
            })
            .catch(function(error) {
                console.log(error.response);
                toastr.error(error.response.data.message);
            });
    }
    </script>
@endsection
