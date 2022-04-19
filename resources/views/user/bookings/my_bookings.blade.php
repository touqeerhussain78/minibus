@extends('layouts.user')
@section('title','My Bookings')
@section('content')

<section class="payment-log p-100 my-booking">
    <div class="container">
        <h2>My booking <?php if(isset($_GET['type'])){ $type =  $_GET['type'];}else{$type=false;} ?></h2>
        @if ($message = Session::has('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ Session::get('message') }}</strong>
                    </div>
                @endif
       <nav>
            <div class="nav nav-tabs justify-content-between" id="nav-tab" role="tablist">
                <a class="nav-item nav-link <?php if($type==false){echo 'active';}?>" id="nav-pending-req-tab" data-toggle="tab" href="#nav-pending-req" role="tab" aria-controls="nav-pending-req" aria-selected="<?php if($type==false){echo 'true';}?>">Pending request</a>
                <a class="nav-item nav-link <?php if($type =='accepted'){echo 'active';}?>" id="nav-acc-qu-tab" data-toggle="tab" href="#nav-acc-qu" role="tab" aria-controls="nav-acc-qu" aria-selected="<?php if($type =='accepted'){echo 'true';}?>">Accepted Quotations</a>
                <a class="nav-item nav-link <?php if($type =='confirmed'){echo 'active';}?>" id="nav-con-trip-tab" data-toggle="tab" href="#nav-con-trip" role="tab" aria-controls="nav-con-trip" aria-selected="<?php if($type =='confirmed'){echo 'true';}?>">Confirmed Trips</a>
                <a class="nav-item nav-link <?php if($type =='started'){echo 'active';}?>" id="nav-on-going-tab" data-toggle="tab" href="#nav-on-going" role="tab" aria-controls="nav-on-going" aria-selected="<?php if($type =='started'){echo 'true';}?>">Ongoing Trips</a>
                <a class="nav-item nav-link <?php if($type =='completed'){echo 'active';}?>" id="nav-com-trip-tab" data-toggle="tab" href="#nav-com-trip" role="tab" aria-controls="nav-com-trip" aria-selected="<?php if($type =='completed'){echo 'true';}?>">Completed Trips</a>
                <a class="nav-item nav-link <?php if($type =='cancelled'){echo 'active';}?>" id="nav-can-trip-tab" data-toggle="tab" href="#nav-can-trip" role="tab" aria-controls="nav-can-trip" aria-selected="<?php if($type =='cancelled'){echo 'true';}?>">Cancelled Trips</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade <?php if($type==false){echo 'show active';}?>" id="nav-pending-req" role="tabpanel" aria-labelledby="nav-pending-req-tab">
                
            <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Booking ID</th>
                            <th>Date</th>
                            <th>Pick up location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($bookings))
                            @foreach($bookings as $key => $row)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{$row->id}}</td>
                                <td>{{$row->pickup_date}}</td> 
                                <td>{{ Str::limit($row->pickup_address, 30)}}</td>
                                <td>
                                    <div class="btn-group mr-1 mb-1">
                                        <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="{{ route('booking.show', $row->id) }}"><i class="fa fa-eye"></i>View </a>

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
            <div class="tab-pane fade <?php if($type =='accepted'){echo 'active show';}?>" id="nav-acc-qu" role="tabpanel" aria-labelledby="nav-acc-qu-tab">
            
            
             <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Booking ID</th>
                            <th>Date</th>
                            <th>Pick up location</th>
                            <th>Operator name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>  
                        @if(isset($accepted))
                        @foreach($accepted as $key => $row)
                        <?php // dd($row->quotes[0]->operator); ?>
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->pickup_date}}</td> 
                            <td>{{ Str::limit($row->pickup_address, 30)}}</td>
                            <td>{{$row->quote[0]->operator['name'] ?? ""}}</td>
                            <td>
                                <div class="btn-group mr-1 mb-1">
                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="{{ route('bookings.accepted', $row->id) }}"><i class="fa fa-eye"></i>View </a>

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
            <div class="tab-pane fade  <?php if($type =='confirmed'){echo 'active show';}?>" id="nav-con-trip" role="tabpanel" aria-labelledby="nav-con-trip-tab">
                <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Booking ID</th>
                            <th>Trip Date</th>
                            <th>Pick up location</th>
                            <th>Operator name</th>
                            <th>Payment status</th>
                            <th>Time Left to Trip</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($confirmed))
                        @foreach($confirmed as $key => $row)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->pickup_date}}</td> 
                            <td>{{ Str::limit($row->pickup_address, 30) }}</td>
                            <td>{{$row->quotes[0]->operator['name'] ?? ""}}</td>
                            <td>Security Deposit Paid</td>
                            @if(check_old_date($row->pickup_date)==false)
                            <td>{{ diff_in_hours($row->pickup_date) }} hours</td>
                            @else
                            <td>0</td>
                            @endif
                            <td>
                                <div class="btn-group mr-1 mb-1">
                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="{{ route('bookings.confirmed', $row->id) }}"><i class="fa fa-eye"></i>View </a>

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
            <div class="tab-pane fade <?php if($type =='started'){echo 'show active';}?>" id="nav-on-going" role="tabpanel" aria-labelledby="nav-on-going-tab">
            
                
                <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Booking ID</th>
                            <th>Trip Date</th>
                            <th>Pick up location</th>
                            <th>Operator name</th>
                            <th>Payment status</th>
                            <th>Trip status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($ongoing))
                        @foreach($ongoing as $key => $row)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->pickup_date}}</td> 
                            <td>{{ Str::limit($row->pickup_address, 30) }}</td>
                            <td>{{$row->quotes[0]->operator['name'] ?? ""}}</td>
                            <td>Security Deposit Paid</td>
                            <td>Ongoing</td>
                            <td>
                                <div class="btn-group mr-1 mb-1">
                                    <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="{{ route('bookings.ongoing', $row->id) }}"><i class="fa fa-eye"></i>View </a>

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
            <div class="tab-pane fade <?php if($type =='completed'){echo 'show active';}?>" id="nav-com-trip" role="tabpanel" aria-labelledby="nav-com-trip-tab">
            
                
                <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Booking ID</th>
                            <th>Trip Date</th>
                            <th>Pick up location</th>
                            <th>Operator name</th>
                            <th>trip ended on</th>
                            <th>total trip fee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($completed))
                            @foreach($completed as $key => $row)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{$row->id}}</td>
                                <td>{{$row->pickup_date}}</td> 
                                <td>{{ Str::limit($row->pickup_address, 30) }}</td>
                                <td>{{$row->quotes[0]->operator['name'] ?? ""}}</td>
                                <td>{{ ($row->is_return == 1) ? $row->return_date : $row->trip_end_date}}</td>
                                <td>{{ $row->quotes[0]->amount ?? "-" }}</td>
                                <td>
                                    <div class="btn-group mr-1 mb-1">
                                        <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="{{ route('bookings.completed', $row->id) }}"><i class="fa fa-eye"></i>View </a>

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
            <div class="tab-pane fade <?php if($type =='cancelled'){echo 'show active';}?>" id="nav-can-trip" role="tabpanel" aria-labelledby="nav-can-trip-tab">
                
            
            <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Booking ID</th>
                            <th>Trip Date</th>
                            <th>Pick up location</th>
                            {{-- <th>Cancelled by</th> --}}
                            <th>Trip cancelled before</th>
                            <th>refund status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($cancelled))
                            @foreach($cancelled as $key => $row)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{$row->id}}</td>
                                <td>{{$row->pickup_date}}</td> 
                                <td>{{ Str::limit($row->pickup_address, 30) }}</td>
                                <td>before</td>
                                <td>{{ ($row->is_refund == 1) ? "Security deposit refunded" : 'refunded'}}</td>
                                <td>
                                    <div class="btn-group mr-1 mb-1">
                                        <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="{{ route('bookings.cancelled', $row->id) }}"><i class="fa fa-eye"></i>View </a>

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

         
        
        <p style = "color:#f7941e; font-style:italic;"><b>*Note: <b>You will lose your deposit if You cancel after 168 hours before trips started.</p>

    </div>
</section>

@endsection