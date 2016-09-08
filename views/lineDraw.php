<?php use Epoque\Chameleon\Daemon; ?>

<div class="row mainRow">
    <section class="col-sm-12 col-md-8 col-md-offset-1 col-lg-offset-2">
        <header>
            <h2>Math Functions</h2>
        </header>
        
        <?php Daemon::contents(PHP_DIR.'mainMenuDropdown.php'); ?>

        <canvas id="line-draw-canvas" width="300" height="300"></canvas>

        <div id="line-draw-input">
          <input id="pt1" type="text" placeholder="point1">
          <input id="pt2" type="text" placeholder="point2">
          <br>
          <button type="button" id="draw-btn" class="btn btn-primary line-draw-btn">Draw Line</button>
          <button type="button" id="clear-btn" class="btn btn-default line-draw-btn">Clear</button>
        </div>

        <script src="<?php echo JS_DIR.'math/lineDraw.js'; ?>"> </script>

    </section>
</div>
