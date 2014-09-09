<?php

namespace SOPx\Auth\V1_1;

class Client
{
    protected $app_id, $app_secret;

    public function __construct($app_id, $app_secret)
    {

        if (!$app_id) {
            throw new \InvalidArgumentException('Missing required parameter: app_id');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing required parameter: app_secret');
        }

        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    public function getAppId() { return $this->app_id; }
    public function getAppSecret() { return $this->app_secret; }
}
