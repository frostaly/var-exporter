<?php

declare(strict_types=1);

namespace Frostaly\VarExporter\Tests\Fixtures;

abstract class AbstractDummy
{
    public mixed $unset;
    private string $scope = 'current'; // @phpstan-ignore-line

    public function __construct(
        protected mixed $foo,
        protected mixed $bar,
        ?string $scope = null,
    ) {
        if (isset($scope)) {
            $this->scope = $scope;
        }
    }
}
