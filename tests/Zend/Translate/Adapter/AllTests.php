<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Translate_Adapter_AllTests::main');
}

require_once dirname(__FILE__) . '/../../../TestHelper.php';

require_once 'Zend/Translate/Adapter/ArrayTest.php';
require_once 'Zend/Translate/Adapter/CsvTest.php';
require_once 'Zend/Translate/Adapter/GettextTest.php';
require_once 'Zend/Translate/Adapter/IniTest.php';
require_once 'Zend/Translate/Adapter/QtTest.php';
require_once 'Zend/Translate/Adapter/TbxTest.php';
require_once 'Zend/Translate/Adapter/TmxTest.php';
require_once 'Zend/Translate/Adapter/XliffTest.php';
require_once 'Zend/Translate/Adapter/XmlTmTest.php';

class Zend_Translate_Adapter_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Zend Framework - Zend_Translate');

        $suite->addTestSuite('Zend_Translate_Adapter_ArrayTest');
        $suite->addTestSuite('Zend_Translate_Adapter_CsvTest');
        $suite->addTestSuite('Zend_Translate_Adapter_GettextTest');
        $suite->addTestSuite('Zend_Translate_Adapter_IniTest');
        $suite->addTestSuite('Zend_Translate_Adapter_QtTest');
        $suite->addTestSuite('Zend_Translate_Adapter_TbxTest');
        $suite->addTestSuite('Zend_Translate_Adapter_TmxTest');
        $suite->addTestSuite('Zend_Translate_Adapter_XliffTest');
        $suite->addTestSuite('Zend_Translate_Adapter_XmlTmTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Zend_Translate_Adapter_AllTests::main') {
    Zend_Translate_Adapter_AllTests::main();
}
