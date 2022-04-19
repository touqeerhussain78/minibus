@extends('layouts.user')
@section('title','Operator Trip')
@section('content')

<section class="p-100 o-operator-quot o-accept-quo">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="m-0">Accepted Quotations</h2>
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

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-pending-req-tab" data-toggle="tab" href="#nav-pending-req" role="tab" aria-controls="nav-pending-req" aria-selected="true">Pending Trips</a>
                <a class="nav-item nav-link" id="nav-acc-qu-tab" data-toggle="tab" href="#nav-acc-qu" role="tab" aria-controls="nav-acc-qu" aria-selected="false">Trips Started</a>
                <a class="nav-item nav-link" id="nav-con-trip-tab" data-toggle="tab" href="#nav-con-trip" role="tab" aria-controls="nav-con-trip" aria-selected="false">Completed Trips History</a>
                <a class="nav-item nav-link" id="nav-can-trip-tab" data-toggle="tab" href="#nav-can-trip" role="tab" aria-controls="nav-can-trip" aria-selected="false">Trips Cancelled By User</a>
                <a class="nav-item nav-link" id="nav-can-trip-tab-you" data-toggle="tab" href="#nav-can-trip-you" role="tab" aria-controls="nav-can-trip-you" aria-selected="false">Trips Cancelled By You</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-pending-req" role="tabpanel" aria-labelledby="nav-pending-req-tab">
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
                                    <th>Trip date &amp; time</th>
                                    <th>Hours left</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($pending)
                                    @foreach($pending as $key => $row) 
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $row->booking_id }}</td>
                                            <td>{{ date("d-m-Y", strtotime($row->created_at)) }}</td>
                                            <td>{{  Str::limit($row['pickup_address'], 30) }}</td>
                                            <td>{{ $row['no_of_passengers'] }}</td>
                                            <td>{{ date("d-m-Y", strtotime($row['pickup_date'])) }}</td>
                                            @if(check_old_date($row->pickup_date)==false)
                                            <td>{{ diff_in_hours($row->pickup_date) }} hours</td>
                                            @else
                                            <td>0</td>
                                            @endif
                                            <td>
                                                <div class="btn-group mr-1 mb-1">
                                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item" href="{{ route('operators.quotations.accepted.pending', $row->id) }}"><i class="fa fa-eye"></i>View </a>
                                                        {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-lg.lg"><i class="fa fa-trash"></i>delete </a>
 --}}

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
            <div class="tab-pane fade" id="nav-acc-qu" role="tabpanel" aria-labelledby="nav-acc-qu-tab">


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
                                    <th>Trip date &amp; time</th>
                                    <th>Trip Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($started)
                                    @foreach($started as $key => $row) 
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $row->booking_id }}</td>
                                            <td>{{ date("d-m-Y", strtotime($row->created_at)) }}</td>
                                            <td>{{  Str::limit($row['pickup_address'], 30) }}</td>
                                            <td>{{ $row['no_of_passengers'] }}</td>
                                            <td>{{ date("d-m-Y", strtotime($row['pickup_date'])) }} & {{ $row['pickup_time'] }}</td>
                                            <td>Trip Started</td>
                                            <td>
                                                <div class="btn-group mr-1 mb-1">
                                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item" href="{{ route('operators.quotations.accepted.ongoing', $row->id) }}"><i class="fa fa-eye"></i>View </a>
                                                        {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-lg.lg"><i class="fa fa-trash"></i>delete </a> --}}


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
            <div class="tab-pane fade" id="nav-con-trip" role="tabpanel" aria-labelledby="nav-con-trip-tab">
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
                                    <th>Trip date &amp; time</th>
                                    <th>Trip completed on</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($completed)
                                    @foreach($completed as $key => $row) 
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $row->booking_id }}</td>
                                            <td>{{ date("d-m-Y", strtotime($row->created_at)) }}</td>
                                            <td>{{  Str::limit($row['pickup_address'], 30) }}</td>
                                            <td>{{ $row['no_of_passengers'] }}</td>
                                            <td>{{ date("d-m-Y", strtotime($row['pickup_date'])) }} & {{ $row['pickup_time'] }}</td>
                                            <td>{{ date("d-m-Y", strtotime($row->updated_at)) }}</td>
                                            <td>
                                                <div class="btn-group mr-1 mb-1">
                                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item" href="{{ route('operators.quotations.accepted.completed', $row->id) }}"><i class="fa fa-eye"></i>View </a>
                                                        {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-lg.lg"><i class="fa fa-trash"></i>delete </a> --}}


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
            <div class="tab-pane fade" id="nav-can-trip" role="tabpanel" aria-labelledby="nav-con-trip-tab">
                <div class="table-responsive">
                    <div class="maain-tabble">
                        <table class="table table-striped table-bordered zero-configuration border-0">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Booking ID</th>
                                    <th>Trip date</th>
                                    <th>Pick up location</th>
                                    <th>username</th>
                                    <th>Secuirty deposit amount</th>
                                    <th>refund status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($cancelled)
                                    @foreach($cancelled as $key => $row) 
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $row->booking_id }}</td>
                                            <td>{{ $row['pickup_date'] }}</td>
                                            <td>{{ Str::limit($row['pickup_address'], 30) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="btn-group mr-1 mb-1">
                                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item" href="{{ route('operators.quotations.accepted.cancelled', $row->id) }}"><i class="fa fa-eye"></i>View </a>
                                                        {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-lg.lg"><i class="fa fa-trash"></i>delete </a> --}}


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

            {{-- Cancel By You --}}
            <div class="tab-pane fade" id="nav-can-trip-you" role="tabpanel" aria-labelledby="nav-con-trip-tab">
                <div class="table-responsive">
                    <div class="maain-tabble">
                        <table class="table table-striped table-bordered zero-configuration border-0">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Booking ID</th>
                                    <th>Trip date</th>
                                    <th>Pick up location</th>
                                    <th>username</th>
                                    {{-- <th>Secuirty deposit amount</th>
                                    <th>refund status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($cancelled_by_you)
                                    @foreach($cancelled_by_you as $key => $row) 
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $row->booking_id }}</td>
                                            <td>{{ $row['pickup_date'] }}</td>
                                            <td>{{ Str::limit($row['pickup_address'], 30) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="btn-group mr-1 mb-1">
                                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item" href="{{ route('operators.quotations.accepted.cancelled', $row->id) }}"><i class="fa fa-eye"></i>View </a>
                                                        {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-lg.lg"><i class="fa fa-trash"></i>delete </a> --}}

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
        </div>

        <p style = "color:#f7941e; font-style:italic;"><b>*Note: <b>You will lose your deposit if You cancel after 336 hours before trips started.</p>



    </div>
</section>



@endsection