@extends('layouts.editorApp')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-10">
                <div class="ml-5 mt-5">
                            <div class="form-group">
                                {!! Form::open(['method' => 'PUT', 'action' => ['FileController@storeReply', $file->id], 'enctype' => 'multipart/form-data']) !!}
                                    <div class="form-group"> 
                                        <div class="input-group">
                                            
                                            <input name="file"  type="file" class="custom-file-input @error('file') is-invalid @enderror" id="inputGroupFile01"
                                                aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            @error('file')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>                                       
                                        {{-- <div class="d-inline ">
                                            <label for="file-upload-input">{{ __('Upload your Tesis') }}
                                                <div class="font-weight-bolder">
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                    <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                                </div>
                                            </label>
                                            <input id="file-upload-input" type="file" class="form-control-file @error('uploaded-file') is-invalid @enderror" name="uploaded-file">
                                            @error('uploaded-file')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>                                                                            --}}
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Upload</button>
                                    </div>
                                {!! Form::close()!!}
                            </div>    
                        </div>
            </div>
        </div>
    </div>


@endsection
