@extends('layouts.user')
@section('title','Edit Profile')
@section('content')

<section class="user-profile p-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>User Profile</h2>
            </div>
        </div>
        <div class="user-profile-inner">
        <form method="POST" action="{{ route('profile.update')}}" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 ">
                        <div class="float-right ">
                            {{-- <a href="#" class="edit"><i class="fa fa-edit"></i>edit profile <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            <a href="#" class="pas" data-toggle="modal" data-target=".bd-example-modal-lg">change password <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a> --}}
                        </div>
                        <div class="attached">
                            <img src="{{ isset($user->image) ? $user->image : asset('/frontend/images/avatar.png')}}" class="img-fluid preview" alt="">
                            <button type="button" name="file" class="camera-btn" onclick="document.getElementById('upload').click()">
                                <i class="fa fa-camera"></i>
                            </button>
                            <input type="file" id="upload" name="file">
                        </div>
                    </div>

                </div>
                <?php // dd($user->image); ?>
                <div class="user-profile-bottom">
                    
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-12">
                            @if ($message = Session::has('message'))
                            <div class="alert alert-success alert-block">
                                    <strong>{{ Session::get('message') }}</strong>
                            </div>
                            @endif
    
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control edit"  placeholder="Enter Name">
                            <i class="fa fa-user-circle"></i>
                        </div>
                        <div class="col-md-6 col-12 form-group">
                            <input type="text" name="surname" value="{{ $user->surname }}" class="form-control edit"  placeholder="Enter Sur Name" >
                            <i class="fa fa-user-circle"></i>
                        </div>
                        <div class="col-md-6 col-12 form-group">
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control edit"  placeholder="Enter Email Address" >
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="col-md-6 col-12 form-group">
                            <input type="text" name="phone_no" value="{{ $user->phone_no }}" class="form-control"  placeholder="Enter Phone No" >
                            <i class="fa fa-phone fa-rotate-90"></i>
                        </div>
                        <div class="col-12 form-group">
                            <input type="text" id="u_address" name="address" value="{{ $user->address }}" class="form-control"   >
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div class="col-md-6 col-12 form-group">
                            <input type="text" id="locality" name="city" value="{{ $user->city }}" class="form-control" placeholder="Enter City" >
                            {{-- <input type="hidden" id="administrative_area_level_1" spellcheck="true" value=""> --}}
                            <i class="fa fa-building"></i>
                        </div>
                        <div class="col-md-6 col-12 form-group">
                            <input type="text" name="country" placeholder="Country" id="country" value="{{ $user->country }}" class="form-control" >
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="col-md-6 col-6 form-group">
                            <input type="text" name="state" placeholder="County" id="administrative_area_level_1" value="{{ $user->state }}" class="form-control" >
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="col-6 form-group">
                            <input type="text" name="zipcode" id="postal_code" value="{{ $user->zipcode }}" class="form-control" placeholder="Enter Post Code" >
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <button type="submit" class="pur"><i class="fa fa-edit"></i>Edit Profile <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>

    </div>
</section>


<!--modal start here-->

<div class="login-fail-main user">
    <div class="featured inner">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lgg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    <div class="payment-modal-main">
                        <div class="payment-modal-inner"> <img src="{{ asset('/frontend/images/modal-1.png')}}" class="img-fluid" alt="">
                            <h2>Change password</h2>

                            <form id="change_password">
                                @csrf
                                <div class="row">
                                    <input type="hidden" id="cp-url" value="{{ route('profile.update_password') }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <div class="col-12 form-group">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" name="old_password" id="old_password" placeholder="current password" class="form-control">
                                    </div>
                                    <div class="col-12 form-group">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" name="new_password" id="password" placeholder="new password" class="form-control">
                                    </div>
                                    <div class="col-12 form-group">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" name="confirm_password" id="password_confirmation" placeholder="re-type password" class="form-control">
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="pur" type="submit">Save <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')

<script src="{{ asset('/frontend/js/app.js') }}"></script>
@endsection