<?php

class SOPx_Auth_V1_1 {

    private $app_id, $app_secret;

    public function __construct($app_id, $app_secret) {

        if (!$app_id) {
            throw new InvalidArgumentException('Missing required parameter: app_id');
        }
        if (!$app_secret) {
            throw new InvalidArgumentException('Missing required parameter: app_secret');
        }

        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    public function getAppId() { return $this->app_id; }
    public function getAppSecret() { return $this->app_secret; }

    public function generateSignature($query) {

        if (!array_key_exists('time', $query) || !$query['time']) {
            throw new InvalidArgumentException('Missing required parameter: time');
        }

        ksort($query);
        $params = array();
        foreach ($query as $key => $val) {
            $params[] = "{$key}={$val}";
        }
        return hash_hmac(
                'sha256',
                implode('&', $params),
                $this->getAppSecret()
                );
    }

    public function signQuery($query) {

        if (!array_key_exists('time', $query)) {
            $query['time'] = time();
        }

        return array_merge(
            $query,
            array('sig' => $this->generateSignature($query))
        );
    }

    public function verifyQuery($query) {

        if (!array_key_exists('sig', $query)) {
            return false;
        }
        if (!array_key_exists('time', $query)) {
            return false;
        }

        $sig = $query['sig'];
        unset($query['sig']);

        return $sig === $this->generateSignature($query);
    }
}
