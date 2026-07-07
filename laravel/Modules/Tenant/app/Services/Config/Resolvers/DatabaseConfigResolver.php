<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Illuminate\Support\Arr;
use Modules\Tenant\Services\Config\ConfigStringKeyFilter;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;

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
     *
     * @return array<string, mixed>
     */
    public function resolve(string $key, string|int|array|null $extraConf = null): float|int|string|array|null
    {
        if (! is_array($extraConf)) {
            return null;
        }

        if ($key !== 'database') {
            return null;
        }

        $originalConf = config('database');
        $originalConfTyped = is_array($originalConf)
            ? ConfigStringKeyFilter::onlyStringKeys($originalConf)
            : [];

        $default = $this->resolveDefaultConnection($extraConf, $originalConfTyped);

        return $this->addModuleConnections($extraConf, $default);
    }

    /**
     * @param  array<string, mixed>  $extraConf
     * @param  array<string, mixed>  $originalConf
     */
    private function resolveDefaultConnection(array $extraConf, array $originalConf): ?string
    {
        $default = Arr::get($extraConf, 'default') ?? Arr::get($originalConf, 'default') ?? config('database.default');

        return is_string($default) ? $default : null;
    }

    /**
     * @param  array<string, mixed>  $extraConf
     *
     * @return array<string, mixed>
     */
    private function addModuleConnections(array $extraConf, ?string $default): array
    {
        if ($default === null) {
            return $extraConf;
        }

        $connectionsRaw = Arr::get($extraConf, 'connections');

        if (! is_array($connectionsRaw)) {
            return $extraConf;
        }

        $connections = ConfigStringKeyFilter::onlyStringKeys($connectionsRaw);

        foreach (Module::getOrdered() as $module) {
            if (! $module instanceof LaravelModule) {
                continue;
            }

            $name = $module->getSnakeName();

            if (isset($connections[$name])) {
                continue;
            }

            $template = Arr::get($connections, $default);
            if ($template === null) {
                continue;
            }

            $connections[$name] = $template;
        }

        $extraConf['connections'] = $connections;

        return $extraConf;
    }
}
