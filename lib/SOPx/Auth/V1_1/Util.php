<?php

namespace SOPx\Auth\V1_1;

class Util
{
    public static function createStringFromArray($params)
    {
        ksort($params);
        $query = array();
        foreach ($params as $key => $value) {
            if (!is_scalar($value)) {
                throw new \InvalidArgumentException('Non-scalar value in parameter: '. $key);
            }
            if (!preg_match('/^sop_/', $key)) {
                $query[] = $key. '='. $value;
            }
        }
        return implode('&', $query);
    }

    public static function createSignature($params, $app_secret)
    {
        $data_string = '';
        if (is_array($params)) {
            $data_string = self::createStringFromArray($params);
        }
        else if (is_scalar($params)) {
            $data_string = $params;
        }
        else {
            throw new \InvalidArgumentException('Non-compatible type provided to $params');
        }
        return hash_hmac('sha256', $data_string, $app_secret);
    }

    public static function isSignatureValid($sig, $params, $app_secret)
    {
        if (!$sig || !$params || !$app_secret) {
            return false;
        }
        return $sig === self::createSignature($params, $app_secret);
    }
}
