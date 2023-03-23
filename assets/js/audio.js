const customAudioControlHTML = '<div class="audiocontroll"><button class="playpause" aria-label="Audio Play-Pause Button"><img src="' + getDir() + '../pictures/play.svg" class="play" alt=""></img><img src="' + getDir() + '../pictures/pause.svg" class="pause" alt=""></img></button><div class="playback"><div class="playbackhead"></div><div class="playbackdisplay"></div><span class="currentTime"></span><span class="totalTime"></span></div></div>';

//allCustomControls
let allCustomControls = new Map();

/**
 * Class for the Custom Audio Controll
 */
class CustomAudioControl {
    /**
     * 
     * @param {element} div The Element of the <audio> Tag to be converted
     */
    constructor(div) {
        this.originalAudio = div;
        this.customAudioControlHTML = createCustomAudioControlHTML();
        this.playpause = this.customAudioControlHTML.querySelector('.playpause');
        this.playImg = this.customAudioControlHTML.querySelector('.play');
        this.pauseImg = this.customAudioControlHTML.querySelector('.pause');
        this.playbackhead = this.customAudioControlHTML.querySelector('.playbackhead');
        this.playback = this.customAudioControlHTML.querySelector('.playback');
        this.currentTime = this.customAudioControlHTML.querySelector('.currentTime');
        this.totalTime = this.customAudioControlHTML.querySelector('.totalTime');
        this.__setUpListeners(this.customAudioControlHTML);
        this.__injectHTML(this.customAudioControlHTML);
        allCustomControls.set(this.originalAudio, this);
        this.update();
    }

    play() {
        this.originalAudio.play();
        this.playImg.style.opacity = "0";
        this.pauseImg.style.opacity = "1";
    }

    pause() {
        this.originalAudio.pause();
        this.playImg.style.opacity = "1";
        this.pauseImg.style.opacity = "0";
    }

    update() {
        this.totalTime.innerText = convertTimeToText(this.originalAudio.duration);
        this.currentTime.innerText = convertTimeToText(this.originalAudio.currentTime);
        var x = 0;
        x += this.playback.offsetWidth * (this.originalAudio.currentTime / this.originalAudio.duration);
        //Adjust width of x by half of the Playheads with
        x -= this.playbackhead.offsetWidth / 2;
        this.playbackhead.style.transform = "translateX(" + x + "px)";
        if (this.paused()) {
            this.pause();
        } else {
            this.play();
        }
    }

    setCurrentTimeFromClick(e) {
        var clickPos = e.clientX - this.playback.getBoundingClientRect().x;
        var time = this.originalAudio.duration * (clickPos / this.playback.offsetWidth);
        this.originalAudio.currentTime = time;
        this.play();
    }

    paused() {
        return this.originalAudio.paused;
    }

    __injectHTML(toInject) {
        //Inserts the customAudioControlHTML AFTER the originalAudio Tag
        insertAfter(this.originalAudio, toInject);
    }

    __setUpListeners() {
        //Setting up the Button
        this.playpause.onclick = togglePlayState;
        this.originalAudio.ontimeupdate = updateCustom;
        this.playback.onclick = adjustPlayback;
    }
}

/**
 * Finds wich Custom Audio fired the Event and executes the Update on it
 * @param {event} e 
 */
function togglePlayState(e) {
    var targetAudio = e.target.parentNode.parentNode.querySelector('audio');
    customAudio = allCustomControls.get(targetAudio);
    //Toggles Playstate
    if (customAudio.paused()) {
        customAudio.play();
    } else {
        customAudio.pause();
    }
}

/**
 * Finds wich Custom Audio fired the Event and executes the Update on it
 * @param {event} e 
 */
function adjustPlayback(e) {
    customAudio = allCustomControls.get(e.target.parentNode.parentNode.querySelector('audio'));
    customAudio.setCurrentTimeFromClick(e);
}

/**
 * Finds wich Custom Audio fired the Event and executes the Update on it
 * @param {event} e 
 */
function updateCustom(e) {
    customAudio = allCustomControls.get(e.target);
    customAudio.update();
}

/**
 * Creates the Elements for the Custom Audio controll
 * @returns {element}
 */
function createCustomAudioControlHTML() {
    var template = document.createElement('template');
    template.innerHTML = customAudioControlHTML;
    return template.content.childNodes[0];
}

/**
 * 
 * @param {element} existing The Existing Element to be inserted after
 * @param {element} toInsert The Element that gets Inserted after
 */
function insertAfter(existing, toInsert) {
    existing.parentNode.insertBefore(toInsert, existing.nextSibling);
}

/**
 * Formats Time in Seconds into Readable Text
 * @param {int} time Time as an Integer in seconds
 * @returns {string} The Time formated MM:SS
 */
function convertTimeToText(time) {
    var rounded = Math.round(time);
    var minutes = Math.floor(rounded / 60);
    var seconds = rounded - (60 * minutes);
    if (seconds < 10)
        seconds = '0' + seconds;
    return minutes + ':' + seconds;
}

//Find all Audio Tags and replace them
allAudios = document.querySelectorAll('audio');
allAudios.forEach(audio => {
    new CustomAudioControl(audio);
    audio.volume = 1;
});

//Updating all Custom Controls once the Audios have loaded
allCustomControls.forEach(customControl => {
    customControl.originalAudio.addEventListener('loadeddata', function(e) {
        allCustomControls.get(e.target).update();
    })
});