<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Exception;

class TypeNotSupportedException extends \Exception
{
    public function __construct(mixed $value, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf(
            'Value type "%s" is not supported.',
            is_object($value) ? $value::class : gettype($value),
        ), 0, $previous);
    }
}
