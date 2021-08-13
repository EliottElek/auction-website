////////////////////////////////////////////////////
var modal2 = document.getElementById("myModalCancelAdding");

// Get the button that opens the modal
var btns = document.getElementsByClassName("cancelSale");
var input = document.getElementById("nbproposition");
// Get the <span> element that closes the modal
var span2 = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
if (btns != null) {
  for (let i = 0; i < btns.length; i++) {
    btns[i].onclick = function () {
      input.value = i+1;
      modal2.style.display = "block";
      return false;
    };
  }
  span2.onclick = function () {
    modal2.style.display = "none";
  };
}

var modal3 = document.getElementById("myModalAcceptAdding");
var accepts = document.getElementsByClassName("accept");
var input2 = document.getElementById("nbpropositionAccept");
var span3 = document.getElementsByClassName("close")[1];

// When the user clicks the button, open the modal
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
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
};