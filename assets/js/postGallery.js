const postCardSpeed = 1;

var gallery = null;
var posts = null;
var wrapper = null;
var rightArrow = null;
var leftArrow = null;

registerOnLoad(setUpGallery);

var mouseDown = false;

function setUpGallery() {
    gallery = document.querySelector('.postgallery');
    posts = gallery.querySelectorAll('.post-card');
    wrapper = gallery.querySelector('.postwrapper');
    rightArrow = gallery.querySelector('.arrow.right');
    leftArrow = gallery.querySelector('.arrow.left');

    registerOnResize(stopGalleryManipulation);

    //Buttons
    rightArrow.onclick = function() {
        currentPost++;
        stopGalleryManipulation();
    }
    leftArrow.onclick = function() {
            currentPost--;
            stopGalleryManipulation();
        }
        //Handlers for Touch Support
    gallery.ontouchstart = function(e) {
        startGalleryManipulation(e.touches[0].screenX)
    }
    gallery.ontouchmove = function(e) {
        updateGalleryManipulation(e.touches[0].screenX);
    }
    gallery.ontouchend = function() {
            stopGalleryManipulation();
        }
        //Handlers for Mouse Support
    gallery.onmousedown = function(e) {
        mouseDown = true;
        startGalleryManipulation(e.screenX);
    }
    document.onmousemove = function(e) {
        if (mouseDown)
            updateGalleryManipulation(e.screenX);
    }
    document.onmouseup = function() {
        mouseDown = false;
        stopGalleryManipulation();
    }
}

registerOnComplete(function() {
    //First adjust
    stopGalleryManipulation();
});

var currentPost = 0;
var manipulationXorigin = 0;
var center = 0;
var change = 0;

function startGalleryManipulation(screenX) {
    manipulationXorigin = screenX;
    change = 0;
    wrapper.classList.remove('animate');
}

function updateGalleryManipulation(screenX) {
    change += screenX - manipulationXorigin;
    manipulationXorigin = screenX;
    var manipulator = change * postCardSpeed + center
        //Manipulate Post
    wrapper.style.transform = 'translateX(' + manipulator + 'px' + ')';
}


function stopGalleryManipulation() {
    if (change < -(gallery.getBoundingClientRect().width / 8)) {
        currentPost++;
        if (currentPost > posts.length - 1)
            currentPost = posts.length - 1;
    }
    if (change > (gallery.getBoundingClientRect().width / 8)) {
        currentPost--;
        if (currentPost < 0)
            currentPost = 0;
    }
    //Update Arrows
    if (currentPost == 0) {
        leftArrow.classList.add('inactive');
        rightArrow.classList.remove('inactive');
    } else {
        if (currentPost >= posts.length - 1) {
            leftArrow.classList.remove('inactive');
            rightArrow.classList.add('inactive');
        } else {
            leftArrow.classList.remove('inactive');
            rightArrow.classList.remove('inactive');
        }
    }

    //Calculate the Center Point
    var paddingLeft = parseFloat(window.getComputedStyle(gallery, null).getPropertyValue('padding-left'));
    center = gallery.getBoundingClientRect().width / 2 - posts[currentPost].getBoundingClientRect().width / 2 - posts[currentPost].offsetLeft - paddingLeft;

    //Animate back
    wrapper.classList.add('animate');
    wrapper.style.transform = 'translateX(' + center + 'px)';
}