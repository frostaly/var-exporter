<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Tests;

use Frostaly\VarExporter\Exception\NotInstantiableTypeException;
use Frostaly\VarExporter\Instantiator;
use Frostaly\VarExporter\Tests\Fixtures\DummyObject;
use Frostaly\VarExporter\Tests\Fixtures\SerializableObject;
use PHPUnit\Framework\TestCase;

class InstantiatorTest extends TestCase
{
    /**
     * @dataProvider provideNotInstantiable
     */
    public function testNotInstantiable(string $class): void
    {
        $this->expectException(NotInstantiableTypeException::class);
        Instantiator::instantiate($class);
    }

    public function testConstruct(): void
    {
        $object = Instantiator::construct(DummyObject::class, ['foo' => 'Hello', 'bar' => 'World']);
        $this->assertEquals(new DummyObject('Hello', 'World'), $object);
    }

    public function testUnserialize(): void
    {
        $object = Instantiator::unserialize(SerializableObject::class, ['foo' => 'Hello', 'bar' => 'World']);
        $this->assertEquals(new SerializableObject('Hello', 'World'), $object);
    }

    public function provideNotInstantiable(): iterable
    {
        yield ['¯\_(ツ)_/¯'];
        yield [\SplHeap::class];
        yield [\Closure::class];
    }
}
