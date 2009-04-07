<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Zend/Http/Client.php';
require_once 'Zend/Http/Client/Adapter/Test.php';
require_once 'Zend/Service/Amazon/Ec2/Elasticip.php';

/**
 * Zend_Service_Amazon_Ec2_Elasticip test case.
 */
class Zend_Service_Amazon_Ec2_ElasticipTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Zend_Service_Amazon_Ec2_Elasticip
     */
    private $Zend_Service_Amazon_Ec2_Elasticip;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->Zend_Service_Amazon_Ec2_Elasticip = new Zend_Service_Amazon_Ec2_Elasticip('access_key', 'secret_access_key');

        $adapter = new Zend_Http_Client_Adapter_Test();
        $client = new Zend_Http_Client(null, array(
            'adapter' => $adapter
        ));
        $this->adapter = $adapter;
        Zend_Service_Amazon_Ec2_Elasticip::setHttpClient($client);

    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        unset($this->adapter);

        $this->Zend_Service_Amazon_Ec2_Elasticip = null;

        parent::tearDown();
    }

    public function testAllocateNewElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<AllocateAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2008-12-01/\">\r\n"
                    . "  <publicIp>67.202.55.255</publicIp>\r\n"
                    . "</AllocateAddressResponse>";
        $this->adapter->setResponse($rawHttpResponse);

        $ipAddress = $this->Zend_Service_Amazon_Ec2_Elasticip->allocate();
        $this->assertEquals('67.202.55.255', $ipAddress);
    }

    public function testAssociateElasticIpWithInstanceReturnsTrue()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<AssociateAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2008-12-01/\">\r\n"
                    . "  <return>true</return>\r\n"
                    . "</AssociateAddressResponse>";
        $this->adapter->setResponse($rawHttpResponse);

        $return = $this->Zend_Service_Amazon_Ec2_Elasticip->associate('67.202.55.255', 'i-ag8ga0a');

        $this->assertTrue($return);

    }

    /**
     * Tests Zend_Service_Amazon_Ec2_Elasticip->describe()
     */
    public function testDescribeSingleElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<DescribeAddressesResponse xmlns=\"http://ec2.amazonaws.com/doc/2008-12-01/\">\r\n"
                    . "  <addressSet>\r\n"
                    . "    <item>\r\n"
                    . "      <publicIp>67.202.55.255</publicIp>\r\n"
                    . "      <instanceId>i-ag8ga0a</instanceId>\r\n"
                    . "    </item>\r\n"
                    . "  </addressSet>\r\n"
                    . "</DescribeAddressesResponse>";
        $this->adapter->setResponse($rawHttpResponse);

        $response = $this->Zend_Service_Amazon_Ec2_Elasticip->describe('67.202.55.255');

        $arrIp = array(
            'publicIp'      => '67.202.55.255',
            'instanceId'    => 'i-ag8ga0a'
        );

        $this->assertSame($arrIp, $response[0]);
    }

    public function testDescribeMultipleElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<DescribeAddressesResponse xmlns=\"http://ec2.amazonaws.com/doc/2008-12-01/\">\r\n"
                    . "  <addressSet>\r\n"
                    . "    <item>\r\n"
                    . "      <publicIp>67.202.55.255</publicIp>\r\n"
                    . "      <instanceId>i-ag8ga0a</instanceId>\r\n"
                    . "    </item>\r\n"
                    . "    <item>\r\n"
                    . "      <publicIp>67.202.55.200</publicIp>\r\n"
                    . "      <instanceId>i-aauoi9g</instanceId>\r\n"
                    . "    </item>\r\n"
                    . "  </addressSet>\r\n"
                    . "</DescribeAddressesResponse>";
        $this->adapter->setResponse($rawHttpResponse);

        $response = $this->Zend_Service_Amazon_Ec2_Elasticip->describe(array('67.202.55.255', '67.202.55.200'));

        $arrIps = array(
            array(
                'publicIp'      => '67.202.55.255',
                'instanceId'    => 'i-ag8ga0a'
            ),
            array(
                'publicIp'      => '67.202.55.200',
                'instanceId'    => 'i-aauoi9g'
            )
        );

        foreach($response as $k => $r) {
            $this->assertSame($arrIps[$k], $r);
        }
    }

    /**
     * Tests Zend_Service_Amazon_Ec2_Elasticip->disassocate()
     */
    public function testDisassocateElasticIpFromInstance()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<DisassociateAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2008-12-01/\">\r\n"
                    . "  <return>true</return>\r\n"
                    . "</DisassociateAddressResponse>";
        $this->adapter->setResponse($rawHttpResponse);

        $return = $this->Zend_Service_Amazon_Ec2_Elasticip->disassocate('67.202.55.255');

        $this->assertTrue($return);

    }

    /**
     * Tests Zend_Service_Amazon_Ec2_Elasticip->release()
     */
    public function testReleaseElasticIp()
    {
        $rawHttpResponse = "HTTP/1.1 200 OK\r\n"
                    . "Date: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Server: hi\r\n"
                    . "Last-modified: Fri, 24 Oct 2008 17:24:52 GMT\r\n"
                    . "Status: 200 OK\r\n"
                    . "Content-type: application/xml; charset=utf-8\r\n"
                    . "Expires: Tue, 31 Mar 1981 05:00:00 GMT\r\n"
                    . "Connection: close\r\n"
                    . "\r\n"
                    . "<ReleaseAddressResponse xmlns=\"http://ec2.amazonaws.com/doc/2008-12-01/\">\r\n"
                    . "  <return>true</return>\r\n"
                    . "</ReleaseAddressResponse>";
        $this->adapter->setResponse($rawHttpResponse);

        $return = $this->Zend_Service_Amazon_Ec2_Elasticip->release('67.202.55.255');

        $this->assertTrue($return);

    }

}

