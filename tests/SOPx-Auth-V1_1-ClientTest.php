<?php

use \SOPx\Auth\V1_1\Client;

class SOPx_Auth_V1_1_ClientTest extends \PHPUnit_Framework_TestCase {

    protected $auth;

    protected function setUp() {
        $this->auth = new \SOPx\Auth\V1_1\Client('1234', 'hogefuga');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testNew_fails_if_app_id_is_missing() {
        $auth = new \SOPx\Auth\V1_1\Client(null, 'hoge');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testNew_fails_if_app_secret_is_missing() {
        $auth = new \SOPx\Auth\V1_1\Client(1, null);
    }

    public function testNew_succeeds() {
        $auth = new \SOPx\Auth\V1_1\Client('1', 'hogehoge');

        $this->assertEquals('1', $auth->getAppId());
        $this->assertEquals('hogehoge', $auth->getAppSecret());
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function getCreateRequest_on_invalid_method() {
        $this->auth->createRequest(
            'PUT', 'http://hoge/', array('aaa' => 'aaa')
        );
    }

    public function testCreateRequest_on_GET() {
        $req = $this->auth->createRequest(
            'GET', 'http://hoge/', array('aaa' => 'aaa')
        );

        $this->assertInstanceOf('GuzzleHttp\Psr7\Request', $req);
        $this->assertEquals('GET', $req->getMethod());
    }

    public function testCreateRequest_on_DELETE() {
        $req = $this->auth->createRequest(
            'DELETE', 'http://hoge/', array('aaa' => 'aaa')
        );

        $this->assertInstanceOf('GuzzleHttp\Psr7\Request', $req);
        $this->assertEquals('DELETE', $req->getMethod());
    }

    public function testCreateRequest_on_POST() {
        $req = $this->auth->createRequest(
            'POST', 'http://hoge/', array('aaa' => 'aaa')
        );

        $this->assertInstanceOf('GuzzleHttp\Psr7\Request', $req);
        $this->assertEquals('POST', $req->getMethod());
    }

    public function testCreateRequest_on_PUT() {
        $req = $this->auth->createRequest(
            'PUT', 'http://hoge/', array('aaa' => 'aaa')
        );

        $this->assertInstanceOf('GuzzleHttp\Psr7\Request', $req);
        $this->assertEquals('PUT', $req->getMethod());
    }

    public function testCreateRequest_on_POSTJSON() {
        $req = $this->auth->createRequest(
            'POSTJSON', 'http://hoge/', array('aaa' => 'aaa')
        );

        $this->assertInstanceOf('GuzzleHttp\Psr7\Request', $req);
        $this->assertEquals('POST', $req->getMethod());

        $sig = $req->getHeader('x-sop-sig');
        $this->assertRegExp('/\A[0-9a-f]{64}\z/', $sig[0]);
    }

    public function testCreateRequest_on_PUTJSON() {
        $req = $this->auth->createRequest(
            'PUTJSON', 'http://hoge/', array('aaa' => 'aaa')
        );

        $this->assertInstanceOf('GuzzleHttp\Psr7\Request', $req);
        $this->assertEquals('PUT', $req->getMethod());

        $sig = $req->getHeader('x-sop-sig');
        $this->assertRegExp('/\A[0-9a-f]{64}\z/', $sig[0]);
    }

    public function testVerifySignature_on_array() {
        $req = $this->auth->createRequest(
            'POST', 'http://hoge/', array('aaa' => 'aaa')
        );

        $query = array();
        parse_str($req->getBody(), $query);

        $sig = $query['sig'];
        unset($query['sig']);

        $this->assertTrue(
            $this->auth->verifySignature(
                $sig,
                $query
            )
        );
    }

    public function testVerifySignature_on_JSON() {
        $req = $this->auth->createRequest(
            'POSTJSON', 'http://hoge/', array('aaa' => 'aaa')
        );

        $sig = $req->getHeader('X-Sop-Sig');

        $this->assertTrue(
            $this->auth->verifySignature(
                $sig[0],
                $req->getBody() . ""
            )
        );
    }
}
