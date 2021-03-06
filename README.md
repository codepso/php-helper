<h1 align="center">
  <img src="https://s3.us-east-2.amazonaws.com/codepso-comunity/codepso-logo.png" alt="Codepso" width="100">
</h1>

# php-helper
Help libraries for PHP development
## Table of content
- [Requirements](#requirements)
- [Installation](#installation)
- [Helpers](#mainhelper)
    - [MainHelper](#mainhelper)
    - [ImageHelper](#imagehelper)
    - [JWTHelper](#jwthelper)
- [Tests](#test)
- [License](#license)
- [Links](#links)
## Requirements
PHP Helper has the following requirements:
 - PHP 7.0+
Image manipulation
The Imagine Helper has the following requirements:
  - Imagine 1.0.1+
  - GD
## Installation
```bash
composer require codepso/php-helper
```
## MainHelper
### `isValid($params, $rules)`
### `populate($object, $data, $ignore)`
### `getIgnoredAttributes($object, $attr)`
### `getClass($object, $namespace)`
### `getElapsed($date)`
### `generatePassword($length)`
### `isJSON($string)`

## ImageHelper
### `createThumbnail($filename, $params)`
* **$filename**: `string | required` Name of the image
* **$params**: `array | required` 
  - **path**: `string | required` Path of the image
  - **filter**: `string | required` Resize info ex: 300x200, 100x100
  - **ratio**: `int | optional` Inset:1 (default), Outbound: 2
  - **rename**: `string | optional` New name of the image
```php
<?php
require_once 'vendor/autoload.php';

use Codepso\PHPHelper\ImageHelper;

try {

    // ratio: 1 (inset)
    $p = ['path' => 'assets/files', 'filter' => '200x200'];
    $r1 = ImageHelper::createThumbnail('teddy.png', $p);
    if (!$r1->status) {
        throw new \Exception($r1->message);
    }

    // ratio: 2 (outbound)
    $p = ['path' => 'assets/files', 'filter' => '200x200', 'rename' => 'teddy-2.png',  'ratio' => 2];
    $r2 = ImageHelper::createThumbnail('teddy.png', $p);
    if (!$r2->status) {
        throw new \Exception($r2->message);
    }

} catch (\Exception $e) {
    $e->getMessage();
}
```
| Original | Inset (200x200) | Outbound (200x200) |
| :---: | :---: | :---: |
| 366x232px | 200x127px | 200x200px |
| ![or](https://s3.us-east-2.amazonaws.com/codepso-comunity/php-helper/teddy.png) | ![in](https://s3.us-east-2.amazonaws.com/codepso-comunity/php-helper/200x200-teddy-1.png) | ![ou](https://s3.us-east-2.amazonaws.com/codepso-comunity/php-helper/200x200-teddy-2.png) |  
  
### `saveBase64($params, $path)`
* **$params**: `array | required`
  - **filename**: `string | required` Name of the image
  - **value**: `string | required` Image in base64 format
  - **rename**: `string | optional` New name of the image
* **$path**: `string | required` The path to save the file
```php
<?php
require_once 'vendor/autoload.php';

use Codepso\PHPHelper\ImageHelper;

try {

    $p = [
        'filename' => 'box.png',
        'value' => 'iVBORw0KGgoAAAANSUhEUgAAABoAAAAYAQMAAADeTH+GAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAA1BMVEWIkr9Q9TFnAAAAC0lEQVQIHWMYIAAAAHgAASxSckIAAAAASUVORK5CYII='
    ];
    $r = ImageHelper::saveBase64($p, 'assets/files');
    if (!$r->status) {
        throw new \Exception($r->message);
    }

} catch (\Exception $e) {
    $e->getMessage();
}
```
## JWTHelper
### `encode($data, $scope)`
### `encode($jwt, $scope)`

## Test

We are using Codeception 

```bash
php vendor/bin/codecept run unit ImageHelperTest
php vendor/bin/codecept run unit
php vendor/bin/codecept run ImageHelperTest:testSaveBase64
php vendor/bin/codecept run ImageHelperTest:testSaveBase64WithNewName

```

## License
The Aimeos TYPO3 extension is licensed under the terms of the GPL Open Source license and is available for free.

## Links
- https://imagine.readthedocs.io/en/stable

 