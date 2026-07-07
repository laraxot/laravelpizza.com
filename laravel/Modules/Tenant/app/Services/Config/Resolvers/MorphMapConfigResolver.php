<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Modules\Tenant\Services\Config\ConfigStringKeyFilter;
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

        /** @var GetAllModelsByModuleNameAction $action */
        $action = app(GetAllModelsByModuleNameAction::class);
        /** @var array<string, class-string> $models */
        $models = $action->execute($moduleName);

        /** @var array<string, mixed> $mergedConf */
        $mergedConf = array_merge($models, $this->getOriginalConfig(), $this->getTenantConfig());

        Config::set('morph_map', $mergedConf);

        $result = $this->fetchValidatedMorphMap($key);

        if ($result === null) {
            return $default;
        }

        return $result;
    }

    /**
     * @return float|int|string|array<mixed>|null
     */
    private function fetchValidatedMorphMap(string $key): float|int|string|array|null
    {
        $result = config($key);

        if ($result === null) {
            return null;
        }

        if (is_array($result)) {
            return $result;
        }

        if (is_numeric($result)) {
            return $result;
        }

        if (is_string($result)) {
            return $result;
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    private function getOriginalConfig(): array
    {
        $config = config('morph_map');

        return is_array($config) ? ConfigStringKeyFilter::onlyStringKeys($config) : [];
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

        return is_array($config) ? ConfigStringKeyFilter::onlyStringKeys($config) : [];
    }
}
