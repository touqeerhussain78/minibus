@extends('admin.layouts.app')
@section('title','Password Recovery')
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
                        <form method="POST" action="{{ route('admin.password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="fields">
                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="fa fa-user"></i>
                                        <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <i class="fa fa-lock"></i>
                                        <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <i class="fa fa-lock"></i>
                                        <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <button class="llogin form-control mt-1" type="submit">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                        <div class="text-center">
							<a class="llogin form-control mt-1" style="background:#f7941e;" href="{{ url('/admin/login')}}">Login</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xl-3"></div>
        </div>
    </div>

@endsection

