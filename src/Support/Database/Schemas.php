<?php

namespace Src\Support\Database;

use Src\Database\Schemas as DatabaseSchemas;
use Src\Support\Facades;

final class Schemas extends Facades
{
    protected static function getAccessor(): string
    {
        return DatabaseSchemas::class;
    }
}
