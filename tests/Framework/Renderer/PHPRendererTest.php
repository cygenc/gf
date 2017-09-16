<?php
namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\Renderer\PHPRenderer;

/**
 * Class PHPRendererTest
 */
class PHPRendererTest extends TestCase
{
    /**
     * @var
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new PHPRenderer(__DIR__ . '/views');
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
