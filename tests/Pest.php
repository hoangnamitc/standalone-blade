<?php

use Illuminate\Container\Container;
use RyanChandler\Blade\Blade;

function blade(): Blade
{
    static $blade;

    return $blade ??= new Blade(__DIR__ . '/views', __DIR__ . '/cache');
}
