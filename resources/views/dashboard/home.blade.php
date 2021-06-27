@extends('master')

@section('content')
    <div class="row" style="margin-top: 3%">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-property"><i class="fa fa-plus"> Add property</i></button>
    </div>
    <div class="row" style="margin-top: 3%" xmlns="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My listings</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="properties" class="table table-bordered table-hover" style="text-align: center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Size</th>
                            <th>Deed</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($properties as $property)
                            <tr>
                                <td>{{$property->id}}</td>
                                <td>{{$property->address}}</td>
                                <td>{{$property->size}}</td>
                                @if(!empty($property->deed))
                                    <td><a class="btn btn-success" href="{{route('properties.deed', $property->id)}}"><i class="fa fa-download"> Get Deed</i></a></td>
                                @else
                                    <td>-</td>
                                @endif
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transfer-{{$property->id}}"><i class="fa fa-arrow-right"> Transfer</i></button></td>
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
    <div class="row" style="margin-top: 3%">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Property requests</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="property-requests" class="table table-bordered table-hover" style="text-align: center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Size</th>
                            <th>Deed</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transferRequests as $property)
                            <tr>
                                <td>{{$property->id}}</td>
                                <td>{{$property->address}}</td>
                                <td>{{$property->size}}</td>
                                @if(!empty($property->deed))
                                    <td><a class="btn btn-success" href="{{route('properties.deed', $property->id)}}"><i class="fa fa-download"> Get Deed</i></a></td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>
                                    <div style="text-align: center" class="row">
                                        <div class="col-md-6">
                                            <a class="btn btn-success" href="{{route('properties.approve', $property)}}"><i class="fa fa-check"> Approve</i></a>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-danger" href="{{route('properties.reject', $property)}}"><i class="fas fa-times"> Reject</i></a>
                                        </div>
                                    </div>
                                </td>
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

    @foreach($properties as $property)
        <!-- Modal -->
        <div class="modal fade" id="transfer-{{$property->id}}" tabindex="-1" role="dialog" aria-labelledby="transfer-{{$property->id}}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transfer-{{$property->id}}">Transfer {{$property->address}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('properties.initiateTransfer', $property->id)}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="vat">VAT no.</label>
                                <input type="text" class="form-control" id="vat" name="vat" aria-describedby="emailHelp" placeholder="Enter VAT no.">
                                <small id="vatHelp" class="form-text text-muted">Enter beneficiary VAT number.</small>
                            </div>
                            <button class="btn btn-primary" type="submit">Initiate transfer</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

{{--    Modal for new property--}}
    <!-- Modal -->
    <div class="modal fade" id="new-property" tabindex="-1" role="dialog" aria-labelledby="new-property" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-property">Add new property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('properties.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$user->id}}">
                        </div>
                        <div class="form-group">
                            <label for="address"></label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                            <small class="form-text text-muted">Enter the property's address</small>
                        </div>
                        <div class="form-group">
                            <label for="size"></label>
                            <input type="number" class="form-control" id="size" name="size" placeholder="Size">
                            <small class="form-text text-muted">Enter the property's size in m^2</small>
                        </div>
                        <div class="form-group">
                            <label for="deed_file"></label>
                            <input type="file" class="form-control" id="deed_file" name="deed_file" placeholder="Upload deed">
                            <small class="form-text text-muted">Upload the property's deed</small>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit property</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
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

            $('#property-requests').DataTable({
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
