@extends('layouts.editorApp')

@section('user-image')
    <img src="img/profile/user.png" id="user-profile" class="img-circle elevation-2" alt="User Image">
@endsection

@section('content')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Researchers File</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        @if (!empty($files))
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
                                                    @foreach ($files as $file)
                                                        <tr>
                                                            <td>{{$count++}}</td>
                                                            <td>{{ ucwords($file->name)}}</td>
                                                            <td>
                                                                <span class="text-success">active</span>
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
                                    No File Found!
                            </div>
                        @endif

                    </div>
                </div>
            </section>
        </div>

@endsection

@section('script')

@endsection
