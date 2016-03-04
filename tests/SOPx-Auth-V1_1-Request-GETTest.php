<?php

use \GuzzleHttp\Psr7\Uri;
use \SOPx\Auth\V1_1\Request\GET;

class SOPx_Auth_V1_1_Request_GETTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->uri = new Uri('http://www.researchpanelasia.com');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testCreateRequest_fails_on_missing_time()
    {
        GET::createRequest(
            $this->uri,
            array( 'aaa' => 'aaa' ),
            'hogehoge'
        );
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testCreateRequest_fails_on_missing_app_secret()
    {
        GET::createRequest(
            $this->uri,
            array( 'aaa' => 'aaa', 'time' => '1234', ),
            ''
        );
    }

    public function testCreateRequest()
    {
        $req = GET::createRequest(
            $this->uri,
            array(
                'time' => '1234',
                'bbb' => 'bbb',
                'aaa' => 'aaa',
            ),
            'hogehoge'
        );

        $this->assertEquals('GuzzleHttp\Psr7\Request', get_class($req));
        $this->assertEquals('GET', $req->getMethod());

        $query = array();
        parse_str($req->getUri()->getQuery(), $query);

        $this->assertEquals(array(
            'aaa' => 'aaa',
            'bbb' => 'bbb',
            'time' => '1234',
            'sig' => '40499603a4a5e8d4139817e415f637a180a7c18c1a2ab03aa5b296d7756818f6',
        ), $query);
    }
}
