@extends('layouts.layout')

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Insert Air Data</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Air Data Elements
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @if(Session::has('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <strong>Well done!</strong> {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="col-lg-6">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="form-horizontal" method="post" action="{{ url('admin/store') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Time</label>
                                        <div class="col-sm-9">
                                            <input type="text" required class="form-control" id="datepicker"
                                                   name="date_time" placeholder="Insert date time" readonly
                                                   value="{{ old('date_time') ?:'' }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label">Location</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="location_id" required>
                                                @foreach($locations as  $location)
                                                    <option value="">Please Select a Location</option>
                                                    <option value="{{ $location->id }}"
                                                            @if(old('location_id') == $location->id) selected @endif> {{ $location->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label">Air Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="air_type_id" required>
                                                <option value="">Please Select Air Type</option>
                                                @foreach($air_types as  $air_type)
                                                    <option value="{{ $air_type->id }}"
                                                            @if(old('air_type_id') == $air_type->id) selected @endif> {{ $air_type->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Value</label>
                                        <div class="col-sm-9">
                                            <input type="text" required name="value" class="form-control"
                                                   placeholder="value" value="{{ old('value') ?:'' }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
