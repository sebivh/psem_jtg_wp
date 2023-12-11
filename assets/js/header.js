registerOnLoad(setUpBurger);
registerOnLoad(setUpSubMenus);

function setUpBurger() {
    //Code to be executed when the document html is loaded
    let nav_element = document.querySelector("nav");
    let burger = nav_element.querySelector(".burger");
    let link_list = nav_element.querySelector(".menu-navbar-container");

    burger.onclick = function() {
        link_list.classList.toggle("active");
        burger.classList.toggle("active");
    }
}

function setUpSubMenus() {
    let sub_menus = document.querySelectorAll("nav .menu-navbar-container #menu-navbar li.menu-item-has-children");

    sub_menus.forEach(m => {
        m.querySelector("a").onclick = function() {
            m.classList.toggle("active");
        }
    });
}