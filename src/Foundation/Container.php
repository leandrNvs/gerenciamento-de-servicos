<?php

namespace Src\Foundation;

use Closure;
use ReflectionClass;
use ReflectionException;

class Container
{
    private array $services = [];

    private array $sharedServices = [];  

    private static $instance;

    public function register(string $serviceName, Closure|string|null $service = null, bool $shared = false): void
    {
        $service = $service ?? $serviceName;

        $this->services[$serviceName] = compact('service', 'shared');
    }

    public function singleton(string $serviceName, Closure|string|null $service = null): void 
    {
        $this->register($serviceName, $service, true);
    }

    public function instance(string $serviceName, mixed $instance): void 
    {
        $this->sharedServices[$serviceName] = $instance;
    }

    public function build(string $serviceName, array $parameters = []): mixed
    {
        if(($object = $this->sharedServices[$serviceName] ?? false)) {
            return $object;
        }

        $service = $this->getService($serviceName);

        $object = $service instanceof Closure
            ? $service($this, $parameters)
            : $this->resolve($service, $parameters);

        if($this->isShared($serviceName)) {
            $this->sharedServices[$serviceName] = $object;
        }

        return $object;
    }

    public function resolve(string $service, array $parameters = []): object
    {
        try {
            $reflection = new ReflectionClass($service);
        } catch(ReflectionException $e) {
            // TODO: not found exception
        }

        if(!$reflection->isInstantiable()) {
            // TODO: not instantiable exception;
        }

        if(!($construct = $reflection->getConstructor()) || !($dependencies = $construct->getParameters())) {
            return new $service; 
        }

        $dp = [];

        foreach($dependencies as $dependence) {
            if(($type = $dependence->getType()) && class_exists(($class = $type->getName()))) {
                $dp[] = $this->build($class);
            }
        }

        $dp = array_merge($dp, $parameters);

        return $reflection->newInstanceArgs($dp);
    }

    protected function getService(string $serviceName): Closure|string
    {
        return $this->services[$serviceName]['service'] ?? $serviceName;
    }

    protected function isShared(string $serviceName): bool
    {
        return $this->services[$serviceName]['shared'] ?? false;
    }

    protected static function setInstance(Container $container): void
    {
        static::$instance = $container; 
    }


    public static function getInstance(): static
    {
        return static::$instance;
    }
}

