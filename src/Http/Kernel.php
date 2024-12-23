<?php

namespace Src\Http;

use App\Models\Model;
use Closure;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use Src\Foundation\Application;
use Src\Routing\Routes;

final class Kernel
{
    public function __construct(
        private Application $app,
        private Request $request,
        private Routes $routes
    ) {}

    public function listen()
    {
        $routes     = $this->routes->getRoutes();
        $uri        = $this->request->getCurrentRequestUri();
        $httpMethod = $this->request->getCurrentRequestMethod();

        foreach($routes as $route => $executable) {
            $pattern = $this->routeToRegex($route, $parameterNames);

            if(preg_match($pattern, $uri, $match)) {
                unset($match[0]);

                $parameters = array_combine($parameterNames, $match);

                return $this->execute($executable[$httpMethod], $parameters);
            }
        }

        // TODO: exception at not found route
    }

    private function execute(Closure|array $executable, array $parameters): mixed
    {
        try {
            $reflection = $executable instanceof Closure
                ? new ReflectionFunction($executable)
                : new ReflectionMethod($executable[0], $executable[1]);
        } catch(ReflectionException $e) {
            // TODO: exception on method error
        }

        if(!($dependencies = $reflection->getParameters())) {
            return call_user_func($executable);
        }

        $dp = [];

        $parametersKeys = array_keys($parameters);

        foreach($dependencies as $dependence) {
            if(($type = $dependence->getType()) && class_exists(($class = $type->getName()))) {

                if(is_subclass_of($class, Model::class, true)) {
                    $parameterKey = array_shift($parametersKeys) ?? '';

                    if(str_starts_with($parameterKey, 'id')) {
                        $dp[] = call_user_func([$class, 'getById'], array_shift($parameters));
                    }
                } else {
                    $dp[] = $this->app->build($class);
                }
            }
        }

        $dp = array_merge($dp, array_values($parameters));

        return call_user_func_array($executable, $dp);
    }

    private function routeToRegex(string $route, mixed &$parameters): string
    {
        $regex = str_replace('/', '\/', $route);
        $regex = preg_replace('/\{.+?\}/', '([^\/]+)', $regex);

        preg_match_all('/\{(.+?)\}/', $route, $matches);

        $parameters = end($matches);

        return "/^{$regex}$/";
    }
}
