@extends('layouts.user')
@section('title','Trip Details')
@section('content')

<div id="loader_div" class="loader_div"></div>
<section class="booking-detail p-100 load">
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <div class="container">
        <h2>My Bookings</h2>
        <?php //dd($booking); ?> 
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box yellow w-100">
                    <h3>Booking ID:</h3>
                    <h4>{{ $booking->id }}</h4>
                </div>
            </div>
            @if($days_left>=0)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box green w-100">
                    <h3>Time left to trip: <span id="spCnt"></span></h3>
                    <h4><span id="spCnt"></span></h4>
                </div>
            </div>
            @endif
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box red w-100">
                    <h3>Booking Status:</h3>
                    <h4>Pending</h4>
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
                                        <p><i class="fa fa-map-marker-alt"></i>To: {{ $booking->dropoff_address }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-map-marker-alt"></i>From: {{ $booking->pickup_address }}</p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0"><i class="fa fa-users"></i>With: {{ $booking->no_of_passengers }} Passengers</p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0"> With:  {{ ($booking->type == 1) ? 'Self' : ($booking->type == 2 ? "Driver" : "Both") }}</p>
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
                                        <p><i class="fa fa-calendar-alt"></i> {{ $booking->pickup_date }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-clock"></i>{{ $booking->pickup_time }}</p>
                                    </div>
                                    {{-- <div class="col-12 text-center">
                                        <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        @if($booking->is_return == 1)
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
                                        <p class="border-0"><i class="fa fa-map-marker-alt"></i>Drop off at return: {{ ($booking->is_return == 1) ? $booking->return_address : $booking->dropoff_address}}</p>
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
                                        <p><i class="fa fa-briefcase"></i>Hand Luggage: <span>{{ $booking->hand_luggage }}</span>
                                        </p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-briefcase"></i>Medium Luggage: <span>{{ $booking->mid_luggage }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0"><i class="fa fa-briefcase"></i>large lagguage: <span>{{ $booking->large_luggage }}</span></p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="border-0">Additional Info:</p>
                                        <p class="border-0 p-2">{{ $booking->additional_info }} </p>
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
                                        <p><i class="fa fa-user-circle"></i>{{ $booking->contact_name }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p><i class="fa fa-envelope"></i>{{ $booking->contact_email }}</p>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <p class="border-0"><i class="fa fa-phone"></i>{{ $booking->contact_phone }}</p>
                                    </div>

                                    {{-- <div class="col-12 text-center">
                                        <a href="#" class="yel">Edit Details <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>


                        <!--detail box end here-->
                        @if($booking->status != 5 && $days_left >= 15)
                        <div class="row">
                            <div class="col-12">
                                <button class="pur canc" type="button" data-toggle="modal" data-target="#exampleModalCenter">Cancel Booking <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
              
                <div class="col-xl-6 col-12">
                    <div class="right">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6 col-12">
                                @if(count($booking->quotes) > 0)
                                    <h3>Quotations <br> Received</h3>
                                    @endif
                            </div>
                            <div class="col-md-6 col-12 text-md-right">
                            @if(count($special_invite ) < 1)
                                <a href="{{ route('bookings.special-invites', $booking->id) }}" class="pur special sendspecialinvitebtn">Send Special Invites <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>
                            @else 
                            <a role="button" disabled class="pur special" style="color:#fff; cursor:pointer">Send Special Invites <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></a>

                            @endif
                            </div>
                        </div>
                        @if(count($booking->quotes) > 0)
                            <div class="col-12">
                            @foreach($booking->quotes as $row)
                            <?php //dd($row); ?>
                                <div class="qu-box">
                                    <div class="text-right">
                                        <button class="star" type="button"><i class="fa fa-star"></i></button>
                                    </div>
                                    <div class="media">
                                        <img src="{{ isset($row->operator['image']) ? $row->operator['image'] : asset('/frontend/images/bus.png') }}" class="img-fluid" alt="" onerror="this.style.display='none'">
                                        <div class="media-body">
                                            <h4>{{ $row->operator['name'] }}</h4>
                                            <p>{{ $row->operator['company_name'] }}</p>
                                            <a href="{{ route("home.operator", $row->operator['id'])}}">view profile</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                    <h5><i class="fa fa-money-bill"></i> Trip Amount: <span>£ {{ $row->amount }}</span></h5>
                                    </div>
                                    <div class="text-center blockui">
                                        @if($row->status == 0)
                                        {{-- <a href="{{ route('bookings.accept', $row->id)}}" class="pur special" role="button">Accept Quotation <i class="fa fa-check"></i></a> --}}
                                        <button onclick="changeQuoteStatus({{ $row->id }}, 1)" class="pur submit" role="button">Accept Quotation <i class="fa fa-check"></i></button>
                                        <button onclick="changeQuoteStatus({{ $row->id }}, 2)" class="yel submit" type="button">Reject Quotation <i class="fa fa-times"></i></button>
                                        @else 
                                        <button class="pur" role="button">{{ ($row->status == 1) ? "Quotation Accepted" : "Quotation Rejected" }} <i class="fa fa-check"></i></button>
                                        @endif
                                        <div id="loader">
                                            <img style="border:none;" src="{{ asset('/frontend/images/load.gif')}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
               
            </div>



        </div>
        <!--detail start here-->
    </div>


</section>



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
                            <button type="button" onclick="cancelBooking({{$booking->id}})" class="yel" > cancle it <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
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
                            <p>Your amount to be refunded is: <span>£0</span></p>
                            <button type="button" class="yel" data-dismiss="modal" aria-label="Close"> ok <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



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