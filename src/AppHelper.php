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

/**
 * Help functions to development
 *
 * @author Juan Minaya Leon <minayaleon@gmail.com>
 */
class AppHelper
{
    /**
     * Get the name of a class
     *
     * @param Object $obj Object instance
     * @param string|boolean $namespace Include the namespace
     * @return null|string
     */
    public static function getClass($obj, $namespace = false)
    {
        if (!is_object($obj)) {
            $obj = null;
        }

        $classname = get_class($obj);
        if (!$namespace) {
            $matches = array();
            if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
                $classname = $matches[1];
            }
        }

        return $classname;
    }

    /**
     * Format URL Query
     *
     * @param array $query Query all
     * @param array $except Except
     * @return string Query URL
     */
    public static function formatUrlQuery($query, $except, $concat = '')
    {
        foreach ($except as $e) {
            if (isset($query[$e])) {
                unset($query[$e]);
            }
        }

        $f = true;
        $queryUrl = '';
        foreach ($query as $key => $value) {
            $queryUrl .= (!$f ? '&' : '') . $key . '=' . $value;
            if ($f) {
                $f = false;
            }
        }

        return (!empty($queryUrl) ? $concat : '') . $queryUrl;
    }

    /**
     * Get ignored attributes
     *
     * @param string $o Object
     * @param array $attr Allowed attributes
     * @return array
     */
    public static function getIgnoredAttributes($o, $attr)
    {
        $reflect = new \ReflectionClass($o);
        $props = $reflect->getProperties();

        $iattr = array();
        foreach ($props as $prop) {
            $field = $prop->getName();
            if (!in_array($field, $attr)) {
                array_push($iattr, $field);
            }
        }

        array_push($iattr, '__initializer__', '__cloner__', '__isInitialized__');

        return $iattr;
    }

    /**
     *
     * @param \DateTime $date 2017-09-01 12:34:56
     * @return int
     */
    public static function getElapsed($date)
    {
        $now = new \DateTime();
        $r = $now->getTimestamp() - $date->getTimestamp();
        return $r;
    }

    public static function existsURL($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 404) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Validate variables
     *
     * @param array $params Variables to evaluate
     * @param array $rules Rules and restrictions
     * @return array Results
     */
    public static function isValid($params, $rules)
    {
        $result = true;
        $message = "";

        foreach ($rules as $key => $rule) {

            $type = gettype($rule);
            $constraints = [];
            switch ($type) {
                case "string":
                    $key = $rule;
                    break;
                case "array":
                    $constraints = $rules[$key];
                    break;
            }

            // Valid exist
            if (!isset($params[$key])) {
                $message = "Variable " . $key . " doesn\'t exist.";
                $result = false;
                break;
            }

            // Valid type
            $value = $params[$key];
            foreach ($constraints as $c) {
                switch ($c) {
                    case "num":
                        if (!is_numeric($value)) {
                            $message = "Variable " . $key . " must be a number";
                            $result = false;
                            break;
                        }
                        break;
                    case ">0":
                        if ($value <= 0) {
                            $message = "Variable " . $key . " must be greater than zero";
                            $result = false;
                            break;
                        }
                        break;
                    case "email":
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $message = "Variable " . $key . " must be email";
                            $result = false;
                            break;
                        }
                        break;
                }

                // Verify
                if (!$result) {
                    break;
                }
            }

            // Verify
            if (!$result) {
                break;
            }
        }

        $r = ['status' => $result, 'message' => $message];
        return (object) $r;
    }

    public static function fixSSL($url)
    {
        $pos = stripos($url, "https://");
        return ($pos !== false && $pos == 0) ? $url : str_replace("http://", "https://", $url);
    }

    public static function generatePassword($length = 8)
    {
        $chars = 'bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ23456789!@';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    public static function populate(array $array, &$object, $ignore = [])
    {
        $class = get_class($object);
        $methods = get_class_methods($class);
        foreach ($methods as $method) {

            preg_match(' /^(set)(.*?)$/i', $method, $results);
            if ($results && $results[1] && $results[2]) {
                $pre = $results[1]  ?? '';
                $k = $results[2]  ?? '';
                $k = strtolower(substr($k, 0, 1)) . substr($k, 1);
                if ($pre == 'set' && isset($array[$k]) && !in_array($k, $ignore)) {
                    $object->$method($array[$k]);
                }
            }
        }
    }

    public static function convertURLFriendly($text)
    {
        return str_replace(' ', '-', strtolower($text));
    }
}
