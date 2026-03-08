<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Modules\Xot\Services\RouteService;

/**
 * Resolves morph_map configuration for admin panel.
 */
class MorphMapConfigResolver implements ConfigResolverInterface
{
    public function canResolve(string $key): bool
    {
        return RouteService::inAdmin()
            && Str::startsWith($key, 'morph_map')
            && Request::segment(2) !== null;
    }

    public function resolve(string $key, string|int|array|null $default = null): float|int|string|array|null
    {
        $moduleName = Request::segment(2);
        if (! is_string($moduleName)) {
            throw new Exception('Invalid module name from request segment');
        }

        // Use action directly instead of helper function to avoid autoload issues during package:discover
        /** @var GetAllModelsByModuleNameAction $action */
        $action = app(GetAllModelsByModuleNameAction::class);
        /** @var array<string, class-string> $models */
        $models = $action->execute($moduleName);
        $originalConf = // @var mixed getOriginalConfig(;
        $tenantConf = // @var mixed getTenantConfig(;

        // Use array_merge to avoid PHPStan type issues with Collection::merge()
        /** @var array<string, mixed> $mergedConf */
        $mergedConf = array_merge($models, $originalConf, $tenantConf);

        Config::set('morph_map', $mergedConf);

        $result = config($key);

        if (! is_numeric($result) && ! is_string($result) && ! is_array($result)) {
            throw new Exception('Invalid morph_map configuration type');
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    private function getOriginalConfig(): array
    {
        $config = config('morph_map');
        if (! is_array($config)) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = [];
        foreach ($config as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    private function getTenantConfig(): array
    {
        $path = TenantService::filePath('morph_map.php');

        if (! File::exists($path)) {
            return [];
        }

        $config = File::getRequire($path);
        if (! is_array($config)) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = [];
        foreach ($config as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
