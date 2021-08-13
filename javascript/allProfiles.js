var modal = document.getElementById("myModal");
  
  // Get the button that opens the modal
  var btns = document.getElementsByClassName("deleteAccount");
  
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  
  // When the user clicks the button, open the modal
  if (btns != null) {
    for (let i = 0; i < btns.length; i++) {
      btns[i].onclick = function () {
        document.getElementById("nbcard").value = i+1;
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
  