<?php

namespace Src\Session;

final class Session
{

    public static function set(string $name, mixed $data)
    {
        $_SESSION[$name] = $data;
    }

    public static function get(string $name): mixed
    {
        $data = $_SESSION[$name] ?? false;

        unset($_SESSION[$name]);

        return $data;
    }

}