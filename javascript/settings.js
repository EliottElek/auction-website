btn = document.getElementById("modify");
inputs = document.getElementsByClassName("info");
btn.onclick = function () {
  for (let i = 0; i < inputs.length; i++) {
    inputs[i].disabled = false;
    inputs[i].style.backgroundColor = "white";
  }
  document.getElementById("saveInfos").style.display = "block";
  return false;
};
var modal = document.getElementById("myModalGetBuyer");
var modal2 = document.getElementById("myModalModifPassword");

// Get the button that opens the modal
var btn = document.getElementById("buyerbtn");
var btn2 = document.getElementById("continue");
var agree = document.getElementById("becomeBuyer");
var terms = document.getElementById("terms");
var message = document.getElementById("span");
var message2 = document.getElementById("span2");
var newpass = document.getElementById("newpass");
var newpassconf = document.getElementById("newpassconf");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close")[1];

function checkedIfAgreed() {
  if (!terms.checked) {
    message.innerText = "you must agree to our terms and conditions.";
    return false;
  } else return true;
}
function checkMatchingPasswords() {
  if (newpass.value != newpassconf.value) {
    message2.innerText = "confirmation pass did not match.";
    return false;
  } else {
  }
  return true;
}
// When the user clicks the button, open the modal
if (btn != null) {
  btn.onclick = function () {
    modal.style.display = "block";
  };
  span.onclick = function () {
    modal.style.display = "none";
  };
}
if (btn2 != null) {
  btn2.onclick = function () {
    modal2.style.display = "block";
  };
  span2.onclick = function () {
    modal2.style.display = "none";
  };
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
