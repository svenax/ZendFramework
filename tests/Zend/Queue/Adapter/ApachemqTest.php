<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Queue
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: AllTests.php 13626 2009-01-14 18:24:57Z matthew $
 */

/*
 * The adapter test class provides a universal test class for all of the
 * abstract methods.
 *
 * All methods marked not supported are explictly checked for for throwing
 * an exception.
 */

/** PHPUnit Test Case */
require_once 'PHPUnit/Framework/TestCase.php';

/** TestHelp.php */
require_once dirname(__FILE__) . '/../../../TestHelper.php';

class Zend_Queue_Adapter_ApachemqTest extends Zend_Queue_Adapter_AdapterTest
{
    /**
     * getAdapterName() is an method to help make AdapterTest work with any
     * new adapters
     *
     * You must overload this method
     *
     * @return string
     */
    public function getAdapterName()
    {
        return 'Apachemq';
    }

    public function getTestConfig()
    {
        $driverOptions = array();
        if (defined('TESTS_ZEND_QUEUE_APACHEMQ_HOST')) {
            $driverOptions['host'] = TESTS_ZEND_QUEUE_APACHEMQ_HOST;
        }
        if (defined('TESTS_ZEND_QUEUE_APACHEMQ_PORT')) {
            $driverOptions['port'] = TESTS_ZEND_QUEUE_APACHEMQ_PORT;
        }
        return array('driverOptions' => $driverOptions);
    }

    /**
     * Stomped requires specific name types
     */
    public function createQueueName($name)
    {
        return '/temp-queue/' . $name;
    }

    public function testConst()
    {
        /**
         * @see Zend_Queue_Adapter_Stomp
         */
        require_once 'Zend/Queue/Adapter/Apachemq.php';
        $this->assertTrue(is_string(Zend_Queue_Adapter_Apachemq::DEFAULT_SCHEME));
        $this->assertTrue(is_string(Zend_Queue_Adapter_Apachemq::DEFAULT_HOST));
        $this->assertTrue(is_integer(Zend_Queue_Adapter_Apachemq::DEFAULT_PORT));
    }
}
