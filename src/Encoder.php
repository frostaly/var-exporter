<?php

declare(strict_types=1);

namespace Frostaly\VarExporter;

use Frostaly\VarExporter\Contracts\EncoderInterface;
use Frostaly\VarExporter\Exception\CircularReferenceException;
use Frostaly\VarExporter\Exception\TypeNotSupportedException;
use WeakMap;

final class Encoder
{
    /**
     * @var WeakMap<object,array|int>
     */
    private WeakMap $encoded;

    /**
     * @param EncoderInterface[] $encoders
     */
    public function __construct(
        private array $encoders,
    ) {
        $this->encoded = new WeakMap();
    }

    /**
     * Encode the value to a formatted array of PHP code.
     */
    public function encode(mixed $value): array
    {
        return is_object($value)
            ? $this->encodeObject($value)
            : $this->tryEncode($value);
    }

    /**
     * Detect circular references and cache the encoded object.
     */
    private function encodeObject(object $object): array
    {
        if (!is_array($this->encoded[$object] ??= 0)) {
            if (is_int($this->encoded[$object]) && $this->encoded[$object]++) {
                throw new CircularReferenceException($object::class);
            }
            $this->encoded[$object] = $this->tryEncode($object);
        }
        return $this->encoded[$object]; /** @phpstan-ignore-line */
    }

    /**
     * Try encoding the value using the registered encoders.
     */
    private function tryEncode(mixed $value): array
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($value)) {
                return $encoder->encode($this, $value);
            }
        }
        throw new TypeNotSupportedException($value);
    }
}
