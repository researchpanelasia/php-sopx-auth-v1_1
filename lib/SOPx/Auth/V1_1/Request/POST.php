<?php

namespace SOPx\Auth\V1_1\Request;

use \GuzzleHttp\Psr7\Request;
use \SOPx\Auth\V1_1\Util;

class POST
{
    public static function createRequest(\GuzzleHttp\Psr7\Uri $uri, array $params, $app_secret)
    {
        if (!array_key_exists('time', $params) || !$params['time']) {
            throw new \InvalidArgumentException('Missing required parameter "time" in params');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing app_secret');
        }

        $query_string = $uri->getQuery();
        $uri = $uri->withQuery('');

        $query = array();
        parse_str($query_string, $query);

        $params = array_merge($params, $query);

        $query_string = http_build_query(array_merge(
            $params,
            array('sig' => Util::createSignature($params, $app_secret))
        ));

        return new Request(
            'POST',
            $uri,
            array('Content-Type' => 'application/x-www-form-urlencoded'),
            $query_string
        );
    }
}
