@extends('layouts.user')
@section('title','Contact Admin')
@section('content')

<section class="contact-us p-100">

    <div class="container">
        <h2>Contact Admin</h2>

        @if ($message = Session::has('message'))
        <div class="alert alert-success alert-block" style="margin-top:10px;">
                <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif
        <br/>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        @endif
    <form method="POST" action="{{ route('operators.contact.store') }}">
        @csrf
            <div class="row">
                <div class="col-12 form-group position-relative">
                    <input type="text" name="subject" class="form-control" spellcheck="true" placeholder="subject">
                    <i class="fa fa-file-alt"></i>
                </div>
                <div class="col-12 form-group position-relative">
                    <input type="email" name="email" class="form-control" spellcheck="true" placeholder="Your Email Address">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="col-12 form-group position-relative">
                    <textarea type="text" name="message" class="form-control" spellcheck="true" placeholder="Your Message"></textarea>
                    <i class="fa fa-comments"></i>
                </div>
                <div class="col-12 form-group text-center">
                    <button type="submit" class="pur">send <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                    
                </div> 
                
            </div>    
        </form>
    </div>
    
</section>

@endsection