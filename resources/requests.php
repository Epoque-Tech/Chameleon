<?php


if (!empty($_REQUEST))
{
    $APP_ROOT = pathinfo(__DIR__)['dirname'];
    $request = filter_input_array(INPUT_GET, [
        'test' => FILTER_SANITIZE_STRING
    ]);


    if ($request['test']) {
        $test = "$APP_ROOT/vendor/epoque/chameleon/tests/".$request['test'].'Test.php';
        $cmd = "phpunit --bootstrap $APP_ROOT/vendor/autoload.php $test";

        $output = shell_exec($cmd);
        print(preg_replace('/\n\n/', '<br>', $output));
    }
}

