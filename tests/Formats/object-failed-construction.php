<?php

return Frostaly\VarExporter\Instantiator::construct(Frostaly\VarExporter\Tests\Fixtures\DummyObject::class, [
    'unset' => 'set',
    'foo' => 'Hello',
    'bar' => 'World',
]);
