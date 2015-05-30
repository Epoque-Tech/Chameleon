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


$bct = new BaseClassTest();
$bct->pWarning('Warning! Something happened that may cause things to break.');
$bct->pError('Doh! Something Broke.');

