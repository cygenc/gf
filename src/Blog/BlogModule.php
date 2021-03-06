<?php
namespace App\Blog;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Framework\Router;

/**
 * Class BlogModule
 */
class BlogModule
{
    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * BlogModule constructor.
     * @param Router $router
     * @param RendererInterface $renderer
     */
    public function __construct(Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog', __DIR__ . '/views');
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug:[a-z\-0-9]+}', [$this, 'show'], 'blog.show');
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     */
    public function index(ServerRequestInterface $request): string
    {
        return  $this->renderer->render('@blog/index');
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     */
    public function show(ServerRequestInterface $request): string
    {
        return  $this->renderer->render('@blog/show', [
            'slug' => $request->getAttribute('slug')
        ]);
    }
}
