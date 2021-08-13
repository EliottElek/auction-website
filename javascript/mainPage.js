if (window.screen.width >= 1200) {
  document.getElementsByTagName("section")[0].style.width = window.screen.width;
  if (document.getElementsByClassName("slider")[0] != null) {
    document.getElementsByClassName("slider")[0].style.width =
      window.screen.width;
    document.getElementsByClassName("slide")[0].style.width =
      window.screen.width;
    document.getElementById("slideimg1").style.width = window.screen.width;
    document.getElementById("slideimg2").style.width = window.screen.width;
    document.getElementById("slideimg3").style.width = window.screen.width;
    document.getElementById("slide1").style.width = window.screen.width;
    document.getElementById("slide2").style.width = window.screen.width;
    document.getElementById("slide3").style.width = window.screen.width;
    document.getElementsByClassName("showOptions")[0].style.width =
      window.screen.width;
  }
}
const navSlide = () => {
  const burger = document.querySelector("#burger");
  const mobilenav = document.querySelector(".mobile-nav");
  const navbuttons = document.querySelectorAll(".mobile-nav button");
  burger.addEventListener("click", () => {
    mobilenav.classList.toggle("nav-active");
    navbuttons.forEach((link, index) => {
      if (link.style.animation) {
        link.style.animation = "";
      } else {
        link.style.animation =
          "navLinkFade 0.5s ease forwards " + (index / 8 + 0.3) + "s";
      }
    });
    //burger animation
    burger.classList.toggle("toggle");
  });
  //animate all nav buttons
};
navSlide();
$("document").ready(function () {
  if (document.getElementById("myModalMainPage") != null) {
    setTimeout(function () {
      document.getElementById("myModalMainPage").style.display = "block";
    }, 2000);
    window.onclick = function(){
      document.getElementById("myModalMainPage").style.display = "none";
    }
    document.getElementsByClassName("span")[0].onclick = function(){
      document.getElementById("myModalMainPage").style.display = "none";
    }
  }
});
