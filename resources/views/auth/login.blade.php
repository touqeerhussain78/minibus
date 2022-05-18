@extends('layouts.login')
@section('content')

<section class="login-main">
    <div class="container">
        <div class="login-inner" >
            @if(Auth::guard('admin')->check())
            <div class="container row" style="padding: 60px;">
                <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    You are not allowed to access 
                </div>
                <div class="text-center">
                    <a class="llogin form-control mt-1" style="background:#f7941e;" href="{{ url('/')}}">Home</a>
                </div>
            </div>
        </div>
                @else
            <div class="row d-flex">
                <div class="col-lg-6 col-12 align-self-center">
                    <div class="left"> <img src="{{ asset('/frontend/images/login-logo.png') }}" class="img-fluid" alt=""> </div>
                </div>
                
                <div class="col-lg-6 col-12 ">
                    
                    <div class="right">
                        <h1>Login</h1>

                        

                        <form id="loginForm" data-action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}
                            <ul>
                                <li>
                                    <label class="login-radio">User
                                        <input
                                            id="user-radio"
                                            data-href="{{ route('login') }}"
                                            data-fp-href="{{ route('password.email') }}"
                                            data-rg-href="{{ route('user.register') }}"
                                            
                                            onclick="loginUrl(this, 1)" class="{{ $errors->has('role') ? ' has-error' : '' }}" type="radio" name="radio" checked >
                                    <span class="checkmark"></span></label>
                                </li>
                                <li>
                                    <label class="login-radio">Operator
                                        <input
                                        id="operator-radio"
                                        data-href="{{ route('operators.login') }}"
                                        data-fp-href="{{ route('operators.password.email') }}"
                                        data-rg-href="{{ route('operators.register.operator') }}"
                                        
                                        onclick="loginUrl(this,2)" type="radio" class="{{ $errors->has('role') ? ' has-error' : '' }}" name="radio" required>
                                    <span class="checkmark"></span></label>
                                </li>

                            </ul>
                            <div class="row">
                                <div class="col-12 form-group">
                                    <input type="email" id="lemail" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}"  required autocomplete="email" autofocus placeholder="Enter Email Address">
                                    <i class="fa fa-envelope"></i>
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                 </div>
                                <div class="col-12 form-group">
                                    <input type="password" id="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" name="password"  required autocomplete="current-password" placeholder="Password">
                                    <i class="fa fa-lock"></i>
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <label class="login-check">Remember Me
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                    {{-- <label for="remember">
                                        {{ __('Remember Me') }}
                                    </label> --}}
                                </div>
                            <div class="">
                                @if (Route::has('password.request'))
                                <a id="u-fp-button" style="cursor:pointer;" class="forgot" data-toggle="modal" data-target="#user-fp-modal"> Forgot Password?</a> 
                                <a id="op-fp-button" style="display:none; cursor:pointer;" class="forgot" data-toggle="modal" data-target="#exampleModalCenter"> Forgot Password?</a>
                             </div>
                                @endif

                            </div>

                            <button type="button" onclick="submitLogin()"> {{ __('Login') }} <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>


                        </form>

                        


                        <!--login modal start here-->

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="forget-pass">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        <div class="modal-body">
                                            <h1>Password Recovery</h1>
                                            <form action="{{ route('operators.send-verification-code') }}" method="post" id="op-fp" >
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <input type="text" name="email" placeholder="Enter email address" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <i class="fa fa-envelope"></i> </div>
                                                    <div class="col-12 blockui">
                                                        {{-- id="cont" --}}
                                                        <button type="submit" class="form-control" > Continue <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                    </div>
                                                    <a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a> </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="user-fp-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="forget-pass">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        <div class="modal-body">
                                            <h1>Password Recovery</h1>
                                            <form action="{{ route('user.send-verification-code') }}" method="post" id="user-fp" >
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <input type="text" name="email"  placeholder="Enter email address" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <i class="fa fa-envelope"></i> </div>
                                                    <div class="col-12 blockui">
                                                        {{-- id="cont" --}}
                                                        <button type="submit" class="form-control" > Continue <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                    </div>
                                                    <a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a> </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="u-verify-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="forget-pass">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        <div class="modal-body">
                                            <h1>Password Recovery</h1>
                                            <form action="{{ route('user.verify-verification-code') }}" method="post" id="u-verify-code">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <input type="text" name="code" id="u-con-pass" placeholder="Enter verification code" class="form-control">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </div>
                                                    <div class="col-12 blockui">
                                                        <button type="submit" class="form-control"> Continue <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                                                                         </div>
                                                    <a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a> </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="u-updatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="forget-pass">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        <div class="modal-body">
                                            <h1>Password Recovery</h1>
                                            <form action="{{ route('user.update-password') }}" method="post" id="u-update-pass">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <input type="password" name="password"  placeholder="Enter New Password" class="form-control">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                    <div class="col-12 blockui">
                                                        <button type="submit" class="form-control"> Update <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                    </div>
                                                    <a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a> </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--login modal end here-->

                        <!--forgot step 2 start here-->

                        <!-- Button trigger modal -->

                        <!-- Modal -->
                        <div class="modal fade" id="op-verify-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="forget-pass">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        <div class="modal-body">
                                            <h1>Password Recovery</h1>
                                            <form action="{{ route('operators.verify-verification-code') }}" method="post" id="op-verify-code">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <input type="text" name="code"  placeholder="Enter verification code" class="form-control">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </div>
                                                    <div class="col-12 blockui">
                                                        <button type="submit" class="form-control"> Continue <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                                                                         </div>
                                                    <a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a> </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="op-updatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="forget-pass">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        <div class="modal-body">
                                            <h1>Password Recovery</h1>
                                            <form action="{{ route('operators.update-password') }}" method="post" id="op-update-pass">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <input type="password" name="password"  placeholder="Enter New Password" class="form-control">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="form-control"> Update <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                    </div>
                                                    <a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a> </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--forgot step 2 end here-->

                        <p class="text-center">- Not a member? Sign up now -</p>
                        <a href="#" class="register" id="reg" data-toggle="modal" data-target="#userRegister">register <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a>
                        <div class="text-center">
							<a class="color-red register" style="background:#f7941e;" href="{{ url('/')}}">Back To Home</a>
						</div>
                    </div>
                   
                        
                    <!--register modal start here-->

                    <!-- long modal -->

                    <!-- Modal -->
                    <div class="modal fade my-modall" id="userRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="overflow-y: scroll;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="forget-pass">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    <div class="modal-body">
                                        <h1 class="text-center">User Registration </h1>
                                        <form id="register" data-action="{{ route('user.register') }}" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="attached">
                                                        <img src="{{ asset('/frontend/images/avatar.png') }}" class="img-fluid preview" alt="">
                                                        <button type="button" class="camera-btn" id="uploadImg" onclick="document.getElementById('upload').click()"><i class="fa fa-camera"></i></button>
                                                        <input type="file" id="upload" accept=".gif,.jpg,.jpeg,.png" name="file">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="alert alert-success d-none" id="msg_div">
                                                        <span id="res_message"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" value="1" name="role" />
                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('name')}}" spellcheck="true" id="name" name="name" placeholder="Name" class="form-control" >
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('surname')}}" spellcheck="true" name="surname" id="surname" placeholder="Sur Name" class="form-control">
                                                    <i class="fa fa-user-circle"></i>
                                                </div>
                                                 {{-- <div class="col-12 form-group">
                                                    <input type="text" spellcheck="true" id="username" placeholder="Username" class="form-control" >
                                                    <i class="fa fa-user-circle"></i> </div> --}}
                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('address')}}" spellcheck="true" id="u_address" name="address" placeholder="Address" class="form-control">
                                                    <i class="fa fa-map-marker-alt"></i> </div>
                                                <div class="col-12 form-group">
                                                    <input type="email" value="{{old('email')}}" spellcheck="true" name="email" id="email" placeholder="Email" class="form-control" >
                                                    <i class="fa fa-envelope"></i> </div>
                                                {{-- <div class="col-12 form-group">
                                                        <input type="password" spellcheck="true"  name="password"  placeholder="Password" class="form-control" >
                                                        <i class="fa fa-lock"></i> </div>
                                                <div class="col-12 form-group">
                                                        <input type="password" spellcheck="true" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control" >
                                                        <i class="fa fa-lock"></i> </div> --}}

                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('city')}}" spellcheck="true" name="city" id="locality" placeholder="town, City" class="form-control">
                                                    <i class="fa fa-building"></i> </div>

                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('state')}}" spellcheck="true" name="state" id="administrative_area_level_1" placeholder="County" class="form-control">
                                                    <i class="fa fa-building"></i> 
                                                </div>
                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('country')}}" spellcheck="true" name="country" id="country" placeholder="country" class="form-control">
                                                    <i class="fa fa-building"></i> 
                                                </div>
                                               <!-- <div class="col-12 form-group">
                                                    <input type="text" spellcheck="true" placeholder="Country" class="form-control">
                                                    <i class="fa fa-globe"></i> </div>-->
                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('zipcode')}}" spellcheck="true" id="postal_code" name="zipcode" placeholder="Post Code" class="form-control">
                                                    <i class="fa fa-map-marker-alt"></i> </div>

                                                <div class="col-12 form-group">
                                                    <input type="text" value="{{old('phone')}}" spellcheck="true" id="phone" name="phone" placeholder="Mobile number" class="form-control">
                                                    <i class="fa fa-phone"></i> </div>

                                               <!--  <div class="col-12 form-group">
                                                    <input type="number" spellcheck="true" placeholder="post code" class="form-control">
                                                    <i class="fa fa-pencil-alt"></i> </div>-->

                                                <div class="col-12 blockui">
                                                    <button type="submit" class="form-control" > Continue <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                </div>
                                                <a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a> </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--register modal end here-->

                    <!--register step 2 start here-->
                    <div class="modal fade register-two" id="register-two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="forget-pass">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <h1>User Registration  </h1>
                                                <p>We have sent a verification code on your phone number and email</p>
                                                <h2>Type The Verification Codes Below</h2>
                                            </div>
                                        </div>

                                        <form id="verify_account">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <input type="hidden" name="uid" id="uid">
                                                <input type="hidden" name="_token" id="token" value="{{ csrf_token()}}">
                                                    <input type="number" name="auth_phone" placeholder="Phone Verification Code" class="form-control" id="auth_phone">
                                                    <i class="fas fa-pencil-alt"></i>
                                                   
                                                </div>
                                                <div class="col-12 form-group">
                                                    <input type="text" name="auth_email" placeholder="Email Verification Code" class="form-control" id="auth_email">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <button type="button" id="u-resend" class="form-control resend"> Resend Code <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <button type="submit" class="form-control" onclick="verify()"> Verify and Continue <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                </div>
                                                <a role="button" style="cursor:pointer" id="back-u-register"><i class="fa fa-arrow-left"></i> go back </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--register step 2 end here-->


                    <!--register step 3 start here-->

                    <div class="modal fade register-two" id="register-three" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="forget-pass">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <h1>User Registration  </h1>
                                                <p>Your account has been verified.</p>
                                                <h2>Please set your password</h2>
                                            </div>
                                        </div>

                                        <form id="reset_password">
                                            <div class="row">
                                                {{-- <div class="col-12 form-group">
                                                    <input type="email" name="email" id="rs-email" placeholder="Email" class="form-control">
                                                    <i class="fas fa-envelope"></i>
                                                </div> --}}
                                                <div class="col-12 form-group">
                                                    <input type="password" name="password" id="rs-password" placeholder="Password" class="form-control">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                                <div class="col-12 form-group">
                                                    <input type="password" name="confirmed" id="rs-password-confirm"  placeholder="Confirm Password" class="form-control">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <button type="button" onclick="setUserPassword()" class="form-control"> Register <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                </div>
                                                <a role="button" style="cursor:pointer" id="back-u2"><i class="fa fa-arrow-left"></i> go back </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
					<div class="modal fade my-modall operator-register" style="overflow-y: scroll;" id="operatorRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

						<div class="modal-dialog" role="document">

							<div class="modal-content">

								<div class="forget-pass">

									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

									<div class="modal-body">

										<h1 class="text-center">operator Registration </h1>

										<form autocomplete="smartystreets" id="op-register" data-action="{{ route('operators.register.operator') }}" method="post" enctype="multipart/form-data">

											<div class="row">

												<div class="col-md-12">

													<div class="attached">
                                                        <img src="{{ asset('/frontend/images/avatar.png') }}" class="img-fluid preview" alt="">
                                                        <button type="button" class="camera-btn" id="uploadImg" onclick="document.getElementById('upload').click()"><i class="fa fa-camera"></i></button>
                                                        <input type="file" id="upload" name="file">
													</div>

												</div>

											</div>

											<div class="row">
												<div class="col-12 form-group">

													<input type="text" spellcheck="true" name="name" placeholder="Name" class="form-control">

													<i class="fa fa-user-circle"></i>

												</div>

												<div class="col-12 form-group">
													<input type="text" spellcheck="true" name="company_name" placeholder="Company Name" class="form-control">

													<i class="fa fa-building"></i>
												</div>

												<div class="col-12 form-group">

													<input type="email" autocomplete="new-password" spellcheck="true" name="email" placeholder="Email" class="form-control">

													<i class="fa fa-envelope"></i>
                                                </div>
                                                <div class="col-12 form-group">

                                                    <input autofill="off" autocomplete="off" type="text" id="op_address" name="address" placeholder="Address" class="form-control">
                                                    <input type="hidden" name="op_latitude" id="op_latitude" value="">
                                                    <input type="hidden" name="op_longitude" id="op_longitude" value="">
													<i class="fa fa-map-marker-alt"></i>
												</div>
                                                <div class="col-12 form-group">
													<input autocomplete="off" type="text" spellcheck="true" id="op_country" name="country" placeholder="Country" class="form-control">

													<i class="fa fa-globe-asia"></i>
												</div>

                                                <div class="col-12 form-group">
                                                <input autocomplete="off" type="text" id="op_administrative_area_level_1" class="form-control" name="state" placeholder="County" spellcheck="true" value="">
                                                <i class="fa fa-building"></i>
                                                </div>

												<div class="col-12 form-group">
													<input autocomplete="off" type="text" spellcheck="true" id="op_locality" name="city" placeholder="City" class="form-control">
                                                   
													<i class="fa fa-building"></i>
												</div>

												
												<div class="col-12 form-group">
													<input autocomplete="off" type="text" spellcheck="true" id="op-phone" name="phone" placeholder="mobile number" class="form-control">
													<i class="fa fa-phone"></i>
												</div>
												<div class="col-12 form-group">
													<input autocomplete="off" type="text" spellcheck="true" id="op_postal_code" name="zipcode" placeholder="Postal code " class="form-control">
													<i class="fa fa-map-marker-alt"></i>
												</div>
												<div class="col-12 form-group">
													<input autocomplete="off" type="text" spellcheck="true" name="drivers_license" placeholder="Operator Licence Number" class="form-control">

													<i class="fa fa-address-card"></i>
												</div>

												<div class="col-12 form-group">
													<textarea name="aboutme" id="" cols="" rows="" placeholder="Further Information" class="form-control"></textarea>
													<i class="fa fa-file-alt"></i>
												</div>

												<div class="col-12 blockui">

													<button type="button" class="form-control" onclick="opRegister()"> Continue <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></button>

												</div>

												<a href="#" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> back to login</a>

											</div>

										</form>

									</div>

								</div>

							</div>

						</div>

					</div>

					
					<div class="modal fade operator-register register-two" id="op-register-two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

						<div class="modal-dialog" role="document">

							<div class="modal-content">

								<div class="forget-pass">

									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

									<div class="modal-body">

										<div class="row">

											<div class="col-12 text-center">
												<h1>Operator Registration </h1>
											</div>

										</div>



										<form id="op-register-minibus" data-action="{{ route('operators.register.minibus') }}" method="post" enctype="multipart/form-data">

											<div class="row">

												<div class="col-md-12">
													{{-- <button class="upload-img" type="button" name="upload-img" onclick="document.getElementById('upload-img').click()"> --}}
													{{-- <i class="fa fa-plus-circle"></i>Add Images</button> --}}
												
                                                    <label>Upload Minibus Images</label>
													<input type="file" accept=".gif,.jpg,.jpeg,.png" name="files" id="upload-img" multiple="multiple" placeholder="Add Minibus Images">

												</div>

											</div>

											<div class="row">

												<div class="col-12 form-group">
													<input type="text" placeholder="Minibus Model" class="form-control" name="model">
													<i class="fas fa-bus"></i>
                                                </div>
                                                
                                                <div class="col-12 form-group">
													<input type="text" placeholder="Minibus Capacity" class="form-control" name="capacity">
													<i class="fas fa-bus"></i>
												</div>

												{{-- <div class="col-12 form-group">
													<select name="" class="form-control" id="">
														<option value="">modal </option>
														<option value="">modal </option>
														<option value="">modal </option>
													</select>
													<i class="fas fa-bus"></i>
												</div> --}}

												<div class="col-12 form-group">
													<label class="login-radio">with driver<input type="radio" name="type" value="1" checked="checked" name="radio"><span class="checkmark"></span></label>
													<label class="login-radio">Self Drive<input type="radio" name="type" value="2" checked="checked" name="radio"><span class="checkmark"></span></label>
													<label class="login-radio">Both<input type="radio" name="type" value="3" checked="checked" name="radio"><span class="checkmark"></span></label>
												</div>

												<div class="col-12 form-group">
													<textarea name="description"   class="form-control" placeholder="Enter Minibus Description"></textarea>
													<i class="fas fa-file-alt"></i>

												</div>


											</div>

											<div class="row">
												<div class="col-12">
													<button type="button" class="form-control resend" onClick="registerOperatorMinibus()"> Continue <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></button>
												</div>

											</div>

											<div class="row">

												<div class="col-12">

												</div>

												<a role="button" style="cursor:pointer" id="back-op-register"><i class="fa fa-arrow-left"></i> go back </a>

											</div>

										</form>

									</div>

								</div>

							</div>

						</div>

					</div>


					<div class="modal fade operator-register register-three" id="op-register-three" style="overflow-y: scroll;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

						<div class="modal-dialog" role="document">

							<div class="modal-content">


								<div class="forget-pass">

									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

									<div class="modal-body">

										<div class="row">

											<div class="col-12 text-center">

												<h1>Operator Registration  </h1>

												<p>We have sent a verification code on your phone number and email</p>

												<h2>Type The Verification Codes Below</h2>

											</div>

										</div>

                                       

										<form id="op-verify" data-action="{{ route('operators.register.verify') }}" method="post">

											<div class="row">

												<div class="col-12 form-group">
                                                   <?php /* {{ session('operator_data')['auth_code_phone'] }} */ ?>
                                                <input type="text" id="op-auth-phone"  placeholder="Phone Verification Code" class="form-control">

													<i class="fas fa-pencil-alt"></i>

												</div>

												<div class="col-12 form-group">
                                                   <?php /* {{ session('operator_data')['auth_code_email'] }} */ ?>
													<input type="text" id="op-auth-email"  placeholder="Email Verification Code" class="form-control">

													<i class="fas fa-pencil-alt"></i>

												</div>

											</div>

											<div class="row">

												<div class="col-12 col-md-6">

													<button type="button" id="op-resend" class="form-control resend"> Resend Code <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>

												</div>

												<div class="col-12 col-md-6">

													<button type="button" class="form-control verify" onclick="opVerify()" > Verify and Continue <img src="images/arrow.png" class="img-fluid" alt=""></button>

												</div>

											</div>

											<div class="row">

												<div class="col-12">

												</div>

												<a role="button" style="cursor:pointer" id="back-op-minibus"><i class="fa fa-arrow-left"></i> go back </a>

											</div>

										</form>

									</div>

								</div>

							</div>

						</div>

					</div>

					
					<div class="modal fade operator-register register-two register-4 register-three" id="op-register-four" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

						<div class="modal-dialog" role="document">

							<div class="modal-content">


								<div class="forget-pass">

									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

									<div class="modal-body">

										<div class="row">

											<div class="col-12 text-center">

												<h1>Operator Registration  </h1>

												<p>Your account has been verified.</p>

												<h2>Please set your password</h2>

											</div>

										</div>



										<form id="op-set-password" data-action="{{ route('operators.register.setpassword') }}" method="post">

											<div class="row">

												<div class="col-12 form-group">

													<input type="text" id="op-username"  placeholder="Username" class="form-control">

													<i class="fas fa-user-circle"></i>

												</div>

												<div class="col-12 form-group">

													<input type="password" id="op-password" placeholder="Password" class="form-control">

													<i class="fas fa-lock"></i>

												</div>

												<div class="col-12 form-group">

													<input type="password" id="op-confirm-password" placeholder="Retype Password" class="form-control">

													<i class="fas fa-lock"></i>

												</div>

											</div>

											<div class="row">

												<div class="col-12 blockui">

													<button type="button" class="form-control resend" onclick="setPassword()" id="count-6"> update <img src="images/arrow.png" class="img-fluid" alt=""></button>

												</div>

											</div>

											<div class="row">

												<div class="col-12">

												</div>

												<a role="button" style="cursor:pointer" id="back-op-verify"><i class="fa fa-arrow-left"></i> go back </a>

											</div>

										</form>

									</div>

								</div>

							</div>

						</div>

					</div>

                   
                    <div class="modal fade operator-register register-two register-5" id="register-four" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="forget-pass">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
									<div class="modal-body">
										<div class="row">
											<div class="col-12 text-center">
												<h1>User Registration Successfull</h1>
												<p>Thank you for registering!!</p>
                                                {{-- <h2>We'll get back to you once your account has be verified.</h2> --}}
                                            <a style="margin: 30px 0 0 0;background: #262262;font-size: 14px;padding: 0;height: 60px;" href="{{ route('login')}}" class="btn btn-primary">Login</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal fade operator-register register-two register-5" id="op-register-five" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="forget-pass">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
									<div class="modal-body">
										<div class="row">
											<div class="col-12 text-center">
												<h1>Operator Registration</h1>
												<p>Thank you for registering!!</p>
                                                {{-- <h2>We'll get back to you once your account has be verified.</h2> --}}
                                            <a style="margin: 30px 0 0 0;background: #262262;font-size: 14px;padding: 0;height: 60px;" href="{{ route('login')}}" class="btn btn-primary">Login</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					
                </div>
             
            </div>
            @endif
        </div>
    </div>
</section>


@endsection

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHPUufTlBkF5NfBT3uhS9K4BbW2N-mkb4&libraries=places&callback=initialize" async defer></script>

<script>
function initialize() {
  autocomplete1();
  autocomplete2();
  autocomplete3();
  autocomplete4();
}

function autocomplete1(){
  var input = document.getElementById('pickup_location');
  var autocomplete = new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
          var place = autocomplete.getPlace();
          document.getElementById('pickup').value = place.geometry.location.lat()+','+place.geometry.location.lng();
      });
}

function autocomplete2(){
  var input = document.getElementById('dropoff_location');
  var autocomplete = new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
          var place = autocomplete.getPlace();
          document.getElementById('dropoff').value = place.geometry.location.lat()+','+place.geometry.location.lng();
      });
}

// operator latlong
function autocomplete3(){
  var input = document.getElementById('op_address');
  var autocomplete = new google.maps.places.Autocomplete(input);

  var componentForm = {
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };
 
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
          var place = autocomplete.getPlace();
          console.log('place' , place);
          for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    
                    if(val){
                        console.log(addressType , val);
                        
                      //  document.getElementById(addressType).value = val;
                          document.getElementById('op_locality').value = place.address_components[0]['long_name'];
                          document.getElementById('op_administrative_area_level_1').value = place.address_components[2]['short_name'];
                          document.getElementById('op_country').value = place.address_components[3]['long_name'];
                         //  console.log('place' , place.address_components[i][postal_code[addressType]]);
                          // if(place.address_components[i][postal_code[addressType]]=='undefined'){
                          //   document.getElementById('op_postal_code').value ='';
                          // }else{
                          //  document.getElementById('op_postal_code').value = place.address_components[i][postal_code[addressType]]=='undefined' ? "" : place.address_components[i][postal_code[addressType]];
                          // }
                          
                      }
                 }
              }
               var address = place.address_components;
               console.log('place' , address[address.length - 1].long_name);
           document.getElementById('op_postal_code').value =address[address.length - 1].long_name;
            document.getElementById('op_latitude').value = place.geometry.location.lat();
            document.getElementById('op_longitude').value = place.geometry.location.lng();
            
           
        });
  }

function autocomplete4(){
  
  var input = document.getElementById('u_address');
  var autocomplete = new google.maps.places.Autocomplete(input);

  var componentForm = {
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };
 
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
          var place = autocomplete.getPlace();
          for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    if(val){
                        console.log(addressType , val);
                        document.getElementById(addressType).value = val;
                    }
               }
            }
         
      });
}

// google.maps.event.addDomListener(window, 'load', initialize);

</script>
