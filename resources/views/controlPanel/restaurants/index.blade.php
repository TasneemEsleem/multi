@extends('parent')
@section('title', 'Dashboard')
@section('lg_title', 'Restaurants')
@section('main_title', 'View Restaurants')
@section('sm_title', 'All Restaurants')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Index Restaurants</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Opening Hours</th>
                                        <th style="width: 20%">Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($restaurants as $restaurant)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $restaurant->name }}</td>
                                            <td>{{ $restaurant->address }}</td>
                                            <td>{{ $restaurant->openingHours }}</td>
                                            <td>
                                                @canany(['Update-Restaurant', 'Delete-Restaurant'])
                                                    <div class="btn-group">
                                                        @can('Update-Restaurant')
                                                            <a href="{{ route('restaurants.edit', $restaurant->id) }}"
                                                                class="btn btn-warning btn-flat">
                                                                <i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('Delete-Restaurant')
                                                            <a href="#" onclick="confirmDelete('{{ $restaurant->id }}', this)"
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
                text: "To Trashed it!",
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
            axios.delete('/restaurants/' + id)
                .then(function(response) {
                    console.log(response);
                    reference.closest('tr').remove();
                    showMessage({
                        title: 'Trashed Success!',
                        text: 'The restaurant has been Trashed.',
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
