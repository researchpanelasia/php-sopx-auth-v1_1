<?php

namespace SOPx\Auth\V1_1\Request;

use \SOPx\Auth\V1_1\Util;
use \Httpful\Request;

class GET
{
    public static function createRequest(\Net_URL2 $uri, array $params, $app_secret)
    {
        if (!array_key_exists('time', $params) || !$params['time']) {
            throw new \InvalidArgumentException('Missing required parameter "time" in params');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing app_secret');
        }

        $uri->setQueryVariables(array_merge(
            $params,
            array( 'sig' => Util::createSignature($params, $app_secret), )
        ));

        return Request::get($uri->getURL());
    }
}
