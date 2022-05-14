<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Tests\Fixtures;

class SetStateObject extends AbstractDummy
{
    public static function __set_state(array $properties): self
    {
        return new self(...$properties);
    }
}
