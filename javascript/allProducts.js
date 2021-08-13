var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btns = document.getElementsByClassName("deleteItem");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
if (btns != null) {
  for (let i = 0; i < btns.length; i++) {
    btns[i].onclick = function () {
      document.getElementById("nbcard").value = i + 1;
      modal.style.display = "block";
    };
  }
  span.onclick = function () {
    modal.style.display = "none";
  };
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
function delayReload() {
  setTimeout(function () {
    window.location.reload();
  }, 2500);
}

var modal2 = document.getElementById("myModalAddObject");
// Get the button that opens the modal
var btn2 = document.getElementById("addcard");
// Get the <span> element that closes the modal
var span2 = document.getElementsByClassName("close")[1];
var cancelAdding = document.getElementById("cancelAdding");
if (btn2 != null) {
  btn2.onclick = function () {
    modal2.style.display = "block";
  };
  span2.onclick = function () {
    modal2.style.display = "none";
  };
}
window.onclick = function (event) {
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
};
if (cancelAdding != null) {
  cancelAdding.onclick = function () {
    modal2.style.display = "none";
  };
}
function discountOrBuyNow() {
  if (document.getElementById("type-select").value == "flashsales") {
    document.getElementById("flash1").style.display = "block";
    document.getElementById("flash2").style.display = "block";
    document.getElementById("flash3").style.display = "block";
    document.getElementById("flash4").style.display = "block";
  } else if (document.getElementById("type-select").value == "buynow") {
    document.getElementById("flash1").style.display = "none";
    document.getElementById("flash2").style.display = "none";
    document.getElementById("flash3").style.display = "none";
    document.getElementById("flash4").style.display = "none";
  }
}
