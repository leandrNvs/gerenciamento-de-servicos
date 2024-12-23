<?php 

namespace Src\Support;

use Src\Foundation\Application;

abstract class Facades
{
    abstract protected static function getAccessor(): string;

    public static function __callStatic($name, $arguments)
    {
        return Application::getInstance()->build(static::getAccessor())->{$name}(...$arguments);
    }
}
