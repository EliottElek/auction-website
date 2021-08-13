var modal = document.getElementById("myModalAddObject");
// Get the button that opens the modal
var btn = document.getElementById("addcard");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var cancelAdding = document.getElementById("cancelAdding");
if (btn != null) {
  btn.onclick = function () {
    modal.style.display = "block";
  };
  span.onclick = function () {
    modal.style.display = "none";
  };
}
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
if (cancelAdding != null) {
  cancelAdding.onclick = function () {
    modal.style.display = "none";
  };
};
////////////////////////////////////////////////////
var modal2 = document.getElementById("myModalCancelAdding");
var modal3 = document.getElementById("myModalAcceptAdding");

// Get the button that opens the modal
var btns = document.getElementsByClassName("cancelSale");
var accepts = document.getElementsByClassName("accept");

var input = document.getElementById("nbproposition");
var input2 = document.getElementById("nbpropositionAccept");

// Get the <span> element that closes the modal
var span2 = document.getElementsByClassName("close")[1];
var span3 = document.getElementsByClassName("close")[2];

// When the user clicks the button, open the modal
if (btns != null) {
  for (let i = 0; i < btns.length; i++) {
    btns[i].onclick = function () {
      input.value = i+1;
      modal2.style.display = "block";
    };
  }
  span2.onclick = function () {
    modal2.style.display = "none";
  };
}
if (accepts != null) {
  for (let i = 0; i < accepts.length; i++) {
    accepts[i].onclick = function () {
      input2.value = i+1;
      modal3.style.display = "block";
      return false;
    };
  }
  span3.onclick = function () {
    modal3.style.display = "none";
  };
}
// When the user clicks anywhere outside of the modal2, close it
window.onclick = function (event) {
  if (event.target == modal3) {
    modal3.style.display = "none";
  }
};
window.onclick = function (event) {
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
};