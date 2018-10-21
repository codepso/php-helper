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
        // codecept_debug($r);
    }

    protected function _after()
    {
        // codecept_debug($r);
    }

    // tests
    public function testCreateThumbnailInset()
    {
        // ratio: 1 (inset)
        $p = ['path' => 'assets/files', 'filter' => '200x200'];
        $r = ImageHelper::createThumbnail('teddy.png', $p);
        $this->assertTrue($r->status);
    }

    public function testCreateThumbnailOutbound()
    {
        // ratio: 2 (outbound)
        $p = ['path' => 'assets/files', 'filter' => '200x200', 'ratio' => 2, 'rename' => 'teddy-r2.png'];
        $r = ImageHelper::createThumbnail('teddy.png', $p);
        $this->assertTrue($r->status);
    }

    public function testCreateThumbnailWithNewName()
    {
        $p = ['path' => 'assets/files', 'filter' => '200x200', 'rename' => 'teddy-' . uniqid() . '.png'];
        $r = ImageHelper::createThumbnail('teddy.png', $p);
        $this->assertTrue($r->status);
    }

    public function testSaveBase64()
    {
        $p = [
            'filename' => 'box.png',
            'value' => 'iVBORw0KGgoAAAANSUhEUgAAABoAAAAYAQMAAADeTH+GAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAA1BMVEWIkr9Q9TFnAAAAC0lEQVQIHWMYIAAAAHgAASxSckIAAAAASUVORK5CYII='
        ];

        $r = ImageHelper::saveBase64($p, 'assets/files');
        $this->assertTrue($r->status);
    }

    public function testSaveBase64WithNewName()
    {
        $p = [
            'filename' => 'box.png',
            'value' => 'iVBORw0KGgoAAAANSUhEUgAAABoAAAAYAQMAAADeTH+GAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAA1BMVEWIkr9Q9TFnAAAAC0lEQVQIHWMYIAAAAHgAASxSckIAAAAASUVORK5CYII=',
            'rename' => 'boxy-' . uniqid() . '.png'
        ];

        $r = ImageHelper::saveBase64($p, 'assets/files');
        $this->assertTrue($r->status);
    }
}
