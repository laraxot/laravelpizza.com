<?php

declare(strict_types=1);

namespace Modules\Xot\Support;

use Filament\Support\Colors\Color;

/**
 * Palette Design Comuni / PA per Filament (FO widget + pannelli admin).
 *
 * @see laravel/Themes/Sixteen/tailwind.config.js (primary verde, italia-blue)
 */
final class PaDesignColors
{
    /** Verde PA — azioni primarie, CTA istituzionali */
    public const PRIMARY_HEX = '#007A52';

    /** Blu istituzionale — info, link header */
    public const INSTITUTIONAL_BLUE_HEX = '#0066CC';

    /**
     * Colori Filament per tutti i panel che usano MetatagData / ApplyMetatagToPanelAction.
     *
     * @return array<string, array<int, string>|string>
     */
    public static function filamentPalette(): array
    {
        return [
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::hex(self::INSTITUTIONAL_BLUE_HEX),
            'primary' => Color::hex(self::PRIMARY_HEX),
            'success' => Color::Green,
            'warning' => Color::Orange,
        ];
    }
}
