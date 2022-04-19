@extends('admin.layouts.app')
@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-xl-3"></div>
            <div class="col-md-8 col-xl-6 col-12">
                <div class="register-main">
                    <img src="{{ asset('administrator/images/logo.png') }}" class="img-full" alt="logo">
                    <div class="form-main">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="img-div">
                                    <div class="img-div-inner"> </div>
                                </div>
                            </div>
                        </div>
                     
                        <div class="alert alert-danger" role="alert">
                            You are not allowed to access
                        </div>
                        <div class="text-center">
                            <a class="llogin form-control mt-1" style="background:#f7941e;" href="{{ url('/')}}">Home</a>
                        </div>
                      
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-3"></div>
        </div>
    </div>
@endsection
