//Gets the Directory this Script is placed in
function getDir() {
    let scripts= document.getElementsByTagName('script');
    let path= scripts[scripts.length-1].src.split('?')[0];
    return path.split('/').slice(0, -1).join('/')+'/';
}

function getCssVar(name) {
    return getComputedStyle(html_map).getPropertyValue(name);
}

/**
 * @var {function} startFunctions
 */
var startFunctions = [];
/**
 * Register On Load
 * 
 * Funktion to register functions that are executed when the DOM loaded
 * 
 * @param {function} func The function that gets executed when the DOM loads
 */
function registerOnLoad(func) {
    startFunctions.push(func);
}

var completeFunctions = [];

function registerOnComplete(func) {
    completeFunctions.push(func);
}

/**
 * Executing every Function that should be executed on start
 */
document.onreadystatechange = function () {
    if (document.readyState == "interactive") {
        startFunctions.forEach(func => {
            func();
        });
    } else {
        if (document.readyState == "complete") {
            completeFunctions.forEach(func => {
                func();
            });
        }
    }
}