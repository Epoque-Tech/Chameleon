<?php 
use Epoque\GitHub\Daemon as GitHub;
use Epoque\GitHub\Repos;

$token = trim(file_get_contents(APP_ROOT.'github.token'));
GitHub::init(['user'=>'not--p', 'token'=> $token]);
$repos = Repos::enumerate(); ?>

<pre>
<?php
    print_r(Repos::branches('funky'));
?>
</pre>
