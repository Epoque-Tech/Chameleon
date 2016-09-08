(function () {
    var h = m = s = ms = 0;
    var lap = [];
    var paused = true;

    var tick = function () {
        if (!paused) {
            if (ms < 99) {
                ms++;
            }
            else {
                ms = 0;
                if (s < 59) {
                    s++;
                }
                else {
                    s = 0;
                    m++;
                    if (m === 59) {
                        m = 0;
                        s = 0;
                        h++;
                    }
                }
            }

            printTime();
            window.setTimeout(tick, 10);
        }
    };

    var printTime = function () {
        if (h.toString().length < 2) {
            h = "0" + h.toString();
        }
        if (m.toString().length < 2) {
            m = "0" + m.toString();
        }
        if (s.toString().length < 2) {
            s = "0" + s.toString();
        }
        if (ms.toString().length < 2) {
            ms = "0" + ms.toString();
        }

        $('#stopwatch').html('<p>' + h + ':' + m + ':' + s + ':' + ms + '</p>');  
    };

    var recordLap = function () {
        lap.push(h + ':' + m + ':' + s + ':' + ms);
        console.log(lap);

        $('#laps').html('');
        lap.forEach(function (laptime) {
            document.getElementById('laps').innerHTML += laptime + '<br>';
        });

        h = m = s = 0;
    };

    var reset = function () {
        h = m = s = ms = 0;
        $('#laps').html('');
        printTime();
    };

    $('#start-stop-btn').click(function () {
        if (paused) {
            paused = false;
            $('#lap-btn').html('Lap');
            $('#lap-btn').unbind('click');
            $('#lap-btn').click(recordLap);
            tick();
        }
        else {
            paused = true;
            $('#lap-btn').html('Reset');
            $('#lap-btn').unbind('click');
            $('#lap-btn').click(reset);
        }
    });
}());

console.log('stopwatch.js loaded');
