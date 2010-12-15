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
 * @package    Zend_Controller
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id:$
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    require_once dirname(__FILE__) . '/../../../../TestHelper.php';
    define('PHPUnit_MAIN_METHOD', 'Zend_Controller_Action_Helper_NamespaceTest::main');
}

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Framework/TestSuite.php';

/**
 * Test class for Zend_Controller_Action_Helper_Abstract.
 *
 * @category   Zend
 * @package    Zend_Controller
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Controller
 * @group      Zend_Controller_Action
 * @group      Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_NamespaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Runs the test methods of this class.
     *
     * @return void
     */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';
        $suite  = new PHPUnit_Framework_TestSuite('Zend_Controller_Action_Helper_NamespaceTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }
    
    /**
     * @group ZF-10158
     */
    public function testGetNameWithNamespace()
    {
        require_once dirname(__FILE__) . '/../../_files/Helpers/NamespacedHelper.php';
        $helper = new MyApp\Controller\Action\Helper\NamespacedHelper;
        $this->assertEquals('NamespacedHelper', $helper->getName());
    }
}

// Call Zend_Controller_Action_Helper_NamespaceTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'Zend_Controller_Action_Helper_NamespaceTest::main') {
    Zend_Controller_Action_Helper_NamespaceTest::main();
}