<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Nwidart\Modules\Facades\Module;

/**
 * Resolves database configuration with module-specific connections.
 */
class DatabaseConfigResolver implements ConfigResolverInterface
{
    public function canResolve(string $key): bool
    {
        return $key === 'database';
    }

    /**
     * @param  array<string, mixed>  $extraConf
     * @return array<string, mixed>
     */
    public function resolve(string $key, string|int|array|null $extraConf = null): float|int|string|array|null
    {
        if (! is_array($extraConf)) {
            return null;
        }

        $originalConf = config('database');
        if (! is_array($originalConf)) {
            $originalConf = [];
        }

        /** @var array<string, mixed> $originalConfTyped */
        $originalConfTyped = [];
        foreach ($originalConf as $key => $value) {
            if (is_string($key)) {
                $originalConfTyped[$key] = $value;
            }
        }

        $default = $this->resolveDefaultConnection($extraConf, $originalConfTyped);

        return $this->addModuleConnections($extraConf, $default);
    }

    /**
     * @param  array<string, mixed>  $extraConf
     * @param  array<string, mixed>  $originalConf
     */
    private function resolveDefaultConnection(array $extraConf, array $originalConf): ?string
    {
        $default = Arr::get($extraConf, 'default');

        if ($default === null) {
            $default = Arr::get($originalConf, 'default');
        }

        if ($default === null) {
            $default = config('database.default');
        }

        return is_string($default) ? $default : null;
    }

    /**
     * @param  array<string, mixed>  $extraConf
     * @return array<string, mixed>
     */
    private function addModuleConnections(array $extraConf, ?string $default): array
    {
        if ($default === null) {
            return $extraConf;
        }

        /** @var Collection<\Nwidart\Modules\Module> */
        $modules = Module::toCollection();

        foreach ($modules as $module) {
            $name = $module->getSnakeName();

            if (! isset($extraConf['connections']) || ! is_array($extraConf['connections'])) {
                continue;
            }

            if (isset($extraConf['connections'][$name])) {
                continue;
            }

            if (! isset($extraConf['connections'][$default])) {
                continue;
            }

            $extraConf['connections'][$name] = $extraConf['connections'][$default];
        }

        return $extraConf;
    }
}
