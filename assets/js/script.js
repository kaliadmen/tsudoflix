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

function initVideo(videoId, username) {
    startHideTimer();
    setStartTime(videoId, username);
    updateProgressTimer(videoId, username);

}

function updateProgressTimer(videoId, username) {
    addDuration(videoId, username);

    let timer;
    const video = document.querySelector("video");

    video.onplaying = function(event) {
        window.clearInterval(timer);
        timer = window.setInterval(function () {
            updateProgress(videoId, username, event.target.currentTime);
        }, 3000);
    };

    video.onpause = function () {
        window.clearInterval(timer);
    };

    video.onended = function() {
        setFinished(videoId, username);
        window.clearInterval(timer);
        showUpNextVideo();
    }

}

function addDuration(videoId, username) {
    //call formData constructor to get PHP data
    const formData = new FormData();
    //pass our key/value pairs to constructor
    formData.append("videoId", videoId);
    formData.append("username", username);

    if (formData !== "") {
        fetch("ajax/add_duration.php", {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .catch(error => {
                console.error('Error:', error);
            });
    }
}

function updateProgress(videoId, username, progress) {

    const formData = new FormData();

    formData.append("videoId", videoId);
    formData.append("username", username);
    formData.append("progress", progress);

    if (formData !== "") {
        fetch("ajax/update_duration.php", {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .catch(error => {
                console.error('Error:', error);
            });
    }
}

function setFinished(videoId, username) {

    const formData = new FormData();

    formData.append("videoId", videoId);
    formData.append("username", username);

    if (formData !== "") {
        fetch("ajax/set_finished.php", {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .catch(error => {
                console.error('Error:', error);
            });
    }
}

function setStartTime(videoId, username) {
    $.post("ajax/get_progress.php", {videoId, username}, (data) => {
        if(isNaN(data)) {
            alert(data);
        }
        const video = $("video");

        video.on("play", (event) => {
            video[0].currentTime = data;
            video.off("play")
        })
    });
}

function restartVideo() {
    const video = document.querySelector("video");


    video.currentTime = 0;
    video.play();

    $(".upNext").fadeOut();

}

function showUpNextVideo() {
    $(".upNext").fadeIn();
}

function watchVideo(videoId) {
    window.location.href = `watch.php?id=${videoId}`
}