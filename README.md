[![Build Status](https://travis-ci.org/researchpanelasia/php-sopx-auth-v1_1.svg?branch=master)](https://travis-ci.org/researchpanelasia/php-sopx-auth-v1_1)

# NAME

SOPx_Auth_V1_1 - SOP v1.1 authentication module

# SYNOPSIS

~~~php
$auth = new \SOPx\Auth\V1_1\Client('<APP_ID>', '<APP_SECRET>');

$request = $auth->createRequest(
  'GET', 'https://<API_HOST>/path/to/endpoint',
  array('app_id' => '<APP_ID>', 'app_mid' => '<APP_MID>', ... )
);
//=> isa GuzzleHttp\Psr7\Request object

~~~

OR

~~~php
$sig = \SOPx\Auth\V1_1\Util::createSignature(
  array(
    'app_id' => '<APP_ID>',
    'app_mid' => '<APP_MID>',
    'time' => $time,
    ...
  ), '<APP_SECRET>'
);
//=> HMAC SHA256 hash signature
~~~

# DESCRIPTION

This module enables you to generate SOP v1.1 signature, make HTTP request to SOP v1.1 API.

# HOW TO USE

## Making a valid request to SOP API endpoint

~~~php
  $auth = new \SOPx\Auth\V1_1\Client('<APP_ID>', '<APP_SECRET>');

  $request = $auth->createRequest(
    'GET',
    'https://<API_HOST>/path/to/endpoint',
    array(
      'param1' => 'foo',
      'param2' => 'bar',
      ...
    )
  );

  // Then use Guzzle HTTP client to send request
~~~

## Creating a valid URL (e.g., for JSONP request)

~~~php
  $auth = new \SOPx\Auth\V1_1\Client('<APP_ID>', '<APP_SECRET>');

  $request = $auth->createRequest(
    'GET',
    'https://<API_HOST>/path/to/jsonp/endpoint',
    array(
      'param1' => 'foo',
      'param2' => 'bar',
      ...
    )
  );

  // Then maybe in your HTML template:
  <script src="<?php echo $request->getUri(); ?>"></script>
~~~

## Verifying a request signature for validity

~~~php
  $auth = new \SOPx\Auth\V1_1\Client('<APP_ID>', '<APP_SECRET>');

  $sig = $params['sig'];
  unset($params['sig']);

  if ($auth->verifySignature($sig, $params)) {
    // Request is valid
  }
  else {
    // Request is invalid
  }
~~~

# SUPPORTED REQUEST TYPES

Currently this client supports:

+ GET
+ POST
+ POST JSON

request types defined in [SOP v1.1 Authentication](https://console.partners.surveyon.com/docs/v1_1/authentication).
