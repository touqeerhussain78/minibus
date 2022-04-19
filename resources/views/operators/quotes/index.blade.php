@extends('layouts.user')
@section('title','Bookings')
@section('content')

<section class="o-operator-quot p-100">

    <div class="container">
        <div class="row">
            <div class="col-12">
            <h2>{{ $title }}</h2>
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


        <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Booking ID</th>
                            <th>Date</th>
                            <th>Pick up location</th>
                            <th>Number of passengers</th>
                            {{-- <th>Security deposit</th> --}}
                            <th>Trip date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($bookings)
                            @foreach($bookings as $row)
                                <tr>
                                    <td></td>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ date("d-m-Y", strtotime($row->pickup_date)) }}</td>
                                    <td>{{  Str::limit($row->pickup_address, 30) }}</td>
                                    <td>{{ $row->no_of_passengers }}</td>
                                    {{-- <td>£60</td> --}}
                                    <td>{{ date("d-m-Y", strtotime($row->pickup_date)) }}</td>
                                    <td>
                                        <div class="btn-group mr-1 mb-1">
                                            <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" href="{{ route('operators.quotations.show', $row->id) }}"><i class="fa fa-eye"></i>View </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-lg.lg"><i class="fa fa-trash"></i>delete </a>


                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<!--delete modal start here-->

<div class="login-fail-main user delete-modal">
    <div class="featured inner">
        <div class="modal fade bd-example-modal-lg lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lgg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    <div class="payment-modal-main">
                        <div class="payment-modal-inner"> <img src="images/modal-2.png" class="img-fluid" alt="">
                            <h3>are you sure you want to delete this operator? </h3>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" data-dismiss="modal" class="yel">yes</button>
                                    <button type="button" class="pur" data-dismiss="modal">no</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection