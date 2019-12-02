@extends('layouts.adminApp')

@section('user-image')
    <img src="img/profile/user.png" id="user-profile" class="img-circle elevation-2" alt="User Image">
@endsection

@section('content')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Users Status</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        @if (count($activeUsers) > 0)
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="content-header">
                                            <h4 class="m-0 ml-3 text-dark">Active Users</h4>
                                        </div>
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th>Modify</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($activeUsers as $user)
                                                        <tr>
                                                            <td>{{$count++}}</td>
                                                            <td>{{ ucwords($user->name)}}</td>
                                                            <td>{{ $user->email}}</td>
                                                            <td>{{ ucwords($user->type)}}</td>
                                                            <td>
                                                                <span class="text-success">active</span>
                                                            </td>
                                                            <td>
                                                                <user-deactivated user-id={{$user->id}}></user-deactivated>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @else
                            <div class=" text-red text-bold text-center mt-5 mb-3 offset-5">
                                    No Active User Found!
                            </div>
                        @endif

                        @if (count($deactiveUsers) > 0)
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="content-header">
                                            <h4 class="m-0 ml-3 text-dark">Deactive Users</h4>
                                        </div>
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th>Modify</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($deactiveUsers as $user)
                                                        <tr>
                                                            <td>{{$num++}}</td>
                                                            <td>{{ ucwords($user->name)}}</td>
                                                            <td>{{ $user->email}}</td>
                                                            <td>{{ ucwords($user->type)}}</td>
                                                            <td>
                                                                <span class="text-danger">deactivated</span>
                                                            </td>
                                                            <td>
                                                                <user-activated user-id={{$user->id}}></user-activated>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @else
                            <div class=" text-red text-bold text-center mt-5 mb-3 ">
                                    No Deactivate User Found!
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>

@endsection

@section('script')
    @if (session('status') == 'account updated')
        <account-updated></account-updated>
    @endif
@endsection
