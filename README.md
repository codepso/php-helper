# php-helper
Help libraries for PHP development
### Requirements
PHP Helper has the following requirements:
 - PHP 7.0+
### Installation
```bash
composer require codepso/php-helper
```

## Image Helper
Image manipulation
### Requirements
The Imagine Helper has the following requirements:
 - Imagine 1.0.1+
 - GD
### Functions
#### 
### `createThumbnail($filename, $params)`
* **$filename**: `string | required` The image's name
* **$params**: `array | required` 
  - **path**: `string | required` Filename path
  - **filter**: `string | required` Resize info ex: 300x200, 100x100
  - **ratio**: `int | optional` Inset (1), Outbound(2)

Example
-------
```php
<?php
use \Firebase\JWT\JWT;

$key = "example_key";
$token = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($token, $key);
$decoded = JWT::decode($jwt, $key, array('HS256'));

print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));
```
  
  
### `uploadBase64($data, $path)`


## Licence
The Aimeos TYPO3 extension is licensed under the terms of the GPL Open Source license and is available for free.

 