function deleteBusImage(id){
    $("#image-div-"+id).hide();
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    
    $.ajax({
        url: $('#url').val() + '/operators/delete_minibus_image/'+id,
        type: 'get',
       
        success: function(response){
            toastr.success(response.message, 'Success');
            setTimeout(function () {
                // window.location.href = $('#url').val() + '/operators/edit';  
            }, 2000);
            
            
        },
        error: function (error) {
            let result = error.responseJSON;
            toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

        }
    })
}
$(document).ready(function() {

    function initialize(){
        var input = document.getElementById('return_location');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById('return').value = place.geometry.location.lat()+','+place.geometry.location.lng();
            });
      }
      google.maps.event.addDomListener(window, 'load', initialize);

    $('input:radio[name="is_return"]').change(function() {
        if (this.value == "0") {
            console.log("yes");
            $('.return-form').hide();
        }
        else if (this.value == "1") {
            console.log("no");
            $('.return-form').show();
        }
    });

    $('.pickup_date').on('change', function(){
        $(".show_pickup_date").html($('.pickup_date').val());
    });

    $('.pickup_time').on('change', function(){
        $(".show_pickup_time").html($('.pickup_time').val());
    });

    $('.return_date').on('change', function(){
        $(".show_return_date").html($('.return_date').val());
    });

    $('.return_time').on('change', function(){
        $(".show_return_time").html($('.return_time').val());
    });

    $('.return_location').on('change', function(){
        $(".show_return_location").html($('.return_location').val());
    });

    $('.trip_reason').on('change', function(){
        $(".show_trip_reason").html($('.trip_reason').val().substring(0,100));
    });

    $('.hand_luggage').on('change', function(){
        $(".show_hand_luggage").html($('.hand_luggage').val());
    });

    $('.mid_luggage').on('change', function(){
        $(".show_mid_luggage").html($('.mid_luggage').val());
    });

    $('.large_luggage').on('change', function(){
        $(".show_large_luggage").html($('.large_luggage').val());
    });

    $('.additional_info').on('change', function(){
        $(".show_additional_info").html($('.additional_info').val().substring(0,100));
    });

    $('.contact_name').on('change', function(){
        $(".show_contact_name").html($('.contact_name').val());
    });

    $('.contact_email').on('change', function(){
        $(".show_contact_email").html($('.contact_email').val());
    });

    $('.contact_phone').on('change', function(){
        $(".show_contact_phone").html($('.contact_phone').val());
    });

    $('#change_password').on('submit', function(e){ e.preventDefault(); });

    if ($("#change_password").length > 0) {
        
        $("#change_password").validate({
            errorClass: "error-class",
            validClass: "valid-class",
    
            rules: {
                password : {required: true, minlength : 8},
                password_confirmation : {required: true, minlength : 8,equalTo : "#password"}
            },
            messages: {
                password: {required: "Please enter Password", minlength: "Password length shoul be atleast 8 characters" },
                password_confirmation : {required: "Please enter Password",minlength: "Password length shoul be atleast 8 characters",equalTo:"Password does not match"}
            },
            submitHandler: function(form) {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
                });
    
                $.ajax({
                url: document.getElementById('cp-url').value ,
                type: "POST",
                data: $('#change_password').serialize(),
                success: function( response ) {
                document.getElementById("change_password").reset();
                if(response.error){
                    toastr.error(response.error, 'Error'); 
                }else{
                    toastr.success(response.msg, 'Success'); 
                }
                  
                   
                  $('.bd-example-modal-lg').modal('hide');
                  
                },
                error: function (error) {
                    let result = error.responseJSON;
                    console.log(result)
                    toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');
          
                }
                });
            }
        })
    }


});