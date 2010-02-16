<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Ly',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }

 }