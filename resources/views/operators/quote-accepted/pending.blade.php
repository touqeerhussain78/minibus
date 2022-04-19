@extends('layouts.user')
@section('title','Operator Pending Trip')
@section('content')

<section class="o-operator-quot p-100 o-pending-trip">
<input id="token" type="hidden" value="{{ csrf_token() }}" />
	<div class="container">
		<div class="quote-detail-top">
			<div class="row">
				<div class="col-12">
					<h2>Pending Trip</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box yellow w-100">
						<h3>Your Wallet:</h3>
						<h4>{{  $quote->operator['quotations'] }} Quotations Left</h4>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 d-sm-flex justify-content-between align-items-center">

					<div class="media align-items-center">
						<img src="{{ (isset($quote->booking->user['image'])) ? $quote->booking->user['image'] : asset('/frontend/images/avatar.png') }}" class="img-fluid rounded-circle" alt="">
						<div class="media-body">
						<h3>{{ $quote->booking->user['name']}}</h3>
                        <p>{{ $quote->booking->user['surname']}}</p>
						</div>
					</div>
					{{-- <a href="#"><img src="{{ asset('/frontend/images/message.png') }}" class="img-fluid" alt="">message</a> --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 text-lg-right">
                    	<a href="{{ route('operators.customer-chat', $quote->booking->user['uuid']) }}"><img src="{{ asset('/frontend/images/message.png') }}" class="img-fluid" alt="">message</a>
                    </div>

				</div>
			</div>



			<div class="row">
				<div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box yellow w-100">
						<h3>Booking ID:</h3>
						<h4>{{ $quote->booking_id }}</h4>
					</div>
				</div>
				<div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box green w-100">
						<h3>Type of trip:</h3>
						<h4>{{ ($quote->booking['is_return'] == 1) ? "Two Way" : "One Way"}}</h4>
					</div>
				</div>

				<div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box dark-green w-100">
						<h3>Estimated trip fee:</h3>
						<h4>£{{ $quote->amount }}</h4>
					</div>
				</div>

				<div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box red w-100">
						<h3>Time left to trip:</h3>
						<h4><span id="spCnt"></span></h4>
					</div>
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
			@if($quote->booking['is_return'] == 1)
			<div class="row">
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
									<p class="border-0"><i class="fa fa-map-marker-alt"></i>Drop off at return: {{ $quote->booking->return_address }}</p>
								</div>

							</div>
						</div>
					</div>


				</div>

				<div class="col-xl-6 col-12">

					<div class="detail-box">
						<div class="top">
							<h4>Additional Details</h4>
						</div>
						<div class="bottom">
							<h5>Trip Reason: Business</h5>
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
								<div class="col-xl-6 col-12">
									<div class="addi">
										<p class="border-0">Additional Info:</p>
										<p class="border-0 p-2">{{ $quote->booking->additional_info }} </p>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
			<div class="row">
				<div class="col-xl-6 col-12">
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
									<p><i class="fa fa-envelope"></i>{{ $quote->booking->contact_phone }}</p>
								</div>
								<div class="col-lg-6 col-12">
									<p class="border-0"><i class="fa fa-phone"></i>{{ $quote->booking->contact_email }}</p>
								</div>


							</div>
						</div>
					</div>
				</div>
			</div> 

		@if($quote->booking->status != 6 && $quote->booking->status != 3)
		
        @if(diff_in_hours($quote->booking->pickup_date) > 336 && ($quote->booking->status ==2 || $quote->booking->status ==1))
			<div class="row">
				<div class="col-12 text-center">
					<a href="#" class="yel" data-toggle="modal" data-target="#cancel-trip">Cancel Trip <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
				</div>
			</div>
		@endif
		</div>
		<div class="row">
			<div class="col-12 text-center">
				<div class="cancled-box yel">
					<h3>Cancelling under 14 days until trip date will result in</h3>
					<h3>security deposit refunding back to the user.</h3>
					@if($quote->booking->status != 3)
					<a href="#" class="pur" data-toggle="modal" data-target="#send-req">Start Trip <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
					@else 
					<a role="button" class="pur" >Trip Started</a>
					@endif
				</div>
			</div>
		</div>
		@endif
		
		</div>
	</div>

	<div class="modal fade report-modal payment-first-step o-send-req load" id="send-req" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
	
			<div class="modal-content">
	
				<div class="forget-pass">
	
					<div class="modal-header blockui">
	
						<h1>Mark trip started</h1>
	
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	
					</div>
	
					<div class="modal-body">
						<div class="top">
							<div class="row">
								<div class="col-12 text-center">
									<p>Mark trip as started?</p>
								</div>
							</div>
								<div class="row">
									<div class="col-12 text-center">
										<button class="yel" data-dismiss="modal" aria-label="Close">Cancel <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
										<button class="pur" type="button" onclick="changeStatus({{ $quote->booking_id }}, 3)">Mark as started<img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
										<div id="loader">
											<img src="{{ asset('/frontend/images/load.gif')}}">
										</div>
									</div>
	
								</div>
						</div>
	
					</div>
	
	
	
				</div>
	
			</div>
	
		</div>
	
	</div>

	<div class="modal fade report-modal payment-first-step o-send-req o-send-req-2" id="o-send-req-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
	
			<div class="modal-content">
	
				<div class="forget-pass">
	
					<div class="modal-header">
	
						<h1>Trip has been started</h1>
	
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	
					</div>
	
					<div class="modal-body">
	
						<div class="top">
	
	 <div class="row">
	
								<div class="col-12 text-center">
	
									<p>This notification will also be sent to the user.</p>
	
								   
								</div>
	
							</div>
	
						 
	
						</div>
	
					</div>
	
				</div>
	
			</div>
	
		</div>
	
	</div>


	<div class="modal fade report-modal payment-first-step o-send-req" id="cancel-trip" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
	
			<div class="modal-content">
	
				<div class="forget-pass">
	
					<div class="modal-header">
	
						<h1>cancel trip</h1>
	
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	
					</div>
	
					<div class="modal-body">
	
						<div class="top">
	
							<div class="row">
	
								<div class="col-12 text-center">
									<p>Are you sure you want to cancel this trip?</p>
								</div>
	
							</div>
								<div class="row">
	
									<div class="col-12 text-center">
	
										<button class="yel" data-dismiss="modal" aria-label="Close">No <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
	
										<button class="pur" type="button" onclick="changeStatus({{ $quote->booking_id }}, 6)"  id="o-cancel-trip">Cancel It <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
	
									</div>
	
								</div>
						</div>
	
					</div>
	
	
	
				</div>
	
			</div>
	
		</div>
	
	</div>

	<div class="modal fade report-modal payment-first-step o-send-req o-send-req-2" id="cancel-trip-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
	
			<div class="modal-content">
	
				<div class="forget-pass">
	
					<div class="modal-header">
	
						<h1>cancel trip</h1>
	
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
	
					</div>
	
					<div class="modal-body">
	
						<div class="top">
	
	 <div class="row">
	
								<div class="col-12 text-center">
	
									<p>Trip Cancelled</p>
	
								   
								</div>
								
								
								
	
							</div>
							
							  <div class="row mt-3">
	
									<div class="col-12 text-center">
	
										<button class="yel" id="refresh" data-dismiss="modal" aria-label="Close">OK <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
	
									   
	
									</div>
	
								</div>
	
						 
	
						</div>
	
					</div>
	
				</div>
	
			</div>
	
		</div>
	
	</div>
</section>

@endsection

@section('js')

<script>
 $(document).ready(function () {
     var m = {{ $future_date->format('m')}} -1;
        var mg = new Date({{ $future_date->format('Y')}}, m, {{ $future_date->format('d')}}, {{ $future_date->format('H')}}, {{ $future_date->format('i')}}, {{ $future_date->format('s')}}, 0);
        console.log('date',new Date());
        var tmr = window.setInterval(function () {
            var d = new Date();
            var dif = mg - d;
            console.log('mg',mg);
            console.log('dif',dif);
            var s = parseInt(dif / 1000);
if (s < 0) {
    document.getElementById('spCnt').innerHTML = 0;
    window.clearInterval(tmr);
    return;
}
            var sec = s % 60;
            var m = parseInt(s / 60);
            var min = m % 60;
            var h = parseInt(m / 60);
            var hour = h % 24;
            d = parseInt(h / 24);

            document.getElementById('spCnt').innerHTML = d + ' days ' + hour + ' hours ' + min + ' min and ' + sec + ' sec remaining';
        }, 1000);
    });
</script>
@endsection