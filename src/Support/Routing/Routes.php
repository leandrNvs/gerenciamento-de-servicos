<?php

namespace Src\Support\Routing;

use Src\Routing\Routes as RoutingRoutes;
use Src\Support\Facades;

final class Routes extends Facades
{
    protected static function getAccessor(): string
    {
        return RoutingRoutes::class;
    }
}
