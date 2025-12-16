<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Contracts;

/**
 * Interface for configuration resolvers.
 */
interface ConfigResolverInterface
{
    /**
     * Check if this resolver can handle the given configuration key.
     */
    public function canResolve(string $key): bool;

    /**
     * Resolve the configuration value for the given key.
     *
     * @return float|int|string|array<mixed>|null
     */
    public function resolve(string $key, string|int|array|null $default = null): float|int|string|array|null;
}
