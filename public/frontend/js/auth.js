

// $(document).ready(function(){
//  $("#phone").inputmask({"mask": "(+99) 999-999-9999"});
//  $("#op-phone").inputmask({"mask": "(+99) 999-999-9999"});
// });

function loginUrl(obj, type){

  console.log('login', obj);
  let url = obj.getAttribute('data-href');
  let fp_url = obj.getAttribute('data-fp-href');
  let rg_url = obj.getAttribute('data-rg-href');
  if(type == 1){
    document.getElementById("reg").setAttribute("data-target", "#userRegister");
    document.getElementById('register').setAttribute('data-action', rg_url);
  }else{
    document.getElementById("reg").setAttribute("data-target", "#operatorRegister");
    document.getElementById('op-register').setAttribute('data-action', rg_url);
    $('#u-fp-button').hide();
    $('#op-fp-button').show();
  }
  
  document.getElementById('loginForm').setAttribute('data-action', url);
  document.getElementById('fp_form').setAttribute('data-action', fp_url);
  
}

function submitLogin(e){
  let url = document.getElementById('loginForm').getAttribute('data-action');
  
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
 
  $.ajax({
      url: url,
      type: 'post',
      data: {
        email: document.getElementById('lemail').value,
        password: document.getElementById('password').value,
    },
      success: function(response){
        
        console.log('login', response);
        if(response.errors){
          toastr.error(response.errors, 'Error');
        }else if(response.error){
          toastr.error(response.error, 'Error');
        }else{
          toastr.success("Login Succesfully");
            setTimeout(function () {
            window.location.href = 'operators'; 
         }, 1000);
        }
          
        
         
          
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}


function submitForgotPassword(){
  let url = document.getElementById('fp_form').getAttribute('data-action');
  console.log(url);
  let body =  JSON.stringify({
      email: document.getElementById('fp_email').value,
  });
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
      url: url,
      type: 'post',
      data: { email : document.getElementById('fp_email').value},
      success: function(response){
        console.log(response);
          jQuery('#exampleModalCenter').modal('hide');
          toastr.success('We have e-mailed you password reset link!');
          setTimeout(function () {
            window.location.href = 'home';
         }, 2000);
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}

function opRegister(){

  if ($("#op-register").length > 0) {
   
    let url = document.getElementById('op-register').getAttribute('data-action');
    $('#op-register').block({ message: 'Processing' });
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        var form = new FormData(document.getElementById('op-register'));
         form.append('file', $('#upload').get(0).files[0]);
       
        $.ajax({
          url: url ,
          type: "POST",
          processData: false,
          contentType: false,
          data:form,
          success: function( response ) {
            console.log("response", response);
            $('#op-register').unblock();
              document.getElementById("register").reset();
              $('#operatorRegister').modal('hide');
              $('#op-register-two').modal('show');
              $("#operatorRegister").modal().on('hidden.bs.modal', function (e) {
              $("body").addClass("modal-open");
              });    
             
             // console.log("response", response.data.auth_code_phone);
              
             // $('#op_auth_phone').val(response.data.auth_code_phone);
             // $('#op_auth_email').val(response.data.auth_code_email);
              
             
          },
          error: function (error) {
            console.log(error,'error');
            if(error.status==500){
              toastr.error("Please add valid number and re-check data.", 'Error');
            }
            $('#op-register').unblock();
            let result = error.responseJSON;
            toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

        }
        });
   
 }
}

function registerOperatorMinibus(){
  if ($("#op-register-minibus").length > 0) {
    let url = document.getElementById('op-register-minibus').getAttribute('data-action');
    var fileCounter = count = 0;

      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        var form = new FormData(document.getElementById('op-register-minibus'));
      //   $.each($("#upload-img")[0].files, function (key, file){
      //     form.append(key, file);
      // });  
        for(var j=0 ; j<= count ; j++)
        {
            $.each($("#upload-img")[j].files, function (i, file)
            {          
              form.append(fileCounter, file);
                fileCounter++;
            });
          }
        $.ajax({
          url: url ,
          type: "POST",
          processData: false,
          contentType: false,
          data:form,
          success: function( response ) {
            console.log("response", response); 
            // $('#op-auth-phone').val(response.data.auth_code_phone);
             //$('#op-auth-email').val(response.data.auth_code_email);
            
            
            //  document.getElementById("operatorRegister").reset();
              $('#operatorRegister').modal('hide');
              $('#op-register-two').modal('hide');
              $('#op-register-three').modal('show');
              // $("#operatorRegister").modal().on('hidden.bs.modal', function (e) {
              // $("body").addClass("modal-open");
              // }); 
          },
          error: function (error) {
            let result = error.responseJSON;
            toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

        }
        });
   
 }
}

function opVerify(){
  let url = document.getElementById('op-verify').getAttribute('data-action');
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        auth_code_phone : $('#op-auth-phone').val(),
        auth_code_email: $('#op-auth-email').val()
      },
      success: function(response){
        
        if(response.status == false){
          toastr.error(response.message, 'Error');
          
        }
        else{
          $('#op-register-three').modal('hide');
          $('#operatorRegister').modal('hide');
          $('#op-register-four').modal('show');
          $("#op-register-three").modal().on('hidden.bs.modal', function (e) {
          $("body").addClass("modal-open");
          }); 

        }
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}

function setPassword(){
  let url = document.getElementById('op-set-password').getAttribute('data-action');
  $('#op-register-four').block({ message: 'Processing' });
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        username : $('#op-username').val(),
        password: $('#op-password').val(),
        password_confirmation: $('#op-confirm-password').val()
      },
      success: function(response){
        $('#op-register-four').unblock();
        $('#op-register-four').modal('hide');
        $('#op-register-five').modal('show');
        $("#op-register-four").modal().on('hidden.bs.modal', function (e) {
        $("body").addClass("modal-open");
        }); 
      },
      error: function (error) {
        $('#op-register-four').unblock();
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}

function validateEmail(sEmail) {
  if(!sEmail){
      toastr.error("Please enter email address", 'Error !');
      return 0;
  }
  var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
  if(!sEmail.match(reEmail)) {
      toastr.error("Invalid Email Address", 'Error !');
      $("input[type=email]").val("");
      return 0;
  }
  return 1;
}

$('#op-fp').on('submit', function (e) {
  e.preventDefault(e);
  let formData = $(this).serializeArray();
  let url = $(this).attr('action');
  if(validateEmail(formData[1].value)){
      $('#op-fp').block({ message: 'Processing' });
      $.ajax({
          url: url,
          data: formData,
          type: 'post',
          success: function (response) {
              $('#op-fp').unblock();
              toastr.success(response.message, 'Success');
              $('#exampleModalCenter').modal('hide');
              $('#op-verify-modal').modal('show');
          },
          error: function (error) {
              $('#op-fp').unblock();
              toastr.error(error.responseJSON.error, 'Error');
          }
      })
  }
});

$('#op-verify-code').on('submit', function (e) {
  e.preventDefault(e);
  let formData = $(this).serializeArray();
  let url = $(this).attr('action');
  if(formData[1].value){
      $('#op-verify-code').block({ message: 'Processing' });
      $.ajax({
          url: url,
          data: formData,
          type: 'post',
          success: function (response) {
              $('#op-verify-code').unblock();
              localStorage.setItem('_token_', formData[1].value);
              toastr.success(response.message, 'Success');
              $('#op-verify-modal').modal('hide');
              $('#op-updatePassword').modal('show');
          },
          error: function (error) {
              $('#op-verify-code').unblock();
              toastr.error(error.responseJSON.error, 'Error');
          }
      })
  }
});

$('#op-update-pass').on('submit', function (e) {
  e.preventDefault(e);
  let formData = $(this).serializeArray();
  formData.push({name: 'code', value: localStorage.getItem('_token_')});
  let url = $(this).attr('action');
  $('#op-update-pass').block({ message: 'Processing' });
  $.ajax({
      url: url,
      data: formData,
      type: 'post',
      success: function (response) {
          $('#op-update-pass').unblock();
          localStorage.removeItem('_token_');
          toastr.success(response.message, 'Success');
          setTimeout(function () {
              window.location.reload();
          }, 1000);
      },
      error: function (error) {
           $('#op-update-pass').unblock();
           toastr.error(error.responseJSON.error, 'Error');
      }
  })
});

$('#op-resend').on('click', function (e) {
 
  $('#op-register-three').block({ message: 'Processing' });
  $.ajax({
      url: $('#url').val() + '/operators/operator-resend',
      type: 'get',
      success: function (response) {
        toastr.success(response.message, 'Success');
          $('#op-register-three').unblock();
         
      },
      error: function (error) {
          $('#op-register-three').unblock();
          toastr.error(error.responseJSON.error, 'Error');
      }
  })

});


$('#register').on('submit', function(e){
  e.preventDefault();
  let url = document.getElementById('url').value + '/user/register';
    console.log("here", url);
    $('#userRegister').block({ message: 'Processing' });
   
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        var form = new FormData(document.getElementById('register'));
        form.append('file', $('#upload').get(0).files[0]);
        
        $.ajax({
          url: url ,
          type: "POST",
          processData: false,
          contentType: false,
          data:form,
          success: function( response ) {

            console.log(response, 'response');
            $('#userRegister').unblock();
           // document.getElementById("register").reset();
            toastr.success('Check your email for registration code');
          
            $('#userRegister').modal('hide');
            $('#register-two').modal('show');
            $("#exampleModalLong").modal().on('hidden.bs.modal', function (e) {
                  $("body").addClass("modal-open");
                 
              }); 
          },
          error: function (error) {
           
            if(error.status==500){
              toastr.error("Please add valid number and re-check data.", 'Error');
            }
            $('#userRegister').unblock();
            let result = error.responseJSON;
            toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

        }
        });
});

$('#user-fp').on('submit', function (e) {
  e.preventDefault(e);
  let formData = $(this).serializeArray();
  let url = $(this).attr('action');
  if(validateEmail(formData[1].value)){
      $('#user-fp').block({ message: 'Processing' });
      $.ajax({
          url: url,
          data: formData,
          type: 'post',
          success: function (response) {
              $('#user-fp').unblock();
              toastr.success(response.message, 'Success');
              $('#user-fp-modal').modal('hide');
              $('#u-verify-modal').modal('show');
          },
          error: function (error) {
              $('#user-fp').unblock();
              toastr.error(error.responseJSON.error, 'Error');
          }
      })
  }
});

$('#u-verify-code').on('submit', function (e) {
  e.preventDefault(e);
  if($('#u-con-pass').val() == ''){
    toastr.error("Input cannot be left blank", 'Error');
 }
  let formData = $(this).serializeArray();
  let url = $(this).attr('action');
  if(formData[1].value){
      $('#u-verify-code').block({ message: 'Processing' });
      $.ajax({
          url: url,
          data: formData,
          type: 'post',
          success: function (response) {
         console.log(response);
              if(response.status == false){
                toastr.error(response.message, 'Error');
              }
              $('#u-verify-code').unblock();
              localStorage.setItem('_token_', formData[1].value);
              toastr.success(response.message, 'Success');
              $('#u-verify-modal').modal('hide');
              $('#u-updatePassword').modal('show');
          },
          error: function (error) {
              $('#u-verify-code').unblock();
              toastr.error(error.responseJSON.error, 'Error');
          }
      })
  }
});

$('#u-resend').on('click', function (e) {
 
      $('#register-two').block({ message: 'Processing' });
      $.ajax({
          url: document.getElementById('url').value + '/user-resend',
          type: 'get',
          success: function (response) {
            toastr.success(response.message, 'Success');
              $('#register-two').unblock();
             
          },
          error: function (error) {
              $('#register-two').unblock();
              toastr.error(error.responseJSON.error, 'Error');
          }
      })
 
});

$('#u-update-pass').on('submit', function (e) {
  e.preventDefault(e);
  let formData = $(this).serializeArray();
  formData.push({name: 'code', value: localStorage.getItem('_token_')});
  let url = $(this).attr('action');
  $('#u-update-pass').block({ message: 'Processing' });
  $.ajax({
      url: url,
      data: formData,
      type: 'post',
      success: function (response) {
          $('#u-update-pass').unblock();
          localStorage.removeItem('_token_');
          toastr.success(response.message, 'Success');
          setTimeout(function () {
              window.location.reload();
          }, 1000);
      },
      error: function (error) {
        $('#u-update-pass').unblock();
        let result = error.responseJSON;
        toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');
      }
  })
});


function verify(){
  if ($("#verify_account").length > 0) {
    let url = document.getElementById('url').value + '/verify_account';
    $("#verify_account").validate({
        errorClass: "error-class",
        validClass: "valid-class",

        rules: {
        auth_phone: {required: true},
        auth_email: {required: true},
        },
        messages: {

        auth_phone: {required: "Please enter Code"},
        auth_email: {required: "Please enter Code" }
        },
        submitHandler: function(form) {

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
            });

            $.ajax({
            url: url ,
            type: "POST",
            data: $('#verify_account').serialize(),
            success: function( response ) {
              if(response.status == false){
                toastr.error(response.message, 'Error');
                
              }
              else{
                $('#register-two').modal('hide');
                $('#register').modal('hide');
                $('#register-three').modal('show');
                $("#register-two").modal().on('hidden.bs.modal', function (e) {
                $("body").addClass("modal-open");
                }); 
      
              }
            }
            });
        }
    })
}
}

function setUserPassword(){
  let url = document.getElementById('url').value + '/user/set-password';
  $('#register-three').block({ message: 'Processing' });
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        email : $('#rs-email').val(),
        password: $('#rs-password').val(),
        password_confirmation: $('#rs-password-confirm').val()
      },
      success: function(response){
      $('#register-three').unblock();
        $('#register-three').modal('hide');
        $('#register-four').modal('show');
          $("#register-three").modal().on('hidden.bs.modal', function (e) {
        $("body").addClass("modal-open");
        }); 
      },
      error: function (error) {
        $('#register-three').unblock();
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}

function changePasswordRegister(){
  
  let url = document.getElementById('url').value + '/change-password';
  if ($("#reset_password").length > 0) {
   
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
 
  $.ajax({
      url: url,
      type: 'post',
      data: {
        email: $('#rs-email').val(),
        password: $('#rs-password').val(),
        confirm_password: $('#rs-password-confirm').val()
    },
      success: function(response){
       
        console.log('login', response);
        if(response.errors){
          toastr.error(response.errors, 'Error');
          
        }else{
          toastr.success("Login Succesfully");
        //     setTimeout(function () {
        //     window.location.href = 'operators'; 
        //  }, 1000);
        }
          
        
         
          
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}
}



$(document).ready(function() {

  $('#a-login').css('display', 'none');

    $('#login').on('submit', function(e){ e.preventDefault(); });

    if ($("#login").length > 0) {
        
        $("#login").validate({
            errorClass: "error-class",
            validClass: "valid-class",
    
            rules: {
              email: {required: true},
              password : {required: true, minlength : 8}
            },
            messages: {
                email: {required: "Please enter valid email" },
                password: {required: "Please enter Password", minlength: "Password length shoul be atleast 8 characters" }
            },
            submitHandler: function(form) {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                }
                });
    
                $.ajax({
                url: "login" ,
                type: "POST",
                data: $('#login').serialize(),
                success: function( response ) {
                  if(response.status == false){
                    toastr.error(response.message, 'Error');
                  }
                  document.querySelector('input[name="_token"]').value = response.token;
                  document.getElementById("login").reset();
                  toastr.success('Login Successfully');
                  
                  $('#b-login').css('display', 'none');    
                  $('.login-modal-lg').modal('hide');
                  // after login show submit button
                  $('#a-login').css('display', 'block');
                      setTimeout(function () {
                        location.reload(); 
                    }, 1000);
                }
                });
            }
        })
    }

    
    $('#verify_account').on('submit', function(e){ e.preventDefault(); });
    
    

 
 

});