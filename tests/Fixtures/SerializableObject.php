<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Tests\Fixtures;

class SerializableObject extends DummyObject
{
    public function __serialize(): array
    {
        return [
            'foo' => $this->foo,
            'bar' => $this->bar,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->foo = $data['foo'];
        $this->bar = $data['bar'];
    }
}
