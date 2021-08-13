var image = document.getElementById("navImage");
var image2 = document.getElementById("navImage2");
let navbuttons = document.getElementsByClassName("navbtn");

navbuttons[0].onmouseover = function(){
    image.setAttribute("src", "iphone.jpg");
    image.style.transition = "0.5s ease";
};
navbuttons[1].onmouseover = function(){
    image.setAttribute("src", "ipad.jpg");
    image.style.transition = "0.5s ease";
};
navbuttons[2].onmouseover = function(){
    image.setAttribute("src", "imac.jpg");
    image.style.transition = "0.5s ease";
};
navbuttons[3].onmouseover = function(){
    image.setAttribute("src", "casque.jpg");
    image.style.transition = "0.5s ease";
};

navbuttons[4].onmouseover = function(){
    image2.setAttribute("src", "Auction-label.png");
    image2.style.transition = "0.5s ease";
};
navbuttons[5].onmouseover = function(){
    image2.setAttribute("src", "buynow.jpg");
    image2.style.transition = "0.5s ease";
};
navbuttons[6].onmouseover = function(){
    image2.setAttribute("src", "bestoffer.jpg");
    image2.style.transition = "0.5s ease";
};
navbuttons[7].onmouseover = function(){
    image2.setAttribute("src", "flashSales.png");
    image2.style.transition = "0.5s ease";
};