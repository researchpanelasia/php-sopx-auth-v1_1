<?php

require_once('lib/SOPx_Auth_V1_1.class.php');

class SOPx_Auth_V1_1Test extends \PHPUnit_Framework_TestCase {

    protected $auth;

    protected function setUp() {
        $this->auth = new \SOPx\Auth\V1_1('1234', 'hogefuga');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testNew_fails_if_app_id_is_missing() {
        $auth = new \SOPx\Auth\V1_1(null, 'hoge');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testNew_fails_if_app_secret_is_missing() {
        $auth = new \SOPx\Auth\V1_1(1, null);
    }

    public function testNew_succeeds() {
        $auth = new \SOPx\Auth\V1_1('1', 'hogehoge');

        $this->assertEquals('1', $auth->getAppId());
        $this->assertEquals('hogehoge', $auth->getAppSecret());
    }
}
