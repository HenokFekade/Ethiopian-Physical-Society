@extends('layouts.adminApp')

@section('user-image')
    <img src="../img/profile/user.png" id="user-profile" class="img-circle elevation-2" alt="User Image">
@endsection

@section('content')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Users</h1>
                        </div>
                        <div  class="ml-auto mr-2">
                            <user-create></user-create>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            
            @if (count($users) > 0)
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-bordered">
                                    <thead>                  
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Fields</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{ ucwords($user->name)}}</td>
                                                <td>{{ $user->email}}</td>
                                                <td>{{ ucwords($user->type)}}</td>
                                                <td>
                                                    @if (count($user->fields) > 0)
                                                        @foreach ($user->fields as $field)
                                                        <p>
                                                            <span class="text-danger font-weight-bold mr-3">&#8658;</span>
                                                            {{ucwords($field->name)}}
                                                        </p>
                                                        @endforeach
                                                    @else
                                                        <span class="text-primary">null</span>
                                                    @endif
                                                </td>
                                                <td> 
                                                    <div class="d-flex">
                                                        <user-edit user="{{ $user}}"></user-edit>
                                                    </div>
                                                </td>                                           
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            @else
                <div class=" text-red text-bold text-center mt-5">
                        No User Found!
                </div>   
            @endif
        </div>
        
@endsection

@section('script')
    @if (session('status') == "user created") 
            <user-created></user-created>
    @endif
    @if (session('status') == "user updated") 
            <user-updated></user-updated>
    @endif
@endsection