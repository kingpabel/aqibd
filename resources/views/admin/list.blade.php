@extends('layouts.layout')

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Air Data</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <strong>Well done!</strong> {{ Session::get('success') }}
                </div>
            @endif
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Air Data List
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Air Type</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($air_datas as $key => $air_data)
                                <tr>
                                    <th scope=row>{{ $key+1 }}</th>
                                    <td>{{ $air_data->date_time }}</td>
                                    <td>{{ $air_data->location->name }}</td>
                                    <td>{{ $air_data->airType->name }}</td>
                                    <td>{{ $air_data->value }}</td>
                                    <td><a class="btn btn-success" href='{{ url("admin/$air_data->id/edit") }}'>Edit</a> </td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $air_datas->links() }}
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    </div>
@endsection