<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <div id="app"class="container">
            <div class="row">
                <div class="off-1 col-10">
                    <div class="flex-right position-ref full-height">
                        @if (Route::has('login'))
                            <div class="top-right links">
                                @auth
                                    <a href="{{ url('/home') }}">Home</a>
                                @else
                                    <a href="{{ route('login') }}">Login</a>
                                @endauth
                            </div>
                        @endif
            
                        <div class="mt-5">
                            <form action="files" method="POST">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input name="file" type="file" class="custom-file-input" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                                <div class="mt-3 form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <select name="field" class="mt-3 form-control">
                                    @foreach ($fields as $field)
                                <option value="{{ $field->name }}"> {{ ucwords($field->name)   }}</option>
                                    @endforeach                                    
                                </select>
                                <button class="btn btn-success mt-3" type="submit">Submit form</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>
