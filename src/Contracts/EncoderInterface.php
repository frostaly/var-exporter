<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Contracts;

use Frostaly\VarExporter\Encoder;

interface EncoderInterface
{
    /**
     * Check whether the encoder supports the given value.
     */
    public function supports(mixed $value): bool;

    /**
     * Encode the value to a formatted PHP code array.
     */
    public function encode(Encoder $encoder, mixed $value): array;
}
