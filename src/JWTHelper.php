<?php

/*
 * This file is part of the Codepso package.
 *
 * (c) Juan Minaya Leon <minayaleon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Codepso\PHPHelper;

use Firebase\JWT\JWT;

class JWTHelper
{
    /**
     * @var array
     */
    private $app;

    /**
     * @var array
     */
    private $params;

    /**
     * @param array $params
     */
    public function __construct($params, $app)
    {
        $this->params = $params;
        $this->app = $app;
    }

    public function encode($data, $scope = "main")
    {
        $time = time();

        $token = [
            "iss" => $this->app['id'],
            "aud" => "web",
            "iat" => $time,
            "exp" => $time + $this->params[$scope]['ttl']
        ];

        if (!empty($data)) {
            $token = array_merge($token, $data);
        }

        $secret = (isset($this->params[$scope]['secret'])) ?  $this->params[$scope]['secret'] : $this->app['secret'];
        return JWT::encode($token, $secret);
    }

    public function decode($jwt, $scope = "main")
    {
        $secret = (isset( $this->params[$scope]['secret'])) ?  $this->params[$scope]['secret'] : $this->app['secret'];
        return JWT::decode($jwt,  $secret, array('HS256'));
    }

}
