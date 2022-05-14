<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Encoders;

use Frostaly\VarExporter\Contracts\EncoderInterface;
use Frostaly\VarExporter\Encoder;
use Frostaly\VarExporter\Instantiator;

class SerializeEncoder implements EncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $value): bool
    {
        return is_object($value)
            && method_exists($value, '__serialize')
            && method_exists($value, '__unserialize');
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     */
    public function encode(Encoder $encoder, mixed $object): array
    {
        return [
            Instantiator::class . '::unserialize(' . $object::class . '::class, ',
            ...$encoder->encode($object->__serialize()),
            ')',
        ];
    }
}
