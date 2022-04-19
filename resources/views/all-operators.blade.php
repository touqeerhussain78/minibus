@extends('layouts.user')
@section('title','View All Operators')
@section('content')


        <section class="find">
            <div class="container wow fadeIn" data-wow-duration=".5s" data-wow-delay=".5s">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                      <h3>All Operators</h3>
                    </div>
                  <div class="col-md-6 col-sm-12 "></div>
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
  
@endsection

