<?php

use \SOPx\Auth\V1_1\Util;

class SOPx_Auth_V1_1_UtilTest extends \PHPUnit_Framework_TestCase {

    public function testCreateStringFromArray() {
        $this->assertSame(
            'xxx=xxx&yyy=yyy&zzz=zzz',
            Util::createStringFromArray(array(
                'zzz' => 'zzz',
                'yyy' => 'yyy',
                'xxx' => 'xxx',
            ))
        );
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testCreateStringFromArray_fail_on_non_scalar_found() {
        Util::createStringFromArray(array(
            'hoge' => array(
                'aaa' => 'aaa',
            ),
        ));
    }

    public function testCreateSignature_from_array() {
        $this->assertSame(
            '2fbfe87e54cc53036463633ef29beeaa4d740e435af586798917826d9e525112',
            Util::createSignature(
                array(
                    'ccc' => 'ccc',
                    'bbb' => 'bbb',
                    'aaa' => 'aaa',
                ),
                'hogehoge'
            )
        );
    }

    public function testCreateSignature_from_scalar() {
        $this->assertSame(
            'dc76e675e2bcabc31182e33506f5b01ea7966a9c0640d335cc6cc551f0bb1bba',
            Util::createSignature(
                '{"hoge":"fuga"}',
                'hogehoge'
            )
        );
    }

    /**
     * @expectedException   InvalidArgumentException
     */
    public function testCreateSignature_fail_on_incompatible_type() {
        Util::createSignature(
            new stdClass(),
            'hogehoge'
        );
    }

    public function testIsSignatureValid_on_valid_sig_for_array() {
        $this->assertTrue(
            Util::isSignatureValid(
                '2fbfe87e54cc53036463633ef29beeaa4d740e435af586798917826d9e525112',
                array('aaa' => 'aaa', 'ccc' => 'ccc', 'bbb' => 'bbb'),
                'hogehoge'
            )
        );
    }

    public function testIsSignatureValid_on_valid_sig_for_JSON() {
        $this->assertTrue(
            Util::isSignatureValid(
                'dc76e675e2bcabc31182e33506f5b01ea7966a9c0640d335cc6cc551f0bb1bba',
                '{"hoge":"fuga"}',
                'hogehoge'
            )
        );
    }

    public function testIsSignatureValid_on_invalid_sig_for_array() {
        $this->assertFalse(
            Util::isSignatureValid(
                '2fbfe87e54cc53036463633ef29beeaa4d740e435af586798917826d9e525112',
                array('aaa' => 'aaa', 'ccc' => 'ccc', 'bbb' => 'bbc'),
                'hogehoge'
            )
        );
    }

    public function testIsSignatureValid_on_invalid_sig_for_JSON() {
        $this->assertFalse(
            Util::isSignatureValid(
                'dc76e675e2bcabc31182e33506f5b01ea7966a9c0640d335cc6cc551f0bb1bba',
                '{"hoge":"huga"}',
                'hogehoge'
            )
        );
    }

    public function testIsSignatureValid_on_missing_variables() {
        $this->assertFalse(
            Util::isSignatureValid(
                null,
                '{"hoge":"huga"}',
                'hogehoge'
            )
        );
        $this->assertFalse(
            Util::isSignatureValid(
                'hogefuga',
                null,
                'hogehoge'
            )
        );
        $this->assertFalse(
            Util::isSignatureValid(
                'hogefuga',
                array('aaa' => 'aaa'),
                null
            )
        );
    }
}
