function markReceived(id, status){
  var url = $('#url').val() + '/operators/mark-received';
  
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        id : id,
        status: status
      },
      success: function(response){
          toastr.success(response.success, 'Success');
          setTimeout(function () {
            location.reload();
          }, 2000);
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.error, 'Error');
      }
  })
}

function markRead(id=""){
  var url = $('#url').val() + '/markasread/'+id;
  console.log(id);
  
  $.ajax({
      url: url,
      type: 'get',
      success: function(response){
        toastr.success(response.message, 'Success');
        setTimeout(function () {
         if(response.url){
          window.location.href = response.url;
         }else{
             location.reload();
         }
        
        }, 2000);
      }
  })
}

function rate(operator_id, booking_id){
  
  var url = $('#url').val() + '/bookings/rating';
  var rating = $("#rating").rate("getValue");
  if(rating > 0){
    $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        booking_id : booking_id,
        operator_id : operator_id,
        rating: $("#rating").rate("getValue"),
        comments: $('#comments').val()
      },
      beforeSend: function() {
        $('.rate-op').block({ message: 'Processing' });
      },
      success: function(response){
        $('.rate-op').unblock({ message: 'Processing' });
        toastr.success(response.success, 'Success');
        setTimeout(function () {
          window.location.href = $('#url').val() + '/bookings';
        }, 1000);
      },
      error: function (error) {
        $('.rate-op').unblock({ message: 'Processing' });
        console.log(error);
        let result = error.responseJSON;
        toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');
    }
  })
  }else{
    toastr.error("Please select rating", 'Error');
  }
 
}

function report(booking_id, operator_id){
  var url = $('#url').val() + '/bookings/report';
  
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        booking_id : booking_id,
        operator_id : operator_id,
        category: $('#cat-id').val(),
        comments: $('#comments').val()
      },
      success: function(response){
          $('.report-modal').modal('hide');
          toastr.success(response.success, 'Success');
          setTimeout(function () {
            window.location.href = $('#url').val() + '/bookings';
          }, 1000);
      },
      error: function (error) {
        let result = error.responseJSON;
        toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');
      }
  })
}

function showPackageAmount(id,amount){
  console.log(amount)
  $('#show-amount').html('<h3>Amount to be paid: £'+amount+'</h3>');
  $('#pkg-id').val(id);
}

function clearTripSession(){
  var url = $('#url').val() + '/clear';
  
  $.ajax({
      url: url,
      type: 'get',
      success: function(response){
          setTimeout(function () {
            location.reload();
          }, 1000);
      }
  })
}

function reload(){
  setTimeout(function () {
    location.reload();
  }, 1000);
}

function reloadWithPath(path){
  setTimeout(function () {
    window.location.href = $('#url').val() + path;
  }, 1000);
}

function changeQuoteStatus(id, status){
  console.log(id);
  var url = $('#url').val() + '/bookings/change-quote-status';
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        quote_id : id,
        status: status
      },
      beforeSend: function() {
        $('.load').block({ message: 'Processing' });
        $('.submit').prop('disabled', true);
      },
      success: function(response){
          toastr.success(response.success, 'Success');
         
          setTimeout(function () {
            window.location.href = $('#url').val() + '/bookings#nav-acc-qu';
          }, 2000);
      },
      complete: function() {
       $('.load').unblock({ message: 'Processing' });
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.error, 'Error');
      }
  })
}

function changeStatus(id, status){
  console.log(id);
  console.log('is it working');
  var url = $('#url').val() + '/operators/change-status';
  
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        id : id,
        status: status
      },
      beforeSend: function() {
        //$('#loader').show();
        $('.load').block({ message: 'Processing' });
      },
      success: function(response){
          console.log(response);
          if(status == 6){
            $('#cancel-trip').modal('hide');
            //$('#cancel-trip-2').modal('show');
             toastr.success("Trip Cancelled", 'Success');
            setTimeout(function () {
              window.location.href = $('#url').val() + '/operators/quotations/accepted';
            }, 1000);
          }
          else if(status == 3){
            $('#send-req').modal('hide');
            toastr.success("Trip Started", 'Success');
            setTimeout(function () {
              window.location.href = $('#url').val() + '/operators/quotations/accepted';
            }, 1000);
          }
          else if(status == 1){
            $('#accept-trip').modal('hide');
            toastr.success(response.success, 'Success');
            setTimeout(function () {
                window.location.href = $('#url').val() + '/operators/quotations/accepted';
              }, 1000);
          }
          else if(status == 2){
            $('#accept-trip').modal('hide');
            toastr.success(response.success, 'Success');
            setTimeout(function () {
                window.location.href = $('#url').val() + '/operators/quotations/accepted';
              }, 1000);
          }
          else if(status == 4){
            $('#o-send-req').modal('hide');
            toastr.success('Trip Completed', 'Success');
            setTimeout(function () {
                window.location.href = $('#url').val() + '/operators/quotations/accepted';
              }, 1000);
          }
          else{
            toastr.success(response.success, 'Success');
            $('#cancel-trip').modal('hide');
            $('#cancel-trip-2').modal('show');
          }
          
      },
      complete: function() {
        //$('#load').hide();
        $('.load').unblock({ message: 'Processing' });
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.error, 'Error');
      }
  })
}

function cancelBooking(id){
  console.log(id);
  var url = $('#url').val() + '/bookings/cancel';
  
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        id : id
      },
      beforeSend: function() {
        $('#loader').show();
    },
    success: function (response) {
        
          toastr.success(response.message, 'Success');
          // $('.confirm-modal').modal('hide');
          // $('.cancle-now').modal('show');
          setTimeout(function () {
            window.location.href = $('#url').val() + '/bookings';
          }, 2000);
      },
      complete: function() {
        $('#loader').hide();
    },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.error, 'Error');
      }
  })
}

function sendSpecialInvites(op_id, b_id){
  var url = $('#url').val() + '/bookings/send-special-invites';
  $('.special-invite').block({ message: 'Processing' });
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        operator_id : op_id,
        booking_id: b_id
      },
      
      success: function(response){
          toastr.success(response.message, 'Success');
      },
      complete: function() {
        $('.special-invite').unblock();
    },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.error, 'Error');
      }
  })
}





function sendQuotation(id){
  var url = $('#url').val() + '/operators/quotations/send';
  $('.payment-first-step').block({ message: 'Processing' });
  $.ajax({
      url: url,
      type: 'post',
      data : { 
        _token: $('#token').val(),
        booking_id : id,
        amount: $('#amount').val()
      },
      beforeSend: function() {
        $('.submit').prop('disabled', true);
    },
      success: function(response){
        if(response.status == true){
          toastr.success(response.message, 'Success');
          $('#send-req').modal('hide');
          $('#o-send-req-2').modal('show');
          setTimeout(function () {
            window.location.href = $('#url').val() + '/operators/quotations/sent';
          }, 2000);
        }else{
          toastr.error(response.message, 'Error');
        }
          
      },
      complete: function(){
        $('.payment-first-step').unblock();
      },
      error: function (error) {
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');

      }
  })
}

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function (e) {
          $('.preview').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
  }
}

function onError(e)
{
   e.style.visibility = "hidden";
  // e.onerror = "";
    // e.src = $('#url').val() + "/public/frontend/images/avatar.png";
}

function imgError(image) {
  image.onerror = "";
  image.src = $('#url').val() + "/public/frontend/images/avatar.png";
  return true;
}

$(function(){
  
  
  $('#subscribe').on('click', function(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    $.ajax({
        url: "/subscribe",
        data: {email: $('#email').val() },
        type: 'post',
        success: function(response){
            toastr.success(response.message,'Success');
            $('#email').val('');
            setTimeout(function () {
              location.reload();
            }, 2000);
        },
        error: function(error){
          let result = error.responseJSON;
          toastr.error(result.errors[Object.keys(result.errors)[0]], 'Error');
        }
    })
});
  $("#upload").change(function(){
    readURL(this);
  });

  $("#op-upload").change(function(){
    readURL(this);
  });

  
  $('#cont').on('click', function(){
    $('#exampleModalCenter').modal('hide');
    //$('#exampleModal').modal('show');
     $("#exampleModalCenter").modal().on('hidden.bs.modal', function (e) {
    $("body").addClass("modal-open");
    }); 
});


$('#back-op-register').on('click', function(){    
  $('#op-register-two').modal('hide');
  $('#operatorRegister').modal('show');
});

$('#back-op-minibus').on('click', function(){    
  $('#op-register-three').modal('hide');
  $('#operatorRegister').modal('hide');
  $('#op-register-two').modal('show');
});

$('#back-op-verify').on('click', function(){    
  $('#op-register-four').modal('hide');
  $('#operatorRegister').modal('hide');
  $('#op-register-three').modal('show');
});

$('#back-u-register').on('click', function(){    
  $('#register-two').modal('hide');
  $('#userRegister').modal('show');
});

$('#back-u2').on('click', function(){    
    $('#register-three').modal('hide');
    $('#register-two').modal('show');
}); 

$('#cancle-it').on('click', function(){    
    $('.confirm-modal').modal('hide');
    $('.cancle-now').modal('show');
}); 


 $('#o-send-req').on('click', function(){
    $('.canceling-trip').modal('hide');
    $('#o-send-req-2').modal('show');
}); 

$('#o-send-req').on('click', function(){
    $('#send-req').modal('hide');
    $('#o-send-req-2').modal('show');
});
$('#o-cancel-trip').on('click', function(){
    $('#cancel-trip').modal('hide');
    $('#cancel-trip-2').modal('show');
});

$('#o-trip').on('click', function(){
    $('#o-trip').modal('hide');
    $('#o-trip-2').modal('show');
});


}); 

$(document).on('keypress', 'input[type=number]', function(evt){
  if (evt.which !== 8 && evt.which !== 0 && evt.which < 48 || evt.which > 57)
      evt.preventDefault();
});

$(document).ready(function() {
  $("#passengers").attr({
     "max" : 50,        // substitute your own
     "min" : 2          // values (or variables) here
  });
});


/*date picker start here*/
$(document).ready(function() {

  var today, datepicker;
  today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

  var date = new Date();
  date.setDate(date.getDate()+1);
  var return_date = new Date(date.getFullYear(), date.getMonth(), date.getDate());

  $('#datepicker-expiry').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'mm/yy',
    minDate: today
});

$('#datepicker-1').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'dd-mm-yyyy',
    minDate: today
});


$('#timepicker-1').timepicker({
  uiLibrary: 'bootstrap4',
  format: 'HH:MM TT'
});



$('#datepicker-2').datepicker({
  uiLibrary: 'bootstrap4',
  format: 'dd-mm-yyyy',
  minDate: today
});



 $('#datepicker-3').datepicker({
      uiLibrary: 'bootstrap4',
      format: 'dd-mm-yyyy',
      minDate: return_date
            
});
 $('#timepicker-2').timepicker({
            uiLibrary: 'bootstrap4',
            format: 'HH:MM TT'
});

});
$(document).ready(function(){
	var maxLength = 30;
	$(".show-read-more").each(function(){
    var myStr = $(this).text();
		if($.trim(myStr).length > maxLength){
			var newStr = myStr.substring(0, maxLength);
			var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
			$(this).empty().html(newStr);
			$(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
			$(this).append('<span class="more-text">' + removedStr + '</span>');
		}
	});
	$(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
		$(this).remove();
	});
});

 
/*nav start here*/


!(function(n, i, e, a) {
  (n.navigation = function(t, s) {
    var o = {
        responsive: !0,
        mobileBreakpoint: 991,
        showDuration: 200,
        hideDuration: 200,
        showDelayDuration: 0,
        hideDelayDuration: 0,
        submenuTrigger: "hover",
        effect: "fade",
        submenuIndicator: !0,
        submenuIndicatorTrigger: !1,
        hideSubWhenGoOut: !0,
        visibleSubmenusOnMobile: !1,
        fixed: !1,
        overlay: !0,
        overlayColor: "rgba(0, 0, 0, 0.5)",
        hidden: !1,
        hiddenOnMobile: !1,
        offCanvasSide: "left",
        offCanvasCloseButton: !0,
        animationOnShow: "",
        animationOnHide: "",
        onInit: function() {},
        onLandscape: function() {},
        onPortrait: function() {},
        onShowOffCanvas: function() {},
        onHideOffCanvas: function() {}
      },
      r = this,
      u = Number.MAX_VALUE,
      d = 1,
      l = "click.nav touchstart.nav",
      f = "mouseenter focusin",
      c = "mouseleave focusout";
    r.settings = {};
    var t = (n(t), t);
    n(t).find(".nav-search").length > 0 &&
      n(t)
        .find(".nav-search")
        .find("form")
        .prepend(
          "<span class='nav-search-close-button' tabindex='0'>&#10005;</span>"
        ),
      (r.init = function() {
        (r.settings = n.extend({}, o, s)),
          r.settings.offCanvasCloseButton &&
            n(t)
              .find(".nav-menus-wrapper")
              .prepend(
                "<span class='nav-menus-wrapper-close-button'>&#10005;</span>"
              ),
          "right" == r.settings.offCanvasSide &&
            n(t)
              .find(".nav-menus-wrapper")
              .addClass("nav-menus-wrapper-right"),
          r.settings.hidden &&
            (n(t).addClass("navigation-hidden"),
            (r.settings.mobileBreakpoint = 99999)),
          v(),
          r.settings.fixed && n(t).addClass("navigation-fixed"),
          n(t)
            .find(".nav-toggle")
            .on("click touchstart", function(n) {
              n.stopPropagation(),
                n.preventDefault(),
                r.showOffcanvas(),
                s !== a && r.callback("onShowOffCanvas");
            }),
          n(t)
            .find(".nav-menus-wrapper-close-button")
            .on("click touchstart", function() {
              r.hideOffcanvas(), s !== a && r.callback("onHideOffCanvas");
            }),
          n(t)
            .find(".nav-search-button, .nav-search-close-button")
            .on("click touchstart keydown", function(i) {
              i.stopPropagation(), i.preventDefault();
              var e = i.keyCode || i.which;
              "click" === i.type ||
              "touchstart" === i.type ||
              ("keydown" === i.type && 13 == e)
                ? r.toggleSearch()
                : 9 == e && n(i.target).blur();
            }),
          n(t).find(".megamenu-tabs").length > 0 && y(),
          n(i).resize(function() {
            r.initNavigationMode(C()), O(), r.settings.hiddenOnMobile && m();
          }),
          r.initNavigationMode(C()),
          r.settings.hiddenOnMobile && m(),
          s !== a && r.callback("onInit");
      });
    var h = function() {
        n(t)
          .find(".nav-submenu")
          .hide(0),
          n(t)
            .find("li")
            .removeClass("focus");
      },
      v = function() {
        n(t)
          .find("li")
          .each(function() {
            n(this).children(".nav-dropdown,.megamenu-panel").length > 0 &&
              (n(this)
                .children(".nav-dropdown,.megamenu-panel")
                .addClass("nav-submenu"),
              r.settings.submenuIndicator &&
                n(this)
                  .children("a")
                  .append(
                    "<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"
                  ));
          });
      },
      m = function() {
        n(t).hasClass("navigation-portrait")
          ? n(t).addClass("navigation-hidden")
          : n(t).removeClass("navigation-hidden");
      };
    (r.showSubmenu = function(i, e) {
      C() > r.settings.mobileBreakpoint &&
        n(t)
          .find(".nav-search")
          .find("form")
          .fadeOut(),
        "fade" == e
          ? n(i)
              .children(".nav-submenu")
              .stop(!0, !0)
              .delay(r.settings.showDelayDuration)
              .fadeIn(r.settings.showDuration)
              .removeClass(r.settings.animationOnHide)
              .addClass(r.settings.animationOnShow)
          : n(i)
              .children(".nav-submenu")
              .stop(!0, !0)
              .delay(r.settings.showDelayDuration)
              .slideDown(r.settings.showDuration)
              .removeClass(r.settings.animationOnHide)
              .addClass(r.settings.animationOnShow),
        n(i).addClass("focus");
    }),
      (r.hideSubmenu = function(i, e) {
        "fade" == e
          ? n(i)
              .find(".nav-submenu")
              .stop(!0, !0)
              .delay(r.settings.hideDelayDuration)
              .fadeOut(r.settings.hideDuration)
              .removeClass(r.settings.animationOnShow)
              .addClass(r.settings.animationOnHide)
          : n(i)
              .find(".nav-submenu")
              .stop(!0, !0)
              .delay(r.settings.hideDelayDuration)
              .slideUp(r.settings.hideDuration)
              .removeClass(r.settings.animationOnShow)
              .addClass(r.settings.animationOnHide),
          n(i)
            .removeClass("focus")
            .find(".focus")
            .removeClass("focus");
      });
    var p = function() {
        n("body").addClass("no-scroll"),
          r.settings.overlay &&
            (n(t).append("<div class='nav-overlay-panel'></div>"),
            n(t)
              .find(".nav-overlay-panel")
              .css("background-color", r.settings.overlayColor)
              .fadeIn(300)
              .on("click touchstart", function(n) {
                r.hideOffcanvas();
              }));
      },
      g = function() {
        n("body").removeClass("no-scroll"),
          r.settings.overlay &&
            n(t)
              .find(".nav-overlay-panel")
              .fadeOut(400, function() {
                n(this).remove();
              });
      };
    (r.showOffcanvas = function() {
      p(),
        "left" == r.settings.offCanvasSide
          ? n(t)
              .find(".nav-menus-wrapper")
              .css("transition-property", "left")
              .addClass("nav-menus-wrapper-open")
          : n(t)
              .find(".nav-menus-wrapper")
              .css("transition-property", "right")
              .addClass("nav-menus-wrapper-open");
    }),
      (r.hideOffcanvas = function() {
        n(t)
          .find(".nav-menus-wrapper")
          .removeClass("nav-menus-wrapper-open")
          .on(
            "webkitTransitionEnd moztransitionend transitionend oTransitionEnd",
            function() {
              n(t)
                .find(".nav-menus-wrapper")
                .css("transition-property", "none")
                .off();
            }
          ),
          g();
      }),
      (r.toggleOffcanvas = function() {
        C() <= r.settings.mobileBreakpoint &&
          (n(t)
            .find(".nav-menus-wrapper")
            .hasClass("nav-menus-wrapper-open")
            ? (r.hideOffcanvas(), s !== a && r.callback("onHideOffCanvas"))
            : (r.showOffcanvas(), s !== a && r.callback("onShowOffCanvas")));
      }),
      (r.toggleSearch = function() {
        "none" ==
        n(t)
          .find(".nav-search")
          .find("form")
          .css("display")
          ? (n(t)
              .find(".nav-search")
              .find("form")
              .fadeIn(200),
            n(t)
              .find(".nav-search")
              .find("input")
              .focus())
          : (n(t)
              .find(".nav-search")
              .find("form")
              .fadeOut(200),
            n(t)
              .find(".nav-search")
              .find("input")
              .blur());
      }),
      (r.initNavigationMode = function(i) {
        r.settings.responsive
          ? (i <= r.settings.mobileBreakpoint &&
              u > r.settings.mobileBreakpoint &&
              (n(t)
                .addClass("navigation-portrait")
                .removeClass("navigation-landscape"),
              S(),
              s !== a && r.callback("onPortrait")),
            i > r.settings.mobileBreakpoint &&
              d <= r.settings.mobileBreakpoint &&
              (n(t)
                .addClass("navigation-landscape")
                .removeClass("navigation-portrait"),
              k(),
              g(),
              r.hideOffcanvas(),
              s !== a && r.callback("onLandscape")),
            (u = i),
            (d = i))
          : (n(t).addClass("navigation-landscape"),
            k(),
            s !== a && r.callback("onLandscape"));
      });
    var b = function() {
        n("html").on("click.body touchstart.body", function(i) {
          0 === n(i.target).closest(".navigation").length &&
            (n(t)
              .find(".nav-submenu")
              .fadeOut(),
            n(t)
              .find(".focus")
              .removeClass("focus"),
            n(t)
              .find(".nav-search")
              .find("form")
              .fadeOut());
        });
      },
      C = function() {
        return (
          i.innerWidth || e.documentElement.clientWidth || e.body.clientWidth
        );
      },
      w = function() {
        n(t)
          .find(".nav-menu")
          .find("li, a")
          .off(l)
          .off(f)
          .off(c);
      },
      O = function() {
        if (C() > r.settings.mobileBreakpoint) {
          var i = n(t).outerWidth(!0);
          n(t)
            .find(".nav-menu")
            .children("li")
            .children(".nav-submenu")
            .each(function() {
              n(this)
                .parent()
                .position().left +
                n(this).outerWidth() >
              i
                ? n(this).css("right", 0)
                : n(this).css("right", "auto");
            });
        }
      },
      y = function() {
        function i(i) {
          var e = n(i)
              .children(".megamenu-tabs-nav")
              .children("li"),
            a = n(i).children(".megamenu-tabs-pane");
          n(e).on("click.tabs touchstart.tabs", function(i) {
            i.stopPropagation(),
              i.preventDefault(),
              n(e).removeClass("active"),
              n(this).addClass("active"),
              n(a)
                .hide(0)
                .removeClass("active"),
              n(a[n(this).index()])
                .show(0)
                .addClass("active");
          });
        }
        if (n(t).find(".megamenu-tabs").length > 0)
          for (var e = n(t).find(".megamenu-tabs"), a = 0; a < e.length; a++)
            i(e[a]);
      },
      k = function() {
        w(),
          h(),
          navigator.userAgent.match(/Mobi/i) ||
          navigator.maxTouchPoints > 0 ||
          "click" == r.settings.submenuTrigger
            ? n(t)
                .find(".nav-menu, .nav-dropdown")
                .children("li")
                .children("a")
                .on(l, function(e) {
                  if (
                    (r.hideSubmenu(
                      n(this)
                        .parent("li")
                        .siblings("li"),
                      r.settings.effect
                    ),
                    n(this)
                      .closest(".nav-menu")
                      .siblings(".nav-menu")
                      .find(".nav-submenu")
                      .fadeOut(r.settings.hideDuration),
                    n(this).siblings(".nav-submenu").length > 0)
                  ) {
                    if (
                      (e.stopPropagation(),
                      e.preventDefault(),
                      "none" ==
                        n(this)
                          .siblings(".nav-submenu")
                          .css("display"))
                    )
                      return (
                        r.showSubmenu(n(this).parent("li"), r.settings.effect),
                        O(),
                        !1
                      );
                    if (
                      (r.hideSubmenu(n(this).parent("li"), r.settings.effect),
                      "_blank" === n(this).attr("target") ||
                        "blank" === n(this).attr("target"))
                    )
                      i.open(n(this).attr("href"));
                    else {
                      if (
                        "#" === n(this).attr("href") ||
                        "" === n(this).attr("href") ||
                        "javascript:void(0)" === n(this).attr("href")
                      )
                        return !1;
                      i.location.href = n(this).attr("href");
                    }
                  }
                })
            : n(t)
                .find(".nav-menu")
                .find("li")
                .on(f, function() {
                  r.showSubmenu(this, r.settings.effect), O();
                })
                .on(c, function() {
                  r.hideSubmenu(this, r.settings.effect);
                }),
          r.settings.hideSubWhenGoOut && b();
      },
      S = function() {
        w(),
          h(),
          r.settings.visibleSubmenusOnMobile
            ? n(t)
                .find(".nav-submenu")
                .show(0)
            : (n(t)
                .find(".submenu-indicator")
                .removeClass("submenu-indicator-up"),
              r.settings.submenuIndicator && r.settings.submenuIndicatorTrigger
                ? n(t)
                    .find(".submenu-indicator")
                    .on(l, function(i) {
                      return (
                        i.stopPropagation(),
                        i.preventDefault(),
                        r.hideSubmenu(
                          n(this)
                            .parent("a")
                            .parent("li")
                            .siblings("li"),
                          "slide"
                        ),
                        r.hideSubmenu(
                          n(this)
                            .closest(".nav-menu")
                            .siblings(".nav-menu")
                            .children("li"),
                          "slide"
                        ),
                        "none" ==
                        n(this)
                          .parent("a")
                          .siblings(".nav-submenu")
                          .css("display")
                          ? (n(this).addClass("submenu-indicator-up"),
                            n(this)
                              .parent("a")
                              .parent("li")
                              .siblings("li")
                              .find(".submenu-indicator")
                              .removeClass("submenu-indicator-up"),
                            n(this)
                              .closest(".nav-menu")
                              .siblings(".nav-menu")
                              .find(".submenu-indicator")
                              .removeClass("submenu-indicator-up"),
                            r.showSubmenu(
                              n(this)
                                .parent("a")
                                .parent("li"),
                              "slide"
                            ),
                            !1)
                          : (n(this)
                              .parent("a")
                              .parent("li")
                              .find(".submenu-indicator")
                              .removeClass("submenu-indicator-up"),
                            void r.hideSubmenu(
                              n(this)
                                .parent("a")
                                .parent("li"),
                              "slide"
                            ))
                      );
                    })
                : n(t)
                    .find(".nav-menu, .nav-dropdown")
                    .children("li")
                    .children("a")
                    .on(l, function(e) {
                      if (
                        (e.stopPropagation(),
                        e.preventDefault(),
                        r.hideSubmenu(
                          n(this)
                            .parent("li")
                            .siblings("li"),
                          r.settings.effect
                        ),
                        r.hideSubmenu(
                          n(this)
                            .closest(".nav-menu")
                            .siblings(".nav-menu")
                            .children("li"),
                          "slide"
                        ),
                        "none" ==
                          n(this)
                            .siblings(".nav-submenu")
                            .css("display"))
                      )
                        return (
                          n(this)
                            .children(".submenu-indicator")
                            .addClass("submenu-indicator-up"),
                          n(this)
                            .parent("li")
                            .siblings("li")
                            .find(".submenu-indicator")
                            .removeClass("submenu-indicator-up"),
                          n(this)
                            .closest(".nav-menu")
                            .siblings(".nav-menu")
                            .find(".submenu-indicator")
                            .removeClass("submenu-indicator-up"),
                          r.showSubmenu(n(this).parent("li"), "slide"),
                          !1
                        );
                      if (
                        (n(this)
                          .parent("li")
                          .find(".submenu-indicator")
                          .removeClass("submenu-indicator-up"),
                        r.hideSubmenu(n(this).parent("li"), "slide"),
                        "_blank" === n(this).attr("target") ||
                          "blank" === n(this).attr("target"))
                      )
                        i.open(n(this).attr("href"));
                      else {
                        if (
                          "#" === n(this).attr("href") ||
                          "" === n(this).attr("href") ||
                          "javascript:void(0)" === n(this).attr("href")
                        )
                          return !1;
                        i.location.href = n(this).attr("href");
                      }
                    }));
      };
    (r.callback = function(n) {
      s[n] !== a && s[n].call(t);
    }),
      r.init();
  }),
    (n.fn.navigation = function(i) {
      return this.each(function() {
        if (a === n(this).data("navigation")) {
          var e = new n.navigation(this, i);
          n(this).data("navigation", e);
        }
      });
    });
})(jQuery, window, document);



(function ($) {
    'use strict';

    var $window = $(window);

    if ($.fn.navigation) {
        $("#navigation1").navigation();
        $("#always-hidden-nav").navigation({
            hidden: true
        });
    }

            $window.on('load', function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });

})(jQuery);
/*nav end here*/


