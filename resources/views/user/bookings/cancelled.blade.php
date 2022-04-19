@extends('layouts.user')
@section('title','Cancelled')
@section('content')

<section class="booking-detail cancle-trip p-100 ">

    <div class="container">

        <h2>My Bookings</h2>

        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box yellow w-100">
                    <h3>Booking ID:</h3>
                    <h4>{{ $quote->booking->id }}</h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box green w-100">
                    <h3>Time left to trip:</h3>
                    <h4>{{ $quote->booking->pickup_time }}</h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box red w-100">
                    <h3>Booking Status:</h3>
                    <h4>trip confirmed</h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box green-2 w-100">
                    <h3>Deposit paid:</h3>
                    <h4>£60</h4>
                </div>
            </div>
        </div>

        <!--detail start here-->

        <div class="detail-main">
            <div class="row">
                <div class="col-xl-6 col-12">
                    <div class="left">
                        <h3>Booking <br> details</h3>

                        <!--detail box start here-->
                        <div class="detail-box">
                            <div class="top">
                                <h4>Journey Summary</h4>
                            </div>
                            <div class="bottom">
                                <!--<h5>Your Journey Would Be:</h5>-->
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-map-marker-alt"></i>To: {{ $quote->booking->dropoff_address }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-map-marker-alt"></i>From: {{ $quote->booking->pickup_address }}</p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0"><i class="fa fa-users"></i>With: {{ $quote->booking->no_of_passengers }} Passengers</p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0"> With: {{ ($quote->booking->type == 1) ? 'Self' : ($quote->booking->type == 2 ? "Driver" : "Both") }}</p>
                                    </div>
                                    {{-- <div class="col-12 text-center">
                                        <a href="#" class="yel">Start Again <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>


                        <div class="detail-box">
                            <div class="top">
                                <h4>Pick up Details</h4>
                            </div>
                            <div class="bottom">
                                <!--<h5>Minibus will pick you up on</h5>-->
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-calendar-alt"></i> {{ $quote->booking->pickup_date }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-clock"></i>{{ $quote->booking->pickup_time }}</p>
                                    </div>
                                    {{-- <div class="col-12 text-center">
                                        <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        @if($quote->booking->is_return == 1)
                        <div class="detail-box">
                            <div class="top">
                                <h4>return Details</h4>
                            </div>
                            <div class="bottom">


                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-calendar-alt"></i>{{ $quote->booking->return_date }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-clock"></i>{{ $quote->booking->return_time }}</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="border-0"><i class="fa fa-map-marker-alt"></i>Drop off at return: {{ ($quote->booking->is_return == 1) ? $quote->booking->return_address : $quote->booking->dropoff_address}}</p>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="detail-box">
                            <div class="top">
                                <h4>Additional Details</h4>
                            </div>
                            <div class="bottom">
                                <h5>Trip Reason: Business</h5>
                                <!--<h5>You will have:</h5>-->
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-briefcase"></i>Hand Luggage: <span>{{ $quote->booking->hand_luggage }}</span>
                                        </p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-briefcase"></i>Medium Luggage: <span>{{ $quote->booking->mid_luggage }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0"><i class="fa fa-briefcase"></i>large lagguage: <span>{{ $quote->booking->large_luggage }}</span></p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0">Additional Info:</p>
                                        <p class="border-0 p-2">{{ $quote->booking->additional_info }} </p>
                                    </div>
                                    {{-- <div class="col-12 text-center">
                                        <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="detail-box">
                            <div class="top">
                                <h4>Contact Details</h4>
                            </div>
                            <div class="bottom">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-user-circle"></i>{{ $quote->booking->contact_name }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-envelope"></i>{{ $quote->booking->contact_email }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p class="border-0"><i class="fa fa-phone"></i>{{ $quote->booking->contact_phone }}</p>
                                    </div>

                                    {{-- <div class="col-12 text-center">
                                        <a href="#" class="yel">Edit Details <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <!--detail box end here--> 
                    </div>
                </div>

                <div class="col-xl-6 col-12">
                    <div class="right">
                        <div class="row"> 
                            <div class="offset-md-5 col-md-7 col-12 text-md-right">
                                <div class="box yel w-100">
                                    <h3>Payment Status:</h3>
                                    <h4>Securoty deposit paid</h4>
                                </div> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">   
                             <div class="top">
                                <h4>Your operator for this ride</h4>
                            </div>
                            <div class="qu-box"> 
                                <div class="text-right">
                                    <button class="star" type="button"><i class="fa fa-star"></i></button>
                                </div>
                                <div class="media">
                                    <img src="{{ isset($quote->operator->image) ? $quote->operator->image : asset('/frontend/images/find-1.png')}}" class="img-fluid" alt="" onerror="this.style.display='none'">
                                    <div class="media-body">
                                    <h4>{{ $quote->operator->name }}</h4>
                                        <p>{{ $quote->operator->company_name }}</p>
                                        <a href="{{ route("home.operator", $quote->operator->id)}}">view profile</a>
                                        <div class="d-md-flex d-block justify-content-between">
                                        <h5><i class="fa fa-money-bill"></i> Trip Amount: <span>£{{ $quote->amount }}</span></h5>
                                            <a href="{{ route('chat', $quote->operator->uuid ) }}" class="message"><img src="{{ asset('/frontend/images/message.png')}}" class="img-fluid" alt="">Message</a>
                                            </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h5><i class="fa fa-money-bill"></i>Trip Amount: <span>£200</span></h5>
                                </div>
                                <h3>Minibus Type</h3>
                                <ul class="border-b">
                                    <li>Model: <span>{{ $quote->operator->minibus[0]['model'] }}</span>
                                    </li>
                                    <li>Capacity: <span>{{ $quote->operator->minibus[0]['capacity'] }}</span>
                                    </li>
                                </ul>

                                <div class="qu-info border-b">

                                    <h3>Operator Words:</h3>
                                    <p>{{ $quote->operator->aboutme }}.</p>

                                </div>
                                <div class="qu-info ">

                                    <h3>Minibus Description:</h3>
                                    <p>{{ $quote->operator->minibus[0]['description'] }}.</p>

                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12 text-center">
              <div class="cancled-box yel">
                  <h3>  This trip was cancelled by </h3>
                  <h3>the operator</h3>
              </div>
          </div>
      </div>
  </div>
  <!--detail start here-->
</div>

</section>


@endsection