<?php
class Foo_Bootstrap extends Zend_Application_Bootstrap_BootstrapAbstract
{
    public $bootstrapped = false;

    public function run()
    {
    }

    protected function _bootstrap($resource = null)
    {
        $this->bootstrapped = true;
        $this->getApplication()->foo = true;
    }
}
