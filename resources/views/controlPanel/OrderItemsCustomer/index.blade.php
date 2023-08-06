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
                                        <th>Name of Item</th>
                                        <th>Price</th>
                                        <th>Total Quantity</th>
                                        <th>Calculate(شيكل)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            @php $itemNames = []; @endphp
                                            @foreach ($orderItems as $index => $orderItem)
                                            @php
                                            $itemName = $orderItem->item ? $orderItem->item->name : null;
                                        @endphp
                                        @if ($itemName && !in_array($itemName, $itemNames))
                                            <tr>
                                                <td>{{$loop->index +1}}</td>
                                                <td>{{ $itemName }}</td>
                                                <td>{{ $orderItem->item->price }}</td>
                                                <td>
                                                     {{ $item_quantities[$orderItem->item->name] ?? 0 }}
                                                </td>
                                                <td>
                                                    @php
                                                        $total = $orderItem->item->price * ($item_quantities[$orderItem->item->name] ?? 0);
                                                    @endphp
                                                    {{ $total }}
                                                </td>
                                                @php $itemNames[] = $itemName; @endphp
                                                @endif
                                                @endforeach
                                            </tr>
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
