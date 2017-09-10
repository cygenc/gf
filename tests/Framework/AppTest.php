<?php
namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\App;
use App\Blog\BlogModule;
use Tests\Framework\Modules\ErroredModule;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/demo/');
        $response = $app->run($request);
        $this->assertContains('/demo', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog()
    {
        $app = new App([
            BlogModule::class
        ]);
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertContains('<h1>Bienvenue sur le blog</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());

        $requestArticle = new ServerRequest('GET', '/blog/article-de-test');
        $responseArticle = $app->run($requestArticle);
        $this->assertContains('<h1>Bienvenue sur l\'article article-de-test</h1>', (string)$responseArticle->getBody());
    }

    public function testThrowException()
    {
        $app = new App([
            ErroredModule::class
        ]);
        $request = new ServerRequest('GET', '/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/ertyui');
        $response = $app->run($request);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
