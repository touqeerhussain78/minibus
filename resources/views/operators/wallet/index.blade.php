@extends('layouts.user')
@section('title','Wallet')
@section('content')

<section class="o-operator-quot p-100 o-wallet">
    <div class="container">
        <div class="row">
                <div class="col-12">
                    <h2>My Wallet</h2>
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

        <div class="wallet-box">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 offset-md-2 col-md-8 col-12">
                    <div class="box text-center">
                        <h3>My Wallet</h3>
                        <h4>You have: {{ isset(auth()->user()->quotations) ? auth()->user()->quotations : 0 }} Quotations left</h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Package selected</th>
                            <th>Amount paid</th>
                        </tr>
                    </thead>
                    <tbody> <?php  //dd($payments); ?>
                        @if(isset($payments))
                        @foreach($payments as $row)
                        <tr> 
                           
                            <td></td>
                            <td>{{$row->created_at }}</td>
                            <td>{{ isset($row->package) ? $row->package['title'] : "" }}</td>
                            <td>£{{$row->amount }}</td>

                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <a role="button" data-toggle="modal" data-target="#exampleModalCenter" style="cursor:pointer; color:#fff" class="yel">Top Up My Wallet <img src="{{asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a>
            </div>
        </div>

    </div>
</section>


<!--modal start here -->


<div class="modal fade report-modal wallet-modal payment-first-step" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Select Package</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form id="op-payment-form" data-action="{{ route('operators.wallet.payment') }}" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}">
                        <div class="top">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2>1 Quotation is equal to £1 </h2>
                                    <div class="row">
                                        @if(isset($packages))
                                        @foreach($packages as $package)
                                        <div class="col-md-6 form-group">
                                        <label class="login-radio" onchange="showPackageAmount({{ $package->id }}, {{ $package->amount }})">{{ $package->quote }} quotes for £{{ $package->amount }}<input type="radio" value="{{$package->id}}" name="package"><span class="checkmark"></span></label>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div id="show-amount"></div>
                            {{-- <h3>Amount to be paid: £9</h3> --}}
                        
                                <input type="hidden" id="token" value="{{ csrf_token()}}">
                                <input type="hidden" id="stripKey" value="{{config('app.stripe_key') }}">
                                <input type="hidden" id="stripeToken" value="">
                                <input type="hidden" id="pkg-id" value="">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control card-name" placeholder="Card Holder Name">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="number" class="form-control card-number" placeholder="Card Number">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="number" class="form-control card-cvc" placeholder="CVV">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input class="form-control card-expiry" onchange="getStripeToken()" id="datepicker-expiry" placeholder="Expiry Month & Year">
                                </div>
                                <div class="col-12 text-center blockui">
                                    <button type="button" class="yel submit" onclick="addOperatorPayment()" id="book-operator">Top Up <img src="{{asset('/frontend/images/arrow.png')}}" alt=""></button>
                                    <div id="loader">
                                        <img style="height: 130px; width: 200px;" src="{{ asset('/frontend/images/load.gif')}}">
                                    </div>
                                </div>
                            </div>
                      
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal end here -->


<!--modal-2 start here-->


<div class="modal fade report-modal payment-second-step wallet-2" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="forget-pass">
                <div class="modal-header">
                    <h1>Selected Pacakge</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h6>10 Quotation for 10% Discount</h6>
                            <p>Thank you for making the purchase</p>
                            <p>Your quotes will be delievered to your wallet</p>


                            <button type="button" class="yel" onclick="reload()" > ok<img src="{{asset('/frontend/images/arrow.png')}}" alt=""></button>

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