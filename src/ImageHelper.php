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

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Exception\Exception as ImagineException;

/**
 * Image is a OOP library for image manipulation built in PHP 5.3+
 * @see http://imagine.readthedocs.io/en/latest Documentation of Imagine.
 *
 * @author Juan Minaya Leon <minayaleon@gmail.com>
 */
class ImageHelper
{
    /**
     * Image manipulation with PHP Imagine
     * @see http://imagine.readthedocs.io/en/latest Documentation of Imagine.
     *
     * @param string $filename Image name
     * @param array $params {
     * @var string $path The file path (Not include end slash)
     * @var string $filter Filters defined in config.yml (original, 75x42, 600x420, etc.)
     * }
     * @return object
     */
    public static function createThumbnail($filename, $params)
    {

        $r = ['status' => true];

        try {

            if (!isset($params['filter'])) {
                throw new \Exception("Param filter is required");
            }

            if (!isset($params['path'])) {
                throw new \Exception("Param path is required");
            }

            $oPath = $params['path'] . '/' . $filename;
            if (empty($filename) || !file_exists($oPath)) {
                throw new \Exception("Local file not exists");
            }

            // Name
            $newFilename = isset($params['new_name']) ? $params['new_name'] : $filename;

            // Dimensions
            $parts = explode('x', $params['filter']);
            $width = intval($parts[0]);
            $height = intval($parts[1]);
            $dPath = $params['path'] . '/' . $params['filter'] . '-' . $newFilename;

            // Verify exist destiny dir - set www-data to web folder
            $dvPath = implode('/', explode('/', $dPath, -1));
            if (!file_exists($dvPath)) {
                mkdir($dvPath, 0777, true);
            }

            $imagine = new Imagine();
            $open = $imagine->open($oPath);

            // Aspect ratio
            if (!isset($params['ratio'])) {

                $size = $open->getSize();
                $box = new Box($size->getWidth(), $size->getHeight());
                $box = $box->widen($width);

                // Review
                if ($height < $box->getHeight()) {
                    $box = $box->heighten($height);
                }

                // Resize
                $open->resize($box)->save($dPath);

            } else {

                // Use inset, outbound
                $ratio = $params['ratio'];
                $box = new Box($width, $height);
                $open->thumbnail($box, $ratio)->save($dPath);
            }

            $r['path'] = $dPath;

        } catch (ImagineException $e) {

            $r['status'] = false;
            $r['message'] = $e->getMessage();

        } catch (\Exception $e) {

            $r['status'] = false;
            $r['message'] = $e->getMessage();
        }

        return (object) $r;
    }

    public static function uploadBase64($data, $path)
    {
        $r = ['status' => true];

        try {

            $filename = $data['filename'];
            $file = base64_decode($data['value']);
            if ($file === false) {
                throw new \Exception('Invalid data code');
            }

            $img = @imagecreatefromstring($file);
            if (!$img) {
                throw new \Exception('Invalid image data');
            }

            $ext = self::getExtension($filename);
            $filename = md5(uniqid()) . '.' . $ext;

            $image = @file_put_contents($path . '/' . $filename, $file);
            if ($image === false) {
                throw new \Exception('Can not upload');
            }

            $r['filename'] = $filename;

        } catch (\Exception $e) {

            $r['status'] = false;
            $r['message'] = $e->getMessage();
        }

        return (object) $r;
    }

    public static function getExtension($filename)
    {
        $parts = explode('.', $filename);
        return end($parts);
    }
}
