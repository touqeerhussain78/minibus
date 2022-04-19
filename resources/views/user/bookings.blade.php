@extends('layouts.user')
@section('content')

<section class="book-trip p-100">
    <div class="container">

        <h2>book trip</h2>



        <form id="regForm" action="confirm-booking.php">
            <div class="step-main d-flex">
                <span class="step">Pick Up Details</span>
                <span class="step">Return Details</span>
                <span class="step">Additional Details</span>
                <span class="step">Contact</span>
                <span class="step">Confirm</span>
            </div>


            <!-- One "tab" for each step in the form: -->
            <div class="tab tab-1">
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <input type="text" id="datepicker-2" readonly placeholder="Date Of Pick Up" class="form-control">
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" id="timepicker-1" readonly placeholder="Time Of Pick Up" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 offset-xl-3 col-12">
                        <div class="journey">
                            <div class="title">
                                <h2>Journey Summary</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Journey Would Be:</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>To: East London</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>From: north London</p>
                                <p class=""><i class="fa fa-users"></i>With: 10 Passengers</p>
                                <p class="">With: Driver</p>
                                <a href="#" class="yel">Start Again <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <div class="tab tab-2">
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Is this a one way trip?</label>

                                    <label class="login-radio">yes
                    <input type="radio" checked="checked" name="radio">
                    <span class="checkmark"></span></label>
                                    <label class="login-radio">No
                    <input type="radio" checked="checked" name="radio">
                    <span class="checkmark"></span></label>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" id="datepicker-3" readonly placeholder="Date Of Return" class="form-control">
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" id="timepicker-2" readonly placeholder="Time Of Departure" class="form-control">
                                </div>
                                <div class="col-12 form-group position-relative">
                                    <input type="text" required="required" placeholder="Drop off location on return" class="form-control">
                                    <i class="fa fa-map-marker-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 offset-xl-3 col-12">
                        <div class="journey">
                            <div class="title">
                                <h2>Journey Summary</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Journey Would Be:</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>To: East London</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>From: north London</p>
                                <p class=""><i class="fa fa-users"></i>With: 10 Passengers</p>
                                <p class="">With: Driver</p>
                                <a href="#" class="yel">Start Again <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                        <div class="journey">
                            <div class="title">
                                <h2>Pick up Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Minibus will pick you up on</h3>-->
                                <p class="border-b"><i class="fa fa-calendar"></i>15-06-2019</p>
                                <p class="border-b"><i class="fa fa-clock"></i>10: 30 am</p>
                                <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="tab tab-3">

                <div class="row">
                    <div class="col-xl-9 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12 form-group position-relative">
                                    <textarea name="" id="" cols="" required="required" class="form-control" placeholder="Enter Trip Reason" rows=""></textarea>
                                    <i class="fa fa-comments"></i>
                                </div>

                                <div class="col-12 form-group position-relative">
                                    <label for=""><i class="fa fa-briefcase"></i> Specify Luggage</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12 form-group">
                                    <select class="form-control">
                                        <option>Hand Luggage(10 kg)</option>
                                        <option>Hand Luggage(10 kg)</option>
                                        <option>Hand Luggage(10 kg)</option>
                                    </select>

                                </div>
                                <div class="col-md-4 col-sm-6 col-12 form-group">
                                    <select class="form-control">
                                        <option>Medium Luggage(20 kg)</option>
                                        <option>Medium Luggage(20 kg)</option>
                                        <option>Medium Luggage(20 kg)</option>
                                    </select>

                                </div>
                                <div class="col-md-4 col-sm-6 col-12 form-group">
                                    <select class="form-control">
                                        <option>Large Luggage(20+ kg)</option>
                                        <option>Large Luggage(20+ kg)</option>
                                        <option>Large Luggage(20+ kg)</option>
                                    </select>

                                </div>
                                <div class="col-12 form-group position-relative">
                                    <textarea name=""  cols="" required="required" class="form-control" rows="" placeholder="Additional Info"></textarea>
                                    <i class="fa fa-exclamation-circle"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-12">
                        <div class="journey">
                            <div class="title">
                                <h2>Journey Summary</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Journey Would Be:</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>To: East London</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>From: north London</p>
                                <p class=""><i class="fa fa-users"></i>With: 10 Passengers</p>
                                <p class="">With: Driver</p>
                                <a href="#" class="yel">Start Again <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                        <div class="journey">
                            <div class="title">
                                <h2>Pick up Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Minibus will pick you up on</h3>-->
                                <p class="border-b"><i class="fa fa-calendar"></i>15-06-2019</p>
                                <p class="border-b"><i class="fa fa-clock"></i>10: 30 am</p>
                                <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>

                        <div class="journey">
                            <div class="title">
                                <h2>return Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Return will be on</h3>-->
                                <p class="border-b"><i class="fa fa-calendar"></i>15-06-2019</p>
                                <p class="border-b"><i class="fa fa-clock"></i>06: 30 am</p>
                                <p class=""><i class="fa fa-map-marker-alt"></i>Drop off at return: </p>
                                <p class="">North London</p>
                                <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
            <div class="tab tab-2 tab-4">
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="left">
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Please confirm these details</label>
                                </div>
                                <div class="col-12 form-group position-relative">
                                    <input type="text" required="required" placeholder="Username" class="form-control">
                                    <i class="fa fa-user-circle"></i>
                                </div>
                                <div class="col-12 form-group position-relative">
                                    <input type="email" required="required" placeholder="Email" class="form-control">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="col-12 form-group position-relative">
                                    <input type="number" required="required" placeholder="Phone" class="form-control">
                                    <i class="fa fa-phone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 offset-xl-3 col-12">
                        <div class="journey">
                            <div class="title">
                                <h2>Journey Summary</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Journey Would Be:</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>To: East London</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>From: north London</p>
                                <p class=""><i class="fa fa-users"></i>With: 10 Passengers</p>
                                <p class="">With: Driver</p>
                                <a href="#" class="yel">Start Again <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                        <div class="journey">
                            <div class="title">
                                <h2>Pick up Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Minibus will pick you up on</h3>-->
                                <p class="border-b"><i class="fa fa-calendar"></i>15-06-2019</p>
                                <p class="border-b"><i class="fa fa-clock"></i>10: 30 am</p>
                                <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>

                        <div class="journey">
                            <div class="title">
                                <h2>return Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Return will be on</h3>-->
                                <p class="border-b"><i class="fa fa-calendar"></i>15-06-2019</p>
                                <p class="border-b"><i class="fa fa-clock"></i>06: 30 am</p>
                                <p class=""><i class="fa fa-map-marker-alt"></i>Drop off at return: </p>
                                <p class="">North London</p>
                                <a href="#" class="yel">Edit Detail <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>

                        <div class="journey additional">
                            <div class="title">
                                <h2>Additional Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <h3>Trip Reason: <span>Business</span></h3>
                                <h4>You will have:</h4>
                                <p class="border-b m-0"><i class="fa fa-briefcase"></i>Hand Luggage: <span>1</span>
                                </p>
                                <p class="border-b"><i class="fa fa-briefcase"></i>Medium Luggage: <span>2</span>
                                </p>
                                <p class=""><i class="fa fa-briefcase"></i>large Luggage: <span>2</span>
                                </p>
                                <p class="">Additional Info:</p>
                                <p class="m-0 p-0">Lorem ipsum dolor sit ametco nsectetur adipisicing. </p>
                                <a href="#" class="yel">Edit Detail  <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="tab tab-5">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey">
                            <div class="title">
                                <h2>Journey Summary</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Journey Would Be:</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>To: East London</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>From: north London</p>
                                <p class=""><i class="fa fa-users"></i>With: 10 Passengers</p>
                                <p class="">With: Driver</p>
                                <a href="#" class="yel">Start Again <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey">
                            <div class="title">
                                <h2>Pick up Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Minibus will pick you up on</h3>-->
                                <p class="border-b"><i class="fa fa-calendar"></i>15-06-2019</p>
                                <p class="border-b"><i class="fa fa-clock"></i>10: 30 am</p>
                                <a href="#" class="yel">Edit Details  <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey">
                            <div class="title">
                                <h2>return Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <!--<h3>Your Return will be on</h3>-->
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>15-06-2019</p>
                                <p class="border-b"><i class="fa fa-map-marker-alt"></i>06: 30 am</p>
                                <p class=""><i class="fa fa-map-marker-alt"></i>Drop off at return: </p>
                                <p class="">North London</p>
                                <a href="#" class="yel">Edit Details <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey additional">
                            <div class="title">
                                <h2>Additional Details</h2>
                            </div>
                            <div class="journey-bottom">
                                <h3>Trip Reason: <span>Business</span></h3>
                                <!--<h4>You will have:</h4>-->
                                <p class="border-b m-0"><i class="fa fa-briefcase"></i>Hand Luggage: <span>1</span>
                                </p>
                                <p class="border-b"><i class="fa fa-briefcase"></i>Medium Luggage: <span>2</span>
                                </p>
                                <p class=""><i class="fa fa-briefcase"></i>large Luggage: <span>2</span>
                                </p>
                                <p class="">Additional Info:</p>
                                <p class="m-0 p-0">Lorem ipsum dolor sit ametco nsectetur adipisicing. </p>
                                <a href="#" class="yel">Edit Details  <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 ">
                        <div class="journey">
                            <div class="title">
                                <h2>Contact Details</h2>
                            </div>
                            <div class="journey-bottom">

                                <p class="border-b"><i class="fa fa-user-circle"></i>John Williams</p>
                                <p class="border-b"><i class="fa fa-envelope"></i>john.williams@gmail.com</p>
                                <p class=""><i class="fa fa-phone"></i>+1-264-567-7890</p>
                                <a href="#" class="yel">Edit Details <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div style="overflow:auto;">
                <button type="button" id="prevBtn" class="yel" onclick="nextPrev(-1)">Previous <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                <button type="button" id="nextBtn" class="pur" onclick="nextPrev(1)">Next <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></i></button>
            </div>
            <!-- Circles which indicates the steps of the form: -->

        </form>


    </div>
</section>


@endsection
