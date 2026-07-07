<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Exception;
use Illuminate\Support\Facades\Config;
use Modules\Tenant\Services\Config\ConfigStringKeyFilter;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;

/**
 * Resolves standard tenant configuration by merging original and tenant-specific configs.
 */
class StandardConfigResolver implements ConfigResolverInterface
{
    public function canResolve(string $key): bool
    {
        return $key !== '';
    }

    /**
     * @param  string|int|array<mixed>|null  $default
     * @return float|int|string|array<mixed>|null
     */
    public function resolve(string $key, string|int|array|null $default = null): float|int|string|array|null
    {
        $group = $this->extractGroup($key);
        $mergedConf = $this->buildMergedConfig($key, $group);

        Config::set($group, $mergedConf);

        return $this->fetchValidatedConfig($key, $default);
    }

    /**
     * @return array<string, mixed>
     */
    private function buildMergedConfig(string $key, string $group): array
    {
        $originalConf = $this->getOriginalConfig($group);
        $extraConf = $this->getTenantConfig($group);

        if ($key === 'database') {
            $extraConf = $this->resolveDatabaseExtraConfig($extraConf);
        }

        return collect($originalConf)->merge($extraConf)->all();
    }

    /**
     * @param  array<string, mixed>  $extraConf
     * @return array<string, mixed>
     */
    private function resolveDatabaseExtraConfig(array $extraConf): array
    {
        $databaseResolver = new DatabaseConfigResolver;
        $resolved = $databaseResolver->resolve('database', $extraConf);

        if (! is_array($resolved)) {
            return [];
        }

        return $resolved;
    }

    /**
     * @param  string|int|array<mixed>|null  $default
     * @return float|int|string|array<mixed>|null
     */
    private function fetchValidatedConfig(string $key, string|int|array|null $default): float|int|string|array|null
    {
        $result = config($key);

        if ($result === null && $default !== null) {
            $this->handleMissingConfig($key);
        }

        if (! is_numeric($result) && ! is_string($result) && ! is_array($result) && $result !== null) {
            throw new Exception('Invalid configuration type for key: '.$key);
        }

        return $result;
    }

    private function extractGroup(string $key): string
    {
        $group = collect(explode('.', $key))->first();

        if ($group === null) {
            throw new Exception('Invalid configuration key: '.$key);
        }

        return $group;
    }

    /**
     * @return array<string, mixed>
     */
    private function getOriginalConfig(string $group): array
    {
        $config = config($group);

        return is_array($config) ? ConfigStringKeyFilter::onlyStringKeys($config) : [];
    }

    /**
     * @return array<string, mixed>
     */
    private function getTenantConfig(string $group): array
    {
        $tenantName = TenantService::getName();
        $configName = str_replace('/', '.', $tenantName).'.'.$group;
        $config = config($configName);

        return is_array($config) ? ConfigStringKeyFilter::onlyStringKeys($config) : [];
    }

    private function handleMissingConfig(string $key): void
    {
        throw new Exception('Configuration key not found: '.$key);
    }
}
