<?php

require_once '../vendor/autoload.php';

use Codepso\PHPHelper\JWTHelper;

$apiKey = '1a2b3c4d';
$params = [
    'main' => [
        'ttl' => 60,
        'secret' => 'oriana20170621'
    ],
    'refresh' => [
        'ttl' => 120
    ]
];

$app = ['id' => '830a54ebf2c44e4fa09b78589af72cd2'];
$jwtHelper = new JWTHelper($params, $app);

$r = ['status' => true];

$action = $_GET['action'];

switch ($action) {
    case 'encode':
        encode($jwtHelper, $apiKey, $r);
        break;
    case 'decode':
        decode($jwtHelper, $r);
        break;
    case 'both':
        encode($jwtHelper, $apiKey, $r);
        decode($jwtHelper, $r);
        break;
}

function encode(JWTHelper $jwt, $apiKey, &$r)
{
    try {

        $rt = rand(1, 10);
        $token = $jwt->encode(['ak' => $apiKey], 'main');
        $refresh = $jwt->encode(['ak' => $apiKey, 'rt' => $rt], 'refresh');

        $r['token'] = $token;
        $r['refresh'] = $refresh;

    } catch (\Exception $e) {
        $r['message'] = $e->getMessage();
    }
}

function decode(JWTHelper $jwt, &$r)
{
    try {

        $data = json_decode(file_get_contents('php://input'), true);
        $token = isset($data['token']) ? $data['token'] : $r['token'];

        $payload = $jwt->decode($token, 'main');
        if (!isset($payload->ak)) {
            throw new \Exception('Invalid Access Token');
        }

        $r['ak'] = $payload->ak;

    } catch (\Exception $e) {
        $r['message'] = $e->getMessage();
    }
}

header("Content-type:application/json");
echo json_encode($r);