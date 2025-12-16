<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Module;

use Error;
use Exception;
use Illuminate\Support\Facades\Config;

class GetModulePathByGeneratorAction
{
    public function execute(string $moduleName, string $generatorPath): string
    {
        $relativePath = Config::string('modules.paths.generator.'.$generatorPath.'.path');
        try {
            $res = module_path($moduleName, $relativePath);
        } catch (Exception|Error $e) {
            throw new Exception('Module path not found: 
            name:['.
            $moduleName.
            '] 
            generatorPath:['.
            $generatorPath.
            ']
            error_message:['.
            $e->getMessage().
                ']');
        }

        return $res;
    }
}
