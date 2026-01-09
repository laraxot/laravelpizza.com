<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use BladeUI\Icons\Factory as IconFactory;
use Exception;
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
     * @param  string  $svgName  Il nome dell'SVG da verificare (es: 'heroicon-o-user')
     *
     * @return bool true se l'SVG esiste, false altrimenti
     */
    public function execute(string $svgName): bool
    {
        if (empty($svgName)) {
            return false;
        }

        /** @var IconFactory $iconsFactory */
        $iconsFactory = App::make(IconFactory::class);
        try {
            $iconsFactory->svg($svgName);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
