<?php

use \GuzzleHttp\Psr7\Uri;
use \SOPx\Auth\V1_1\Request\DELETE;

class SOPx_Auth_V1_1_Request_DELETETest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->uri = new Uri('http://www.researchpanelasia.com/?ccc=ccc');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testCreateRequest_fails_on_missing_time()
    {
        DELETE::createRequest(
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
        DELETE::createRequest(
            $this->uri,
            array( 'aaa' => 'aaa', 'time' => '1234', ),
            ''
        );
    }

    public function testCreateRequest()
    {
        $req = DELETE::createRequest(
            $this->uri,
            array(
                'time' => '1234',
                'bbb'  => 'bbb',
                'aaa'  => 'aaa',
            ),
            'hogehoge'
        );

        $this->assertEquals('GuzzleHttp\Psr7\Request', get_class($req));
        $this->assertEquals('DELETE', $req->getMethod());

        $query = array();
        parse_str($req->getUri()->getQuery(), $query);

        $this->assertEquals(array(
            'aaa'  => 'aaa',
            'bbb'  => 'bbb',
            'ccc'  => 'ccc',
            'time' => '1234',
            'sig'  => '04708cb98a5ffcb4ad3501b284f23b9b31eb770a06b86abed03d814687d86e56',
        ), $query);
    }
}
