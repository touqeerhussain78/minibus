@extends('layouts.user')
@section('title','Confirmed')
@section('content')


<section class="booking-detail cancle-trip confirm-trip p-100 ">

    <div class="container">

        <h2>My Bookings</h2>
        <input type="hidden" id="token" value="{{ csrf_token()}}">
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
                    <h4><span id="spCnt"></span></h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box red w-100">
                    <h3>Booking Status:</h3>
                    <h4>Trip Confirmed</h4>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box green-2 w-100">
                    <h3>Deposit paid:</h3>
                    <h4>£{{ $security_deposit }}</h4>
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
                                        <p class="border-0"> With: {{ ($quote->booking->type == 1) ? 'Self' : ($quote->booking->type == 2) ? "Driver" : "Both" }}</p>
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
                        {{-- <div class="row">
                            <div class="offset-md-5 col-md-7 col-12 text-md-right">
                                <div class="box yel w-100">
                                    <h3>Payment Status:</h3>
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
                        </div> --}}

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
                                               @if($paid)
                                            <?php
                                            
                                                $perc = $check->amount / $quote->amount  * 100;
                                            ?>
                                            @if($perc >= 30)
                                                <a href="{{ route('chat', $quote->operator->uuid ) }}" class="message"><img src="{{ asset('/frontend/images/message.png')}}" class="img-fluid" alt="">Message</a>
                                            @endif()

                                            @endif()
                                                </div>
                                        </div>
                                    </div>
                                   <?php //dd($quote->operator->minibus); ?>
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
           {{--  @php 
                $date1 = new DateTime();
                $date2 = new DateTime($quote->booking->created_at);

                $diff = $date2->diff($date1);

                $hours = $diff->h;
                $hours = $hours + ($diff->days*24);
            @endphp --}}
        
            @if(diff_in_hours($quote->booking->pickup_date) > 336 && $quote->booking->status ==2)
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="cancle-msg">
                    <p>Cancelling under 336 hours until trip date will result in no refund of the security deposit.</p>
                    <button class="pur canc" type="button" data-toggle="modal" data-target="#exampleModalCenter">Cancel Booking <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></button>
                        </div>
                </div>
            </div>
            @endif

        </div>
        <!--detail start here-->
    </div>

    <div class="modal fade report-modal booking-cancle confirm-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="forget-pass">
                    <div class="modal-header">
                        <h1>Booking Cancelled</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <p> are you sure you want to cancel <br> this booking?</p>
                                <button type="button" class="pur" data-dismiss="modal" aria-label="Close"> no <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                                <button type="button" onclick="cancelBooking({{$quote->booking->id}})" class="yel" > cancle it <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade report-modal booking-cancle cancle-now" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="forget-pass">
                    <div class="modal-header">
                        <h1>Booking Cancelled</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <p>Your amount will be refunded</p>
                                <button type="button" class="yel" data-dismiss="modal" aria-label="Close"> ok <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <!--payment first step modal start here-->
{{-- <div class="modal fade report-modal payment-first-step" id="exampleModalCenterPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
</div> --}}

</section>




@endsection
@section('js')
<script src="{{ asset('/frontend/js/stripe.js') }}"></script>

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
