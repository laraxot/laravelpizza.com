<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Module;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class GetModulePathByGeneratorAction
{
    public function execute(string $moduleName, string $generatorPath): string
    {
        $relativePath = Config::string('modules.paths.generator.'.$generatorPath.'.path');
        try {
            $res = module_path($moduleName, $relativePath);
            if ('' !== $res) {
                return $res;
            }
        } catch (\Exception|\Error $e) {
            // Fallback: costruisci path manualmente per graceful degradation
            $modulePath = base_path('Modules/'.$moduleName);
            $fullPath = $modulePath.'/'.$relativePath;

            if (File::exists($fullPath)) {
                return $fullPath;
            }

            // Se path non esiste e non è opzionale, lancia eccezione
            throw new \Exception('Module path not found: 
            name:['.$moduleName.'] 
            generatorPath:['.$generatorPath.']
            relativePath:['.$relativePath.']
            error_message:['.$e->getMessage().']');
        }

        throw new \Exception('Module path not found: 
        name:['.$moduleName.'] 
        generatorPath:['.$generatorPath.']
        relativePath:['.$relativePath.']');
    }
}
