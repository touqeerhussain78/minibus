@extends('layouts.user')
@section('title','Operator Profile - Edit')
@section('content')

<section class="operator-profile-main accepted-profile o-profile p-100 o-edit-profile">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Edit Profile </h2>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
            </div>
        </div>

    <form method="POST" action="{{ url('/operators/update') }}" enctype="multipart/form-data">
            @csrf

        <div class="operator-profile align-items-center">
            <div class="left">
                <div class="media align-items-center">

                    <div class="attached">
                        <img src="{{ isset($operator->image) ? $operator->image : asset('/frontend/images/avatar.png')}}" class="img-fluid preview" alt="">
                            <button type="button" class="camera-btn" onclick="document.getElementById('upload').click()">
                                <i class="fa fa-camera"></i>
                            </button>
                            <input type="file" id="upload" name="image">
                    </div>
                    <div class="media-body">
                        <h3>{{ $operator->name }}</h3>
                        <h4>{{ $operator->company_name }}</h4>

                    </div>
                </div>
            </div>

        </div>

        <div class="operator-information">
            <div class="row">
                <input type="hidden" name="id" value="{{ $operator->id }}">
                <div class="col-md-6">
                    <label for=""><i class="fa fa-user-circle"></i>name</label>
                    <input type="text" class="form-control" name="name" spellcheck="true" placeholder="JohnWilliams" value="{{ $operator->name }}">
                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-building"></i>Company</label>

                    <input type="text" class="form-control" name="company_name" spellcheck="true" placeholder="JohnWilliams & Co." value="{{ $operator->company_name }}">
                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-envelope"></i>Email</label>

                    <input type="text" class="form-control" name="email" spellcheck="true" placeholder="johnwilliams@gmail.com" value="{{ $operator->email }}">


                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-phone fa-rotate-90"></i>phone</label>

                    <input type="text" class="form-control" name="phone_no" placeholder="+1-202-555-0162" value="{{ $operator->phone_no }}">

                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-map-marker-alt"></i>Address</label>

                    {{-- <input type="text" class="form-control" name="address" spellcheck="true" placeholder="Massapequa Park, NY" value="{{ $operator->address }}"> --}}

                    <input type="text" id="op_address" name="address" placeholder="Address" class="form-control" value="{{ $operator->address }}">
               
                </div>
               
                    <input type="hidden" name="latitude" class="form-control" id="op_latitude" value="{{ $operator->latitude }}">
              
                    <input type="hidden" class="form-control" name="longitude" id="op_longitude" value="{{ $operator->longitude }}">
              

                <div class="col-md-6">
                    <label for=""><i class="fa fa-building"></i>city</label>

                    <input type="text" class="form-control" name="city" id="op_locality" spellcheck="true" placeholder="New York" value="{{ $operator->city }}">
                    
                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-building"></i>County</label>
                    <input type="text" id="op_administrative_area_level_1" class="form-control" name="state" spellcheck="true" placeholder="NY" value="{{ $operator->state }}">

                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-globe"></i>Country</label>

                    <input type="text" class="form-control" name="country" id="op_country" spellcheck="true" placeholder="United States" value="{{ $operator->country }}">

                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-pencil-alt"></i>Postal Code</label>

                    <input type="text" class="form-control" name="zipcode" id="op_postal_code" spellcheck="true" placeholder="AL23XG" value="{{ $operator->zipcode }}">

                </div>

                <div class="col-md-6">
                    <label for=""><i class="fa fa-address-card"></i>Driving Licence Number</label>

                    <input type="text" class="form-control" name="drivers_license" spellcheck="true" placeholder="MOR1246DSG78942" value="{{ $operator->drivers_license }}">

                </div>


            </div>


            <div class="operator-bus">
                <div class="row">
                    @if($buses)
                        @foreach($buses as $row)
                       
                            <div class="col-lg-3 col-sm-6 col-md-4 col-12 position-relative" id="{{'image-div-'}}{{$row->id}}">
                                <img src="{{ $row->path }}" class="img-fluid" alt="bus image">

                                <button type="button" onclick="deleteBusImage({{$row->id}})"><i class="fa fa-minus-circle"></i></button>

                            </div>
                        @endforeach
                    @endif
                </div>
                    {{-- <div class="col-lg-3 col-sm-6 col-md-4 col-12 position-relative" id="filediv">
                       
                        <input type="file" id="file" name="file[]">
                            <button type="button" class="change-cover" onclick="document.getElementById('file').click()" >
                                <i class="fa fa-plus-circle"></i>New Image</button>
                    </div> --}}
                <div class="row images-box" >
                    <div class="col-lg-3 col-sm-6 col-md-4 col-12">
                        <div class="upload-pic">
                            <button type="button" id="add_more" class="btn btn-primary change-cover" value=""><i class="fa fa-plus-circle"></i>Add New Image</button>
                            

                        </div>
                    </div>
                </div>

            </div>

            <div class="operator-bus">
                <div class="row">
                    <div class="col-12">
                        <h3>Further Information</h3>

                        <textarea  name="aboutme" class="form-control" rows="" placeholder="Further Information">{{ $operator->aboutme ?? "" }}</textarea>
                        <h3>Minibus Type</h3>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-12">
                        <label class="login-radio">Self Drive<input type="radio" value="1" name="type" {{ (isset($operator->minibus[0]) && $operator->minibus[0]['type'] == 1) ? 'checked' : "" }}><span class="checkmark"></span></label>
                        <label class="login-radio">With Driver<input type="radio" value="2" name="type" {{ (isset($operator->minibus[0]) && $operator->minibus[0]['type'] == 2) ? 'checked' : "" }}><span class="checkmark"></span></label> 
                        <label class="login-radio">Both <input type="radio" value="3" name="type" {{ (isset($operator->minibus[0]) && $operator->minibus[0]['type'] == 3) ? 'checked' : "" }}><span class="checkmark"></span></label>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <label for=""><i class="fa fa-bus"></i>Model: </label>
                    <input type="text" class="form-control" name="model" spellcheck="true" placeholder=" Trend L3H2" value="{{ isset($operator->minibus[0]) ? $operator->minibus[0]['model'] : "" }}">
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <label for=""><i class="fa fa-bus"></i>Capacity: </label>
                    <input type="number" class="form-control" name="capacity" spellcheck="true" placeholder="25" value="{{isset($operator->minibus[0]) ? $operator->minibus[0]['capacity'] : "" }}">

                    </div>
                </div>
               
                <div class="row">
                    <div class="col-12">
                        <label for=""><i class="fa fa-file-alt"></i>Minibus Description: </label>

                        <textarea rows="" name="description" class="form-control" spellcheck="true" placeholder="description">{{ isset($operator->minibus[0]) ? $operator->minibus[0]['description'] : "" }}</textarea>

                    </div>
                </div>
               
            </div>


            <div class="row">
                <div class="col-12 text-center">

                    <button class="pur" type="submit">Update and Save  <img src="{{asset('/frontend/images/arrow.png')}}" class="img-fluid" alt=""></button>

                </div>
            </div>


        </div>


        </form>
</section>


@endsection

@section('js')

<script src="{{ asset('/frontend/js/app.js') }}"></script>
<script>
var abc = 0;
        $('#add_more').click(function ()
            {
                $(this).after($("<div/>",{id: 'filediv'}).fadeIn('slow').append($("<input/>",
                            {
                                name: 'files[]',
                                type: 'file',
                                id: 'file'
                            }),
                            $("")
                        ));
              
            });
        $('body').on('change', '#file', function ()
            {
                if (this.files && this.files[0])
                {
                    abc += 1; //increementing global variable by 1
                    var z = abc - 1;
                    var x = $(this)
                        .parent()
                        .find('#previewimg' + z).remove();
                    $('.images-box').append("<div class='col-lg-3 col-sm-6 col-md-4 col-12'> <div class = 'upload-pic'> <div id = 'filediv' ><div id='abcd" + abc + "' class='abcd change-cover'><img id='previewimg" + abc + "' src=''/></div> </div> </div>");
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                    $(this)
                        .hide();

                    $("#abcd" + abc).append($("<button/> ",{

                                role: 'button', 
                                class: 'remove-uploaded-image',
                                value: '<i class="fa fa-minus-circle"></i>', 
                               
                            }) .click(function ()
                            {
                                $(this)
                                    .parent()
                                    .parent()
                                    .parent()
                                    .parent()
                                    .remove()
                                    
                            }));
                        $('.remove-uploaded-image').html(''); 
                        $('.remove-uploaded-image').append('<i class="fa fa-minus-circle"></i>');       

                }
            });
        //image preview
        function imageIsLoaded(e)
        {
            $('#previewimg' + abc)
                .attr('src', e.target.result);
        };
        //   $('#filediv').on('click', fuction(){
        //             alert('here');
        //         })
</script>
{{-- <script>
    $(document).ready(function(){
        $('#filediv').on('click', fuction({
                    alert('here');
                }))
})
  
</script> --}}
@endsection