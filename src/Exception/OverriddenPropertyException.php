<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Exception;

class OverriddenPropertyException extends \Exception
{
    public function __construct(string $class, string $property, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf(
            'Class "%s" has overridden private property "%s".',
            $class,
            $property,
        ), 0, $previous);
    }
}
