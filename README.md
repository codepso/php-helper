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
  
  
### `uploadBase64($data, $path)`


## Licence
The Aimeos TYPO3 extension is licensed under the terms of the GPL Open Source license and is available for free.

 