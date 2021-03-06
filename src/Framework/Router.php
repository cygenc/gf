<?php
namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Router\Route;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRouter;

/**
* Register and match routes
*/
class Router
{
    /**
    * @var FastRouteRouter
    */
    private $router;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
    * @param string $path
    * @param callable $callable
    * @param string $name
    */
    public function get(string $path, callable $callable, string $name)
    {
        $this->router->addRoute(new ZendRouter($path, $callable, ['GET'], $name));
    }

    /**
    * @param ServerRequestInterface $request
    * @return Route/null
    */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    /**
     * Génère une url
     * @param string $name
     * @param array $params
     * @return null|string
     */
    public function generateUri(string $name, array $params): ?string
    {
        return $this->router->generateUri($name, $params);
    }
}
