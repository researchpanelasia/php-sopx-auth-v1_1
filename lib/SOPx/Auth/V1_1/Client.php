<?php

namespace SOPx\Auth\V1_1;

use \GuzzleHttp\Psr7\Uri;
use \SOPx\Auth\V1_1\Request\DELETE;
use \SOPx\Auth\V1_1\Request\GET;
use \SOPx\Auth\V1_1\Request\POST;
use \SOPx\Auth\V1_1\Request\POSTJSON;
use \SOPx\Auth\V1_1\Request\PUT;
use \SOPx\Auth\V1_1\Request\PUTJSON;

class Client
{
    protected $app_id, $app_secret;

    public function __construct($app_id, $app_secret, $time = null)
    {
        if (!$app_id) {
            throw new \InvalidArgumentException('Missing required parameter: app_id');
        }
        if (!$app_secret) {
            throw new \InvalidArgumentException('Missing required parameter: app_secret');
        }
        if (!$time) {
            $time = time();
        }

        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->time = $time;
    }

    public function getAppId() { return $this->app_id; }
    public function getAppSecret() { return $this->app_secret; }
    public function getTime() { return $this->time; }

    public function createRequest($method, $uri, $params)
    {
        if (is_string($uri)) {
            $uri = new Uri($uri);
        }

        $params = array_merge(
            array('app_id' => $this->getAppId(), 'time' => $this->getTime()),
            $params
        );

        $req;
        switch ($method) {
            case 'DELETE':
                $req = DELETE::createRequest($uri, $params, $this->getAppSecret());
                break;
            case 'GET':
                $req = GET::createRequest($uri, $params, $this->getAppSecret());
                break;
            case 'POST':
                $req = POST::createRequest($uri, $params, $this->getAppSecret());
                break;
            case 'POSTJSON':
                $req = POSTJSON::createRequest($uri, $params, $this->getAppSecret());
                break;
            case 'PUT':
                $req = PUT::createRequest($uri, $params, $this->getAppSecret());
                break;
            case 'PUTJSON':
                $req = PUTJSON::createRequest($uri, $params, $this->getAppSecret());
                break;
            default:
                throw new \InvalidArgumentException('Cannot handle method: '. $method);
        }
        return $req;
    }

    public function verifySignature($sig, $params)
    {
        return Util::isSignatureValid(
            $sig,
            $params,
            $this->getAppSecret(),
            $this->getTime()
        );
    }
}
