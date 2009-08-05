<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Zend/Feed/Reader.php';
require_once 'Zend/Cache.php';

class Zend_Feed_ReaderTest extends PHPUnit_Framework_TestCase
{

    protected $_feedSamplePath = null;

    public function setup()
    {
        $this->_feedSamplePath = dirname(__FILE__) . '/Reader/_files';
    }

    public function tearDown()
    {
        Zend_Feed_Reader::reset();
    }

    public function testDetectsFeedIsRss20()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/rss20.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_RSS_20, $type);
    }

    public function testDetectsFeedIsRss094()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/rss094.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_RSS_094, $type);
    }

    public function testDetectsFeedIsRss093()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/rss093.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_RSS_093, $type);
    }

    public function testDetectsFeedIsRss092()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/rss092.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_RSS_092, $type);
    }

    public function testDetectsFeedIsRss091()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/rss091.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_RSS_091, $type);
    }

    public function testDetectsFeedIsRss10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/rss10.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_RSS_10, $type);
    }

    public function testDetectsFeedIsRss090()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/rss090.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_RSS_090, $type);
    }

    public function testDetectsFeedIsAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/atom10.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_ATOM_10, $type);
    }

    public function testDetectsFeedIsAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/Reader/atom03.xml'));
        $type = Zend_Feed_Reader::detectType($feed);
        $this->assertEquals(Zend_Feed_Reader::TYPE_ATOM_03, $type);
    }

    public function testGetEncoding()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents(dirname(__FILE__) . '/Reader/Entry/_files/Atom/title/plain/atom10.xml')
        );

        $this->assertEquals('utf-8', $feed->getEncoding());
        $this->assertEquals('utf-8', $feed->current()->getEncoding());
    }

    public function testImportsFile()
    {
        try {
            $feed = Zend_Feed_Reader::importFile(
                dirname(__FILE__) . '/Reader/Entry/_files/Atom/title/plain/atom10.xml'
            );
        } catch(Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testImportsUri()
    {
        if (!defined('TESTS_ZEND_FEED_READER_ONLINE_ENABLED')
            || !constant('TESTS_ZEND_FEED_READER_ONLINE_ENABLED')
        ) {
            $this->markTestSkipped('testImportsUri() requires a network connection');
            return;
        }

        try {
            $feed = Zend_Feed_Reader::import('http://www.planet-php.net/rdf/');
        } catch(Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetsFeedLinksAsValueObject()
    {
        if (!defined('TESTS_ZEND_FEED_READER_ONLINE_ENABLED')
            || !constant('TESTS_ZEND_FEED_READER_ONLINE_ENABLED')
        ) {
            $this->markTestSkipped('testGetsFeedLinksAsValueObject() requires a network connection');
            return;
        }

        try {
            $links = Zend_Feed_Reader::findFeedLinks('http://www.planet-php.net');
        } catch(Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals('http://www.planet-php.org/rss/', $links->rss);
    }

    public function testAddsPrefixPath()
    {
        Zend_Feed_Reader::addPrefixPath('A_B_C', '/A/B/C');
        $prefixPaths = Zend_Feed_Reader::getPluginLoader()->getPaths();
        $this->assertEquals('/A/B/C/', $prefixPaths['A_B_C_'][0]);
    }

    public function testRegistersUserExtension()
    {
        try {
            Zend_Feed_Reader::addPrefixPath('My_FeedReader_Extension',dirname(__FILE__) . '/Reader/_files/My/Extension');
            Zend_Feed_Reader::registerExtension('JungleBooks');
        } catch(Exception $e) {
            $this->fail($e->getMessage());
        }
        $this->assertTrue(Zend_Feed_Reader::isRegistered('JungleBooks'));
    }

    /**  Test condition for ZF-7486 (Could Not Replicate)  **/
    public function testRepeatedFeedImportsWithCacheEnabledDirectOrIndirectDoNotCreateARedeclarationOfAbstractClassFatalError()
    {
        if (!defined('TESTS_ZEND_FEED_READER_ONLINE_ENABLED')
            || !constant('TESTS_ZEND_FEED_READER_ONLINE_ENABLED')
        ) {
            $this->markTestSkipped('testRepeatedFeedImportsDoNotCreateARedeclarationOfAbstractClassFatalError() requires a network connection');
            return;
        }
        $frontendOptions = array(
           'lifetime' => 7200,
           'automatic_serialization' => true
        );
        $backendOptions = array(
            'cache_dir' => $this->_getTempDirectory()
        );
        $cache = Zend_Cache::factory('Core','File',$frontendOptions,$backendOptions);
        Zend_Feed_Reader::setCache($cache);
        $feed = Zend_Feed_Reader::import('http://www.planet-php.net/rss/');
        $cache->save($feed, 'feed1');
        $feed2 = Zend_Feed_Reader::import('http://www.planet-php.net/rdf/');
        $cache->save($feed, 'feed2');
        $feed3 = Zend_Feed_Reader::import('http://www.planet-php.net/atom/');
        $cache->save($feed, 'feed3');
        $feed4 = Zend_Feed_Reader::import('http://www.phpdeveloper.org/feed');
        $cache->save($feed, 'feed4');
        $feedFromCache = $cache->load('feed4');
        $this->assertTrue($feedFromCache instanceof Zend_Feed_Reader_FeedAbstract);
    }

    protected function _getTempDirectory()
    {
        $tmpdir = array();
        foreach (array($_ENV, $_SERVER) as $tab) {
            foreach (array('TMPDIR', 'TEMP', 'TMP', 'windir', 'SystemRoot') as $key) {
                if (isset($tab[$key])) {
                    if (($key == 'windir') or ($key == 'SystemRoot')) {
                        $dir = realpath($tab[$key] . '\\temp');
                    } else {
                        $dir = realpath($tab[$key]);
                    }
                    if ($this->_isGoodTmpDir($dir)) {
                        return $dir;
                    }
                }
            }
        }
        if (function_exists('sys_get_temp_dir')) {
            $dir = sys_get_temp_dir();
            if ($this->_isGoodTmpDir($dir)) {
        	    return $dir;
            }
        }
        $tempFile = tempnam(md5(uniqid(rand(), TRUE)), '');
        if ($tempFile) {
            $dir = realpath(dirname($tempFile));
            unlink($tempFile);
            if ($this->_isGoodTmpDir($dir)) {
                return $dir;
            }
        }
        if ($this->_isGoodTmpDir('/tmp')) {
            return '/tmp';
        }
        if ($this->_isGoodTmpDir('\\temp')) {
            return '\\temp';
        }
    }

    protected function _isGoodTmpDir($dir)
    {
        if (is_readable($dir) && is_writable($dir)) {
            return true;
        }
    	return false;
    }

}
