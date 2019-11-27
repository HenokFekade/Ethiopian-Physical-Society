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
                            <h1 class="m-0 text-dark">Fields</h1>
                        </div>
                        <a href="/fields/create" class="ml-auto mr-2">
                            <button class="btn btn-success">
                                Add Field
                            </button>
                        </a>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            
            @if (count($fields) > 0)
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
                                            <th>N<u>o</u> Editors Exist</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fields as $field)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{ ucwords($field->name)}}</td>
                                                <td>{{ $field->users()->count()}}</td>
                                                <td> 
                                                    <div class="d-flex">
                                                        <a href="{{route('fields.edit', $field->id)}}" class="mr-1">
                                                            <span class="text-primary">edit <i class="fas fa-edit fw"></i></span>
                                                        </a>
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
                        No Field Found!
                </div>   
            @endif
        </div>
        
@endsection

@section('script')
    @if (session('status') == "field created") 
            <field-created></field-created>
    @endif
    @if (session('status') == "field updated") 
            <field-updated></field-updated>
    @endif
@endsection