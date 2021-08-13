function logOut() {
    $.post("logOut.php", function () {});
    window.location.reload();
  }
  $(document).ready(function () {
    if (document.getElementById("addcard") != null) {
      document.getElementById("addcard").onclick = function () {
        document.getElementById("addcard").style.display = "none";
        document.getElementById("formAdd").style.display = "block";
      };
    }
    if (document.getElementById("cancel") != null) {
      document.getElementById("cancel").onclick = function () {
        document.getElementById("addcard").style.display = "block";
        document.getElementById("formAdd").style.display = "none";
      };
    }  });
  