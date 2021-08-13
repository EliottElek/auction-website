// temporary variable to store the link og the picture
var temp = "";
var mainImg = document.getElementById("mainImg");
var img1 = document.getElementById("img1");
var img2 = document.getElementById("img2");
var img3 = document.getElementById("img3");

img1.onclick = function () {
  temp = document.getElementById("mainImg").getAttribute("src");
  mainImg.setAttribute("src", img1.getAttribute("src"));
  img1.setAttribute("src", temp);
};
img2.onclick = function () {
  temp = document.getElementById("mainImg").getAttribute("src");
  mainImg.setAttribute("src", img2.getAttribute("src"));
  img2.setAttribute("src", temp);
};
img3.onclick = function () {
  temp = document.getElementById("mainImg").getAttribute("src");
  mainImg.setAttribute("src", img3.getAttribute("src"));
  img3.setAttribute("src", temp);
};

if (document.getElementById("bidIn") != null) {
  document.getElementById("bidIn").addEventListener("input", () => {
    if (document.getElementById("bidIn").value.length != 0) {
      document.getElementById("bid").disabled = false;
      document.getElementById("bid").style.backgroundColor =
        "rgb(236, 138, 26)";
    } else {
      document.getElementById("bid").disabled = true;
      document.getElementById("bid").style.backgroundColor = "gray";
    }
  });
}
