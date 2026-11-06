<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Module;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Exceptions\ModuleNotFoundException;

class GetModulePathByGeneratorAction
{
    public function execute(string $moduleName, string $generatorPath): string
    {
        $relativePath = Config::string('modules.paths.generator.'.$generatorPath.'.path');
        try {
            return module_path($moduleName, $relativePath);
        } catch (ModuleNotFoundException $exception) {
            $fullPath = base_path('Modules/'.$moduleName).'/'.$relativePath;
            if (File::exists($fullPath)) {
                return $fullPath;
            }

            throw new \RuntimeException('Module path not found: name:['.$moduleName.'] generatorPath:['.$generatorPath.'] relativePath:['.$relativePath.']', 0, $exception);
        }
    }
}
