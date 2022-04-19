var url = document.getElementById("asset_url").value;

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  console.log('tab',n);
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[currentTab].style.display = "none";
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Confirm and Submit Details" +'<img src="'+url+'/images/arrow.png" alt="">';
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("submitBtn").style.display = "block";
    //document.getElementById("nextBtn").type = "submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next" +'<img src="'+url+'/images/arrow.png" alt="">';
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function tabChange(val){
  var x = document.getElementsByClassName("tab");
  
//  if (val == 1 && !validateForm()) return false;
  x[currentTab].style.display = "none";
  if (currentTab >= x.length) {
    document.getElementById("regForm").submit();
    return false;
  }
  show(val);
}
function show(n) {
  
  var x = document.getElementsByClassName("tab");
  x[currentTab].style.display = "none";
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Confirm and Submit Details" +'<img src="'+url+'/images/arrow.png" alt="">';
    document.getElementById("nextBtn").style.display = "block";
    document.getElementById("submitBtn").style.display = "block";
    //document.getElementById("nextBtn").type = "submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next" +'<img src="'+url+'/images/arrow.png" alt="">';
  }
  //... and run a function that will display the correct step indicator:
  //fixStepIndicator(n);
  
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");

  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;

  for (let index = 0; index < x.length; index++) {
    const tab = x[index];
    tab.style.display = 'none';
  }

  // Hide the current tab:
  x[currentTab].style.display = "none";
  
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    console.log('input', y[i].name);
    // If a field is empty...
    
    if(y[i].name == "is_return"){
     break;
    }
    else if (y[i].value == "") {
      y[i].className += " invalid";
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }else{
    toastr.error("Please fill all details", 'Error');
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}


