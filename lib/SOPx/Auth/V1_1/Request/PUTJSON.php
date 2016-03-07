<?php

namespace SOPx\Auth\V1_1\Request;

use \GuzzleHttp\Psr7\Request;
use \SOPx\Auth\V1_1\Util;

class PUTJSON
{
    public static function createRequest(\GuzzleHttp\Psr7\Uri $uri, array $params, $app_secret)
    {
        if (!array_key_exists('time', $params) || !$params['time']) {
            throw new \InvalidArgumentException('Missing required parameter "time" in params');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing app_secret');
        }

        $data = json_encode($params);
        $sig = Util::createSignature($data, $app_secret);

        return new Request(
            'PUT', $uri, array(
                'X-Sop-Sig' => $sig,
                'Content-Type' => 'application/json',
            ),
            $data
        );
    }
}
