<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Zend/Feed/Reader.php';

class Zend_Feed_Reader_Entry_AtomTest extends PHPUnit_Framework_TestCase
{

    protected $_feedSamplePath = null;

    public function setup()
    {
        $this->_feedSamplePath = dirname(__FILE__) . '/_files/Atom';
    }

    /**
     * Get Id (Unencoded Text)
     */
    public function testGetsIdFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/id/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('1', $entry->getId());
    }

    public function testGetsIdFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/id/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('1', $entry->getId());
    }

    /**
     * Get creation date (Unencoded Text)
     */
    public function testGetsDateCreatedFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/datecreated/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Saturday 07 March 2009 08 03 50 +0000',
        $entry->getDateCreated()->toString('EEEE dd MMMM YYYY HH mm ss ZZZ'));
    }

    public function testGetsDateCreatedFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/datecreated/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Saturday 07 March 2009 08 03 50 +0000',
        $entry->getDateCreated()->toString('EEEE dd MMMM YYYY HH mm ss ZZZ'));
    }

    /**
     * Get modification date (Unencoded Text)
     */
    public function testGetsDateModifiedFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/datemodified/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Saturday 07 March 2009 08 03 50 +0000',
        $entry->getDateModified()->toString('EEEE dd MMMM YYYY HH mm ss ZZZ'));
    }

    public function testGetsDateModifiedFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/datemodified/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Saturday 07 March 2009 08 03 50 +0000',
        $entry->getDateModified()->toString('EEEE dd MMMM YYYY HH mm ss ZZZ'));
    }

    /**
     * Get Title (Unencoded Text)
     */
    public function testGetsTitleFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/title/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Entry Title', $entry->getTitle());
    }

    public function testGetsTitleFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/title/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Entry Title', $entry->getTitle());
    }

    /**
     * Get Authors (Unencoded Text)
     */
    public function testGetsAuthorsFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/author/plain/atom03.xml')
        );

        $authors = array(
            0 => 'joe@example.com (Joe Bloggs)',
            1 => 'Joe Bloggs',
            3 => 'joe@example.com',
            4 => 'http://www.example.com',
            6 => 'jane@example.com (Jane Bloggs)'
        );

        $entry = $feed->current();
        $this->assertEquals($authors, $entry->getAuthors());
    }

    public function testGetsAuthorsFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/author/plain/atom10.xml')
        );

        $authors = array(
            0 => 'joe@example.com (Joe Bloggs)',
            1 => 'Joe Bloggs',
            3 => 'joe@example.com',
            4 => 'http://www.example.com',
            6 => 'jane@example.com (Jane Bloggs)'
        );

        $entry = $feed->current();
        $this->assertEquals($authors, $entry->getAuthors());
    }

    /**
     * Get Author (Unencoded Text)
     */
    public function testGetsAuthorFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/author/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('joe@example.com (Joe Bloggs)', $entry->getAuthor());
    }

    public function testGetsAuthorFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/author/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('joe@example.com (Joe Bloggs)', $entry->getAuthor());
    }

    /**
     * Get Description (Unencoded Text)
     */
    public function testGetsDescriptionFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/description/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Entry Description', $entry->getDescription());
    }

    public function testGetsDescriptionFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/description/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Entry Description', $entry->getDescription());
    }

    /**
     * Get enclosure
     */
    public function testGetsEnclosureFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/enclosure/plain/atom03.xml')
        );
        $entry = $feed->current();

        $expected = new stdClass();
        $expected->url    = 'http://www.example.org/myaudiofile.mp3';
        $expected->length = '1234';
        $expected->type   = 'audio/mpeg';

        $this->assertEquals($expected, $entry->getEnclosure());
    }

    public function testGetsEnclosureFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath.'/enclosure/plain/atom10.xml')
        );
        $entry = $feed->current();

        $expected = new stdClass();
        $expected->url    = 'http://www.example.org/myaudiofile.mp3';
        $expected->length = '1234';
        $expected->type   = 'audio/mpeg';

        $this->assertEquals($expected, $entry->getEnclosure());
    }

    /**
     * Get Content (Unencoded Text)
     */
    public function testGetsContentFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/content/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Entry Content', $entry->getContent());
    }

    public function testGetsContentFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/content/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('Entry Content', $entry->getContent());
    }

    /**
     * Get Link (Unencoded Text)
     */
    public function testGetsLinkFromAtom03()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/link/plain/atom03.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('http://www.example.com/entry', $entry->getLink());
    }

    public function testGetsLinkFromAtom10()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath . '/link/plain/atom10.xml')
        );
        $entry = $feed->current();
        $this->assertEquals('http://www.example.com/entry', $entry->getLink());
    }
}
