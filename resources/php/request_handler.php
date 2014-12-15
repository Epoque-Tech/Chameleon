<?php
namespace requests;

require_once('authentication.php');
use authentication as auth;


/**
 * A switch for handling user requests.
 */

if (isset($_REQUEST)) {

    foreach($_REQUEST as $type => $args)
    {
        switch ($type)
        {
            case 'login':
            $username = isset($_POST['username'])? $_POST['username'] : False;
            $password = isset($_POST['password'])? $_POST['password'] : False;

            if ($username && $password) {
                if (auth\valid_login($username, $password)) {
                    session_start();
                }
            }
            break;

            case 'test':
            print('Hello World');
            break;
        }
    }
}
