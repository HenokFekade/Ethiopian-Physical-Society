@extends('layouts.adminApp')

@section('user-image')
    <img src="../img/profile/user.png" id="user-profile" class="img-circle elevation-2" alt="User Image">
@endsection

@section('content')
    <div class="content-wrapper ">
        <div class="row  mt-4">
            <div class="col-md-8 m-auto">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Edit Account</h3>
                    </div>
                    @if(session('status') == 'something went wrong')
                        <div class="alert alert-danger" role="alert">
                            Fail to update your Account. Please retry again.
                        </div>
                    @endif
                    {!! Form::open(['action' => ['AccountController@update', auth()->user()->id], 'method' => 'POST']) !!}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ auth()->user()->name }}" required placeholder="Enter Name">
                                @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}" required placeholder="Enter email">
                                @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"  placeholder="Enter password">
                                @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
