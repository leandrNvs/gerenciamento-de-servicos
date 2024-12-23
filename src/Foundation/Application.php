<?php

namespace Src\Foundation;

use Src\Database\Database;
use Src\Database\Paginate;
use Src\Filesystem\Filesystem;
use Src\Http\Kernel;
use Src\Http\Request;
use Src\Routing\Routes;
use Src\Routing\RoutesUtilities;

class Application extends Container
{
    public function __construct(string $basePath)
    {
        session_start();

        $this->setBasePaths($basePath);
        $this->setBaseBindings();
        $this->createBaseDirectories();

        $this->build(ExceptionHandler::class)->listen();

        $this->build(Environment::class)->start(
            $this->build('root') . '/.env'
        );
    }

    private function setBasePaths($basePath): void
    {
        $this->instance('root', $basePath);
        $this->instance('cache', $basePath . '/cache/');
        $this->instance('views.base', $basePath . '/views/');
        $this->instance('views.cache', $basePath . '/cache/views/');
    }

    private function setBaseBindings(): void 
    {
        static::setInstance($this);

        $this->instance(Application::class, $this);
        $this->instance(Container::class, $this);

        $this->singleton(Routes::class);
        $this->singleton(RoutesUtilities::class);
        $this->singleton(Environment::class);
        $this->singleton(Kernel::class);
        $this->singleton(Request::class);
        $this->singleton(Database::class);
        $this->singleton(ExceptionHandler::class);

        $this->register(Paginate::class, function($app, $parameters) {
            return new Paginate(...$parameters);
        });
    }

    private function createBaseDirectories()
    {
        $filesystem = $this->build(Filesystem::class);

        $filesystem->mkdir($this->build('cache'));
        $filesystem->mkdir($this->build('views.base'));
        $filesystem->mkdir($this->build('views.cache'));
    }
}

