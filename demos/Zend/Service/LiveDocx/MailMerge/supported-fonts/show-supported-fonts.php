#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../../common.php';


$phpLiveDocx = new Zend_Service_LiveDocx_MailMerge();

$phpLiveDocx->setUsername(Demos_Zend_Service_LiveDocx_Helper::USERNAME);
$phpLiveDocx->setPassword(Demos_Zend_Service_LiveDocx_Helper::PASSWORD);

system('clear');

print(Demos_Zend_Service_LiveDocx_Helper::wrapLine(
    PHP_EOL . 'Supported Fonts' .
    PHP_EOL . 
    PHP_EOL . 'The following fonts are installed on the backend server and may be used in templates. Fonts used in templates, which are NOT listed below, will be substituted. If you would like to use a font, which is not installed on the backend server, please contact your LiveDocx provider.' .
    PHP_EOL . 
    PHP_EOL . Demos_Zend_Service_LiveDocx_Helper::arrayDecorator($phpLiveDocx->getFontNames()) . 
    PHP_EOL . 
    PHP_EOL)
);

unset($phpLiveDocx);