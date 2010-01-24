<?php

require_once dirname(__FILE__) . '/../../common.php';


system('clear');

print(Demos_Zend_Service_LiveDocx_Helper::wrapLine(
    PHP_EOL . 'Using the Free Public Server' .
    PHP_EOL . 
    PHP_EOL . 'This sample application illustrates how to use Zend_Service_LiveDocx_MailMerge with the free, public LiveDocx server.' .
    PHP_EOL .
    PHP_EOL)
);

$phpLiveDocx = new Zend_Service_LiveDocx_MailMerge();

$phpLiveDocx->setUsername(DEMOS_ZEND_SERVICE_LIVEDOCX_USERNAME)
            ->setPassword(DEMOS_ZEND_SERVICE_LIVEDOCX_PASSWORD);

$phpLiveDocx->getTemplateFormats(); // then call methods as usual

printf('Username : %s%sPassword : %s%s    WSDL : %s%s%s',
    $phpLiveDocx->getUsername(),
    PHP_EOL,
    $phpLiveDocx->getPassword(),
    PHP_EOL,
    $phpLiveDocx->getWsdl(),
    PHP_EOL,
    PHP_EOL
);

unset($phpLiveDocx);

// -----------------------------------------------------------------------------

// Alternatively, you can pass username and password in the constructor.

$phpLiveDocx = new Zend_Service_LiveDocx_MailMerge(
    array (
        'username' => DEMOS_ZEND_SERVICE_LIVEDOCX_USERNAME,
        'password' => DEMOS_ZEND_SERVICE_LIVEDOCX_PASSWORD,
    )
);

$phpLiveDocx->getTemplateFormats(); // then call methods as usual

printf('Username : %s%sPassword : %s%s    WSDL : %s%s%s',
    $phpLiveDocx->getUsername(),
    PHP_EOL,
    $phpLiveDocx->getPassword(),
    PHP_EOL,
    $phpLiveDocx->getWsdl(),
    PHP_EOL,
    PHP_EOL
);

unset($phpLiveDocx);