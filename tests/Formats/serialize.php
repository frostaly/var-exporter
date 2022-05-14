<?php

return Frostaly\VarExporter\Instantiator::unserialize(Frostaly\VarExporter\Tests\Fixtures\SerializableObject::class, [
    'foo' => 'Hello',
    'bar' => 'World',
]);
