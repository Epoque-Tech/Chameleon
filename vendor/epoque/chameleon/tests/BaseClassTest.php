<?php
use Epoque\Chameleon\BaseClass;

class BaseClassTest extends BaseClass {
    public function pWarning($mesg)
    {
        return $this->printWarning($mesg);
    }
    public function pError($mesg)
    {
        return $this->printError($mesg);
    }
};


print <<<HTML
<!doctype html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
HTML;

$bct = new BaseClassTest();
$bct->pWarning('Warning! Something happened that may cause things to break.');
$bct->pError('Doh! Something Broke.');

print '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>';
