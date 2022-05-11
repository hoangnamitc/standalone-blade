<?php

namespace RyanChandler\Blade;

use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Facade;
use Illuminate\View\ViewServiceProvider;

/**
 * @mixin \Illuminate\Contracts\View\Factory
 */
class Blade
{
    protected Factory $factory;

    final public function __construct(
        protected string|array $viewPaths,
        protected string $cachePath,
        protected ?ContainerContract $container = null
    ) {
        $this->viewPaths = Arr::wrap($viewPaths);

        $this->init();
    }

    protected function init()
    {
        $this->container ??= new Container;

        $this->container->singleton('files', fn () => new Filesystem);
        $this->container->singleton('events', fn () => new Dispatcher);
        $this->container->singleton('config', fn () => new Repository([
            'view.paths' => $this->viewPaths,
            'view.compiled' => $this->cachePath,
        ]));

        (new ViewServiceProvider($this->container))->register();

        $this->factory = $this->container->get('view');
    }

    public function __call(string $name, array $arguments)
    {
        return $this->factory->{$name}(...$arguments);
    }

    public static function make(string $viewPath, string $cachePath, ?ContainerContract $container = null)
    {
        return new static($viewPath, $cachePath, $container);
    }
}
