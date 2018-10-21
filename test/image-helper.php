<?php

require_once '../vendor/autoload.php';

use Codepso\PHPHelper\ImageHelper;
use Imagine\Image\ImageInterface;

$imageHelper = new ImageHelper;
$p = ['module' => 'user', 'filter' => '100x100', 'root_path' => 'files/uploads/'];
// print_r($p);

try {

    var_dump(ImageInterface::THUMBNAIL_INSET);
    var_dump(ImageInterface::THUMBNAIL_OUTBOUND);

    //$r = $imageHelper->createThumbnail('peluche.jpg', $p);
    //echo $r->message;

} catch (\Exception $e) {

}

// echo $imageHelper->getExtension('hola.jpg');