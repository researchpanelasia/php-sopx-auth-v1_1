<?php

namespace SOPx\Auth\V1_1\Request;

use \GuzzleHttp\Psr7\Request;
use \GuzzleHttp\Psr7\Uri;
use \SOPx\Auth\V1_1\Util;

class DELETE
{
    public static function createRequest(\GuzzleHttp\Psr7\Uri $uri, array $params, $app_secret)
    {
        if (!array_key_exists('time', $params) || !$params['time']) {
            throw new \InvalidArgumentException('Missing required parameter "time" in params');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing app_secret');
        }

        $query = array();
        parse_str($uri->getQuery(), $query);

        $params = array_merge($query, $params);

        $query = array_merge(
            $params,
            array('sig' => Util::createSignature($params, $app_secret))
        );

        return new Request('DELETE', $uri->withQuery(http_build_query($query)));
    }
}
