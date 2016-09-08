<?php use Epoque\Chameleon\Daemon; ?>

<div class="dropdown mainMenuDropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Main Menu
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
      <?php Daemon::contents(PHP_DIR.'mainMenu.php'); ?>
  </ul>
</div>