<?php

namespace Src\Routing;

use function Src\Helpers\route;

class Redirect
{
    public static function to($path)
    {
        die(header('Location: ' . $path));
    }

    public static function back()
    {
        static::to($_SERVER['HTTP_REFERER']);
    }

    public static function to_route(string $namedRoute, array $parameters = [])
    {
        $route = route($namedRoute, $parameters);

        static::to($route);
    }
}
