@extends('layouts.app')
@section('title','Home')
@section('content')

<div class="header-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-12">
          <h5>Save Time &amp; Money</h5>
          <h1>MiniBus <br>
            Comparsion</h1>
          <a href="#"><i class="fa fa-play"></i> Watch Video</a> <a href="#" class="learn">Learn More <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a> </div>
        <div class="col-lg-5 offset-lg-1 col-12">
        @if(!Auth::guard('operators')->check())
          <div class="box">
            <div class="box-top">
              <h3>Get A Quote</h3>
            </div>
            <form action="{{route('quote')}}" method="POST">
              @csrf
              <div class="box-bottom">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                <label for="passangers">No. of passengers <i class="fa fa-user-circle"></i></label>
                <input type="number" id="passengers" name="passengers" class="form-control" placeholder="No of Passengers" required>
                <label for="Post">Where do you want to go?
                    <i class="fa fa-map-marker-alt"></i></label>
                <input type="text" id="dropoff_location" class="form-control" name="dropoff_location" placeholder="Location" required>
                <input type="hidden" id="dropoff" class="form-control" name="dropoff" >

                <label for="Post">Where do you want to go from? <i class="fa fa-map-marker-alt"></i></label>
                  <input type="text" id="pickup_location" class="form-control" name="pickup_location" placeholder="Location" required>
                  <input type="hidden" id="pickup" class="form-control" name="pickup" >
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-12">
                    <label class="check">Self Drive
                      <input type="checkbox" value="1" name="type[]" checked="checked">
                      <span class="checkmark"></span></label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-12">
                    <label class="check">With Driver
                      <input type="checkbox" value="2" name="type[]" checked="checked">
                      <span class="checkmark"></span></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 text-center">
                    @if(Auth::guard('web')->check())
                    <button type="submit" id="quote"> Get Quote</button>
                    @else 
                      <button type="submit" id="a-login"> Get Quote</button>
                      <a href="#" class="learn" id="b-login" data-toggle="modal" data-target=".login-modal-lg" style="margin-top:15px;">Get Quote </a>
                    @endauth
                  </div>
                </div>
              </div>
              </form>
           
              @endif
           
            </div>
        
        
        
        </div>
      
      </div>
    </div>
  </div>

  <!--quote start here-->

<section class="quote wow fadeIn" data-wow-duration=".5s" data-wow-delay=".5s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h3>QUOTES IN 2 EASY STEPS</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-12 wow fadeInLeft d-flex" data-wow-duration="1.s" data-wow-delay=".5s">
          <div class="box flex-column"> <img src="{{ asset('/frontend/images/quote-1.png')}}" class="img-fluid" alt="img">
            <h4>ENTER</h4>
            <p>Enter your departure location and number of passengers</p>
          </div>
        </div>
        <div class="col-md-6 col-12 wow fadeInRight d-flex" data-wow-duration="1.5s" data-wow-delay=".5s">
          <div class="box flex-column"> <img src="{{ asset('/frontend/images/quote-3.png')}}" class="img-fluid" alt="img">
            <h4>Submit </h4>
            <p>Submit your journey information and wait for a response</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--quote end here-->

  <!--about start here-->

  <section class="about wow fadeIn" data-wow-duration=".5s" data-wow-delay=".5s">
    <div class="my-container">
      <div class="row">
        <div class="col-lg-6 col-12 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".6s"> <img src="{{ asset('/frontend/images/about-1.png')}}" class="img-fluid" alt="img"> </div>
        <div class="col-lg-6 col-12 wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".6s">
            <div class="right">
          <h5>Who We Are</h5>
          <h3>About Us</h3>
          <p>Minibus Comparison offers you the facility to find and compare Minibus operators throughout the U.K. </p>
          <p>Simply enter the number of passengers and your location and you will be provided with a list of operators offering their services in your area. Select your chosen operators, enter your travel details and click submit.</p>
          <a href="#">Learn More <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a>
            </div>
           </div>
      </div>
    </div>
  </section>

  <!--about end here-->

  <!--find start here-->

  <section class="find">
    <div class="container wow fadeIn" data-wow-duration=".5s" data-wow-delay=".5s">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <h5>Find Out</h5>
          <h3>Top New Operators</h3>
        </div>
      <div class="col-md-6 col-sm-12 "> <a href="{{ route('view-all-operator')}}" class="pull-right">View All Operator <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a> </div>
      </div>
      <div class="row">
        @foreach($operators as $row)
       
        <div class="col-md-6 col-lg-4 col-12 text-center wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".6s">
          <div class="boxx"> <img src="{{ isset($row->image) ? $row->image : asset('/frontend/images/find-1.png')}}" class="img-fluid" alt="">
            <h6>{{ $row->name }}</h6>
            <p>{{ $row->company_name }}</p>
            <p><span>{{ $row->phone_no }}</span></p>
            <p><i class="fa fa-map-marker-alt"></i></p>
            <p><span>Area Covered</span></p>
            <p>{{ $row->address }}</p>
            <p>{{ $row->city }} | {{ $row->state }} | {{ $row->country }}</p>
          <a href="{{ route("home.operator", $row->id)}}">View Profile <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a> </div>
        </div>
       @endforeach

      </div>
    </div>
  </section>

  <!--find end here-->

  <!--why start here-->
  <section class="why">
    <div class="my-container wow fadeIn" data-wow-duration=".5s" data-wow-delay=".5s">
      <div class="row">
        <div class="col-md-12 col-lg-6 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".8s">
          <h3>why choose us</h3>
          <div class="row">
            <div class="col-md-6 col-sm-12 d-flex">
              <div class="box flex-column"> <img src="{{ asset('/frontend/images/why-1.png')}}" class="img-fluid" alt="">
                <p>Quotes directly from <br>Operators </p>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 d-flex">
              <div class="box flex-column"> <img src="{{ asset('/frontend/images/why-2.png')}}" class="img-fluid" alt="">
                <p>Competitive Rates </p>
              </div>
            </div>
          </div>
          <div class="row pl-xl-5">
            <div class="col-md-6 col-sm-12 d-flex ">
              <div class="box flex-column"> <img src="{{ asset('/frontend/images/why-3.png')}}" class="img-fluid" alt="">
                <p>Secure your booking </p>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 d-flex  ">
              <div class="box flex-column "> <img src="{{ asset('/frontend/images/why-4.png')}}" class="img-fluid" alt="">
                <p>DVSA Licensed Operators <br>to ensure your safety</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-12 text-lg-left text-center wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".8s"> <img src="{{ asset('/frontend/images/why-bus.png')}}" class="bus img-fluid" alt=""> </div>
      </div>
    </div>
  </section>

  <!--why end here-->

  <!--why-2 start here-->

  <div class="why-2">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".8s">
          <div class="boxx"> <img src="{{ asset('/frontend/images/why-5.png')}}" class="img-fluid" alt="">
            <div class="boxx-bottom">
              <h6>Minibus Hire/ Minibus Rental Minibus Hire UK</h6>
              <p>Are you looking to pick up a minibus hire service to take you across the United Kingdom? </p>
              <p>Then you are in the right place. We make it very easy indeed for you to carry out these key factors as time goes on. </p>
              <a href="#">Read more <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a> </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 wow fadeIn" data-wow-duration="1.5s" data-wow-delay=".8s">
          <div class="boxx"> <img src="{{ asset('/frontend/images/why-6.png')}}" class="img-fluid" alt="">
            <div class="boxx-bottom">
              <h6>Affordable Minibus Hire across the UK</h6>
              <p>One thing that we care about more than most is the desire to give y.ou a simple minibus hire service. In just three easy steps, you can get quotes from all reputable operators that could help you to make your minibus hire... </p>
              <a href="#">Read more <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a> </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".8s">
          <div class="boxx"> <img src="{{ asset('/frontend/images/why-7.png')}}" class="img-fluid" alt="">
            <div class="boxx-bottom">
              <h6>Minibus Hire/ Minibus Rental Minibus Hire UK</h6>
              <p>Are you looking to pick up a minibus hire service to take you across the United Kingdom? </p>
              <p>Then you are in the right place. We make it very easy indeed for you to carry out these key factors as time goes on. </p>
              <a href="#">Read more <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--why-2 end here-->

  <!--testimonial start here-->

  <section class="testi">
    <div class="container wow fadeIn" data-wow-duration=".5s" data-wow-delay=".5s" >
      <div class="row">
        <div class="col-md-6 col-12">
          <h5>Testimonial</h5>
          <h3>Some Of Our Clients <br>
            Saying About Us.</h3>
        </div>
        <div class="col-md-6 col-12"> <a href="#" class="pull-right">View All Testimonials <img src="{{ asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></a> </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".8s">
          <div class="box"> <i class="fa fa-quote-left"></i>
            <p>Learning curve deployment testing is scrum project investor twitte backing innovator social media market design user experence return on investment scrum is a project series a financing twitter backing traction.</p>
            <div class="box-bottom"> <img src="{{ asset('/frontend/images/testi-1.png')}}" class="img-fluid pull-left mr-3" alt="">
              <h4>Stephen Patterson</h4>
              <h6>Redbox Company</h6>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 wow fadeIn" data-wow-duration="1.5s" data-wow-delay=".8s">
          <div class="box"> <i class="fa fa-quote-left"></i>
            <p>Learning curve deployment testing is scrum project investor twitte backing innovator social media market design user experence return on investment scrum is a project series a financing twitter backing traction.</p>
            <div class="box-bottom"> <img src="{{ asset('/frontend/images/testi-2.png')}}" class="img-fluid pull-left mr-3" alt="">
              <h4>Stephen Patterson</h4>
              <h6>Redbox Company</h6>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".8s">
          <div class="box"> <i class="fa fa-quote-left"></i>
            <p>Learning curve deployment testing is scrum project investor twitte backing innovator social media market design user experence return on investment scrum is a project series a financing twitter backing traction.</p>
            <div class="box-bottom"> <img src="{{ asset('/frontend/images/testi-3.png')}}" class="img-fluid pull-left mr-3" alt="">
              <h4>Stephen Patterson</h4>
              <h6>Redbox Company</h6>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  
        <div class="modal fade login-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index: 11111;">
            <div class="modal-dialog modal-lgg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    <div class="payment-modal-main">
                        <div class="payment-modal-inner">
                            <h2>Login</h2>

                            <form id="login">
                                @csrf
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <i class="fa fa-envelope"></i>
                                        <input type="email" name="email" id="login_email" placeholder="Email" class="form-control">
                                    </div>
                                    <div class="col-12 form-group">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" name="password" id="login_password" placeholder="Password" class="form-control">
                                    </div>
                                    
                                    <div class="col-12 text-center">
                                        <button class="pur" type="submit">Submit <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

  <!--testimonial end here-->

@endsection
