<?php

declare(strict_types=1);

namespace Frostaly\VarExporter;

use Frostaly\VarExporter\Exception\NotInstantiableTypeException;

final class Instantiator
{
    /**
     * Create an object without invoking its constructor.
     */
    public static function instantiate(string $class): object
    {
        try {
            $reflector = new \ReflectionClass($class); // @phpstan-ignore-line
            return $reflector->newInstanceWithoutConstructor();
        } catch (\Throwable $exception) {
            throw new NotInstantiableTypeException($class, $exception);
        }
    }

    /**
     * Create an object with the given properties.
     */
    public static function construct(string $class, array $properties = [], array $privateProperties = []): object
    {
        $object = self::instantiate($class);
        self::hydrate($object, $properties, $object::class);
        foreach ($privateProperties as $scope => $properties) {
            self::hydrate($object, $properties, $scope);
        }
        return $object;
    }

    /**
     * Create an object using the __unserialize() method.
     */
    public static function unserialize(string $class, array $data = []): object
    {
        $object = self::instantiate($class);
        $object->__unserialize($data);
        return $object;
    }

    /**
     * Hydrate the object with the given properties.
     */
    private static function hydrate(object $object, array $properties, string $scope): void
    {
        (function (array $properties) use ($object) {
            foreach ($properties as $name => $value) {
                $object->{$name} = $value;
            }
        })->bindTo($object, $scope)($properties);
    }
}
