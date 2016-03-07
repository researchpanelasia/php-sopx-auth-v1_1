<?php

namespace SOPx\Auth\V1_1\Request;

use \Httpful\Mime;
use \Httpful\Request;
use \SOPx\Auth\V1_1\Util;

class PUT
{
    public static function createRequest(\Net_URL2 $uri, array $params, $app_secret)
    {
        if (!array_key_exists('time', $params) || !$params['time']) {
            throw new \InvalidArgumentException('Missing required parameter "time" in params');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing app_secret');
        }

        $query = $uri->getQueryVariables();
        $uri->setQueryVariables(array());
        $query = array_merge($query, $params);

        return Request::put(
            $uri->getURL(),
            array_merge(
                $query,
                array('sig' => Util::createSignature($query, $app_secret))
            ),
            Mime::FORM
        );
    }
}
