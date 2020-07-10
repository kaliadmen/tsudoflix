function volumeToggle(button) {
    //when you click the button it always does the opposite of what is currently set
    const toggleMute = document.querySelector(".previewVideo").muted = !document.querySelector(".previewVideo").muted;
    document.querySelector(".vol").classList.toggle("fa-volume-mute");
    document.querySelector(".vol").classList.toggle("fa-volume-up");

}

function previewEnded() {
    let imageToggle = document.querySelector(".previewImage");
    let videoToggle = document.querySelector(".previewVideo");
    imageToggle.removeAttribute("hidden");
    videoToggle.setAttribute("hidden", "true");
}

function goBack() {
    window.history.back();
}

function startHideTimer() {
    const watchContainer = document.querySelector(".watchContainer");
    const watch = document.querySelector(".watchNav");
    let timeout = null;

    clearTimeout(timeout);

    timeout = setTimeout(() => {
        watch.classList.add("active");
    }, 2000);

    watchContainer.onmousemove = () => {
        clearTimeout(timeout);
        watch.classList.remove("active");
    };

    watchContainer.onmouseleave = () => {
        timeout = setTimeout(() => {
            watch.classList.add("active");
        }, 2000);
    };
}

    function initVideo() {
        startHideTimer();
    }