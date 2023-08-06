@extends('parent')
@section('title','Dashboard')
@section('lg_title','restaurant')
@section('main_title','View Trashed')
@section('sm_title','Trashed Resaurants')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Trashed Resaurants</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th style="width: 20%">Setting</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($restaurants as $restaurant)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$restaurant->name}}</td>
                                    <td>{{$restaurant->address}}</td>
                                    <td>
                                        <div class="btn-group">
                                                <a href="#" onclick="confirmRestore('{{$restaurant->id}}', this)" class="btn btn-primary">
                                                    <i class="fas fa-undo"></i>
                                                  </a>
                                                <a href="#" onclick="confirmForceDelete('{{$restaurant->id}}')" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                  </a>
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
function confirmRestore(id, reference) {
  Swal.fire({
    title: 'Are you sure?',
    text: "To restore this resaurants!",
    icon: 'warning',
    showCancelButton: true,
    cancelButtonColor: '#d33',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Yes, restore it!'
  }).then((result) => {
    if (result.isConfirmed) {
      performRestore(id, reference);
    }
  });
}
function performRestore(id, reference) {
  axios.post(`/restaurants/${id}/restore`)
    .then(response => {
      console.log('restaurant restored:', response.data);
      window.location.href = '/restaurants';

    })
    .catch(error => {
      console.error('Error restoring Resaurants:', error);
    });
}

  function confirmForceDelete(restaurantId) {
    Swal.fire({
      title: 'Are you sure To Delete it?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#d33',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        performForceDelete(restaurantId);
      }
    });
  }

  function performForceDelete(restaurantId) {
    axios.delete(`/restaurants/${restaurantId}/forceDelete`)
      .then(response => {
        console.log('Resaurants deleted Successfully:', response.data);
        window.location.href = '/restaurants';
      })
      .catch(error => {
        console.error('Error performing forcedelete:', error);
      });
  }

</script>
@endsection
