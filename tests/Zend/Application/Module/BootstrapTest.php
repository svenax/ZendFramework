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
 * @package    Zend_Application
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Application_Module_BootstrapTest::main');
}

/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../../TestHelper.php';

/**
 * Zend_Loader_Autoloader
 */
require_once 'Zend/Loader/Autoloader.php';

/**
 * @category   Zend
 * @package    Zend_Application
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Application_Module_BootstrapTest extends PHPUnit_Framework_TestCase
{
    public static function main()
    {
        $suite  = new PHPUnit_Framework_TestSuite(__CLASS__);
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp()
    {
        // Store original autoloaders
        $this->loaders = spl_autoload_functions();
        if (!is_array($this->loaders)) {
            // spl_autoload_functions does not return empty array when no 
            // autoloaders registered...
            $this->loaders = array();
        }

        Zend_Loader_Autoloader::resetInstance();
        $this->autoloader = Zend_Loader_Autoloader::getInstance();

        $this->application = new Zend_Application('testing');
    }

    public function tearDown()
    {
        // Restore original autoloaders
        $loaders = spl_autoload_functions();
        foreach ($loaders as $loader) {
            spl_autoload_unregister($loader);
        }

        foreach ($this->loaders as $loader) {
            spl_autoload_register($loader);
        }
    }

    public function testConstructorShouldInitializeModuleResourceLoaderWithModulePrefix()
    {
        require_once dirname(__FILE__) . '/../_files/ZfModuleBootstrap.php';
        $bootstrap = new ZfModule_Bootstrap($this->application);
        $module = $bootstrap->getModuleName();
        $loader = $bootstrap->getResourceLoader();
        $this->assertEquals($module, $loader->getNamespace());
    }

    public function testConstructorShouldAcceptResourceLoaderInOptions()
    {
        $loader = new Zend_Loader_Autoloader_Resource(array(
            'namespace' => 'Foo',
            'basePath'  => dirname(__FILE__),
        ));
        $this->application->setOptions(array('resourceLoader' => $loader));

        require_once dirname(__FILE__) . '/../_files/ZfModuleBootstrap.php';
        $bootstrap = new ZfModule_Bootstrap($this->application);
        $this->assertSame($loader, $bootstrap->getResourceLoader(), var_export($bootstrap->getOptions(), 1));
    }

    public function testModuleNameShouldBeFirstSegmentOfClassName()
    {
        require_once dirname(__FILE__) . '/../_files/ZfModuleBootstrap.php';
        $bootstrap = new ZfModule_Bootstrap($this->application);
        $this->assertEquals('ZfModule', $bootstrap->getModuleName());
    }

    public function testShouldPullModuleNamespacedOptionsWhenPresent()
    {
        $options = array(
            'foo' => 'bar',
            'ZfModule' => array(
                'foo' => 'baz',
            )
        );
        $this->application->setOptions($options);
        require_once dirname(__FILE__) . '/../_files/ZfModuleBootstrap.php';
        $bootstrap = new ZfModule_Bootstrap($this->application);
        $this->assertEquals('baz', $bootstrap->foo);
    }
}

if (PHPUnit_MAIN_METHOD == 'Zend_Application_Module_BootstrapTest::main') {
    Zend_Application_Module_BootstrapTest::main();
}
