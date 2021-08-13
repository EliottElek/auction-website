var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("profileModif");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
if (btn != null) {
  btn.onclick = function () {
    modal.style.display = "block";
    return false;
  };
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
const arrayOfBackgounds = [
  "https://images.unsplash.com/photo-1595757816291-ab4c1cba0fc2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1000&q=80",
  "https://img.freepik.com/vecteurs-libre/fond-blanc-elegant-lignes-brillantes_1017-17580.jpg?size=626&ext=jpg&ga=GA1.2.1282066085.1610236800",
  "https://www.enjpg.com/img/2020/light-blue-background-4.jpg",
  "https://i.pinimg.com/originals/3a/fc/fc/3afcfcafb55d99e30d9a7ffab4ed96c7.jpg",
  "https://i.pinimg.com/originals/ba/32/e3/ba32e3025d97b4da3bc0a68474c43217.jpg",
  "https://cdn4.vectorstock.com/i/1000x1000/95/18/seamless-geometric-pattern-repeating-background-vector-9789518.jpg",
  "http://unblast.com/wp-content/uploads/2020/05/Light-Wood-Background-Texture-4.jpg",
  "https://cdn.hipwallpaper.com/i/40/76/J6SsKx.jpg",
  "https://www.desktopbackground.org/download/1920x1080/2015/07/31/987869_magic-blue-sea-bright-spots-backgrounds-large-wallpapers-1920-1166_1920x1166_h.jpg",
];

let status = document.getElementById("status").value;
if (status == 1) {
  var indexBack = document.getElementById("indexofcolor").value;
  document.getElementsByTagName("body")[0].style.backgroundImage =
    "url('" + arrayOfBackgounds[indexBack - 1] + "')";
  document.getElementsByTagName("body")[0].style.backgroundSize = "cover";
  document.getElementsByTagName("section")[0].style.paddingBottom = "100px";
  document.getElementsByTagName("section")[0].style.backgroundColor =
    "transparent";
}else {
    document.getElementsByTagName("body")[0].style.backgroundImage =
    "url('" + arrayOfBackgounds[1] + "')";
    document.getElementsByTagName("body")[0].style.backgroundSize = "cover";
    document.getElementsByTagName("section")[0].style.paddingBottom = "100px";
    document.getElementsByTagName("section")[0].style.backgroundColor =
      "transparent";
}
