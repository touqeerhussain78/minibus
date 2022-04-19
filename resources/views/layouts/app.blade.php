<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('/frontend/images/favicon.ico')}}" sizes="32x32"/>
	<title>{{config('app.name')}} - @yield('title')</title>
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.default.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/frontend/css/hover-min.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('/frontend/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/frontend/css/animate.css') }}">
	<link href="{{ asset('/frontend/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/frontend/css/mega-menu.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('/frontend/css/style.css') }}" type="text/css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>

	<!--header start here-->
	<header class="header_area index-header">
		<div class="my-container">
			<div class="main_header_area animated">
				<div class="row">
					<div class="col-12">
						<div class="pull-right"> <a href="tel:0114 345 0114"> <i class="fa fa-phone fa-rotate-90"></i> 0114 345 0114</a> <a href="mailto:info@minibuscomparison.co.uk"> <i class="fa fa-envelope"></i> info@minibuscomparison.co.uk</a> </div>
					</div>
				</div>
				<div class="navi">
					<div class="row">
						<div class="col-12 col-sm-3"> <a href="{{url('/')}}"><img src="{{ asset('/frontend/images/logo.png') }}" alt="" class="img-fluid"></a> </div>
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
								<li class="search-main"> <div class="main-header__searchbar">
										<div class="main-header__searchbar__curtain main-header__searchbar__curtain--1"></div>
										<div class="main-header__searchbar__cont main-header__searchbar__curtain main-header__searchbar__curtain--2">
											<div class="main-header__searchbar__input">
                      <form action="{{ route('search') }}" method="GET" class="form-inline">
                          <div class="form-group mb-2">
													<input type="text" name="search" placeholder="Start typing to search minibus" autofocus="">
                          <input type="submit" value="Submit" class="pur" style="color: #fff !important;">
                          </div>
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
									<nav id="navigation1" class="navigation">
                   
                   
                    @if(Auth::guard('operators')->check())
                      <li class="dropdown dropdown-user nav-item show">

                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown" aria-expanded="true">
                          <div class="tog">
                            <div class="media align-items-center">
                              <img src="{{Auth::guard('operators')->user()->image ?? asset('/frontend/images/avatar.png') }}" alt="avatar" onError="this.onerror=null;this.src='/frontend/images/avatar.png';">
                              <div class="media-body">
                                <h6 class="user-name">{{Auth::guard('operators')->user()->name}} <i class="fa fa-angle-down"></i></h6>
                              </div>
                            </div>
                          </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right ">
                          <a class="dropdown-item" href="{{ url('operators/edit') }}"><i class="fa fa-angle-right"></i>Profile</a>
                          <a class="dropdown-item" href="{{ route('operators.payment-logs') }}"><i class="fa fa-angle-right"></i>Payment Log</a>
											<a class="dropdown-item" href="{{ route('operators.quotation-logs') }}"><i class="fa fa-angle-right"></i>Quotation Log</a>
											<a class="dropdown-item" href="{{ route('operators.chat') }}"><i class="fa fa-angle-right"></i>Message</a>
											<a class="dropdown-item" href="{{ route('operators.contact-us') }}"><i class="fa fa-angle-right"></i>Contact Admin</a>
                            <a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-angle-right"></i>Logout</a>
                        </div>
                      </li>

                    @elseif(Auth::check())
                    <li class="dropdown dropdown-user nav-item show">

                      <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown" aria-expanded="true">
                        <div class="tog">
                          <div class="media align-items-center">
                            <img src="{{Auth::user()->image ?? asset('/frontend/images/avatar.png') }}" alt="avatar">
                            <div class="media-body">
                              <h6 class="user-name">{{Auth::user()->name}} <i class="fa fa-angle-down"></i></h6>
                            </div>
                          </div>
                        </div>
                      </a>
                      
                      <div class="dropdown-menu dropdown-menu-right ">
                        <a class="dropdown-item" href="{{ route('profile')}}"><i class="fa fa-angle-right"></i>Profile</a>
                        <a class="dropdown-item" href="{{ route('bookings')}}"><i class="fa fa-angle-right"></i>My Bookings</a>
                        <a class="dropdown-item"  href="{{ route('payment-logs') }}"><i class="fa fa-angle-right"></i>Payment Log</a>
                        <a class="dropdown-item" href="{{ route('messages') }}"><i class="fa fa-angle-right"></i>Message</a>
                        <a class="dropdown-item" href="{{ route('contact-us') }}"><i class="fa fa-angle-right"></i>Contact Us</a>
                        <a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-angle-right"></i>Logout</a>
                      </div>
                      
                    </li>
                    @else
                    <div class="home-buttons"> 
                      <a href="{{ route('login')}}"> login</a> 
                      <a href="{{ route('login')}}" class="register"> Register</a>
                    </div> 
                    @endif
                                    
                                      
                    
									</nav>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
    </header>
    <!--Views start here-->

     @yield('content')

   <!--Views end here-->

<!--footer start here-->

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
              <a mailto="info@minibuscomparison.co.uk">Email: info@minibuscomparison.co.uk</a> <a href="tel:01143450114">Tel:  0114 345 0114</a> </div>
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
              <form >
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

  <!--footer end here-->
  <script src="{{ asset('/frontend/js/jquery.min.js') }}"></script>
  <!--<script src="js/step-fom.js"></script>-->
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
  <script src="{{ asset('/frontend/js/app.js') }}"></script>
  <script src="{{ asset('/frontend/js/auth.js') }}"></script>
  
  </body>
  </html>
