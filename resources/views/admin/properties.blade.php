@extends('master')

@section('content')
    <div class="row" style="margin-top: 3%" xmlns="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All properties</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="properties" class="table table-bordered table-hover" style="text-align: center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Size</th>
                            <th>Owner ID</th>
                            <th>Status</th>
                            <th>Deed</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($properties as $property)
                            <tr>
                                <td>{{$property->id}}</td>
                                <td>{{$property->address}}</td>
                                <td>{{$property->size}}</td>
                                <td>{{$property->user_id}}</td>
                                <td>{{empty($property->transfer_user_id) ? '-' : 'Pending transfer to ' . $property->transfer_user_id}}</td>
                                @if(!empty($property->deed))
                                    <td><a class="btn btn-success" href="{{route('properties.deed', $property->id)}}"><i class="fa fa-download"> Get Deed</i></a></td>
                                @else
                                    <td>-</td>
                                @endif
                            </tr>
                        @endforeach
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('#properties').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
