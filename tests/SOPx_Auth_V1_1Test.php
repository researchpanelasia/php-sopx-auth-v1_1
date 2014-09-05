<?php

if (file_exists('vendor/autoload.php')) {
    require_once('vendor/autoload.php');
}
require_once('lib/SOPx_Auth_V1_1.class.php');

class SOPx_Auth_V1_1Test extends PHPUnit_Framework_TestCase {

    protected $auth;

    protected function setUp() {
        $this->auth = new SOPx_Auth_V1_1('1234', 'hogefuga');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testNew_fails_if_app_id_is_missing() {
        $auth = new SOPx_Auth_V1_1(null, 'hoge');
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testNew_fails_if_app_secret_is_missing() {
        $auth = new SOPx_Auth_V1_1(null, 'hoge');
    }

    public function testNew_succeeds() {
        $auth = new SOPx_Auth_V1_1('1', 'hogehoge');

        $this->assertEquals('1', $auth->getAppId());
        $this->assertEquals('hogehoge', $auth->getAppSecret());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGenerateSignature_without_time() {
        $this->auth->generateSignature(array(
            'hoge' => 'hoge',
            'fuga' => 'fuga',
        ));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGenerateSignature_with_blank_time() {
        $this->auth->generateSignature(array(
            'hoge' => 'hoge',
            'fuga' => 'fuga',
            'time' => '',
        ));
    }

    public function testGenerateSignature() {
        $sig = $this->auth->generateSignature(array(
            'app_id' => '1234',
            'hoge' => 'hoge',
            'fuga' => 'fuga',
            'time' => '123456',
        ));

        $this->assertEquals('c4a23f5cb57d0bfe16a7ad4fc58ba0cccd92122efb144b0abf43315ff171a746', $sig);
    }

    public function testSignQuery_without_time() {
        $res = $this->auth->signQuery(array(
            'app_id' => '1234',
            'hoge' => 'hoge',
            'fuga' => 'fuga',
        ));

        $this->assertArrayHasKey('sig', $res);
        $this->assertArrayHasKey('time', $res);
    }

    public function testSignQuery_with_time() {
        $res = $this->auth->signQuery(array(
            'app_id' => '1234',
            'hoge' => 'hoge',
            'fuga' => 'fuga',
            'time' => '123456',
        ));

        $this->assertSame(
            array(
                'app_id' => '1234',
                'hoge' => 'hoge',
                'fuga' => 'fuga',
                'time' => '123456',
                'sig' => 'c4a23f5cb57d0bfe16a7ad4fc58ba0cccd92122efb144b0abf43315ff171a746',
            ),
            $res
        );
    }

    public function testVerifyQuery_without_time() {
        $res = $this->auth->verifyQuery(array(
            'app_id' => '1234',
            'hoge' => 'hoge',
            'fuga' => 'fuga',
            'sig' => 'c4a23f5cb57d0bfe16a7ad4fc58ba0cccd92122efb144b0abf43315ff171a746',
        ));

        $this->assertFalse($res);
    }

    public function testVerifyQuery_without_sig() {
        $res = $this->auth->verifyQuery(array(
            'app_id' => '1234',
            'hoge' => 'hoge',
            'fuga' => 'fuga',
            'time' => '123456',
        ));

        $this->assertFalse($res);
    }

    public function testVerifyQuery_fail() {
        $res = $this->auth->verifyQuery(array(
            'app_id' => '1234',
            'hoge' => 'hogehoge',
            'fuga' => 'fugafuga',
            'time' => '123456',
            'sig' => 'c4a23f5cb57d0bfe16a7ad4fc58ba0cccd92122efb144b0abf43315ff171a746',
        ));

        $this->assertFalse($res);
    }

    public function testVerifyQuery_succeed() {
        $res = $this->auth->verifyQuery(array(
            'app_id' => '1234',
            'hoge' => 'hoge',
            'fuga' => 'fuga',
            'time' => '123456',
            'sig' => 'c4a23f5cb57d0bfe16a7ad4fc58ba0cccd92122efb144b0abf43315ff171a746',
        ));

        $this->assertTrue($res);
    }
}
