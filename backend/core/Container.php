<?php

namespace Core;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

class Container {

    // Contenedor de dependencias para inyeccion de dependencias y autowiring //
    private array $bindings = [];

    // Contenedor de instancias para singletons //
    private array $instances = [];

    // registra un binding de clase con una funcion de fabrica //
    public function bind(string $id, callable $factory): void {
        $this->bindings[$id] = $factory;
    }

    // registra una instancia concreta para un id //
    public function instance(string $id, object $instance): void {
        $this->instances[$id] = $instance;
    }

    // resuelve una clase, creando la instancia y resolviendo sus dependencias //
    public function make(string $class): object {

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

        // sin constructor -> instanciar directo //
        if ($constructor === null) {
            return $this->instances[$class] = new $class();
        }

        // resolver cada parametro del constructor //
        $dependencies = [];
        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            // parametro primitivo sin tipo de clase no se puede resolver automaticamente //
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                    continue;
                }
                throw new RuntimeException(
                    "No se puede resolver \${$param->getName()} en $class"
                );
            }

            // resolver la dependencia recursivamente //
            $dependencies[] = $this->make($type->getName());
        }

        return $this->instances[$class] = $reflection->newInstanceArgs($dependencies);
    }
}