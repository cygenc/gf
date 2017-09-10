<?php
namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\Renderer;

class RendererTest extends TestCase
{
    private $renderer;

    public function setUp()
    {
        $this->renderer = new Renderer();
        $this->renderer->addPath(__DIR__ . '/views');
    }

    public function testRenderTheRightPath()
    {
        $this->renderer->addPath('blog', __DIR__ . '/views');
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Hello World!', $content);
    }

    public function testRenderTheDefaultPath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals('Hello World!', $content);
    }

    public function testRenderWithParams()
    {
        $content = $this->renderer->render('demoparams', ['nom' => 'cygenc']);
        $this->assertEquals('Salut cygenc', $content);
    }

    public function testGlobalParameters()
    {
        $this->renderer->addGlobal('nom', 'cygenc');
        $content = $this->renderer->render('demoparams');
        $this->assertEquals('Salut cygenc', $content);
    }
}