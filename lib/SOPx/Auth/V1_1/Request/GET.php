<?php

namespace SOPx\Auth\V1_1\Request;

use \GuzzleHttp\Psr7\Request;
use \GuzzleHttp\Psr7\Uri;
use \SOPx\Auth\V1_1\Util;

class GET
{
    public static function createRequest(\GuzzleHttp\Psr7\Uri $uri, array $params, $app_secret)
    {
        if (!array_key_exists('time', $params) || !$params['time']) {
            throw new \InvalidArgumentException('Missing required parameter "time" in params');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing app_secret');
        }

        $query = array_merge(
            $params,
            array('sig' => Util::createSignature($params, $app_secret))
        );

        return new Request('GET', $uri->withQuery(http_build_query($query)));
    }
}
