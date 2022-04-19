@extends('layouts.user')
@section('title','Operator Profile')
@section('content')

<section class="operator-profile-main accepted-profile o-profile p-100">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>My profile</h2>
				@if ($message = Session::has('message'))
				<br/>
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong>{{ Session::get('message') }}</strong>
					</div>
				@endif

				@if(!isset(auth()->user()->latitude) && !isset(auth()->user()->latitude))
				<br/>
				<div class="alert alert-danger alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong>Please edit your profile and save you current address.</strong>
					</div>
				@endif
			</div>
        </div>
        
		<div class="operator-profile border-b d-md-flex justify-content-between">
			<div class="left">
				<div class="media">
					<img src="{{ isset($operator->image) ? $operator->image : asset('/frontend/images/avatar.png')}}" class="img-fluid" alt="" onError="this.onerror=null;this.src='/frontend/images/avatar.png';">
					
					<div class="media-body">
						<h3>{{ $operator->name }}</h3>
						<h4>{{ $operator->company_name }}</h4>
						<br/>
						<?php $stars = operator_rating($operator->id); $stars = round($stars,0); ?>
						@for($i= 1;$i<=$stars;$i++)
							@if($i>5)
								@break(0);
							@endif
							<i class="fa fa-star" style="color:#edac08"></i>
						@endfor
							@if(5-$stars > 0)
								@for($i= 1;$i<=5-$stars;$i++)
									<i class="fa fa-star"></i>
								@endfor
							@endif
						
						
					</div>
				</div>
			</div>
			<div class="right"> 
                <a href="{{ url('operators/edit') }}" class="pur-s"><i class="fa fa-edit"></i>edit profile <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                <a href="#" class="yel-s" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-lock"></i>change password <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
			</div>
		</div>	

		<div class="operator-information">
			<div class="row">
				
				<div class="col-md-6">
				<label for=""><i class="fa fa-user-circle"></i>name</label>
					<p>{{ $operator->name }}</p>
				</div>  
				
				<div class="col-md-6">
				<label for=""><i class="fa fa-building"></i>Company</label>
					<p>{{ $operator->company_name }}</p>
				</div> 
				
				<div class="col-md-6">
				<label for=""><i class="fa fa-envelope"></i>Email</label>
					<p>{{ $operator->email }}</p>
				</div> 
				 
				<div class="col-md-6">
				<label for=""><i class="fa fa-phone fa-rotate-90"></i>phone</label>
					<p>{{ $operator->phone_no }}</p>
				</div> 
				  
				<div class="col-md-12">
				<label for=""><i class="fa fa-map-marker-alt"></i>Address</label>
					<p>{{ $operator->address }}</p>
				</div> 
				
				<div class="col-md-6">
				<label for=""><i class="fa fa-building"></i>city</label>
					<p>{{ $operator->city }}</p>
				</div> 
				 
				<div class="col-md-6">
				<label for=""><i class="fa fa-globe"></i>Country</label>
					<p>{{ $operator->country }}</p>
				</div> 

				<div class="col-md-6">
					<label for=""><i class="fa fa-building"></i>County</label>
						<p>{{ $operator->state }}</p>
					</div> 
				 
				<div class="col-md-6">
				<label for=""><i class="fa fa-pencil-alt"></i>Postal code</label>
					<p>{{ $operator->zipcode }}</p>
				</div> 
				
				<div class="col-md-6">
				<label for=""><i class="fa fa-address-card"></i>Driving Licence Number</label>
					<p>{{ $operator->drivers_license }}</p>
				</div>
				  
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
						<p>{{ $operator->aboutme ?? "" }}</p>
					</div>
				</div> 
			</div>
			@if(isset($operator->minibus[0]))
	
			<div class="operator-bus">
				<div class="row">
					<div class="col-12">
						<h3>Minibus Type</h3>
						<ul>
							<li>{{ $operator->minibus[0]['type'] == 1 ? 'Self' : ($operator->minibus[0]['type'] == 2 ? "With Driver Only" : "Both" )}}</li>
							<li>Model: <span>{{ $operator->minibus[0]['model'] }}</span></li>
							<li>Capacity: <span>{{ $operator->minibus[0]['capacity'] }}</span></li>
						</ul>
						<p>{{ $operator->minibus[0]['description'] }} </p>
						
					</div>
				</div> 
			</div>
			@endif
	
			@if(isset($reviews))
			<div class="operator-review">
				<h3>Reviews</h3>   
				
			 
				
				@foreach ($reviews as $row)
				<div class="review-box">
					<div class="media m-0">
						<img src="{{ isset($row->user->image) ? $row->user->image : asset('/frontend/images/avatar.png') }}" class="img-fluid" alt="">

						<div class="meida-body">
							<p>{{ $row->comments }}</p>
							<div class="d-flex justify-content-between">
								<h6>{{ $row->user->name }}</h6>
								<div>
								<?php $stars = get_rating_by_id($row->id); $stars = round($stars,0); ?>
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
								</div>
								{{-- <button type="button"><i class="fa fa-reply"></i>reply</button> --}}
							</div> 
						</div>
					</div>
				</div>
				
				<form action="{{ route('operators.review-reply') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-12">
						<input type="hidden" value="{{$row->id}}" name="id"/>
						<label style="margin-top: 15px;"><i class="fa fa-reply"> Reply</i></label>
						<textarea name="reply" rows="1" placeholder="Add Reply" class="form-control" required >{{$row->reply ? $row->reply : ""}}</textarea>
						@if($row->reply==null && $errors->has('reply'))
							<div class="alert alert-danger">{{ $errors->first('reply') }}</div>
						@endif
						</div>
					</div>
					
					<div class="row">
						<div class="col-12 text-right">
						@if($row->reply==null)
						<button type="submit" class="pur">send <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
						@endif
					</div>
					</div>
					</form>
				
				@endforeach
				@endif
			</div>
	
		</div>
	</section>
	
	
	
	<!-- change password modal start here-->
	
	<div class="login-fail-main user">
		<div class="featured inner">
			<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lgg">
					<div class="modal-content">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
						<div class="payment-modal-main">
							<div class="payment-modal-inner"> <img src="{{ asset('/frontend/images/modal-1.png')}}" class="img-fluid" alt="">
								<h2>Change password</h2>
	
								<form id="change_password">
									@csrf
									<div class="row">
										<input type="hidden" id="cp-url" value="{{ route('operators.update_password') }}">
										<div class="col-12 form-group">
											<i class="fa fa-lock"></i>
											<input type="password" name="old_password" id="old_password" placeholder="current password" class="form-control {{ $errors->has('old_password') ? ' has-error' : '' }}">
										</div>
										<div class="col-12 form-group">
											<i class="fa fa-lock"></i>
											<input type="password" name="new_password" id="password" placeholder="new password" class="form-control {{ $errors->has('new_password') ? ' has-error' : '' }}">
										</div>
										<div class="col-12 form-group">
											<i class="fa fa-lock"></i>
											<input type="password" name="confirm_password" id="password_confirmation" placeholder="re-type password" class="form-control {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
										</div>
										<div class="col-12 text-center">
											<button class="pur" type="submit">Save <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	


@endsection

@section('js')
<script>
<script>
$(document).ready(function(){
 
  $("#show").click(function(){
    $("p").show();
  });
});
</script>
</script>
<script>
$(function () {
	var ratingValue = {{ operator_rating($operator->id) }}, rounded = (ratingValue | 0);
	console.log('ratingValue',ratingValue);
	for (var j = 0; j < 5; j++) {
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


})
</script>
@endsection