$(document).ready(function() {

  function initialize() {
    autocomplete1();
    autocomplete2();
    autocomplete3();
    autocomplete4();
  }

  function autocomplete1(){
    var input = document.getElementById('pickup_location');
    var autocomplete = new google.maps.places.Autocomplete(input);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('pickup').value = place.geometry.location.lat()+','+place.geometry.location.lng();
        });
  }

  function autocomplete2(){
    var input = document.getElementById('dropoff_location');
    var autocomplete = new google.maps.places.Autocomplete(input);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('dropoff').value = place.geometry.location.lat()+','+place.geometry.location.lng();
        });
  }

  // operator latlong
  function autocomplete3(){
    
    var input = document.getElementById('op_address');
    var autocomplete = new google.maps.places.Autocomplete(input);

    var componentForm = {
                  locality: 'long_name',
                  administrative_area_level_1: 'short_name',
                  country: 'long_name',
                  postal_code: 'short_name'
              };
   
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            console.log('place' , place);
            for (var i = 0; i < place.address_components.length; i++) {
                  var addressType = place.address_components[i].types[0];
                  if (componentForm[addressType]) {
                      var val = place.address_components[i][componentForm[addressType]];
                      
                      if(val){
                          console.log(addressType , val);
                          
                        //  document.getElementById(addressType).value = val;
                            document.getElementById('op_locality').value = place.address_components[0]['long_name'];
                            document.getElementById('op_administrative_area_level_1').value = place.address_components[2]['short_name'];
                            document.getElementById('op_country').value = place.address_components[3]['long_name'];
                           //  console.log('place' , place.address_components[i][postal_code[addressType]]);
                            // if(place.address_components[i][postal_code[addressType]]=='undefined'){
                            //   document.getElementById('op_postal_code').value ='';
                            // }else{
                            //  document.getElementById('op_postal_code').value = place.address_components[i][postal_code[addressType]]=='undefined' ? "" : place.address_components[i][postal_code[addressType]];
                            // }
                            
                        }
                   }
                }
                 var address = place.address_components;
                 console.log('place' , address[address.length - 1].long_name);
             document.getElementById('op_postal_code').value =address[address.length - 1].long_name;
              document.getElementById('op_latitude').value = place.geometry.location.lat();
              document.getElementById('op_longitude').value = place.geometry.location.lng();
              
             
          });
    }

  function autocomplete4(){
    
    var input = document.getElementById('u_address');
    var autocomplete = new google.maps.places.Autocomplete(input);

    var componentForm = {
                  locality: 'long_name',
                  administrative_area_level_1: 'short_name',
                  country: 'long_name',
                  postal_code: 'short_name'
              };
   
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            for (var i = 0; i < place.address_components.length; i++) {
                  var addressType = place.address_components[i].types[0];
                  if (componentForm[addressType]) {
                      var val = place.address_components[i][componentForm[addressType]];
                      if(val){
                          console.log(addressType , val);
                          document.getElementById(addressType).value = val;
                      }
                 }
              }
           
        });
  }

  google.maps.event.addDomListener(window, 'load', initialize);

  

});
