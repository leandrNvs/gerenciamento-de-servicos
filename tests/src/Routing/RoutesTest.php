<?php

namespace Tests\src\Routing;

use PHPUnit\Framework\TestCase;
use Src\Exceptions\RouteMethodNotAllowed;
use Src\Routing\Routes;
use Src\Routing\RoutesUtilities;

final class RoutesTest extends TestCase
{
    public function testRoutesIsEmpty(): void
    {
        $route = new Routes(
            new RoutesUtilities
        );

        $this->assertEmpty($route->getRoutes());
    }

    public function testCanRegisterMultipleVerbsForTheSameRoute(): void
    {
        $route = new Routes(
            new RoutesUtilities
        );

        $uri = '/client';

        $route->get($uri, []);
        $route->post($uri, []);
        $route->put($uri, []);
        $route->delete($uri, []);
        $route->patch($uri, []);

        $this->assertSame([
            $uri => [
                'get'    => [],
                'post'   => [],
                'put'    => [],
                'delete' => [],
                'patch'  => [],
            ]
        ], $route->getRoutes());
    }

    public function testThrowExceptionAtInvalidRouteMethod(): void
    {
        $route = new Routes(
            new RoutesUtilities
        );

        $this->expectException(RouteMethodNotAllowed::class);

        $route->notExistingMethod();
    }
}
