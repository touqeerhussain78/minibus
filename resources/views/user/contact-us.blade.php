@extends('layouts.user')
@section('title','Contact Us')
@section('content')

<section class="contact-us p-100">

    <div class="container">
        <h2>contact us</h2>

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
    <form method="POST" action="{{ route('contact.store') }}">
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
                <div class="col-12 form-group position-relative">
                <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_SITE_KEY')}}"></div>
                    {{-- <button class="g-recaptcha btn btn-primary" 
                        type="submit">Submit</button> --}}
                </div>
                <div class="col-12 form-group text-center">
                    <button type="submit" class="pur">send <img src="{{ asset('/frontend/images/arrow.png')}}" alt=""></button>
                    
                </div> 
                
            </div>    
        </form>
    </div>
    
</section>

@endsection

@section('js')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection