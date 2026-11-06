<?php

declare(strict_types=1);

namespace Modules\Xot\Enums;


/**
 * Colori di marca del design system PA (valore backed = hex).
 *
 * Fonte unica dei due hex: la palette Filament e' costruita in
 * {@see \Modules\Xot\Actions\PaDesignColorsAction}, che resta il punto di riferimento
 * documentato (allineato a laravel/Themes/Sixteen/tailwind.config.js).
 */
enum PaDesignColorEnum: string
{
    /** Verde PA, azioni primarie e CTA istituzionali. */
    case Primary = '#007A52';

    /** Blu istituzionale, info e link header. */
    case InstitutionalBlue = '#0066CC';
}
