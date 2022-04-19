@extends('layouts.user')
@section('title','Awaiting Confirmation')
@section('content')

<section class="o-operator-quot p-100 o-recent-sent-quote">
    <div class="container" >
        <div class="quote-detail-top">
            <div class="row">
                <div class="col-12">
                    <h2>Quotation Requests</h2>
                </div>
            </div>
            <input id="token" type="hidden" value="{{ csrf_token() }}" />
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                    <div class="box yellow w-100">
                        <h3>Your Wallet:</h3>
                        <h4>{{  $quote->operator['quotations'] }} Quotations Left</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="media align-items-center">
                        <img src="{{ (isset($quote->operator['image'])) ? $quote->operator['image'] : asset('/frontend/images/avatar.png') }}" class="img-fluid rounded-circle" alt="">
                        <div class="media-body">
                            <h3>{{ $quote->booking->user['name']}}</h3>
                            <p>{{ $quote->booking->user['surname']}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="quote-info">Awaiting your confirmation on this trip</p>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                    <div class="box yellow w-100">
                        <h3>Booking ID:</h3>
                        <h4>{{ $quote->booking->id }}</h4>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                    <div class="box green w-100">
                        <h3>Type of trip:</h3>
                        <h4>{{ ($quote->booking->is_return == 1) ? "Two Way" : "One Way"}}</h4>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                    <div class="box red w-100">
                        <h3>Estimated trip fee:</h3>
                        <h4>£{{ $quote->amount }}</h4>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-12 text-lg-right">
                    <a href="{{ route('operators.customer-chat', $quote->booking->user['uuid']) }}"><img src="{{ asset('/frontend/images/message.png') }}" class="img-fluid" alt="">message</a>
                </div>
            </div>
        </div>
        <div class="quote-detail-bottom">
            <div class="row">
                <div class="col-xl-6 col-12">

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
									<p class="border-0"><i class="fa fa-users"></i>With: {{ $quote->booking->no_of_passengres }} Passengers</p>
								</div>
								<div class="col-md-6 col-12">
									<p class="border-0"> With: {{ ($quote->booking->type == 1) ? 'Self' : ($quote->booking->type == 2) ? "Driver" : "Both" }}</p>
								</div>


							</div>
                        </div>
                    </div>
                    
                </div>
				 <div class="col-xl-6 col-12">
                    <div class="detail-box">
                        <div class="top">
                            <h4>Pick up Details</h4>
                        </div>
                        <div class="bottom">
                            <!--<h5>Minibus will pick you up on</h5>-->
                            <div class="row">
								<div class="col-lg-6 col-12">
									<p><i class="fa fa-calendar-alt"></i>{{ $quote->booking->pickup_date }}</p>
								</div>
								<div class="col-lg-6 col-12">
									<p><i class="fa fa-clock"></i>{{ $quote->booking->pickup_time }}</p>
								</div>

							</div>
                        </div>
                    </div>
					 </div>
			</div>
			<div class="row">
                @if($quote->booking->is_return == 1)
                <div class="col-xl-6 col-12">
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
                </div>
                @endif
				<div class="col-xl-6 col-12">
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
									<p class="border-0"><i class="fa fa-briefcase"></i>Hand Luggage: <span>{{ $quote->booking->large_luggage }}</span>
									</p>
								</div>
								<div class="col-md-6 col-12">
									<p class="border-0">Additional Info:</p>
									<p class="border-0 p-2">{{ $quote->booking->additional_info }}</p>
								</div>

							</div>
                        </div>
                    </div>
				</div>
            </div>
            @if($quote->booking->status != 2)
            <div class="row">
                <div class="col-12 text-center">
                    <a href="#" class="yel" data-toggle="modal" data-target="#cancel-trip">Reject Trip <img src="{{asset('/frontend/images/arrow.png')}}" alt=""></a>
                    <a href="#" class="pur" data-toggle="modal" data-target="#accept-trip">Confirm Trip <img src="{{asset('/frontend/images/arrow.png')}}" alt=""></a> 
                </div>
            </div>
            @endif
        </div>
    </div>
</section>



<!--accept trip modal start here-->


<div class="modal fade report-modal payment-first-step o-send-req load" id="accept-trip" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>You have accepted this trip</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="top">
                            
                        <div class="row">
                            <div class="col-12 text-center blockui">
                                <p class="m-0 ">Are you sure you want to confirm this Trip ?</p>
                                <button class="yel" onclick="changeStatus({{ $quote->booking_id }}, 2)">Yes <img src="{{asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--accept trip modal end here-->

<!--cancel trip modal start here-->


<div class="modal fade report-modal payment-first-step o-send-req " id="cancel-trip" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>You have accepted this trip</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="top">
                            
                        <div class="row">
                            <div class="col-12 text-center">
                                <p class="m-0">Are you sure you want to cancel this Trip</p>
                                <button class="yel" data-dismiss="modal" aria-label="Close">No <img src="{{asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></button>
                                <button class="pur" data-dismiss="modal" aria-label="Close" onclick="changeStatus({{ $quote->booking_id }}, 6)" >Cancel it <img src="{{asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--cancel trip modal end here-->
<!--cancel trip-2 modal start here-->


<div class="modal fade report-modal payment-first-step o-send-req " id="cancel-trip-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>You have accepted this trip</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="top">
                            
                        <div class="row">
                            <div class="col-12 text-center">
                                <p class="m-0">Trip cancelled</p>
                                <button class="yel" data-dismiss="modal" aria-label="Close">Ok <img src="{{asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
