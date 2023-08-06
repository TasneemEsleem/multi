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
                                    <th>Assigned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->guard_name}}</td>
                                    <td>
                                        <div class="form-group clearfix">

                                            <div class="icheck-success d-inline">
                                              <input onclick="PerformUpdate('{{$permission->id}}')" type="checkbox"  id="permission{{$permission->id}}"
                                              @if ($permission->assigned)checked @endif>
                                              <label for="permission{{$permission->id}}">
                                              </label>
                                            </div>

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

<script>
function PerformUpdate(permissionId){
    axios.put('/roles/{{$role->id}}/permission',{
        permission_id: permissionId,
        role_id: {{ $role->id}},})
        .then(function(response) {
                console.log(response);
                toastr.success(response.data.message);
            })
            .catch(function(error) {
                console.log(error.response);
                toastr.error(error.response.data.message);
            });
}


</script>
@endsection

