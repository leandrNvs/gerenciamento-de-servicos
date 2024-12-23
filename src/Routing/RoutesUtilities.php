<?php

namespace Src\Routing;

use Exception;
use Src\Exceptions\NamedRouteNotFoundException;

final class RoutesUtilities
{
    private array $lastAddedRouteInfo = [];

    private array $namedRoutes = [];

    public function setLastAddedRouteInfo(string $uri, string $verb): self
    {
        $this->lastAddedRouteInfo = compact('uri', 'verb');

        return $this;
    }

    public function name(string $routeName): self
    {
        $this->namedRoutes[$routeName] = $this->lastAddedRouteInfo['uri'];

        return $this;
    }

    public function getNamedRoute(string $routeName, array $replacement = [])
    {
        $route = $this->namedRoutes[$routeName] ?? throw new NamedRouteNotFoundException("A rota {$routeName} não foi encontrada.");

        $params = array_map(fn($i) => "{{$i}}", array_keys($replacement));

        return str_replace($params, $replacement, $route);
    }
}
