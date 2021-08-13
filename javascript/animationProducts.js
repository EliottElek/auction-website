$(function () {
  //settings for slider
  const tl = new TimelineMax();
  header = document.querySelector("header");
  var width = window.screen.width;
  var animationSpeed = 1000;
  var pause = 6000;
  var currentSlide = 1;
  //cache DOM elements
  var $slider = $(".slider");
  var $slideContainer = $(".slides", $slider);
  var $slides = $(".slide", $slider);
  var $insideSlde1 = $("#textAnimation1");
  var $insideSlde2 = $("#textAnimation2");
  var interval;
  function startSlider() {
    interval = setInterval(function () {
      $slideContainer.animate(
        { "margin-left": "-=" + width },
        animationSpeed,
        function () {
          if (++currentSlide === $slides.length) {
            currentSlide = 1;
            $slideContainer.css("margin-left", 0);
          }
        }
      );
    }, pause);
  }
  startSlider();
});
