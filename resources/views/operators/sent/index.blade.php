@extends('layouts.user')
@section('title','Sent Quotations')
@section('content')

<section class="p-100 o-operator-quot o-quotes ">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="m-0">Quotations Sent</h2>
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
                <a class="nav-item nav-link active" id="nav-pending-req-tab" data-toggle="tab" href="#nav-pending-req" role="tab" aria-controls="nav-pending-req" aria-selected="true">Recently Sent Quotations</a>
                <a class="nav-item nav-link" id="nav-acc-qu-tab" data-toggle="tab" href="#nav-acc-qu" role="tab" aria-controls="nav-acc-qu" aria-selected="false">Awaiting Confirmation</a>
                <a class="nav-item nav-link" id="nav-con-trip-tab" data-toggle="tab" href="#nav-con-trip" role="tab" aria-controls="nav-con-trip" aria-selected="false">Quotation Declined</a> 
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
                            <th>Trip date</th> 
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($quotes)
                            @foreach($quotes as $row)
                                <tr>
                                    <td></td>
                                    <td>{{ $row->booking['id'] }}</td>
                                    <td>{{ date("m/d/Y", strtotime($row->created_at)) }}</td>
                                    <td>{{ Str::limit($row->booking['pickup_address'], 30) }}</td>
                                    <td>{{ $row->booking['no_of_passengers'] }}</td>
                                    <td>{{ $row->booking['pickup_date'] }}</td>
                                    <td>
                                        <div class="btn-group mr-1 mb-1">
                                            <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" href="{{ route('operators.quotations.sent.recently-sent', $row->booking_id) }}"><i class="fa fa-eye"></i>View </a>
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
                            <th>Trip date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($confirmed)
                            @foreach($confirmed as $row)
                                <tr>
                                    <td></td>
                                    <td>{{ $row->booking['id'] }}</td>
                                    <td>{{ date("m/d/Y", strtotime($row->created_at)) }}</td>
                                    <td>{{  Str::limit($row->booking['pickup_address'], 30) }}</td>
                                    <td>{{ $row->booking['no_of_passengers'] }}</td>
                                    <td>{{ $row->booking['pickup_date'] }}</td>
                                    <td>
                                        <div class="btn-group mr-1 mb-1">
                                            <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" href="{{ route('operators.quotations.sent.confirmed', $row->booking_id) }}"><i class="fa fa-eye"></i>View </a>
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
                            <th>Trip date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($rejected)
                            @foreach($rejected as $row)
                                <tr>
                                    <td></td>
                                    <td>{{ $row->booking['id'] }}</td>
                                    <td>{{ date("m/d/Y", strtotime($row->created_at)) }}</td>
                                    <td>{{  Str::limit($row->booking['pickup_address'], 30) }}</td>
                                    <td>{{ $row->booking['no_of_passengers'] }}</td>
                                    <td>{{ $row->booking['pickup_date'] }}</td>
                                    <td>
                                        <div class="btn-group mr-1 mb-1">
                                            <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" href="{{ route('operators.quotations.sent.declined', $row->id) }}"><i class="fa fa-eye"></i>View </a>
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
            
        </div>

         
        

    </div>
</section>

@endsection