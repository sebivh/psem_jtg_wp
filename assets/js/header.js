
registerOnLoad(setUpBurger);

function setUpBurger() {
    //Code to be executeted when the document html is loaded
    let nav_element = document.querySelector("nav");
    let burger = nav_element.querySelector(".burger");
    let link_list = nav_element.querySelector(".menu-navbar-container");

    burger.onclick = function () {
        link_list.classList.toggle("active");
        burger.classList.toggle("active");
    }
}