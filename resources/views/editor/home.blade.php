@extends('layouts.editorApp')

@section('body')
    @if (session('status'))
        <body onload="fileDownload()" class="hold-transition sidebar-mini layout-fixed" >
    @else
        <body class="hold-transition sidebar-mini layout-fixed" >
    @endif

@endsection

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
                                                        <th>File Name</th>
                                                        <th>Download</th>
                                                        <th>Reply</th>
                                                        <th>Reject</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($files as $file)
                                                        @if (!($file->pivot->replied))
                                                            <tr >
                                                            <td>{{ $count++}}</td>
                                                                <td>{{ $file->original_name }}</td>
                                                                <td>
                                                                    <a href="/file/download/{{$file->id}}"  class="blue"> download <i class="nav-icon fas fa-download fw  blue"></i></a>
                                                                </td>
                                                                <td>
                                                                    <a href="/file/reply/{{$file->id}}" class="green" > reply <i class="nav-icon fas fa-reply fw  green"></i></a>
                                                                </td>
                                                                <td>
                                                                    <reject-file file-id={{$file->id}}> </reject-file>
                                                                </td>
                                                                @if (!($file->pivot->seen))
                                                                    <td>
                                                                        <span class="right badge badge-danger">New</span>
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <span class="right badge badge-success">Seen</span>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endif
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
    <script>
        function fileDownload() {
            if(true)
            {
                Swal.fire(
                        'Download!',
                        'File Not Found.',
                        'error'
                    );
            }
        }
    </script>
