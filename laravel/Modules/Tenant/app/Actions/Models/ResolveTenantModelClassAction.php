<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Models;

use Exception;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;
use Spatie\QueueableAction\QueueableAction;

class ResolveTenantModelClassAction
{
    use QueueableAction;

    public function execute(string $name): string
    {
        $name = Str::snake(Str::singular($name));

        $class = app(ResolveTenantConfigValueAction::class)->execute('morph_map.'.$name);

        if ($class === null) {
            $class = $this->resolveAndPersistModelClass($name);
        }

        if (! \is_string($class)) {
            throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
        }

        return $class;
    }

    private function resolveAndPersistModelClass(string $name): string
    {
        $models = $this->getAllModulesModels();
        if (! array_key_exists($name, $models)) {
            throw new Exception('model unknown ['.$name.']['.__LINE__.']['.basename(__FILE__).']');
        }

        app(SaveTenantConfigAction::class)->execute('morph_map', [$name => $models[$name]]);

        return $models[$name];
    }

    /**
     * @return array<string, class-string>
     */
    private function getAllModulesModels(): array
    {
        /** @var array<string, class-string> $models */
        $models = [];

        foreach (Module::allEnabled() as $module) {
            if (! $module instanceof LaravelModule) {
                continue;
            }

            $models = array_merge($models, $this->modelsFromModule($module));
        }

        return $models;
    }

    /**
     * @return array<string, class-string>
     */
    private function modelsFromModule(LaravelModule $module): array
    {
        $moduleName = $module->getName();

        /** @var GetAllModelsByModuleNameAction $action */
        $action = app(GetAllModelsByModuleNameAction::class);
        /** @var array<string, class-string> $moduleModels */
        $moduleModels = $action->execute($moduleName);

        return $this->filterValidModelClasses($moduleModels);
    }

    /**
     * @param  array<string, class-string>  $moduleModels
     * @return array<string, class-string>
     */
    private function filterValidModelClasses(array $moduleModels): array
    {
        /** @var array<string, class-string> $models */
        $models = [];

        foreach ($moduleModels as $key => $fqcn) {
            if (! \is_string($key) || ! \is_string($fqcn) || ! class_exists($fqcn)) {
                continue;
            }

            /** @var class-string $fqcnClass */
            $fqcnClass = $fqcn;
            $models[$key] = $fqcnClass;
        }

        return $models;
    }
}
