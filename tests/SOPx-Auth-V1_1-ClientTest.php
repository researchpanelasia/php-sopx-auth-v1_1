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
}
