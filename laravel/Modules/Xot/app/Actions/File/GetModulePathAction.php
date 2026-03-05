<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

use function Safe\scandir;

use Spatie\QueueableAction\QueueableAction;

class GetModulePathAction
{
    use QueueableAction;

    /**
     * Ottiene il percorso di un modulo.
     *
     * @param string $moduleName Il nome del modulo
     *
     * @return string Il percorso completo del modulo
     */
    public function execute(string $moduleName): string
    {
        try {
            $module_path = Module::getModulePath($moduleName);
        } catch (\Exception) {
            $modulesPath = base_path('Modules');
            if (! File::exists($modulesPath)) {
                return __DIR__.'/../';
            }

            $files = scandir($modulesPath);
            $moduleNameLower = Str::lower($moduleName);

            $foundModule = collect($files)->filter(static function ($item) use ($moduleNameLower): bool {
                if (! is_string($item)) {
                    return false;
                }

                return Str::lower($item) === $moduleNameLower;
            })->first();

            // Se non troviamo il modulo, restituiamo un percorso di fallback
            if (null === $foundModule || ! is_string($foundModule)) {
                return base_path('Modules/'.$moduleName);
            }

            $module_path = base_path('Modules/'.$foundModule);
        }

        return $module_path;
    }
}
