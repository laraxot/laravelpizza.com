<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

/**
 * Sostituto di ResolveTenantConfigValueAction: restituisce la connessione di default e le connessioni
 * date piu' la connessione utente `user_<default>` in memoria (classe con nome, non anonima).
 */
final class TenantConfigValueResolverStub
{
    /**
     * @param  array<string, mixed>  $connections
     */
    public function __construct(private readonly string $default, private readonly array $connections) {}

    /**
     * @param  array<array-key, mixed>|int|string|null  $defaultValue
     * @return array<string, mixed>
     */
    public function execute(string $key, string|int|array|null $defaultValue = null): array
    {
        return [
            'default' => $this->default,
            'connections' => $this->connections + [
                'user_'.$this->default => ['driver' => 'sqlite', 'database' => ':memory:'],
            ],
        ];
    }
}
