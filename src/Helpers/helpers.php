<?php

namespace Src\Helpers;

use ReflectionClass;
use Src\Foundation\Application;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Routing\RoutesUtilities;
use Src\Session\Session;
use Src\Support\View\View;

function tableName(string $model)
{
    $reflection = new ReflectionClass($model);

    $properties = $reflection->getDefaultProperties();

    $tablename = explode('\\', $model);

    return [
        'tableName'  => $properties['tableName'] ?? strtolower(end($tablename)),
        'primaryKey' => $properties['primaryKey'] ?? 'id'
    ];
}

function view(string $view, array $data = [])
{
    return View::render($view, $data);
}

function route(string $routeName, $data = []): string
{
    $route = Application::getInstance()->build(RoutesUtilities::class)->getNamedRoute($routeName);

    $route = str_replace(
        array_map(fn($i) => "{{$i}}", array_keys($data)),
        array_map(fn($i) => str_replace(' ', '-', $i), array_values($data)),
        $route
    );

    return $route;
}

function to_route(string $routeName, array $parameters = []): void
{
    Redirect::to_route($routeName, $parameters);
}

function component(array $componentClass, ...$parameters)
{
    $componentClass[0] = '\App\Views\\' . $componentClass[0];

    return Application::getInstance()->build($componentClass[0])->{$componentClass[1]}(...$parameters);
}

function hidden(string $name, string|null $value = null): string
{
    return "<input type='hidden' name='{$name}' value='{$value}' />\n";
}

function method(string $method): string
{
    return "<input type='hidden' name='_method' value='{$method}' />\n";
}

function success(string $message): void
{
    Session::set('success', true);
    Session::set('message', $message);
}

function error(string $message): void
{
    Session::set('success', false);
    Session::set('message', $message);
}

function getMessage()
{
    return [
        'success' => Session::get('success'),
        'message' => Session::get('message')
    ];
}

function request()
{
    return Application::getInstance()->build(Request::class);
}
