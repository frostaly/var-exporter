<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Encoders;

use Frostaly\VarExporter\Contracts\EncoderInterface;
use Frostaly\VarExporter\Encoder;

class ArrayEncoder implements EncoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports(mixed $value): bool
    {
        return is_array($value) || $value instanceof \ArrayAccess;
    }

    /**
     * {@inheritDoc}
     *
     * @param array|\ArrayAccess $value
     */
    public function encode(Encoder $encoder, mixed $value): array
    {
        $array = (array) $value;
        $omitKey = array_is_list($array);

        foreach ($array as $key => $value) {
            $encoded[] = [...$encoder->encode($value), ','];
            $omitKey ?: array_unshift(
                $encoded[array_key_last($encoded)],
                var_export($key, true) . ' => ',
            );
        }
        return isset($encoded) ? ['[', $encoded, ']'] : ['[]'];
    }
}
