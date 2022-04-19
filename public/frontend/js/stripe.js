function stripeResponseHandler(status, response) {
    var token = response['id'];
    document.getElementById('stripeToken').value = token;
    console.log('input token',  $('#stripeToken').val());
}

function getStripeToken(){
var date = $('.card-expiry').val();
var arr = date.split('/');
Stripe.setPublishableKey($('#stripKey').val());

Stripe.createToken({
      number: $('.card-number').val(),
      cvc: $('.card-cvc').val(),
      exp_month: arr[0],
      exp_year: arr[1]
    }, stripeResponseHandler);
}

function addOperatorPayment(){
 
    var url = $('#url').val() + '/operators/wallet/payment';
    $('.payment-first-step').block({ message: 'Processing' });
    $.ajax({
        url: url,
        type: 'post',
        data : { 
          _token: $('#token').val(),
          id : $('#pkg-id').val(),
          name: $('.card-name').val(),
          card_number: $('.card-number').val(),
          cvv: $('.card-cvc').val(),
          expiry: $('.card-expiry').val(),
          stripeToken: $('#stripeToken').val()
        },
        beforeSend: function() {
        //  $('.submit').prop('disabled', true);
      },
        success: function(response){
          console.log(response);
          //return;
          if(response.status = "true"){
            toastr.success(response.message, 'Success');
           $('.payment-first-step').modal('hide');
        //    $('.payment-second-step').modal('show');
            setTimeout(function () {
              window.location.href = $('#url').val() + '/operators/wallet';
            }, 2000);
          }
         
        },
        complete: function() {
          $('.payment-first-step').unblock();
      },
        error: function (error) {
            let result = error.responseJSON;
            toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');
  
        }
    })
  }

function addPayment(id){
  var url = $('#url').val() + '/bookings/payment';
  $('.payment-first-step').block({ message: 'Processing' });
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        id : id,
        name: $('.card-name').val(),
        card_number: $('.card-number').val(),
        cvv: $('.card-cvc').val(),
        expiry: $('.card-expiry').val(),
        amount: $('#amount').val(),
        stripeToken: $('#stripeToken').val()
      },
      beforeSend: function() {
       // $('#loader').show();
        //$('.submit').prop('disabled', true);
    },
      success: function(response){
          toastr.success(response.message, 'Success');
          $('.payment-first-step').modal('hide');
          $('.payment-second-step').modal('show');
          setTimeout(function () {
                window.location.href = $('#url').val() + '/bookings';
              }, 2000);
          
      },
      complete: function() {
       // $('#loader').hide();
       $('.payment-first-step').unblock();
    },
      error: function (error) {
        $('.payment-first-step').unblock();
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}


