<?php

use Codepso\PHPHelper\ImageHelper;

class ImageHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function uploadBase64()
    {
        $p = [
            'filename' => 'box.png',
            'value' => 'iVBORw0KGgoAAAANSUhEUgAAABoAAAAYAQMAAADeTH+GAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAA1BMVEWIkr9Q9TFnAAAAC0lEQVQIHWMYIAAAAHgAASxSckIAAAAASUVORK5CYII='
        ];

        $r = ImageHelper::uploadBase64($p, 'assets/files');
        codecept_debug($r);
    }
}