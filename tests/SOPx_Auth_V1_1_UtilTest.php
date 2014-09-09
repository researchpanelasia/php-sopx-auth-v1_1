<?php

require_once('lib/SOPx_Auth_V1_1/Util.class.php');

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
}
