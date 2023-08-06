@extends('parent')
@section('title','Dashboard')
@section('lg_title','Category||Subcategory')
@section('main_title','View Category||Subcategory')
@section('sm_title','All Category||Subcategory')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Index Category||Subcategory</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th style="width: 20%">Setting</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{ $category->parent->name }}</td>
                                    <td>
                                        <div class="btn-group">

                                            <a href="{{route('categories.edit', $category->id)}}" class="btn btn-warning btn-flat">
                                                <i class="fas fa-edit"></i></a>
                                            <a href="#" onclick="confirmDelete('{{$category->id}}', this)" class="btn btn-danger">
                                                <i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">No categories</td>
                                </tr>
                                @endif
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
        axios.delete('/categories/' + id)
            .then(function(response) {
                console.log(response);
                reference.closest('tr').remove();
                showMessage({
                title: 'Deleted Success!',
                text: 'The subCategory has been Deleted .',
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
