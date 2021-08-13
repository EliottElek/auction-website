function logOut() {
  $.post("logOut.php", function () {});
  window.location.reload();
}
$(document).ready(function () {
  if (document.getElementById("addAdress1") != null) {
    document.getElementById("addAdress1").onclick = function () {
      document.getElementById("addAdress1").style.display = "none";
      document.getElementById("form1").style.display = "block";
    };
  }
  if (document.getElementById("addAdress2") != null) {
    document.getElementById("addAdress2").onclick = function () {
      document.getElementById("addAdress2").style.display = "none";
      document.getElementById("form2").style.display = "block";
    };
  }
  if (document.getElementById("addAdress1-2") != null) {
    document.getElementById("addAdress1-2").onclick = function () {
      document.getElementById("addAdress1-2").style.display = "none";
      document.getElementById("form1-2").style.display = "block";
    };
  }
});
var modal = document.getElementById("myModal");
var modal2 = document.getElementById("myModalSec");

// Get the button that opens the modal
var btn = document.getElementById("delete1");
var btn2 = document.getElementById("delete21");
var btn3 = document.getElementById("delete22");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close")[1];

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
    modal.style.display = "block";
  };
  span.onclick = function () {
    modal.style.display = "none";
  };
}
if (btn3 != null) {
  btn3.onclick = function () {
    modal2.style.display = "block";
  };
  span2.onclick = function () {
    modal2.style.display = "none";
  };
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal || event.target == modal2) {
    modal.style.display = "none";
    modal2.style.display = "none";
  }
};
function delayReload() {
  setTimeout(function () {
    window.location.reload();
  }, 2500);
}
