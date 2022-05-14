<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Encoders;

use Frostaly\VarExporter\Contracts\EncoderInterface;
use Frostaly\VarExporter\Encoder;
use Frostaly\VarExporter\Exception\OverriddenPropertyException;

class SetStateEncoder implements EncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $value): bool
    {
        return is_object($value)
            && method_exists($value, '__set_state');
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     */
    public function encode(Encoder $encoder, mixed $object): array
    {
        return [
            $object::class . '::__set_state(',
            ...$encoder->encode($this->extract($object)),
            ')',
        ];
    }

    /**
     * Extract object properties as an associative array.
     */
    protected static function extract(object $object): array
    {
        $properties = (array) $object;
        foreach ($properties as $key => $value) {
            if (is_int($pos = strrpos((string) $key, "\0"))) {
                $name = substr((string) $key, $pos + 1);
                if (array_key_exists($name, $properties)) {
                    throw new OverriddenPropertyException($object::class, $name);
                }
                $properties[$name] = $value;
                unset($properties[$key]);
            }
        }
        return $properties;
    }
}
