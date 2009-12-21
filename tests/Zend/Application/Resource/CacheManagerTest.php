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
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Zend_Application_Resource_CacheManagerTest::main');
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
 * Zend_Controller_Front
 */
require_once 'Zend/Controller/Front.php';

/**
 * Zend_Application_Resource_CacheManager
 */
require_once 'Zend/Application/Resource/CacheManager.php';

/**
 * @category   Zend
 * @package    Zend_Application
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Application
 */
class Zend_Application_Resource_CacheManagerTest extends PHPUnit_Framework_TestCase
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

        require_once dirname(__FILE__) . '/../_files/ZfAppBootstrap.php';
        $this->bootstrap = new ZfAppBootstrap($this->application);
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

        Zend_Controller_Front::getInstance()->resetInstance();

        // Reset autoloader instance so it doesn't affect other tests
        Zend_Loader_Autoloader::resetInstance();
    }

    public function testInitializationCreatesCacheManagerInstance()
    {

        $resource = new Zend_Application_Resource_CacheManager(array());
        $resource->init();
        $this->assertTrue($resource->getCacheManager() instanceof Zend_Cache_Manager);
    }

    public function testInitializationPushesCacheManagerToBootstrapWhenPresent()
    {
        $resource = new Zend_Application_Resource_CacheManager(array());
        $resource->setBootstrap($this->bootstrap);
        $resource->init();
        $this->assertSame($resource->getCacheManager(), $this->bootstrap->cacheManager);
    }

    public function testShouldReturnCacheManagerWhenComplete()
    {
        $resource = new Zend_Application_Resource_CacheManager(array());
        $manager = $resource->init();
        $this->assertTrue($manager instanceof Zend_Cache_Manager);
    }

    public function testShouldMergeConfigsIfOptionsPassedForDefaultCacheTemplate()
    {
        $options = array(
            'page' => array(
                'backend' => array(
                    'options' => array(
                        'cache_dir' => '/foo'
                    )
                )
            )
        );
        $resource = new Zend_Application_Resource_CacheManager($options);
        $manager = $resource->init();
        $cacheTemplate = $manager->getCacheTemplate('page');
        $this->assertEquals('/foo', $cacheTemplate['backend']['options']['cache_dir']);

    }
    public function testShouldCreateNewCacheTemplateIfConfigNotMatchesADefaultTemplate()
    {
        $options = array(
            'foo' => array(
                'backend' => array(
                    'options' => array(
                        'cache_dir' => '/foo'
                    )
                )
            )
        );
        $resource = new Zend_Application_Resource_CacheManager($options);
        $manager = $resource->init();
        $cacheTemplate = $manager->getCacheTemplate('foo');
        $this->assertSame($options['foo'], $cacheTemplate);
    }

}

if (PHPUnit_MAIN_METHOD == 'Zend_Application_Resource_CacheManagerTest::main') {
    Zend_Application_Resource_CacheManagerTest::main();
}
