@extends('layouts.user')
@section('title','Accepted')
@section('content')

<section class="operator-profile-main accept-quotation p-100">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>book operator</h2>
			</div>
		</div>
		<div class="operator-profile border-b d-md-flex justify-content-between align-items-center">
			<div class="left">
				<div class="media">
					<img src="{{ isset($quote->operator['image']) ? $quote->operator['image'] : asset('/frontend/images/bus.png') }}" class="img-fluid" alt="" onerror="this.style.display='none'">
					<div class="media-body">
					<h3>{{ $quote->operator['name'] }}</h3>
						<h4>{{ $quote->operator->company_name }}</h4>
						<br/>
						
						<?php $stars = operator_rating($quote->operator->id); $stars = round($stars,0); ?>
						@for($i= 1;$i<=$stars;$i++)
							@if($i>5)
								@break(0);
							@endif
							<i class="fa fa-star" style="color:#edac08"></i>
						@endfor
							@if(5-$stars > 0)
								@for($i= 1;$i<=5-$stars;$i++)
									<i class="fa fa-star"></i>
								@endfor
							@endif
                        <h5>Trip Amount: £{{ $quote->amount }}</h5>
					</div> 
				</div>
			</div>
			<div class="right">
				<!--<a href="{{ route('chat', $quote->operator->uuid) }}">-->
				<!--	<div class="media align-items-center">-->
				<!--		<img src="{{ asset('/frontend/images/message.png') }}" class="img-fluid" alt="message image">-->
				<!--		<div class="media-body">-->
				<!--			<p>Message</p>-->
				<!--		</div>-->
				<!--	</div> -->
				<!--</a>-->
				@if($quote->status==1)
					@if($paid == 0)
					<!--<a href="#" class="pur" data-toggle="modal" data-target="#exampleModalCenter">Add Payment <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>-->
					@else 
					<a style="color:#fff" class="pur" >Deposit Paid</a>
					@endif
				@else 
				<a style="color:#fff" role="button" class="pur" >Awaiting confirmation by operator</a>
				@endif
			</div>
			
		</div>	
<div class="row">
	<div class="offset-md-5 col-md-4 col-12 text-md-right">
		<div class="box  w-100">
			{{-- <h6>Payment Status:</h6> --}}
			<!--<h4>Securoty deposit paid</h4>-->
				@if($quote->status==1)
				@if($paid == 0)
				<a style="padding:15px;" href="#" class="pur" data-toggle="modal" data-target="#exampleModalCenterPayment">Add Payment <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
				@else 
				<a style="color:#fff" class="pur" >SECUROTY DEPOSIT PAID</a>
				@endif
			@else 
			<a style="color:#fff" role="button" class="pur" >Awaiting confirmation by operator</a>
			@endif

		</div>
	</div>
</div>
		@php $buses = $quote->operator->minibus[0]->media @endphp
		@if($buses)
		<div class="operator-bus">
			<div class="row">
				@foreach($buses as $row)
				<div class="col-lg-3 col-sm-6 col-md-4 col-12">
					<img src="{{ $row->path }}" class="img-fluid" alt="bus image">
				</div>
				@endforeach
			</div>

		</div>
		@endif
		<div class="about-operator border-b"> 
			<div class="row">
				<div class="col-12">
					<h3>Further Information</h3>
					<p>{{ $quote->operator->aboutme }}</p>
				</div>
			</div> 
		</div>

		<div class="operator-bus">
			<div class="row">
				<div class="col-12">
					<h3>Minibus Type</h3>
					<ul>
						<li>{{ ($quote->operator->minibus[0]['type'] == 1) ? 'With Driver Only' : ($quote->operator->minibus[0]['type'] == 2) ? "Self" : "Both" }}</li>
						<li>Model: <span>{{ $quote->operator->minibus[0]->model }}</span></li>
						<li>Capacity: <span>{{ $quote->operator->minibus[0]->capacity }}</span></li>
					</ul>
					<p>{{ $quote->operator->minibus[0]->description }}</p>

				</div>
			</div> 
		</div>


		

	</div>

	  <!--payment first step modal start here-->
<div class="modal fade report-modal payment-first-step" id="exampleModalCenterPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Add payment details to book operator</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center blockui">
                            <h2>30% of the total trip fee is needed to confirm the booking,</h2>
                            <h2>remaining 70% would be paid to the operator / driver when the trip begins</h2>
                            <h3>Amount to be paid: £{{ $security_deposit }}</h3>
                            <form id="payment-form" data-cc-on-file="false"	data-stripe-publishable-key="pk_test_nwSs12xsC9VsJ322DFLRxr2Q">
							<input type="hidden" id="token" value="{{ csrf_token()}}">
							<input type="hidden" id="amount" value="{{ $security_deposit }}">
							<input type="hidden" id="stripKey" value="pk_test_nwSs12xsC9VsJ322DFLRxr2Q">
							<input type="hidden" id="stripeToken" value="">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control card-name" id="c_name" placeholder="Card Holder Name">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="number" class="form-control card-number" id="c_number" placeholder="Card Number">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="number" class="form-control card-cvc" id="c_cvv" placeholder="CVV">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input class="form-control card-expiry" onchange="getStripeToken()" id="datepicker-expiry" placeholder="Expiry Month & Year">
									</div>
									
                                    
                                </div>
                            <button type="button" class="yel submit" onclick="addPayment({{ $quote->id }})" > Book Operator for Trip <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></button>
							<div id="loader">
								<img src="{{ asset('/frontend/images/load.gif')}}">
							</div>
						</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>



<!--operator-profile end here-->



<!--payment first step modal start here-->
<div class="modal fade report-modal payment-first-step" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Add payment details to book operator</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center blockui">
                            <h2>30% of the total trip fee is needed to confirm the booking,</h2>
                            <h2>remaining 70% would be paid to the operator / driver when the trip begins</h2>
                            <h3>Amount to be paid: £{{ $security_deposit }}</h3>
                            <form id="payment-form" data-cc-on-file="false"	data-stripe-publishable-key="pk_test_nwSs12xsC9VsJ322DFLRxr2Q">
							<input type="hidden" id="token" value="{{ csrf_token()}}">
							<input type="hidden" id="amount" value="{{ $security_deposit }}">
							<input type="hidden" id="stripKey" value="pk_test_nwSs12xsC9VsJ322DFLRxr2Q">
							<input type="hidden" id="stripeToken" value="">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control card-name" id="c_name" placeholder="Card Holder Name">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="number" class="form-control card-number" id="c_number" placeholder="Card Number">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="number" class="form-control card-cvc" id="c_cvv" placeholder="CVV">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input class="form-control card-expiry" onchange="getStripeToken()" id="datepicker-expiry" placeholder="Expiry Month & Year">
									</div>
									
                                    
                                </div>
                            <button type="button" class="yel submit" onclick="addPayment({{ $quote->id }})" > Book Operator for Trip <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></button>
							<div id="loader">
								<img src="{{ asset('/frontend/images/load.gif')}}">
							</div>
						</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--payment first step modal end here-->


<!--payment first step modal start here-->

<div class="modal fade report-modal payment-second-step" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Add payment details to book operator</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>We will confirm the tirp once the operator approves it.</p>
                             
                             
                            <button type="button" class="yel" data-dismiss="modal" aria-label="Close"> ok<img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></button>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('js')
<script src="{{ asset('/frontend/js/stripe.js') }}"></script>
@endsection


@endsection