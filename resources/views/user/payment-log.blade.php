@extends('layouts.user')
@section('title','Payment Logs')
@section('content')

<section class="payment-log p-100">
    <div class="container">
        <h2>Payment Log</h2>
            <div class="table-responsive">
                <div class="maain-tabble">
                    <table class="table table-striped table-bordered zero-configuration border-0">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Booking ID</th>
                                <th>Trip Date</th>
                                <th>Operator name</th>
                                <th>Trip Free</th>
                                <th>Security deposit</th>
                                <th>paid on</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment_logs as $item => $row)
                            {{-- @dd($row) --}}
                            <tr>
                                <td>{{ ++$item }}</td>
                                <td>{{ $row->booking_id }}</td>
                                <td>{{ $row->booking->pickup_date ?? "" }}</td>
                                <td><span data-toggle="popover" data-content="johny" class="circle"><img src="{{ $row->operator->image }}" class="img-fluid" alt=""></span>{{ $row->operator->name }}</td>
                                <td>£{{ $row->quote->amount ?? 0 }}</td>
                                <td>£{{ $row->amount }}</td>
                                <td>{{ $row->created_at ?? "" }}</td>
                                <td>
                                    <div class="btn-group mr-1 mb-1">
                                        <button type="button" class="btn  btn-drop-table btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 21px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item" href="{{ route('bookings.accepted', $row->booking_id) }}"><i class="fa fa-eye"></i>View </a>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>   
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        
    </div>
</section>

@endsection