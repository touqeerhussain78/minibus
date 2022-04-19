@extends('layouts.user')
@section('title','Operator Cancelled Trip')
@section('content')

<section class="o-operator-quot p-100 ">
	<div class="container">
		<div class="quote-detail-top">
			<div class="row">
				<div class="col-12">
					<h2>Cancelled Trip</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box yellow w-100">
						<h3>Your Wallet:</h3>
						<h4>{{ $quote->operator['quotations'] }} Quotations Left</h4>
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
					<div class="box dark-green w-100">
						<h3>Estimated trip fee:</h3>
						<h4>£{{ $quote->amount }}</h4>
					</div>
				</div>

				{{-- <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box red w-100">
						<h3>Trip Completed on:</h3>
						<h4>20 days, 400 hours</h4>
					</div>
				</div> --}}

				<div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
					<div class="box red w-100">
						<h3>Trip Status:</h3>
						<h4>Completed</h4>
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
									<p class="border-0"> With: {{ ($quote->booking->type == 1) ? 'Self' : ($quote->booking->type == 2 ? "Driver" : "Both") }}</p>
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
			

		</div>
	</div>
</section>


@endsection