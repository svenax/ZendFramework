#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../../common.php';


system('clear');

print(Demos_Zend_Service_LiveDocx_Helper::wrapLine(
    PHP_EOL . 'Deleting All Remotely Stored Templates' .
    PHP_EOL .
    PHP_EOL)
);

$phpLiveDocx = new Zend_Service_LiveDocx_MailMerge();

$phpLiveDocx->setUsername(Demos_Zend_Service_LiveDocx_Helper::USERNAME);
$phpLiveDocx->setPassword(Demos_Zend_Service_LiveDocx_Helper::PASSWORD);

$counter = 1;
foreach ($phpLiveDocx->listTemplates() as $result) {
    printf('%d) %s', $counter, $result['filename']);
    $phpLiveDocx->deleteTemplate($result['filename']);
    print(' - DELETED.' . PHP_EOL);
    $counter++;
}

print(PHP_EOL);

unset($phpLiveDocx);