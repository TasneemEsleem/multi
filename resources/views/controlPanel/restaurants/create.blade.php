@extends('parent')
@section('title', 'Dashboard')
@section('lg_title', 'Create Restaurant')
@section('main_title', 'Restaurant')
@section('sm_title', 'Create Restaurant')
@section('content')

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Restaurant</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create-form">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter the Name"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" value="{{ old('address') }}">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" maxlength="10" pattern="\d{10}"
                                    value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">

                            <div class="form-group">
                                <label for="openingHours">Opening Hours</label>
                                <input type="text" class="form-control" id="openingHours"
                                    value="{{ old('openingHours') }}">
                            </div>
                            <div class="form-group">
                                <h3>Information of Admin </h3>
                                <label for="user_id">Admin Name</label>
                                <select class="form-control" id="user_id">
                                    <option value="">Select Admin .....</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <button type="button" id="addAdminButton" class="btn btn-primary float-right">
                                <i class="fas fa-plus"></i>Add Admin
                            </button>

                            <div id="adminContainer" style="display: none;">
                                <div class="form-group">
                                    <label for="name_user">name</label>
                                    <input type="text" class="form-control" id="name_user" placeholder="Enter the Name"
                                        value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email_user">Email</label>
                                    <input type="email" class="form-control" id="email_user" value="{{ old('email') }}">
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        // Wait for the document to load
        document.addEventListener('DOMContentLoaded', function() {
            var addAdminButton = document.getElementById('addAdminButton');
            var adminContainer = document.getElementById('adminContainer');
            var userSelect = document.getElementById('user_id');

            addAdminButton.addEventListener('click', function() {
                if (adminContainer.style.display === 'none') {
                    adminContainer.style.display = 'block';
                    userSelect.style.display = 'none'; // Hide the select element
                } else {
                    adminContainer.style.display = 'none';
                    userSelect.style.display = 'block'; // Show the select element
                }
            });
        });
    </script>
    <script>
        function performStore() {

            axios.post('/restaurants', {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    address: document.getElementById('address').value,
                    openingHours: document.getElementById('openingHours').value,
                    user_id: document.getElementById('user_id').value,
                    name_user: document.getElementById('name_user').value,
                    email_user: document.getElementById('email_user').value,

                })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    //  document.getElementById('create-form').reset();
                    window.location.href = '/restaurants';
                })
                .catch(function(error) {
                    console.log(error.response);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
