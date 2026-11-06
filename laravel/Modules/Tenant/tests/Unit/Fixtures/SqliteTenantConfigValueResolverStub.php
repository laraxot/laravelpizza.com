<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

/**
 * Sostituto di ResolveTenantConfigValueAction con configurazione sqlite fissa (classe con nome, non anonima).
 */
final class SqliteTenantConfigValueResolverStub
{
    /**
     * @param  array<array-key, mixed>|int|string|null  $defaultValue
     * @return array<string, mixed>
     */
    public function execute(string $key, string|int|array|null $defaultValue = null): array
    {
        return [
            'default' => 'sqlite',
            'connections' => [
                'sqlite' => ['driver' => 'sqlite'],
                'user_sqlite' => ['driver' => 'sqlite', 'database' => ':memory:'],
            ],
        ];
    }
}
