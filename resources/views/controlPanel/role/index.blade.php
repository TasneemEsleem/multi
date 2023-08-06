@extends('parent')
@section('title','Dashboard')
@section('lg_title','Role')
@section('main_title','View Role')
@section('sm_title','All Role')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Index Role</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Name</th>
                                    <th>User Type</th>
                                    <th>Permission</th>
                                    <th style="width: 20%">Setting</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->guard_name}}</td>

                                    <td>
                                        <a href="{{route('roles.editPermission',$role->id)}}"  class="btn btn-app bg-warning">
                                            <span class="badge bg-danger">{{$role->permissions_count}}</span>
                                            <i class="fas fa-heart"></i> Permission
                                          </a>
                                    <td>
                                        <div class="btn-group">

                                            <a href="{{route('roles.edit', $role->id)}}" class="btn btn-warning btn-flat">
                                                <i class="fas fa-edit"></i></a>
                                            <a href="#" onclick="confirmDelete('{{$role->id}}', this)" class="btn btn-danger">
                                                <i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('scripts')

<script>
    function confirmDelete(id, reference) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To Deleted it!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                performDelete(id, reference);

            }
        });
    }
    function performDelete(id, reference) {
        axios.delete('/roles/' + id)
            .then(function(response) {
                console.log(response);
                reference.closest('tr').remove();
                showMessage({
                title: 'Deleted Success!',
                text: 'The Role has been Deleted .',
                icon: 'success'
            });
            })
            .catch(function(error) {
                console.log(error.response);
                showMessage(error.response.data);
            });
    }

    function showMessage(data) {
        Swal.fire(
            data.title,
            data.text,
            data.icon
        );
    }
</script>
@endsection
