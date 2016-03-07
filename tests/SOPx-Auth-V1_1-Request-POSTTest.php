<?php

use \Net_URL2;
use \SOPx\Auth\V1_1\Request\POST;

class SOPx_Auth_V1_1_Request_POSTTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->uri = new \Net_URL2('http://www.researchpanelasia.com/?ccc=ccc');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testCreateRequest_fails_on_missing_time()
    {
        POST::createRequest(
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
        POST::createRequest(
            $this->uri,
            array( 'aaa' => 'aaa', 'time' => '1234', ),
            ''
        );
    }

    public function testCreateRequest()
    {
        $req = POST::createRequest(
            $this->uri,
            array(
                'time' => '1234',
                'bbb' => 'bbb',
                'aaa' => 'aaa',
            ),
            'hogehoge'
        );

        $this->assertEquals('POST', $req->method);
        $this->assertEquals('http://www.researchpanelasia.com/', $req->uri);
        $this->assertEquals(array(
            'aaa'  => 'aaa',
            'bbb'  => 'bbb',
            'ccc'  => 'ccc',
            'time' => '1234',
            'sig'  => '04708cb98a5ffcb4ad3501b284f23b9b31eb770a06b86abed03d814687d86e56',
        ), $req->payload);
    }
}
