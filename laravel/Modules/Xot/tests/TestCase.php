<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

/**
 * Class TestCase.
 *
 * Specific TestCase for Xot module, extending the generic XotBaseTestCase.
 */
abstract class TestCase extends XotBaseTestCase
{
    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Modules\Xot\Providers\XotServiceProvider::class,
        ];
    }
}
