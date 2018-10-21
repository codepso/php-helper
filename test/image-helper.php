<?php

require_once '../vendor/autoload.php';

use Codepso\PHPHelper\ImageHelper;

$imageHelper = new ImageHelper;
$r = ['status' => true];

try {

    // ratio: 1 (inset)
    $p = ['path' => 'files', 'filter' => '200x200', 'new_name' => 'teddy-1.png'];
    $r1 = $imageHelper->createThumbnail('teddy.png', $p);
    if (!$r1->status) {
        throw new \Exception($r1->message);
    }

    // ratio: 2 (outbound)
    $p = ['path' => 'files', 'filter' => '200x200', 'new_name' => 'teddy-2.png',  'ratio' => 2];
    $r2 = $imageHelper->createThumbnail('teddy.png', $p);
    if (!$r2->status) {
        throw new \Exception($r2->message);
    }

} catch (\Exception $e) {
    // echo $e->getMessage();
    $r['message'] = $e->getMessage();
}

// echo $imageHelper->getExtension('hola.jpg');
header("Content-type:application/json");
echo json_encode($r);