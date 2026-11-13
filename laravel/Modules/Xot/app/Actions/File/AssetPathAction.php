<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Nwidart\Modules\Facades\Module;
use Spatie\QueueableAction\QueueableAction;

/**
 * Percorso su disco di un asset.
 *
 * - `Modulo::file` -> `Modules/<Modulo>/resources/<file>`
 * - percorso pubblico (`/themes/Trattoria/images/logo.svg`, anche con `?v=...`) -> file sotto la document root,
 *   cosi' i logo configurati come URL (metatag.logo_header) funzionano anche nelle email che li allegano.
 */
class AssetPathAction
{
    use QueueableAction;

    public function execute(string $asset): string
    {
        if (! str_contains($asset, '::')) {
            // Toglie query string e frammento (`logo.svg?v=2#x`).
            $path = strtok($asset, '?#');
            $path = \is_string($path) ? $path : '';

            return public_path(ltrim($path, '/'));
        }

        [$ns, $file] = explode('::', $asset, 2);
        $module_path = Module::getModulePath($ns).'resources';

        return $module_path.'/'.$file;
    }
}
