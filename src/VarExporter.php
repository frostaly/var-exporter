<?php

declare(strict_types=1);

namespace Frostaly\VarExporter;

use Frostaly\VarExporter\Contracts\EncoderInterface;

/**
 * Generate PHP code from variables.
 *
 * VarExporter is an alternative to var_export() with more features.
 *
 * By leveraging OPcache, the generated PHP code is faster than doing the same with unserialize().
 */
final class VarExporter
{
    /**
     * Export the given value to PHP code.
     *
     * @param mixed $value The variable to export.
     * @param int $indent The indentation level.
     * @param EncoderInterface[] $encoders The registered encoders.
     */
    public static function export(mixed $value, int $indent = 0, ?array $encoders = null): string
    {
        $encoder = new Encoder($encoders ?? [
            new Encoders\ArrayEncoder(),
            new Encoders\NativeEncoder(),
            new Encoders\StdClassEncoder(),
            new Encoders\SetStateEncoder(),
            new Encoders\SerializeEncoder(),
            new Encoders\ObjectEncoder(),
        ]);

        return self::formatLine($encoder->encode($value), $indent);
    }

    /**
     * Iteratively reduce line segments to a string.
     */
    private static function formatLine(array $segments, int $depth): string
    {
        $code = '';
        foreach ($segments as $segment) {
            $code .= is_array($segment)
                ? self::formatLines($segment, $depth)
                : $segment;
        }
        return $code;
    }

    /**
     * Iteratively reduce multiple lines to a string.
     */
    private static function formatLines(array $lines, int $depth): string
    {
        $code = '';
        $newLine = PHP_EOL . str_repeat('    ', ++$depth);
        foreach ($lines as $segments) {
            $code .= $newLine . self::formatLine($segments, $depth);
        }
        return $code . PHP_EOL . str_repeat('    ', --$depth);
    }
}
