@extends('parent')
@section('title', 'Dashboard')
@section('lg_title', 'Financial')
@section('main_title', 'View Financial')
@section('sm_title', 'All Financial')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Index Financial</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>Name</th>
                                        <th>Restaurant Name</th>
                                        <th style="width: 20%">Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($financials as $financial)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $financial->name }}</td>
                                            <td>{{$financial->restaurant->name ?? ''}}</td>
                                            <td>
                                                @canany(['Delete-Financial', 'Update-Financial'])
                                                    <div class="btn-group">
                                                        @can('Update-Financial')
                                                            <a href="{{ route('financials.edit', $financial->id) }}"
                                                                class="btn btn-warning btn-flat">
                                                                <i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('Delete-Financial')
                                                            <a href="#" onclick="confirmDelete('{{ $financial->id }}', this)"
                                                                class="btn btn-danger">
                                                                <i class="fas fa-trash"></i></a>
                                                        @endcan
                                                    </div>
                                                @endcanany
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
            axios.delete('/financials/' + id)
                .then(function(response) {
                    console.log(response);
                    reference.closest('tr').remove();
                    showMessage({
                        title: 'Deleted Success!',
                        text: 'The financial has been Deleted .',
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
