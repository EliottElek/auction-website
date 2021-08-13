// formDeliv">addDelivAdress

function logOut() {
    $.post("logOut.php", function () {});
    window.location.reload();
  }
  $(document).ready(function () {
    if (document.getElementById("addDelivAdress") != null) {
      document.getElementById("addDelivAdress").onclick = function () {
        document.getElementById("addDelivAdress").style.display = "none";
        document.getElementById("formDeliv").style.display = "block";
      };
    }
    
  });
  
  