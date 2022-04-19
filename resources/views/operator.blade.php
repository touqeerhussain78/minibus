@extends('layouts.user')
@section('title','Operator')
@section('content')

<section class="operator-profile-main p-100">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>Operator profile</h2>
				@if ($message = Session::has('message'))
				<br/>
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong>{{ Session::get('message') }}</strong>
					</div>
				@endif
			</div>
        </div>
        <?php //dd( operator_rating($operator->id)); ?>
		<div class="operator-profile border-b d-md-flex justify-content-between">
			<div class="left">
				<div class="media">
					<img src="{{ isset($operator->image) ? $operator->image : asset('/frontend/images/avatar.png')}}" class="img-fluid" alt="">
					<div class="media-body">
						<h3>{{ $operator->name }}</h3>
						<h4 style="margin-bottom: 10px;">{{ $operator->company_name }}</h4>
						{{-- @if(operator_rating($operator->id) > 0) --}}
						
						<?php $stars = operator_rating($operator->id); $stars = round($stars,0); ?>
						@for($i= 1;$i<=$stars;$i++)
							@if($i>5)
								@break(0);
							@endif
							<i class="fa fa-star" style="color: #edac08"></i>
						@endfor
							@if(5-$stars > 0)
								@for($i= 1;$i<=5-$stars;$i++)
									<i class="fa fa-star"></i>
								@endfor
							@endif
					
						{{-- @endif --}}
					</div>
				</div>
			</div>
			<div class="right">
				@if(Auth::guard('web')->check())
			<a href="{{ route('chat', $operator->uuid) }}">
					<div class="media align-items-center">
						<img src="{{ asset('/frontend/images/message.png') }}" class="img-fluid" alt="message image">
						<div class="media-body">
							<p>Message</p>
						</div>
					</div>

				</a>
				@endif
			</div>
		</div>	


		<div class="operator-bus">
			
			<div class="row">
				@if($buses)
					@foreach($buses as $row)
						<div class="col-lg-3 col-sm-6 col-md-4 col-12">
							<img src="{{ $row->path }}" class="img-fluid" alt="bus image">
						</div>
					@endforeach
				@endif
			</div>

		</div>
		
		<div class="about-operator border-b"> 
			<div class="row">
				<div class="col-12">
					<h3>Further Information</h3>
					<p>{{ $operator->aboutme ?? "" }} </p>
				</div>
			</div> 
		</div>

		<div class="operator-bus">
			<div class="row">
				<div class="col-12">
					<h3>Minibus Type</h3>
					@if(count($operator->minibus) > 0)
					<ul>
						<li>{{ ($operator->minibus[0]['type'] == 1) ? 'With Driver Only' : ($operator->minibus[0]['type'] == 2) ? "Self" : "Both" }}</li>
						<li>Model: <span>{{ $operator->minibus[0]['model'] }}</span></li>
						<li>Capacity: <span>{{ $operator->minibus[0]['capacity'] }}</span></li>
					</ul>
					<p>{{ $operator->minibus[0]['description'] }} </p>
					@endif
				</div>
			</div> 
		</div>

		
		<div class="operator-review review-content">
			@if( Auth::check())
			<h3>Reviews</h3>
			
			@if ($errors->any())
				@foreach ($errors->all() as $error)
					<div class="alert alert-danger" style="margin-top: 10px;">{{$error}}</div>
				@endforeach
			@endif
			@if(isset($allowed) && $allowed == 1)
			<form method="post" action="{{ route('add-review')}}">
				@csrf
                <div class="row">
                    <div class="col-12">
					<input type="hidden" name="operator_id" value="{{ $operator->id }}" />
                        <textarea name="review"  placeholder="Add review" class="form-control"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" class="pur">send <img src="{{ asset('/frontend/images/arrow.png') }}" alt=""></button>
                    </div>
                </div>
			</form>
			@endif
			@endauth
			
			@foreach ($reviews as $row)
			<div class="review-box">
				<div class="media m-0">
					<img src="{{ isset($row->user->image) ? $row->user->image : asset('/frontend/images/avatar.png') }}" class="img-fluid" alt=""> 
					<div class="meida-body">
						<p>{{ $row->comments }}</p>
						<ul class="stars">
							<li class="active"><i class="fa fa-star"></i></li>
							<li class="active"><i class="fa fa-star"></i></li>
							<li class="active"><i class="fa fa-star"></i></li>
							<li class="active"><i class="fa fa-star"></i></li>
							<li class="active"><i class="fa fa-star"></i></li>
						</ul>
						<div class="d-flex justify-content-between">
							<h6>{{ $row->user->name }}</h6>
							
						</div> 
					</div>
				</div>
			</div>
			@endforeach
			
		</div>

	</div>
</section>

@endsection

@section('js')
<script>
$(function () {
	var ratingValue = $('#op-rating').val(), rounded = (ratingValue | 0);
	console.log('ratingValue',ratingValue);
	for (var j = 0; j < 6; j++) {
	str = '<li class="active"><i class="fa ';
	if (j < rounded) {
		str += "fa-star";
	} else if ((ratingValue - j) > 0 && (ratingValue - j) < 1) {
		str += "fa-star-half-o";
	} else {
		str += "fa-star-o";
	}
	str += '" aria-hidden="true"></i><li>';
	$(".rating").append(str);
	}


});

</script>
@endsection