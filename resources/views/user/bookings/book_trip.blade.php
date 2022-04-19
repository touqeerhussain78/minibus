@extends('layouts.user')
@section('title','Book Trip')
@section('content')

<section class="book-trip p-100">
    <div class="container">
        <h2>book trip</h2>
        <form id="regForm" method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <div class="step-main d-flex">
                <span class="step" id="t1">Pick Up Details</span>
                <span class="step" id="t2">Return Details</span>
                <span class="step" id="t3">Additional Details</span>
                <span class="step" id="t4">Contact</span>
                <span class="step" id="t5">Confirm</span>
            </div>
           
            <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? ''}}">
            <input type="hidden" name="pickup_address" value="{{$trip_details['pickup_location'] ?? ''}}">
            <input type="hidden" name="pickup" value="{{$trip_details['pickup'] ?? ''}}">
            <input type="hidden" name="dropoff_address" value="{{$trip_details['dropoff_location'] ?? ''}}">
            <input type="hidden" name="dropoff" value="{{$trip_details['dropoff'] ?? ''}}">
            <input type="hidden" name="passengers" value="{{$trip_details['passengers'] ?? ''}}">
         
            <input type="hidden" name="type" value="{{$trip_details['type'] ?? ''}}">
          
           
            <!-- One "tab" for each step in the form: -->
            <div class="tab tab-1">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            @endif
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <input type="text" id="datepicker-2"  value="{{ old('pickup_date') }}" readonly placeholder="Date Of Pick Up" class="form-control pickup_date" name="pickup_date">
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" id="timepicker-1" value="{{ old('pickup_time') }}" readonly placeholder="Time Of Pick Up" class="form-control pickup_time" name="pickup_time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 offset-xl-3 col-12">
                        <div class="journey">
                            <div class="title">
                                <h2>Journey Summary</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Journey Would Be:</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>To: {{$trip_details['dropoff_location']}}</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>From: {{$trip_details['pickup_location']}}</p>
                                <p class=""><i class="fa fa-users"></i>With: {{$trip_details['passengers'] ?? ''}} Passengers</p>
                                <!-- <p class="">With: Driver</p> -->
                                <a role="button" onclick="clearTripSession()" class="yel twhite" style="cursor:pointer">Start Again <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <div class="tab tab-2">
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Is this a one way trip?</label>

                                    <label class="login-radio">yes
                                    <input type="radio" value="0" name="is_return">
                                    <span class="checkmark"></span></label>
                                                    <label class="login-radio">No
                                    <input type="radio" checked="checked" value="1" name="is_return">
                                    <span class="checkmark"></span></label>
                                </div>
                                <!-- <div id="return-form"> -->
                                    <div class="col-12 form-group return-form">
                                        <input type="text" id="datepicker-3" value="{{ old('return_date') }}" name="return_date" readonly placeholder="Date Of Return" class="form-control return_date">
                                    </div>
                                    <div class="col-12 form-group return-form">
                                        <input type="text" id="timepicker-2" value="{{ old('return_time') }}" name="return_time" readonly placeholder="Time Of Departure" class="form-control return_time">
                                    </div>
                                    <div class="col-12 form-group position-relative return-form">
                                        <input type="hidden" name="return"  id="return">
                                        <input type="text" name="return_address" value="{{ old('return_address') }}" id="return_location" placeholder="Drop off location on return" class="form-control return_location">
                                        <i class="fa fa-map-marker-alt"></i>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 offset-xl-3 col-12">
                       
                        <div class="journey">
                            <div class="title">
                                <h2>Pick up Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Minibus will pick you up on</h3>-->
                                <p class="border-b show_pickup_date"><i class="fa fa-calendar"></i></p>
                                <p class="border-b show_pickup_time"><i class="fa fa-clock"></i></p>
                                <a role="button" onclick="tabChange(0)" class="yel twhite" style="cursor:pointer">Edit Details <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="tab tab-3">

                <div class="row">
                    <div class="col-xl-9 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12 form-group position-relative">
                                    <textarea name="trip_reason" value="{{ old('trip_reason') }}" class="form-control trip_reason" placeholder="Enter Trip Reason" rows=""></textarea>
                                    <i class="fa fa-comments"></i>
                                </div>

                                <div class="col-12 form-group position-relative">
                                    <label for=""><i class="fa fa-briefcase"></i> Specify Luggage</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12 form-group">
                                    
                                    <select class="form-control hand_luggage" name="hand_luggage" placeholder="">
                                        <option>Hand Luggage(10 kg)</option>
                                        @for($n=1; $n<=20; $n++)
                                        <option>{{$n}}</option>
                                        @endfor
                                    </select>

                                </div>
                                <div class="col-md-4 col-sm-6 col-12 form-group">
                                    <select class="form-control mid_luggage" name="mid_luggage">
                                        <option>Medium Luggage(20 kg)</option>
                                        @for($n=1; $n<=20; $n++)
                                        <option>{{$n}}</option>
                                        @endfor
                                    </select>

                                </div>
                                <div class="col-md-4 col-sm-6 col-12 form-group">
                                    <select class="form-control large_luggage" name="large_luggage">
                                        <option>Large Luggage(20+ kg)</option>
                                        @for($n=1; $n<=20; $n++)
                                        <option>{{$n}}</option>
                                        @endfor
                                    </select>

                                </div>
                                <div class="col-12 form-group position-relative">
                                    <textarea name="additional_info"  value="{{ old('additional_info') }}" class="form-control additional_info"  placeholder="Additional Info"></textarea>
                                    <i class="fa fa-exclamation-circle"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-12">

                        <div class="journey return-form">
                            <div class="title">
                                <h2>return Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Return will be on</h3>-->
                                <p class="border-b show_return_date"><i class="fa fa-calendar"></i></p>
                                <p class="border-b show_return_time"><i class="fa fa-clock"></i></p>
                                <p class=""><i class="fa fa-map-marker-alt"></i>Drop off at return: <span class="show_return_location"></span></p>
                               
                                <a role="button" onclick="tabChange(1)" class="yel twhite"  style="cursor:pointer">Edit Details <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
            <div class="tab tab-2 tab-4">
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Please confirm these details</label>
                                </div>
                                <div class="col-12 form-group position-relative">
                                <input type="text" name="contact_name" placeholder="Username" value="{{ auth()->user()->name ?? old('contact_name') }}" class="form-control contact_name">
                                    <i class="fa fa-user-circle"></i>
                                </div>
                                <div class="col-12 form-group position-relative">
                                    <input type="email" name="contact_email" placeholder="Email" value="{{ auth()->user()->email ?? old('contact_email') }}" class="form-control contact_email">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="col-12 form-group position-relative">
                                    <input type="text" name="contact_phone" placeholder="Phone" value="{{ auth()->user()->phone_no ?? old('contact_phone') }}" class="form-control contact_phone">
                                    <i class="fa fa-phone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 offset-xl-3 col-12">
                       
                        <div class="journey additional">
                            <div class="title">
                                <h2>Additional Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <h3>Trip Reason: <span class="show_trip_reason"></span></h3>
                                <h4>You will have:</h4>
                                <p class="border-b m-0 "><i class="fa fa-briefcase"></i>Hand Luggage: <span class="show_hand_luggage"></span>
                                </p>
                                <p class="border-b"><i class="fa fa-briefcase"></i>Medium Luggage: <span class="show_mid_luggage"></span>
                                </p>
                                <p class=""><i class="fa fa-briefcase"></i>large Luggage: <span class="show_large_luggage"></span>
                                </p>
                                <p class="">Additional Info:</p>
                                <p class="m-0 p-0 show_additional_info"></p>
                                <a role="button" onclick="tabChange(2)" class="yel twhite" style="cursor:pointer">Edit Details  <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="tab tab-5">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey">
                            <div class="title">
                                <h2>Journey Summary</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Journey Would Be:</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>To: {{$trip_details['dropoff_location']}}</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>From: {{$trip_details['pickup_location']}}</p>
                                <p class=""><i class="fa fa-users"></i>With: {{$trip_details['passengers']}} Passengers</p>
                                <!-- <p class="">With: Driver</p> -->
                                <a role="button" onclick="clearTripSession()" class="yel">Start Again <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey">
                            <div class="title">
                                <h2>Pick up Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Minibus will pick you up on</h3>-->
                                <p class="border-b show_pickup_date"><i class="fa fa-calendar"></i></p>
                                <p class="border-b show_pickup_time"><i class="fa fa-clock"></i></p>
                                {{-- <a role="button" onclick="tabChange(0)" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 return-form">
                        <div class="journey">
                            <div class="title">
                                <h2>return Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Return will be on</h3>-->
                                <p class="border-b show_return_date"><i class="fa fa-calendar"></i></p>
                                <p class="border-b show_return_time"><i class="fa fa-clock"></i></p>
                                <p class=""><i class="fa fa-map-marker-alt"></i>Drop off at return: <span class="show_return_location"></span></p>
                               
                                {{-- <a role="button" onclick="tabChange(1)" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 ">
                    <div class="journey additional">
                        <div class="title">
                                <h2>Additional Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <h3>Trip Reason: <span class="show_trip_reason show-read-more"></span></h3>
                                <h4>You will have:</h4>
                                <p class="border-b m-0 "><i class="fa fa-briefcase"></i>Hand Luggage: <span class="show_hand_luggage"></span>
                                </p>
                                <p class="border-b"><i class="fa fa-briefcase"></i>Medium Luggage: <span class="show_mid_luggage"></span>
                                </p>
                                <p class=""><i class="fa fa-briefcase"></i>large Luggage: <span class="show_large_luggage"></span>
                                </p>
                                <p class="">Additional Info:</p>
                                <p class="m-0 p-0 show_additional_info show-read-more"></p>
                                {{-- <a role="button" onclick="tabChange(2)" class="yel">Edit Detail  <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey">
                            <div class="title">
                                <h2>Contact Details</h2>
                            </div>
                            <div class="journey-bottom">

                            <p class="border-b"><i class="fa fa-user-circle"></i><span class="show_contact_name">{{ auth()->user()->name ?? '' }}</span></p>
                                <p class="border-b"><i class="fa fa-envelope"></i><span class="show_contact_email">{{ auth()->user()->email ?? "" }}</span></p>
                                <p class=""><i class="fa fa-phone"></i><span class="show_contact_phone">{{ auth()->user()->phone_no ?? "" }}</span></p>
                                {{-- <a role="button" onclick="tabChange(3)" class="yel">Edit Details <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div style="overflow:auto;">
                <button type="button" id="prevBtn" class="yel" onclick="nextPrev(-1)">Previous <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                <button type="button" id="nextBtn" class="pur" onclick="nextPrev(1)">Next <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></i></button>
                <button type="submit" id="submitBtn" class="pur" style="display:none" >Confirm and Submit Details <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></i></button>
            </div>
            <!-- Circles which indicates the steps of the form: -->

        </form>


    </div>
</section>


@endsection
