@extends('layouts.user')
@section('title','Booking Details')
@section('content')

<section class="o-operator-quot p-100">
    <div class="container">
        <div class="quote-detail-top">
            <div class="row">
                <div class="col-12">
                    <h2>Quotation Requests</h2>
                </div>
            </div>
            <input  type="hidden" id="booking_id" value="{{ $booking->id }}" />
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                    <div class="box yellow w-100">
                        <h3>Your Wallet:</h3>
                        <h4>{{ auth()->user()->quotations }} Quotations Left</h4>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">

                    <div class="media align-items-center">
                        <img src="{{ (isset($booking->user['image'])) ? $booking->user['image'] : asset('/frontend/images/avatar.png') }}" class="img-fluid rounded-circle" alt="">
                        <div class="media-body">
                            <h3>{{ $booking->user['name'] }}</h3>
                            <p>user</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                    <div class="box yellow w-100">
                        <h3>Booking ID:</h3>
                        <h4>{{ $booking->id }}</h4>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                    <div class="box green w-100">
                        <h3>Type of trip:</h3>
                        <h4>{{ ($booking->is_return == 1) ? "two ways" : "one way" }}</h4>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4 col-md-6 col-12 text-lg-right">

                    <a href="{{ route('operators.customer-chat', $booking->user->uuid??0) }}"><img src="{{ asset('/frontend/images/message.png') }}" class="img-fluid" alt="">message</a>
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
                                    <p><i class="fa fa-map-marker-alt"></i>To: {{ $booking->dropoff_address }}</p>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <p><i class="fa fa-map-marker-alt"></i>From: {{ $booking->pickup_address }}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <p class="border-0"><i class="fa fa-users"></i>With: {{ $booking->no_of_passengers }} Passengers</p>
                                </div>
                                <div class="col-md-6 col-12">
                                
                                    <p class="border-0"> With: {{ ($booking->type == 1) ? 'Self' : ($booking->type == 2 ? "Driver" : "Both") }}</p>
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
                                    <p><i class="fa fa-calendar-alt"></i>{{ $booking->pickup_date }}</p>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <p><i class="fa fa-clock"></i>{{ $booking->pickup_time }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="row">
                @if($booking->is_return == 1)
                <div class="col-xl-6 col-12">
                    <div class="detail-box">
                        <div class="top">
                            <h4>return Details</h4>
                        </div>
                        <div class="bottom">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <p><i class="fa fa-calendar-alt"></i>{{ $booking->return_date }}</p>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <p><i class="fa fa-clock"></i>{{ $booking->return_time }}</p>
                                </div>
                                <div class="col-12">
                                    <p class="border-0"><i class="fa fa-map-marker-alt"></i>Drop off at return: {{ $booking->return_address }}</p>
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
                                    <p><i class="fa fa-briefcase"></i>Hand Luggage: <span>{{ $booking->hand_luggage }}</span>
                                    </p>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <p><i class="fa fa-briefcase"></i>Medium Luggage: <span>{{ $booking->mid_luggage }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <p class="border-0"><i class="fa fa-briefcase"></i>Hand Luggage: <span>{{ $booking->large_luggage }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <p class="border-0">Additional Info:</p>
                                    <p class="border-0 p-2">{{ $booking->additional_info }} </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 text-center">
                    @if(count($booking->quotes) > 0)
                        @foreach ($booking->quotes as $item)
                            @if( $item['operator_id'] != auth()->user()->id)
                                <a class="yel" data-toggle="modal" data-target="#send-req">send quotation <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                <a href="#" class="pur" data-toggle="modal" data-target="#reject-req">Reject Request <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                            @else 
                                <a class="yel" style="cursor: pointer">Quotation Sent <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                @break
                            @endif
                        @endforeach
                    @else 
                        <a class="yel" data-toggle="modal" style="cursor:pointer; color:#fff;" data-target="#send-req">send quotation <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                       <!--  <a href="#" class="pur" data-toggle="modal" data-target="#reject-req">Reject Request <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a> -->
                    @endif
                    
                    

                </div>

            </div>
        </div>
    </div>
</section>


<!--operator quote detail end here-->
<!--reject modal start here -->


<div class="modal fade report-modal payment-first-step" id="reject-req" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Request Rejected</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="top">
                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="yel"  type="button" onclick="reloadWithPath('/operators/quotations')" data-dismiss="modal" aria-label="Close">Back to Requests Log<img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!--reject modal end here -->


<!--send req modal start here-->


<div class="modal fade report-modal payment-first-step o-send-req " id="send-req" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Send Quotation</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="top">
                        <div class="row">
                            <div class="col-12 text-center">
                                <p>You currently have {{ auth()->user()->quotations }} quotations left in your wallet</p>
                                <p>Are you sure you want to send a quotation?</p>
                            </div>
                        </div>
                        <form action="">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                            <div class="row ">
                                <div class="col-md-6 col-12">
                                    <label for="">Enter estimated trip fee </label>
                                </div>
                                <div class="col-md-6 col-12 position-relative">
                                    <input type="number" id="amount" placeholder="trip fee" class="form-control">
                                    <i class="fa fa-money-bill-alt"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center blockui">
                                    <button class="yel submit" type="button" onclick="sendQuotation({{ $booking->id }})">Send Quotation <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                    <button class="pur" data-dismiss="modal" aria-label="Close">Cancel <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                                    <div id="loader">
                                        <img style="height: 130px; width: 200px;" src="{{ asset('/frontend/images/load.gif')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!--send req modal end here-->


<!--send req-2 modal start here-->


<div class="modal fade report-modal payment-first-step o-send-req o-send-req-2" id="o-send-req-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Quotation sent</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="top">

                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="yel" data-dismiss="modal" aria-label="Close">Ok <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection