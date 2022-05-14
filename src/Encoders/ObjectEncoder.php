<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Encoders;

use Frostaly\VarExporter\Contracts\EncoderInterface;
use Frostaly\VarExporter\Encoder;
use Frostaly\VarExporter\Instantiator;

class ObjectEncoder implements EncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $value): bool
    {
        if (!is_object($value)) {
            return false;
        }
        $reflector = new \ReflectionClass($value);
        return !$reflector->isInternal() || !$reflector->isFinal();
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     */
    public function encode(Encoder $encoder, mixed $object): array
    {
        [$properties, $privateProperties] = $this->extract($object);

        return $this->isInstantiable($object, $properties)
            ? $this->encodeConstructor($encoder, $object, $properties)
            : $this->encodeInstantiator($encoder, $object, $properties, $privateProperties);
    }

    /**
     * Check whether the object can be instantiated with the given parameters.
     */
    protected function isInstantiable(object $object, array $parameters): bool
    {
        try {
            return $object == new ($object::class)(...$parameters);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Create the object using named parameters.
     */
    protected function encodeConstructor(
        Encoder $encoder,
        object $object,
        array $parameters,
    ): array {
        $encoded = [];
        foreach ($parameters as $name => $value) {
            $encoded[] = [$name . ': ', ...$encoder->encode($value), ','];
        }
        return ['new ' . $object::class . '(', $encoded, ')'];
    }

    /**
     * Delegate the creation of the object to the Instantiator class.
     */
    protected function encodeInstantiator(
        Encoder $encoder,
        object $object,
        array $properties,
        array $privateProperties,
    ): array {
        $encoded = [Instantiator::class . '::construct(' . $object::class . '::class'];
        empty($properties)
            ?: $encoded = [...$encoded, ', ', ...$encoder->encode($properties)];
        empty($privateProperties)
            ?: $encoded = [...$encoded, ', ', ...$encoder->encode($privateProperties)];
        return [...$encoded, ')'];
    }

    /**
     * Extract the object state as an associative array.
     */
    protected function extract(object $object): array
    {
        $values = (array) $object;
        $defaultValues = (array) Instantiator::instantiate($object::class);

        foreach ($values as $name => $value) {
            $hasDefault = array_key_exists($name, $defaultValues);
            if (!$hasDefault || $defaultValues[$name] !== $value) {
                preg_match('/^(?:\x00(.*)\x00)?(.*)$/', (string) $name, $matches);
                in_array($matches[1], ['', '*', $object::class])
                    ? $properties[$matches[2]] = $value
                    : $privateProperties[$matches[1]][$matches[2]] = $value;
            }
        }
        return [$properties ?? [], $privateProperties ?? []];
    }
}
