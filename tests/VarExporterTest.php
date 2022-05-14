<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Tests;

use Frostaly\VarExporter\Exception\CircularReferenceException;
use Frostaly\VarExporter\Exception\OverriddenPropertyException;
use Frostaly\VarExporter\Exception\TypeNotSupportedException;
use Frostaly\VarExporter\Tests\Fixtures\DummyEnum;
use Frostaly\VarExporter\Tests\Fixtures\DummyObject;
use Frostaly\VarExporter\Tests\Fixtures\OverridenProperty;
use Frostaly\VarExporter\Tests\Fixtures\SerializableObject;
use Frostaly\VarExporter\Tests\Fixtures\SetStateObject;
use Frostaly\VarExporter\VarExporter;
use PHPUnit\Framework\TestCase;

class VarExporterTest extends TestCase
{
    /**
     * @dataProvider provideExport
     */
    public function testExport(string $template, mixed $value): void
    {
        $format = __DIR__ . '/Formats/' . $template . '.php';
        $exported = "<?php\n\nreturn " . VarExporter::export($value) . ";\n";
        $this->assertStringEqualsFile($format, $exported);
        $this->assertEquals($value, include $format);
    }

    public function testTypeNotSupported(): void
    {
        $this->expectException(TypeNotSupportedException::class);
        VarExporter::export(opendir('./'));
    }

    public function testOverriddenProperty(): void
    {
        $this->expectException(OverriddenPropertyException::class);
        VarExporter::export(new OverridenProperty('Hello', 'World'));
    }

    public function testCircularReference(): void
    {
        $this->expectException(CircularReferenceException::class);
        $foo = (object) [];
        $bar = (object) [];
        $foo->bar = $bar;
        $bar->foo = $foo;
        VarExporter::export($foo);
    }

    public function provideExport(): iterable
    {
        yield ['string', 'frostaly'];
        yield ['double', 3.14];
        yield ['integer', 42];
        yield ['null', null];
        yield ['bool-true', true];
        yield ['bool-false', false];
        yield ['array-empty', []];
        yield ['array-assoc', ['foo' => 'Hello', 'bar' => 'World']];
        yield ['array-list', [0, ['foo', 'bar']]];
        yield ['array-mix', ['foo' => 'bar', 'baz' => [4, 2]]];
        yield ['enum', DummyEnum::Frostaly];
        yield ['stdclass', (object) ['foo' => 'bar']];
        yield ['setstate', new SetStateObject('Hello', 'World')];
        yield ['serialize', new SerializableObject('Hello', 'World')];
        yield ['object-constructor', new DummyObject('Hello', 'World')];
        yield ['object-instantiator', new DummyObject('Hello', 'World', 'new')];
        yield ['object-failed-construction', new DummyObject('Hello', 'World', changeUnset: 'set')];
    }
}
