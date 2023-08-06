@extends('parent')
@section('title', 'Dashboard')
@section('lg_title', 'Item')
@section('main_title', 'View Item')
@section('sm_title', 'All Item')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Index Item</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th style="width: 20%">Setting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                            @foreach ($item->categories as $category)
                                               ** {{ $category->name }} **
                                                <br>
                                            @endforeach</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>

                                            <td>
                                                @canany(['Update-Item', 'Delete-Item'])
                                                    @can('Update-Item')
                                                        <div class="btn-group">
                                                            <a href="{{ route('items.edit', $item->id) }}"
                                                                class="btn btn-warning btn-flat">
                                                                <i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('Delete-Item')
                                                            <a href="#" onclick="confirmDelete('{{ $item->id }}', this)"
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
            axios.delete('/items/' + id)
                .then(function(response) {
                    console.log(response);
                    reference.closest('tr').remove();
                    showMessage({
                        title: 'Deleted Success!',
                        text: 'The item has been Deleted .',
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
