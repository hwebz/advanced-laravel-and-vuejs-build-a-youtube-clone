var player = videojs('#my_video_1');

var viewLogged = false;

player.on('timeupdate', function() {
    var percentagePlayed = Math.ceil(player.currentTime() / player.duration() * 100);

    if (percentagePlayed > 10 && !viewLogged) {
        axios.put('/videos/' + window.CURRENT_VIDEO);

        viewLogged = true;
    }
});
