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
 * @package    Zend_Translate
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * PHPUnit test case
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Zend_Translate
 */
require_once 'Zend/Translate.php';

/**
 * @category   Zend
 * @package    Zend_Translate
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_TranslateTest extends PHPUnit_Framework_TestCase
{
    /**
     * Runs the test methods of this class.
     *
     * @return void
     */
    public static function main()
    {
        $suite  = new PHPUnit_Framework_TestSuite("Zend_TranslateTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function testCreate()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('1' => '1'));
        $this->assertTrue($lang instanceof Zend_Translate);
    }

    public function testLocaleInitialization()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'message1'), 'en');
        $this->assertEquals('en', $lang->getLocale());
    }

    public function testDefaultLocale()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'message1'));
        $defaultLocale = new Zend_Locale();
        $this->assertEquals($defaultLocale->toString(), $lang->getLocale());
    }

    public function testGetAdapter()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY , array('1' => '1'), 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Array);

        $lang = new Zend_Translate(Zend_Translate::AN_GETTEXT , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en.mo', 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Gettext);

        $lang = new Zend_Translate(Zend_Translate::AN_TMX , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en.tmx', 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Tmx);

        $lang = new Zend_Translate(Zend_Translate::AN_CSV , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en.csv', 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Csv);

        $lang = new Zend_Translate(Zend_Translate::AN_XLIFF , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en.xliff', 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Xliff);

        $lang = new Zend_Translate('Qt' , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en2.ts', 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Qt);

        $lang = new Zend_Translate('XmlTm' , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en.xmltm', 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_XmlTm);

        $lang = new Zend_Translate('Tbx' , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en.tbx', 'en');
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Tbx);
    }

    public function testSetAdapter()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_GETTEXT , dirname(__FILE__) . '/Translate/Adapter/_files/translation_en.mo', 'en');
        $lang->setAdapter(Zend_Translate::AN_ARRAY, array('de' => 'de'));
        $this->assertTrue($lang->getAdapter() instanceof Zend_Translate_Adapter_Array);

        try {
            $lang->xxxFunction();
            $this->fail("exception expected");
        } catch (Zend_Translate_Exception $e) {
            // success
        }
    }

    public function testAddTranslation()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1'), 'en');

        $this->assertEquals('msg2', $lang->_('msg2'));

        $lang->addTranslation(array('msg2' => 'Message 2'), 'en');
        $this->assertEquals('Message 2', $lang->_('msg2'));
        $this->assertEquals('msg3',      $lang->_('msg3'));

        $lang->addTranslation(array('msg3' => 'Message 3'), 'en', array('clear' => true));
        $this->assertEquals('msg2',      $lang->_('msg2'));
        $this->assertEquals('Message 3', $lang->_('msg3'));
    }

    public function testGetLocale()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1'), 'en');
        $this->assertEquals('en', $lang->getLocale());
    }

    public function testSetLocale()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1'), 'en');
        $lang->addTranslation(array('msg1' => 'Message 1 (ru)'), 'ru');
        $this->assertEquals('ru', $lang->getLocale());

        $lang->setLocale('en');
        $this->assertEquals('en', $lang->getLocale());

        $lang->setLocale('ru');
        $this->assertEquals('ru', $lang->getLocale());

        $lang->setLocale('ru_RU');
        $this->assertEquals('ru', $lang->getLocale());
    }

    public function testSetLanguage()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1'), 'en');
        $lang->addTranslation(array('msg1' => 'Message 1 (ru)'), 'ru');
        $this->assertEquals('ru', $lang->getLocale());

        $lang->setLocale('en');
        $this->assertEquals('en', $lang->getLocale());
    }

    public function testGetLanguageList()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1'), 'en');
        $lang->addTranslation(array('msg1' => 'Message 1 (ru)'), 'ru');
        $this->assertEquals(2, count($lang->getList()));
        $this->assertTrue(in_array('en', $lang->getList()));
        $this->assertTrue(in_array('ru', $lang->getList()));
    }

    public function testIsAvailable()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1'), 'en');
        $lang->addTranslation(array('msg1' => 'Message 1 (ru)'), 'ru');
        $this->assertTrue( $lang->isAvailable('en'));
        $this->assertTrue( $lang->isAvailable('ru'));
        $this->assertFalse($lang->isAvailable('fr'));
    }

    public function testTranslate()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1 (en)'), 'en');
        $lang->addTranslation(array('msg1' => 'Message 1 (ru)'), 'ru');
        $this->assertEquals('Message 1 (en)', $lang->_('msg1', 'en'        ));
        $this->assertEquals('Message 1 (ru)', $lang->_('msg1'              ));
        $this->assertEquals('msg2',           $lang->_('msg2', 'en'        ));
        $this->assertEquals('msg2',           $lang->_('msg2'              ));
        $this->assertEquals('Message 1 (en)', $lang->translate('msg1', 'en'));
        $this->assertEquals('Message 1 (ru)', $lang->translate('msg1'      ));
        $this->assertEquals('msg2',           $lang->translate('msg2', 'en'));
        $this->assertEquals('msg2',           $lang->translate('msg2'      ));
    }

    public function testIsTranslated()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'Message 1 (en)'), 'en_US');
        $this->assertTrue( $lang->isTranslated('msg1'             ));
        $this->assertFalse($lang->isTranslated('msg2'             ));
        $this->assertFalse($lang->isTranslated('msg1', false, 'en'));
        $this->assertFalse($lang->isTranslated('msg1', true,  'en'));
        $this->assertFalse($lang->isTranslated('msg1', false, 'ru'));
    }

    public function testWithOption()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_CSV , dirname(__FILE__) . '/Translate/Adapter/_files/translation_otherdelimiter.csv', 'en', array('delimiter' => ','));
        $this->assertEquals('Message 1 (en)', $lang->translate('Message 1'));
        $this->assertEquals('Message 4 (en)', $lang->translate('Message 4,'));
        $this->assertEquals('Message 5, (en)', $lang->translate('Message 5'));
    }

    public function testDirectorySearch()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_CSV, dirname(__FILE__) . '/Translate/Adapter/_files/testcsv', 'de_AT', array('scan' => Zend_Translate::LOCALE_DIRECTORY));
        $this->assertEquals(array('de_AT' => 'de_AT', 'en_GB' => 'en_GB'), $lang->getList());
        $this->assertEquals('Nachricht 8', $lang->translate('Message 8'));
    }

    public function testFileSearch()
    {
        $lang = new Zend_Translate(Zend_Translate::AN_CSV, dirname(__FILE__) . '/Translate/Adapter/_files/testcsv', 'de_DE', array('scan' => Zend_Translate::LOCALE_FILENAME));
        $this->assertEquals(array('de_DE' => 'de_DE', 'en_US' => 'en_US'), $lang->getList());
        $this->assertEquals('Nachricht 8', $lang->translate('Message 8'));
    }

    public function testTestingCacheHandling()
    {
        require_once 'Zend/Cache.php';
        $cache = Zend_Cache::factory('Core', 'File',
            array('lifetime' => 120, 'automatic_serialization' => true),
            array('cache_dir' => dirname(__FILE__) . '/_files/'));
        Zend_Translate::setCache($cache);

        $cache = Zend_Translate::getCache();
        $this->assertTrue($cache instanceof Zend_Cache_Core);
        $this->assertTrue(Zend_Translate::hasCache());
        Zend_Translate::clearCache();
        $this->assertTrue(Zend_Translate::hasCache());
        Zend_Translate::removeCache();
        $this->assertFalse(Zend_Translate::hasCache());
    }

    public function testExceptionWhenNoAdapterClassWasSet()
    {
        try {
            $lang = new Zend_Translate('Zend_Locale', dirname(__FILE__) . '/Translate/_files/test2', null, array('scan' => Zend_Translate::LOCALE_FILENAME));
            $this->fail('Exception due to false adapter class expected');
        } catch (Zend_Translate_Exception $e) {
            $this->assertContains('does not extend Zend_Translate_Adapter', $e->getMessage());
        }
    }

    public function testZF3679()
    {
        require_once 'Zend/Locale.php';
        $locale = new Zend_Locale('de_AT');
        require_once 'Zend/Registry.php';
        Zend_Registry::set('Zend_Locale', $locale);

        $lang = new Zend_Translate(Zend_Translate::AN_ARRAY, array('msg1' => 'message1'), 'de_AT');
        $this->assertEquals('de_AT', $lang->getLocale());
        Zend_Registry::_unsetInstance();
    }
}

// Call Zend_TranslateTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "Zend_TranslateTest::main") {
    Zend_TranslateTest::main();
}
