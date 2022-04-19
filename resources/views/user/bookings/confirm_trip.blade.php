@extends('layouts.user')
@section('title','Confirm Trip')
@section('content')

<section class="confirm-booking p-100">
    <div class="container">
        <h2>book trip</h2>
        <div class="con-box">

            <div class="row">
                <div class="col-12 text-center">
                    <img src="{{ asset('/frontend/images/check.png') }}" class="img-fluid" alt="">
                    <h3>Your trip booking has started.</h3>
                    <p>The request has been sent to Operators within a 30 mile radius of your location.</p>
                    <p>You can also request quotes directly from Operators of your choice from your profile.</p>
                    <p>Please track your quote on My Booking on your profile.</p>
                    <p>You can cancel a confirmed booking 14 days (336 hours) before the trip time.</p>
                    <a href="{{ route('home') }}" class="yel">Back to Home <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                <a href="{{ route('bookings') }}" class="pur">Go to My Bookings <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>    
                </div>
            </div>
        </div>
    </div>

</section>

@endsection