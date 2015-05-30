<?php
use Epoque\Chameleon\BaseClass;

class BaseClassTest extends BaseClass {
    public function pWarning()
    {
        return $this->printWarning();
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

$bct->pWarning();
