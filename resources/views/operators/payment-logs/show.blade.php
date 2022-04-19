@extends('layouts.user')
@section('title','Payment Logs')
@section('content')

<section class="o-payment p-100 o-operator-quot">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Payment Log Detail</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box yellow w-100">
                    <h3>Your Wallet:</h3>
                    <h4>{{ isset(auth()->user()->quotations) ? auth()->user()->quotations : 0 }} Quotations Left</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-lg-8 col-12">
                <div class="detail-box"> 
                    <div class="border-b d-sm-flex justify-content-between">
                        <h4>Booking ID: </h4>
                        <h5>{{ $payment_log->booking_id }}</h5>
                    </div>
                    <div class="border-b d-sm-flex justify-content-between">
                        <h4>Trip Fee: </h4>
                        <h5>£{{ $payment_log->quote->amount }}</h5>
                    </div>
                    <div class="border-b d-sm-flex justify-content-between">
                        <h4>Amount Paid:</h4>
                        <h5>£{{ $paid }}</h5>
                    </div>  
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3>{{ $payment_log->created_at }}</h3>
                        </div>
                    </div> 
                </div>
                @if($payment_log->booking->is_paid == 0)
                <div class="row">
                    <div class="col-12">
                        <input id="token" type="hidden" value="{{ csrf_token() }}" />
                        <button type="button" class="yel" onclick="markReceived({{ $payment_log->booking_id }}, 1)">Mark as Received <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                        <button type="button" class="pur" onclick="markReceived({{ $payment_log->booking_id }}, 2)">Mark as Not Received<img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        
        

    </div>
</section>

@endsection