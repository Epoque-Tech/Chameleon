<?php use Epoque\Chameleon\Daemon; ?>

<div class="row mainRow">
    <section class="col-md-8 col-md-offset-1 col-lg-offset-2">
        <header>
            <h2>Economic Functions</h2>
            <p>Select an Economic Calculator</p>
        </header>
        
        <?php Daemon::contents(PHP_DIR.'mainMenuDropdown.php'); ?>

        <ul class="nav nav-pills nav-stacked">
          <li role="presentation"><a href="/inflation">Inflation</a></li>
          <li role="presentation"><a href="/gold">Gold</a></li>
        </ul>
    </section>
</div>