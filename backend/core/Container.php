<?php

namespace Core;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

class Container{
    /** @var array<string, callable> */
    private array $bindings = [];

    /** @var array<string, object> */
    private array $instances = [];

    
    public function bind(string $id, callable $factory): void
    {
        $this->bindings[$id] = $factory;
    }

   
    public function instance(string $id, object $instancia): void
    {
        $this->instances[$id] = $instancia;
    }

    
    public function make(string $class): object
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        
        if (isset($this->bindings[$class])) {
            return $this->instances[$class] = ($this->bindings[$class])($this);
        }

        
        if (!class_exists($class)) {
            throw new RuntimeException("Clase no encontrada: $class");
        }

        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new RuntimeException("No se puede instanciar: $class");
        }

        $constructor = $reflection->getConstructor();

      
        if ($constructor === null) {
            return $this->instances[$class] = new $class();
        }

      
        $dependencias = [];
        foreach ($constructor->getParameters() as $param) {
            $tipo = $param->getType();

           
            if (!$tipo instanceof ReflectionNamedType || $tipo->isBuiltin()) {
                if ($param->isDefaultValueAvailable()) {
                    $dependencias[] = $param->getDefaultValue();
                    continue;
                }
                throw new RuntimeException(
                    "No se puede resolver \${$param->getName()} en $class"
                );
            }

            $dependencias[] = $this->make($tipo->getName());
        }

        return $this->instances[$class] = $reflection->newInstanceArgs($dependencias);
    }
}