<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Tests\Fixtures;

class DummyObject extends AbstractDummy
{
    public function __construct(
        mixed $foo,
        mixed $bar,
        ?string $newScope = null,
        mixed $changeUnset = null,
    ) {
        parent::__construct($foo, $bar, $newScope);
        if ($changeUnset) {
            $this->unset = $changeUnset;
        }
    }
}
