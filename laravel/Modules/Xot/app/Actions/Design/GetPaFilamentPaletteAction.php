<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Design;

use Modules\Xot\Actions\PaDesignColorsAction;
use Modules\Xot\Enums\PaDesignColorEnum;
use Spatie\QueueableAction\QueueableAction;

/**
 * Palette Design Comuni / PA per Filament (FO widget + pannelli admin).
 *
 * @see laravel/Themes/Sixteen/tailwind.config.js (primary verde, italia-blue)
 */
final class GetPaFilamentPaletteAction
{
    use QueueableAction;

    /** Verde PA — azioni primarie, CTA istituzionali */
    public const string PRIMARY_HEX = PaDesignColorEnum::Primary->value;

    /** Blu istituzionale — info, link header */
    public const string INSTITUTIONAL_BLUE_HEX = PaDesignColorEnum::InstitutionalBlue->value;

    /**
     * @return array<string, array<int, string>|string>
     */
    public function execute(): array
    {
        return app(PaDesignColorsAction::class)->filamentPalette();
    }
}
