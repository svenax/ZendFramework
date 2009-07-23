<?php

require_once dirname(__FILE__) . '/CommonHttpTests.php';

require_once 'Zend/Http/Client/Adapter/Socket.php';

/**
 * This Testsuite includes all Zend_Http_Client that require a working web
 * server to perform. It was designed to be extendable, so that several
 * test suites could be run against several servers, with different client
 * adapters and configurations.
 *
 * Note that $this->baseuri must point to a directory on a web server
 * containing all the files under the _files directory. You should symlink
 * or copy these files and set 'baseuri' properly.
 *
 * You can also set the proper constant in your test configuration file to
 * point to the right place.
 *
 * @category   Zend
 * @package    Zend_Http_Client
 * @subpackage UnitTests
 * @version    $Id$
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Http_Client_SocketTest extends Zend_Http_Client_CommonHttpTests
{
    /**
     * Configuration array
     *
     * @var array
     */
    protected $config = array(
        'adapter' => 'Zend_Http_Client_Adapter_Socket'
    );

    /**
     * Stream context related tests
     */

    public function testGetNewStreamContext()
    {
        $adapter = new $this->config['adapter'];
        $context = $adapter->getStreamContext();

        $this->assertEquals('stream-context', get_resource_type($context));
    }

    public function testSetNewStreamContextResource()
    {
        $adapter = new $this->config['adapter'];
        $context = stream_context_create();

        $adapter->setStreamContext($context);

        $this->assertEquals($context, $adapter->getStreamContext());
    }

    public function testSetNewStreamContextOptions()
    {
        $adapter = new $this->config['adapter'];
        $options = array(
            'socket' => array(
                'bindto' => '1.2.3.4:0'
            ),
            'ssl' => array(
                'verify_peer' => true,
                'allow_self_signed' => false
            )
        );

        $adapter->setStreamContext($options);

        $this->assertEquals($options, stream_context_get_options($adapter->getStreamContext()));
    }

    /**
     * Test that setting invalid options / context causes an exception
     *
     * @dataProvider      invalidContextProvider
     * @expectedException Zend_Http_Client_Adapter_Exception
     */
    public function testSetInvalidContextOptions($invalid)
    {
        $adapter = new $this->config['adapter'];
        $adapter->setStreamContext($invalid);
    }

    public function testSetHttpsStreamContextParam()
    {
        if ($this->client->getUri()->getScheme() != 'https') {
            $this->markTestSkipped();
        }

        $adapter = new $this->config['adapter'];
        $adapter->setStreamContext(array(
            'ssl' => array(
                'capture_peer_cert' => true,
                'capture_peer_chain' => true
            )
        ));

        $this->client->setAdapter($adapter);
        $this->client->setUri($this->baseuri . '/testSimpleRequests.php');
        $this->client->request();

        $opts = stream_context_get_options($adapter->getStreamContext());
        $this->assertTrue(isset($opts['ssl']['peer_certificate']));
    }

    /**
     * Data Providers
     */

    /**
     * Provide invalid context resources / options
     *
     * @return array
     */
    static public function invalidContextProvider()
    {
        return array(
            array(new stdClass()),
            array(fopen('data://text/plain,', 'r')),
            array(false),
            array(null)
        );
    }
}
