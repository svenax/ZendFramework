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
 * @package    Zend_Feed_Writer
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
 
/**
 * @see Zend_Feed_Writer_Extension_RendererAbstract
 */
require_once 'Zend/Feed/Writer/Extension/RendererAbstract.php';
 
/**
 * @category   Zend
 * @package    Zend_Feed_Writer
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Feed_Writer_Extension_ITunes_Renderer_Entry
extends Zend_Feed_Writer_Extension_RendererAbstract
{

    public function render()
    {
        $this->_appendNamespaces();
        $this->_setAuthors($this->_dom, $this->_base);
        $this->_setBlock($this->_dom, $this->_base);
        $this->_setDuration($this->_dom, $this->_base);
        $this->_setExplicit($this->_dom, $this->_base);
        $this->_setKeywords($this->_dom, $this->_base);
        $this->_setSubtitle($this->_dom, $this->_base);
        $this->_setSummary($this->_dom, $this->_base);
    }
    
    protected function _appendNamespaces()
    {
        $this->getRootElement()->setAttribute('xmlns:itunes',
            'http://www.itunes.com/dtds/podcast-1.0.dtd');  
    }

    protected function _setAuthors(DOMDocument $dom, DOMElement $root)
    {
        $authors = $this->getDataContainer()->getItunesAuthors();
        if (!$authors || empty($authors)) {
            return;
        }
        foreach ($authors as $author) {
            $el = $dom->createElement('itunes:author');
            $el->nodeValue = Zend_Feed_Writer::xmlentities(
                $author, $this->getEncoding()
            );
            $root->appendChild($el);
        }
    }
    
    protected function _setBlock(DOMDocument $dom, DOMElement $root)
    {
        $block = $this->getDataContainer()->getItunesBlock();
        if (is_null($block)) {
            return;
        }
        $el = $dom->createElement('itunes:block');
        $el->nodeValue = $block;
        $root->appendChild($el);
    }
    
    protected function _setDuration(DOMDocument $dom, DOMElement $root)
    {
        $duration = $this->getDataContainer()->getItunesDuration();
        if (!$duration) {
            return;
        }
        $el = $dom->createElement('itunes:duration');
        $el->nodeValue = $duration;
        $root->appendChild($el);
    }
    
    protected function _setExplicit(DOMDocument $dom, DOMElement $root)
    {
        $explicit = $this->getDataContainer()->getItunesExplicit();
        if (is_null($explicit)) {
            return;
        }
        $el = $dom->createElement('itunes:explicit');
        $el->nodeValue = $explicit;
        $root->appendChild($el);
    }
    
    protected function _setKeywords(DOMDocument $dom, DOMElement $root)
    {
        $keywords = $this->getDataContainer()->getItunesKeywords();
        if (!$keywords || empty($keywords)) {
            return;
        }
        $el = $dom->createElement('itunes:keywords');
        $el->nodeValue = Zend_Feed_Writer::xmlentities(
            implode(',', $keywords), $this->getEncoding()
        );
        $root->appendChild($el);
    }
    
    protected function _setSubtitle(DOMDocument $dom, DOMElement $root)
    {
        $subtitle = $this->getDataContainer()->getItunesSubtitle();
        if (!$subtitle) {
            return;
        }
        $el = $dom->createElement('itunes:subtitle');
        $el->nodeValue = Zend_Feed_Writer::xmlentities(
            $subtitle, $this->getEncoding()
        );
        $root->appendChild($el);
    }
    
    protected function _setSummary(DOMDocument $dom, DOMElement $root)
    {
        $summary = $this->getDataContainer()->getItunesSummary();
        if (!$summary) {
            return;
        }
        $el = $dom->createElement('itunes:summary');
        $el->nodeValue = Zend_Feed_Writer::xmlentities(
            $summary, $this->getEncoding()
        );
        $root->appendChild($el);
    }

}
