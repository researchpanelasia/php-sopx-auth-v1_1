[![Build Status](https://travis-ci.org/researchpanelasia/php-SOPx-Auth-V1_1.svg?branch=master)](https://travis-ci.org/researchpanelasia/php-SOPx-Auth-V1_1)

# NAME

SOPx_Auth_V1_1 - SOP v1.1 authentication module

# SYNOPSIS

~~~php
$auth = new \SOPx\Auth\V1_1\Client('<APP_ID>', '<APP_SECRET>');

$request = $auth->createRequest(
  'GET', 'https://<API_HOST>/path/to/endpoint',
  array('app_id' => '<APP_ID>', 'app_mid' => '<APP_MID>', ... )
);
//=> isa \Httpful\Request object

$response = $request->send();
//=> isa \Httpful\Response object
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
