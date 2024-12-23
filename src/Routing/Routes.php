<?php

namespace Src\Routing;

use Closure;
use Src\Exceptions\RouteMethodNotAllowed;

class Routes
{
    private array $routes = [];

    private array $allowedVerbs = ['get', 'post', 'put', 'patch', 'delete'];

    public function __construct(private RoutesUtilities $routeUtilities) {}

    public function __call(string $name, array $arguments)
    {
        if(in_array($name, $this->allowedVerbs)) {
            $verb    = $name;
            $uri     = $arguments[0];
            $closure = $arguments[1];

            $this->addRoute($uri, $verb, $closure);

            return $this->routeUtilities->setLastAddedRouteInfo(
                $uri, $verb
            );
        }

        throw new RouteMethodNotAllowed("O método {$name} não existe na classe " . Routes::class);
    }

    private function addRoute(string $uri, string $verb, Closure|array $closure): void
    {
        $this->routes[$uri][$verb] = $closure;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}

