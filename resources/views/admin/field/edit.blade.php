@extends('layouts.adminApp')

@section('user-image')
    <img src="../../img/profile/user.png" id="user-profile" class="img-circle elevation-2" alt="User Image">
@endsection

@section('content')
    <div class="content-wrapper ">
        <div class="row  mt-4">
            <div class="col-md-8 m-auto">
                <!-- general form elements -->
                <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Edit Field</h3>
                </div>
                @if(session('status') == 'error')
                    <div class="alert alert-danger" role="alert">
                        Fail to update the Field. Please retry again.
                    </div>
                @endif
                <!-- /.card-header -->
                {!! Form::open(['action' => ['FieldController@update', $field->id], 'method' => 'PATCH']) !!}
                    <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Field Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $field->name }}" required placeholder="Enter Field Name">
                        @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
