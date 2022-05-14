<?php

return Frostaly\VarExporter\Instantiator::construct(Frostaly\VarExporter\Tests\Fixtures\DummyObject::class, [
    'foo' => 'Hello',
    'bar' => 'World',
], [
    'Frostaly\\VarExporter\\Tests\\Fixtures\\AbstractDummy' => [
        'scope' => 'new',
    ],
]);
