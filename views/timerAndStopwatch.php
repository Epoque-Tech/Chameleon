<?php use Epoque\Chameleon\Daemon; ?>
<div class="row mainRow">
    <section class="col-md-8 col-md-offset-1 col-lg-offset-2">
        <header>
            <h2>Timer and Stopwatch</h2>
        </header>

        <?php Daemon::contents(PHP_DIR.'mainMenuDropdown.php'); ?>

        <div class="row">

          <div class="col-sm-4 col-sm-offset-1 col-md-6 col-md-offset-0">
            <h3>Timer</h3>

            <input id="timerHrs" class="numinput" type="number" min="00" value="00">
            <input id="timerMin" class="numinput" type="number" min="00" value="00">
            <input id="timerSec" class="numinput" type="number" min="00" value="00">

            <br><br>

            <button id="start-timer-btn" class="btn btn-primary">Start/Stop</button>
            <button id="timer-reset-btn" class="btn btn-default">Reset</button>
            
            <audio id="asound" src="/resources/audio/alert.ogg"></audio>

            <script src="<?php echo JS_DIR . 'timer.js'; ?>"></script>

          </div>


          <div class="col-sm-3 col-md-6">
            <h3>Stopwatch</h3>

            <div id="stopwatch"><p>00:00:00:00</p></div>

            <button id="start-stop-btn" class="btn btn-primary">Start/Stop</button>
            <button id="lap-btn" class="btn btn-default">Lap</button>

            <br><br>
            <div id="laps"></div>

            <script src="<?php echo JS_DIR . 'stopwatch.js'; ?>"></script>
          </div>

        </div>

    </section>
</div>
