<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Encoders;

use Frostaly\VarExporter\Contracts\EncoderInterface;
use Frostaly\VarExporter\Encoder;

class StdClassEncoder implements EncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $value): bool
    {
        return $value instanceof \stdClass;
    }

    /**
     * {@inheritDoc}
     *
     * @param \stdClass $object
     */
    public function encode(Encoder $encoder, mixed $object): array
    {
        return [
            '(object) ',
            ...$encoder->encode((array) $object),
        ];
    }
}
