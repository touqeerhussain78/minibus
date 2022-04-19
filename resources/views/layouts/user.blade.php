<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('/frontend/images/favicon.ico')}}?v=1.0" sizes="32x32"/>
	<input type="hidden" id="url" value="{{ url('/')}}">
	
	<input type="hidden" id="asset_url" value="{{ asset('/frontend')}}">
	<title>{{config('app.name')}} - @yield('title')</title>
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700,300" rel="stylesheet">
	<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{ asset('/frontend/css/hover-min.css')}}" type="text/css">
	<link rel="stylesheet" href="{{ asset('/frontend/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('/frontend/css/animate.css')}}">
	<link href="{{ asset('/frontend/fonts/fontawesome/css/all.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/frontend/css/mega-menu.css')}}" type="text/css">
	<link rel="stylesheet" href="{{ asset('/frontend/css/datatables.min.css')}}" type="text/css">
	<link rel="stylesheet" href="{{ asset('/frontend/css/style.css')}}" type="text/css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<style>
    #audiocall{
        display:none;
    }
</style>
<style>

	.loader_div{
		position: absolute;
		top: 0;
		bottom: 0%;
		left: 0;
		right: 0%;
		z-index: 99;
		opacity:0.7;
		display:none;
		background: lightgrey url('/loaderimages.gif') center center no-repeat;
		}
    </style>
<style>
.twhite{color: #fff !important;}
.show-read-more .more-text{
        display: none;
    }
#loader{ display: none;}

.blockUI.blockMsg.blockElement {
            width: 100px !important;
            height: 100px !important;
            border-radius: 50%;
            color: transparent !important;
            background-color: transparent !important;
            transform: translateX(-50%) translateY(-50%);
            top: 50% !important;
            left: 50% !important;
            border-color: white !important;
            border-top-color: #f7941e !important;
            animation: spinner 1.2s ease-in-out infinite;
        }

        @keyframes spinner {
            0% {
                transform: translateX(-50%) translateY(-50%) rotate(0deg);
            }
            100% {
                transform: translateX(-50%) translateY(-50%) rotate(360deg);
            }
        }
</style>

</head>

<body id="my-body">


	<!--header start here-->
	<header class="header_area inner-header">
		<div class="container">
			<div class="main_header_area animated">
				<div class="row">
					<div class="col-12">
						<div class="pull-right"> <a href="tel:0114 345 0114"> <i class="fa fa-phone fa-rotate-90"></i> 0114 345 0114</a> <a href="mailto:info@minibuscomparison.co.uk"> <i class="fa fa-envelope"></i> info@minibuscomparison.co.uk</a> </div>
					</div>
				</div>
				<div class="navi">
					<div class="row">
                    <div class="col-12 col-sm-3"> <a href="{{url('/')}}"><img src="{{ asset('/frontend/images/logo.png')}}" alt="" class="img-fluid"></a> </div>
						<div class="col-sm-9 col-12">
							<ul>

								<li>
									<div id="myNav" class="overlay"> <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
										<div class="overlay-content">
											<a href="{{ route('about') }}">About</a>
											<a href="{{ route('services') }}">Services</a>
											<a href="{{ route('clients') }}">Clients</a>
											<a href="{{ route('contact-us') }}">Contact</a>
											@if(!Auth::guard('operators')->check() && !Auth::guard('web')->check())
											<a href="{{ route('login') }}">Login</a>
											@endif
										</div>
									</div>
									<div class="toggle" onclick="openNav()">
										<div class="second-toggle"></div>
									</div>
								</li>
								<li class="search-main">
									<div class="main-header__searchbar">
										<div class="main-header__searchbar__curtain main-header__searchbar__curtain--1"></div>
										<div class="main-header__searchbar__cont main-header__searchbar__curtain main-header__searchbar__curtain--2">
											<div class="main-header__searchbar__input">
												<form action="{{ route('search') }}" method="GET" class="form-inline">
														<input type="text" name="search" placeholder="Start typing to search minibus" autofocus="">
													<input type="submit" value="Submit" class="pur" style="color: #fff !important;">
													
												</form>
												<div class="main-header__searchbar__close">
													<img src="http://dev17.onlinetestingserver.com/hn/al-hadi-wp/wp-content/themes/al-hadi/images/close-icon.png">
												</div>
											</div>
										</div>
									</div>
									<div class="main-header__search__toggle wow slideInDown">
										<span class="icon-search"><i class="fa fa-search"></i></span>
									</div>
								</li>
									<li>
									    @if(Auth::guard('operators')->check())
									        <a class="nav-link nav-link-label" href="/operators/chat" > <i style ="margin-top:10px;" class="fas fa-comments"></i>  
                                                <span class="message-badge badge badge-pill" style = "background:#f69016;" id="message-badge"></span>
                                            </a>
                                        @else
                                               <a class="nav-link nav-link-label" href="{{route('messages')}}" > <i style ="margin-top:10px;" class="fas fa-comments"></i>  
                                                <span class="message-badge badge badge-pill" style = "background:#f69016;" id="message-badge"></span>
                                            </a>
                                        @endif
									    
									</li>
								@if(Auth::guard('web')->check())
								<li class="dropdown dropdown-notification nav-item"> <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="fa fa-bell"></i> <span class="badge badge-pill badge-default badge-danger badge-default badge-up">{{ auth()->user()->unreadNotifications->count() }}</span> </a>
									@if(auth()->user()->unreadNotifications->count() > 0)
									<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
										<li class="dropdown-menu-header">
											<h6 class="dropdown-header m-0"> 
												<span class="grey darken-2">Notifications</span> 
												
												<span class="notification-tag badge badge-default badge-danger float-right m-0">{{ auth()->user()->unreadNotifications->count() }} New</span>
												
											</h6>
										</li>
										<li class="scrollable-container media-list ps-container ps-theme-dark ps-active-y" data-ps-id="cbae8718-1b84-97ac-6bfa-47d792d8ad89">
											@foreach (auth()->user()->unreadNotifications as $notification)
											<a  onclick="markRead('{{$notification->id}}')" role="button">
												<div class="media">
													<div class="media-left align-self-center"><i class="fa fa-exclamation-circle"></i>
													</div>
													<div class="media-body">
														<h6 class="media-heading">{{ $notification->data['title'] }}</h6>
														<p class="notification-text font-small-3 text-muted">{{ $notification->data['message'] }}</p>
														<small>
                    									<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}</time>
                    									</small>
													</div>
												</div>
											</a>
											@endforeach
                 
										</li>
										{{-- <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" onclick="markRead()" role="button">Read all notifications</a>
										</li> --}}
									</ul>
									@endif 
								</li>
								<li class="dropdown dropdown-user nav-item show">

									<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown" aria-expanded="true">
										<div class="tog">
											<div class="media align-items-center">
												<img src="{{Auth::user()->image ?? asset('/frontend/images/avatar.png')}}" alt="avatar" onerror="this.style.display='none'">
												<div class="media-body">
													<h6 class="user-name">{{Auth::user()->name ?? ""}} <i class="fa fa-angle-down"></i></h6>
												</div>
											</div>
										</div>
									</a>
									
									<div class="dropdown-menu dropdown-menu-right ">
											<a class="dropdown-item" href="{{ route('profile')}}"><i class="fa fa-angle-right"></i>Profile</a>
											<a class="dropdown-item" href="{{ route('bookings')}}"><i class="fa fa-angle-right"></i>My Bookings</a>
											<a class="dropdown-item" href="{{ route('payment-logs') }}"><i class="fa fa-angle-right"></i>Payment Log</a>
											<a class="dropdown-item" href="{{ route('messages') }}"><i class="fa fa-angle-right"></i>Message</a>
											<a class="dropdown-item" href="{{ route('contact-us') }}"><i class="fa fa-angle-right"></i>Contact Us</a>
											<a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-angle-right"></i>Logout</a>
									</div>
									
								</li>
							
							@elseif(Auth::guard('operators')->check())
							<li class="dropdown dropdown-notification nav-item"> <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="fa fa-bell"></i> <span class="badge badge-pill badge-default badge-danger badge-default badge-up">{{ Auth::guard('operators')->user()->unreadNotifications->count() }}</span> </a>
								@if(Auth::guard('operators')->user()->unreadNotifications->count() > 0)
								<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
									<li class="dropdown-menu-header">
										<h6 class="dropdown-header m-0"> 
											<span class="grey darken-2">Notifications</span> 
											
											<span class="notification-tag badge badge-default badge-danger float-right m-0">{{ Auth::guard('operators')->user()->unreadNotifications->count() }} New</span>
											
										</h6>
									</li>
									<li class="scrollable-container media-list ps-container ps-theme-dark ps-active-y" data-ps-id="cbae8718-1b84-97ac-6bfa-47d792d8ad89">
										@foreach (Auth::guard('operators')->user()->unreadNotifications as $notification)
										<a  onclick="markRead('{{$notification->id}}')" role="button">
											<div class="media">
												<div class="media-left align-self-center"><i class="fa fa-exclamation-circle"></i>
												</div>
												<div class="media-body">
													<h6 class="media-heading">{{ $notification->data['title'] }}</h6>
													<p class="notification-text font-small-3 text-muted">{{ $notification->data['message'] }}</p>
													<small>
													<time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}</time>
													</small>
												</div>
											</div>
										</a>
										@endforeach
			 
									</li>
									<!-- <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" onclick="markRead()" role="button">Read all notifications</a>
									</li> -->
								</ul>
								@endif 
							</li>
								<li class="dropdown dropdown-user nav-item show">

									<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown" aria-expanded="true">
										<div class="tog">
											<div class="media align-items-center">
												<img src="{{Auth::guard('operators')->user()->image ?? asset('/frontend/images/avatar.png')}}" alt="avatar" onError="this.onerror=null;this.src='/frontend/images/avatar.png';">
												<div class="media-body">
													<h6 class="user-name">{{Auth::guard('operators')->user()->name ?? ""}} <i class="fa fa-angle-down"></i></h6>
												</div>
											</div>
										</div>
									</a>
									
									<div class="dropdown-menu dropdown-menu-right ">
										<a class="dropdown-item" href="{{ url('operators') }}"><i class="fa fa-angle-right"></i>Profile</a>
											<a class="dropdown-item" href="{{ route('operators.payment-logs') }}"><i class="fa fa-angle-right"></i>Payment Log</a>
											<a class="dropdown-item" href="{{ route('operators.quotation-logs') }}"><i class="fa fa-angle-right"></i>Quotation Log</a>
											<a class="dropdown-item" href="{{ route('operators.chat') }}"><i class="fa fa-angle-right"></i>Message</a>
											<a class="dropdown-item" href="{{ route('operators.contact-us') }}"><i class="fa fa-angle-right"></i>Contact Admin</a>
											<a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-angle-right"></i>Logout</a>
									</div>
								</li>
							@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!--header end here-->
	@if(Auth::guard('operators')->check())
		@include( 'layouts/operator_header')
	@endif
    <!--Views start here-->

    @yield('content')

    <!--Views end here-->

    <footer>

        <!--ready start here-->
        <section class="ready">
          <div class="container wow fadeIn" data-wow-duration=".5s" data-wow-delay=".5s">
            <div class="row">
              <div class="col-lg-7 col-md-12 wow fadeInLeft text-lg-left text-center" data-wow-duration="1.5s" data-wow-delay=".8s">
                <h2>Are You Ready? Let’s Talk!</h2>
              </div>
              <div class="col-lg-5 col-md-12 wow fadeInRight p-0 text-lg-left text-center" data-wow-duration="1.5s" data-wow-delay=".8s">
                <div class="pull-lg-right"> <a href="{{ route('advertise') }}" class="pur">Advertise <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></a> 
                    <a href="{{ route('contact-us') }}" class="yel">Contact us <img src="{{ asset('/frontend/images/arrow.png') }}" class="img-fluid" alt=""></a> </div>
              </div>
            </div>
          </div>
        </section>
        <!--ready end here-->
        <div class="container">
          <div class="footer-top">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="footer footer-1">
                  <h6>Minibus <br>
                    Comparison</h6>
                  <p>5 Ivegate, Yeadon Leeds LS197RE</p>
				  <a href="mailto:info@minibuscomparison.co.uk">Email: info@minibuscomparison.co.uk</a>
				   <a href="tel:01143450114">Tel:  0114 345 0114</a> 
				</div>
              </div>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="footer footer-3">
                  <h6>Quick Links</h6>
                  <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Sitemap</a></li>
                    <li><a href="#">about us</a></li>
                    <li><a href="#">Why Us</a></li>
                    <li><a href="#">How We Work</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="footer footer-3">
                  <h6>Quick Links</h6>
                  <ul>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">What We Offer</a></li>
                    <li><a href="#">Privacy policy</a></li>
                    <li><a href="#">Cookie policy</a></li>
                    <li><a href="#">Contact Us</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="footer footer-1 footer-4">
                  <h6> newsletter</h6>
                  <form>
                    <div class="row">
                      <div class="col-md-12">
                        <p>Enter your email and we'll send you more information.</p>
                        <input id="email" type="email" class="form-control" spellcheck="true" placeholder="your email">
                    	<button id="subscribe" type="button">Subscribe</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="footer-bottom footer-1 ">
            <div class="row">
              <div class="col-md-6 col-12">
                <p>© Copyright 2020 <span>Minibus Comparison.</span></p>
              </div>
              <div class="col-md-6 col-12">
                <ul>
					<li><a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a></li>
					<li><a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
					<li><a href="https://www.google.com" target="_blank"><i class="fab fa-google"></i></a></li>
					<li><a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
	  </footer>
	  <div id="loader">
		<img style="height: 130px; width: 200px;" src="{{ asset('/frontend/images/load.gif')}}">
	</div>
	  <!--footer end here-->
	  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
      <script src="{{ asset('/frontend/js/jquery.min.js') }}"></script>
      <script src="{{ asset('/frontend/js/step-fom.js') }}"></script>
      <script src="{{ asset('/frontend/js/datatable-basic.js') }}"></script>
      <script src="{{ asset('/frontend/js/datatables.min.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script src="{{ asset('/frontend/js/function.js') }}"></script>
      <script src="{{ asset('/frontend/js/owl.carousel.min.js') }}"></script>
      <script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('/frontend/js/wow.min.js') }}"></script>
      <script>
      function openNav() {document.getElementById("myNav").style.height = "100%";}
      function closeNav() {document.getElementById("myNav").style.height = "0%";}
	  </script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script>
             $('.main-header__search__toggle').click(function(){ $('body').addClass('search-open'); }); $('.main-header__searchbar__close').click(function(){ $('body').removeClass('search-open'); });

		  </script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHPUufTlBkF5NfBT3uhS9K4BbW2N-mkb4&libraries=places"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
	
  

	 <script src="{{ asset('/frontend/js/user.js') }}"></script>
	 @yield('js')
	<script>
	   $(document).ready(function(){
            $(".sendspecialinvitebtn").click(function(){
	            $('.loader_div').show();
            });
	   });
    
	</script>

	 @if(Auth::guard('operators')->check())
	 <script>
	 //get message counter every 5 seconds
	    setInterval(getMessageCounter, 5000);
	    function getMessageCounter(){
	         $.ajax({
                    async: true,
                    url:"/operators/get-message-count",
                    type: 'GET',
                    data:{},
                    success: function(data){
                        if(data == 0){
                            $('.message-badge').text('');
                        }
                        else{
                            $('.message-badge').text('');
                            $('.message-badge').text(data);    
                        }
                        
                        // document.getElementById("message-badge").innerHTML = d.toLocaleTimeString();
                    }
                });
        }     
        
            
	</script>
	 @elseif(Auth::guard('web')->check())
	 <script>
	 //get message counter every 5 seconds
	    setInterval(getMessageCounter, 5000);
	    function getMessageCounter(){
	         $.ajax({
                    async: true,
                    url:"/get-message-count",
                    type: 'GET',
                    data:{},
                    success: function(data){
                        if(data == 0){
                            $('.message-badge').text('');
                        }
                        else{
                            $('.message-badge').text('');
                            $('.message-badge').text(data);    
                        }
                        
                        // document.getElementById("message-badge").innerHTML = d.toLocaleTimeString();
                    }
                });

        }     
        
            
	</script>
	 @endif()
      </body>
      </html>
