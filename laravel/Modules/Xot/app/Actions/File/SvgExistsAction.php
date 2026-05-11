<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Support\Facades\App;

/**
 * Verifica l'esistenza di un SVG registrato utilizzando BladeUI Icons.
 *
 * @method bool execute(string $svgName)
 */
class SvgExistsAction
{
    /**
     * Verifica se l'SVG esiste nei set di icone registrati.
     *
     * @param string $svgName Il nome dell'SVG da verificare (es: 'heroicon-o-user')
     *
     * @return bool true se l'SVG esiste, false altrimenti
     */
    public function execute(string $svgName): bool
    {
        if (empty($svgName)) {
            return false;
        }

        // BladeUI Kit icon check: only for standard sets (heroicon-*, etc.)
        // Geo SVGs use "geo-" prefix (e.g., "geo-magnifying-glass") — served via <img> or Lit JS, not BladeUI Kit
        if (str_starts_with($svgName, 'geo-')) {
            // Geo SVGs are in Modules/Geo/resources/svg/ — check file existence directly
            $relativePath = str_replace('geo-', '', $svgName);
            $svgPath = base_path('Modules/Geo/resources/svg/'.$relativePath.'.svg');

            return file_exists($svgPath);
        }

        /** @var IconFactory $iconsFactory */
        $iconsFactory = App::make(IconFactory::class);
        try {
            $iconsFactory->svg($svgName);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
