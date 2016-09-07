<?php
use Epoque\Chameleon\Daemon;

echo "<h1>Hello</h1>\n";

var_dump(Daemon::addRoute(['/site' => APP_ROOT.'test.php']));
// var_dump(Daemon::fetch());

Daemon::fetch();

