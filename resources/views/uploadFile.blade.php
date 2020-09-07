@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="opacity: 95%">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <p id = "flash_message"
                       class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <p>Errors:</p>
                            <ul>
                        @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                        @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="card">
                    <div class="card-header text-white" style="background-color: #344b60;">Upload file <span
                            class="text-muted subtitle"> JSON, CSV, EDI </span></div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <form method="POST" action="/processFile" enctype="multipart/form-data" onsubmit="return validForm()">
                                @csrf
                                <div class="form-group">
                                    <label for="inputFile">File to upload:</label>
                                    <input type="file" class="form-control-file" name="file" id="inputFile">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                        {{--<div class="row justify-content-center">
                            @if(session('success'))
                                <div class="alert alert-success"> {{session('success')}} </div>
                            @endif
                        </div>
                        </div>
                        <div class="row justify-content-center">
                            @if(session('error'))
                                <div class="alert alert-danger"> {{session('error')}} </div>
                            @endif
                        </div>--}}
                    </div>
                </div>
                <br/>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .subtitle {
            font-size: 0.6rem !important;

        }
    </style>
@endsection

@section("js")
    <script>
        const ready = function ready(fn) {
            if (document.readyState != 'loading') {
                fn();
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        };

        ready(function () {

        });

        function validForm() {
            let input = document.getElementById('inputFile');
            if(input.value !== '' && input.value !== undefined){
                return true;
            }
            swal('Error','Please provide a json file','error');
            return false;
        }

    </script>
@endsection
