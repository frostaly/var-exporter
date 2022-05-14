<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Exception;

class CircularReferenceException extends \Exception
{
    public function __construct(string $class, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf(
            'Object "%s" has a circular reference.',
            $class
        ), 0, $previous);
    }
}
