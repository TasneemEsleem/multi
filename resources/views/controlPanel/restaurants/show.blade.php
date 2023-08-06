@extends('parent')
@section('title','Dashboard')
@section('lg_title','Restaurant')
@section('main_title','Show Restaurant')
@section('sm_title','Restaurant')
@section('content')
 <!-- Main content -->
 <section class="content">
 <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Name :{{$restaurant->name}}</h3>
        @canany(['Update-Restaurant', 'Delete-Restaurant'])
        <div class="card-tools">
            @can('Delete-Restaurant')
          <button type="button" class="btn btn-tool">
            <a href="#" onclick="confirmDelete('{{$restaurant->id}}', this)" class="btn btn-danger">
                <i class="fas fa-trash"></i></a>
          </button>
          @endcan
           @can('Update-Restaurant')
          <button type="button" class="btn btn-tool" >
            <a href="{{route('restaurants.edit', $restaurant->id)}}" class="btn btn-warning btn-flat">
                <i class="fas fa-edit"></i></a>
          </button>
          @endcan
          @endcanany
        </div>
      </div>
      <div class="card-body">
      Email :  {{$restaurant->email}}
    </div>
    <div class="card-body">
        Phone :  {{$restaurant->phone}}
      </div>
      <div class="card-body">
        Opening Hours :  {{$restaurant->openingHours}}
      </div>

      <div class="card-body">
        Address :  {{$restaurant->address}}
      </div>
      <!-- /.card-body -->
      <div class="card-footer">

      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
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
        axios.delete('/restaurants/' + id)
            .then(function(response) {
                console.log(response);
                reference.closest('tr').remove();
                showMessage({
                title: 'Deleted Success!',
                text: 'The restaurant has been Deleted.',
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

