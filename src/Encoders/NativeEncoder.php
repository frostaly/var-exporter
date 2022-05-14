<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Encoders;

use Frostaly\VarExporter\Contracts\EncoderInterface;
use Frostaly\VarExporter\Encoder;

class NativeEncoder implements EncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $value): bool
    {
        return in_array(gettype($value), [
            'boolean',
            'integer',
            'double',
            'string',
            'NULL',
        ]) || $value instanceof \UnitEnum;
    }

    /**
     * {@inheritDoc}
     */
    public function encode(Encoder $encoder, mixed $value): array
    {
        return [$value === null ? 'null' : var_export($value, true)];
    }
}
