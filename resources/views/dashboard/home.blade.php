@extends('master')

@section('content')
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
                                <td>{{$property->deed}}</td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transfer-{{$property->id}}"><i class="fa fa-arrow-right"> Transfer</i></button>
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
                                <td>{{$property->deed}}</td>
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
