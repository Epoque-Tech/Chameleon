(function () {
    var hrs = min = sec = 0;
    var pause = true;
    var prev  = false;

    var countdown = function () {
        var hoursLeft = false;
        var minsLeft  = false;
        var secLeft   = false;

        if (!pause) {
            hrs = parseInt($('#timerHrs').val()) || 0;
            min = parseInt($('#timerMin').val()) || 0;
            sec = parseInt($('#timerSec').val()) || 0;

            if (hrs > 0) {
                hoursLeft = true;
            }
            if (hrs > 0 || min > 0) {
                minsLeft = true;
            }
            if (hrs > 0 || min > 0 || sec > 0) {
                secLeft = true;
            }

            if (secLeft) {
                if (sec > 0) {
                    sec--;
                }
                else if (min > 0) {
                    min--;
                    sec = 59;
                }
                else if (hrs > 0) {
                    hrs--;
                    min = min + 59;
                    sec = 59;
                }

                printCountdown();
                window.setTimeout(countdown, 15*60);
            }
            else {
                console.log('playing audio');
                var audio = new Audio('/resources/audio/alert.ogg');
                audio.play();
                window.setTimeout(countdown, 3*15*60);
            }
        }
    };

    var printCountdown = function () {
        if (hrs.toString().length < 2) {
            hrs = "0" + hrs.toString();
        }
        if (min.toString().length < 2) {
            min = "0" + min.toString();
        }
        if (sec.toString().length < 2) {
            sec = "0" + sec.toString();
        }

        $('#timerHrs').val(hrs);
        $('#timerMin').val(min);
        $('#timerSec').val(sec);
    };

    var reset = function () {
        if (pause && prev) {
            console.log(prev);
            hrs = prev[0];
            min = prev[1];
            sec = prev[2];
            printCountdown();
            prev = false;
        }
    };

    $('#start-timer-btn').click( function () {
        if (pause && !prev) {
            console.log('Setting prev...');
            prev = [
                parseInt($('#timerHrs').val()) || 0,
                parseInt($('#timerMin').val()) || 0,
                parseInt($('#timerSec').val()) || 0
            ];
            console.log(prev);
        }

        pause = !pause;
        countdown();
    });

    $('#timer-reset-btn').click(reset);
}());

console.log('timer.js loaded');
