<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Exception;

class NotInstantiableTypeException extends \Exception
{
    public function __construct(string $type, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf(
            'Type "%s" is not instantiable.',
            $type,
        ), 0, $previous);
    }
}
