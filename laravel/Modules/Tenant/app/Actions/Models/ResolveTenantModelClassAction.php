<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Models;

use Exception;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Nwidart\Modules\Facades\Module;
use Spatie\QueueableAction\QueueableAction;

class ResolveTenantModelClassAction
{
    use QueueableAction;

    public function execute(string $name): string
    {
        $name = Str::singular($name);
        $name = Str::snake($name);

        /** @var mixed $class */
        $class = app(ResolveTenantConfigValueAction::class)->execute('morph_map.'.$name);

        if ($class === null) {
            $models = $this->getAllModulesModels();
            if (! array_key_exists($name, $models)) {
                throw new Exception('model unknown ['.$name.']['.__LINE__.']['.basename(__FILE__).']');
            }

            $class = $models[$name];
            $data = [];
            $data[$name] = $class;

            // Persist morph_map for future calls
            // We purposely avoid calling TenantService here to keep Action self-contained.
            app(\Modules\Tenant\Actions\Config\SaveTenantConfigAction::class)->execute('morph_map', $data);
        }

        if (! \is_string($class)) {
            throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
        }

        return $class;
    }

    /**
     * @return array<string, class-string>
     */
    private function getAllModulesModels(): array
    {
        /** @var array<string, class-string> $models */
        $models = [];

        foreach (Module::allEnabled() as $module) {
            if (! is_object($module) || ! method_exists($module, 'getName')) {
                continue;
            }

            /** @var mixed $moduleName */
            $moduleName = $module->getName();
            if (! \is_string($moduleName)) {
                continue;
            }

            // Use action directly instead of helper function to avoid autoload issues during package:discover
            /** @var \Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction $action */
            $action = app(\Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction::class);
            $moduleModels = $action->execute($moduleName);

            foreach ($moduleModels as $key => $fqcn) {
                if (! \is_string($key) || ! \is_string($fqcn)) {
                    continue;
                }

                if (! class_exists($fqcn)) {
                    continue;
                }

                /** @var class-string $fqcnClass */
                $fqcnClass = $fqcn;
                $models[$key] = $fqcnClass;
            }
        }

        return $models;
    }
}
