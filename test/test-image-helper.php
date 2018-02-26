<?php

require_once '../vendor/autoload.php';

use Codepso\PHPHelper\ImageHelper;

$imageHelper = new ImageHelper;
$p = ['module' => 'user', 'filter' => '100x100', 'root_path' => 'files/uploads/'];
print_r($p);

try {

    $r = $imageHelper->createThumbnail('peluche.jpg', $p);
    echo $r->message;

} catch (\Exception $e) {

}

echo $imageHelper->getExtension('hola.jpg');