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
                        @if(Auth::guard('operators')->check() || Auth::guard('web')->check())
                        <div class="alert alert-danger" role="alert">
                            You are not allowed to access
                        </div>
                        <div class="text-center">
                            <a class="llogin form-control mt-1" style="background:#f7941e;" href="{{ url('/')}}">Home</a>
                        </div>
                        @else
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="fields">
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-user"></i><input type="text" class="form-control" spellcheck="true" name="email" placeholder="Email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <i class="fa fa-key"></i><input type="password" spellcheck="true" class="form-control" name="password" placeholder="Password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-6">

                                    </div>
                                    <div class="col-md-6 col-6"><a href="{{ route('admin.password.request') }}">Forgot Password?</a></div>
                                </div>
                                <button class="llogin form-control mt-1" type="submit">Login</button>
                            </div>
                        </form>
                        <div class="text-center">
							<a class="llogin form-control mt-1" style="background:#f7941e;" href="{{ url('/')}}">Home</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-3"></div>
        </div>
    </div>
@endsection
