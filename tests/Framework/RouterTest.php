<?php
namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Router;

class RouterTest extends TestCase
{
    public function setUp()
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function () {
            return 'Hello!';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('Hello!', call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGetMethodIfURLDoesNotExists()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blogdsds', function () {
            return 'Hello!';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET', '/blog/posts/1');
        $this->router->get('/blog', function () {
            return 'Hello!';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}/{id:\d+}', function () {
            return 'Hello!';
        }, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('Hello!', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug' => 'posts', 'id' => '1'], $route->getParams());
        
        // Test invalid url
        $route = $this->router->match(new ServerRequest('GET', '/blog/my_slug/1'));
        $this->assertEquals(null, $route);
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog', function () {
            return 'Hello!';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}/{id:\d+}', function () {
            return 'Hello!';
        }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'posts', 'id' => 1]);
        $this->assertEquals('/blog/posts/1', $uri);
    }
}
