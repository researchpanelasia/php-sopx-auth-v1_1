<?php

use \GuzzleHttp\Psr7\Uri;
use \SOPx\Auth\V1_1\Util;
use \SOPx\Auth\V1_1\Request\POSTJSON;

class SOPx_Auth_V1_1_Request_POSTJSONTest extends \PHPUnit_Framework_TestCase
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
        POSTJSON::createRequest(
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
        POSTJSON::createRequest(
            $this->uri,
            array( 'aaa' => 'aaa', 'time' => '1234', ),
            ''
        );
    }

    public function testCreateRequest()
    {
        $req = POSTJSON::createRequest(
            $this->uri,
            array(
                'time' => '1234',
                'bbb' => 'bbb',
                'aaa' => 'aaa',
            ),
            'hogehoge'
        );

        $uri = $req->getUri();

        $this->assertEquals('POST', $req->getMethod());
        $this->assertEquals("http://www.researchpanelasia.com", $uri . "");
        $this->assertEquals($req->getHeader('content-type'), array('application/json'));
        $this->assertEquals(
            array(
                'aaa' => 'aaa',
                'bbb' => 'bbb',
                'time' => '1234',
            ),
            json_decode($req->getBody(), true)
        );

        $sig = $req->getHeader('X-Sop-Sig');

        $this->assertEquals(
            Util::createSignature($req->getBody() . "", 'hogehoge'),
            $sig[0]
        );
    }
}
