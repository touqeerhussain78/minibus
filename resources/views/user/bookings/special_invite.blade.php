@extends('layouts.user')
@section('title','Special Invite')
@section('content')

<section class="special-invite p-100">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Send Special Invites</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-9 col-12">
                <div class="left">
                    <div class="operator-location">
                        <div class="title">
                            <h3>All Operators within 30 miles of your location</h3>
                        </div>
                    <input type="hidden" id="token" value="{{ csrf_token() }}" />
                        <!--operator detail start here-->

                        <div class="operator-detail">
                                @if(count($operators) > 0)
                                
                                <ul class="operators">
                                    @foreach($operators as $row)
                                    <li>
                                        <div class="media align-items-center">
                                            <img src="{{ isset($row->image) ? url('/').Storage::disk('local')->url($row->image) : asset('/frontend/images/avatar.png')}}" class="img-fluid" alt="bus image" onError="this.onerror=null;this.src='{{ asset('/frontend/images/avatar.png')}}';">
                                            <div class="media-body">
                                                <div class="d-md-flex d-block justify-content-between">
                                                    <div class="">
                                                    <h4>{{ $row->name }}</h4>
                                                    <h5>{{ $row->company_name }}</h5>
                                                    <a href="{{ route("home.operator", $row->id)}}">View Profile</a>
                                                    </div>
                                                    <div class="blockui">
                                                        <a role="button" style="cursor: pointer" onclick="sendSpecialInvites({{$row->id}}, {{$booking->id}})" class="special pur">Send Special Lead <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                                                        <div id="loader">
                                                            <img src="{{ asset('/frontend/images/load.gif')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <p> {{ $row->aboutme }} </p>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    @endforeach
                                </ul>
                                <div class="text-center">
                                    <a data-page="5" data-link="{{ route('bookings.special-invites', $booking->id)}}" data-div=".operators" class="yel see-more">load more <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                                </div>
                        @else 
                        <div class="text-center">
                            <a role="button" class="yel" style="cursor:pointer">There is no more operator in your region </a>
                        </div>
                        @endif 
                    </div>    
                        <!--operator detail start here-->

                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-12">
                <div class="right">


                    <div class="title text-center">
                        <h3>Journey Summary</h3>
                    </div>
                    <div class="journey">
                        <!--<h4 class="text-center">Your Journey Would Be:</h4>-->
                        <p><i class="fa fa-map-marker-alt"></i>To: <span>{{ $booking->dropoff_address }}</span>
                        </p>
                        <p><i class="fa fa-map-marker-alt"></i>From: <span>{{ $booking->pickup_address }}</span>
                        </p>
                        <p class="border-0"><i class="fa fa-users"></i>With: {{ $booking->no_of_passengers }} Passengers</p>
                        <p class="border-0 p-2">With: Driver</p>
                        <div class="text-center">
                        {{-- <a href="#" class="yel">Start Booking<img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a> --}}
                            </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>

@endsection

@section('js')
<script>
$(".see-more").click(function() {
  $avatar ='{{ asset('/frontend/images/avatar.png')}}'; //div to append
  $div = $($(this).attr('data-div')); //div to append
  $link = $(this).attr('data-link'); //current URL

  $page = $(this).attr('data-page'); //get the next page #
  $href = $link + '?page='+ $page; //complete URL
  console.log($href);
  $.get($href, function(response) { //append data
    console.log(response);
    if(response.length > 0){
        $.each(response, function(i, val) {
        $op = '<li><div class="media align-items-center">';
        if (val.image !== null){
            $op += '<img id="opimg" src="'+$('#url').val()+'/storage/'+val.image+'" onerror="onError(this);" class="img-fluid" alt="bus image">';
        }else{
            $op += '<img id="opimg" src="'+$avatar+'" onerror="onError(this);" class="img-fluid" alt="bus image">';
        }
        $op += '<div class="media-body">';
        $op += '<div class="d-md-flex d-block justify-content-between">';
        $op += '<div><h4>'+val.name+'</h4><h5>'+val.company_name+'</h5>';
        $op += '<a href="{{url("/operator/")}}/'+val.id+'">View Profile</a></div>';
        $op += ' <div class="blockui"><a role="button" style="cursor: pointer" onclick="sendSpecialInvites('+val.id+', {{ $booking->id}})" class="special pur">Send Special Lead <img src="http://127.0.0.1:8000/frontend/images/arrow.png" alt=""></a>';
        $op += '</div></div></div></div></li>';
    
        $('.operators').append($op);
    });
    }else{
        toastr.error('No new records found', 'Warning');
    }
    
    
  });

  $(this).attr('data-page', (parseInt($page) + 1)); //update page #
});
</script>
<script>
$(function(){
    var img = document.getElementById("opimg");
img.onerror = function () { 
    //this.style.display = "none";
    this.onerror=null;
    this.src= $('#url').val() +'/frontend/images/avatar.png';
}

});
</script>
@endsection