<?php

namespace RyanChandler\Blade;

use Closure;
use Illuminate\Container\Container as BaseContainer;

class Container extends BaseContainer
{
    public function terminating(Closure $callback) {}
}
