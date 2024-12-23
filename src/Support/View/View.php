<?php

namespace Src\Support\View;

use Src\Support\Facades;
use Src\View\View as ViewView;

final class View extends Facades
{
    protected static function getAccessor(): string
    {
        return ViewView::class;
    }
}