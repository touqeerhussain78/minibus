@extends('admin.layouts.app')
@section('title', 'Password Recovery')
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
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(Auth::guard('operators')->check() || Auth::guard('web')->check() || Auth::guard('admin')->check())
                        <div class="alert alert-danger" role="alert">
                            You are not allowed to access
                        </div>
                        <div class="text-center">
                            <a class="llogin form-control mt-1" style="background:#f7941e;" href="{{ url('/')}}">Home</a>
                        </div>
                        @else
                        <form method="POST" action="{{ route('admin.password.email') }}">
                            @csrf
                            <div class="fields">
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-user"></i>
                                        <input placeholder="Email Address" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <button class="llogin form-control mt-1" type="submit">{{ __('Continue') }}</button>
                                <div class="new-user">
                                    <p>OR</p>
                                <a href="{{route('admin.login')}}" class="login form-control">Login</a></div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-3"></div>
        </div>
    </div>

@endsection
