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
        //Check for left Mouse Button
        if (e.button == 0) {
            mouseDown = true;
            startGalleryManipulation(e.screenX);
        }
    }
    document.onmousemove = function(e) {
        if (mouseDown)
            updateGalleryManipulation(e.screenX);
    }
    document.onmouseup = function(e) {
        if (mouseDown) {
            mouseDown = false;
            //Check if Mose has moved since click
            if (change != 0) {
                //If so, Gallery has been Manipulated and needs to be Changed accordingly
                stopGalleryManipulation();
            } else {
                //In any other Case, it could be User tried to click on the Post Card trying to Navigate
                //If the User clicked on the Picture in the Arrows, he didn't try to follow the post Card link, so don't do anything
                //If this isn't the Case, redirect the User to the Post of the Card by clicking it, like intended
                //Also checks if the Click is on the Gallery
                if (e.target == gallery && !(e.target == rightArrow.querySelector('img') || e.target == leftArrow.querySelector('img')))
                    posts[currentPost].click();
            }
        }
    }
}

/**
 * In order for the Gallery to be shown right when loading the Page, this initial call needs to happen!
 */
registerOnComplete(function() {
    //First adjust
    stopGalleryManipulation();
});

var currentPost = 0;
var manipulationXorigin = 0;
var center = 0;
var change = 0;

/**
 * Funktion that registers all necessary Information to start the Manipulation
 * Also turns all Animations on the Postcard Wrapper off so it follows the Mouse nicely
 * @param {*} screenX The Screen Position of the Interaktion
 */
function startGalleryManipulation(screenX) {
    manipulationXorigin = screenX;
    change = 0;
    wrapper.classList.remove('animate');
}

/**
 * Calculates the Distance the Mouse Moved on the X-Axis and adjusts the Wrapper accordingly
 * @param {*} screenX The Screen Position of the Interaktion
 */
function updateGalleryManipulation(screenX) {
    change += screenX - manipulationXorigin;
    manipulationXorigin = screenX;
    var manipulator = change * postCardSpeed + center
        //Manipulate Post
    wrapper.style.transform = 'translateX(' + manipulator + 'px' + ')';
}

/**
 * Sets the new aktive Post and turns on Animations again
 */
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