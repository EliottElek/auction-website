const tl = new TimelineMax();
form = document.querySelector(".sign-up-form");

tl.fromTo(form, 1, { opacity: "0", x: "300" }, { opacity: "1", x: "0" }, "0");
