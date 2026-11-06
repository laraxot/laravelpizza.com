<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Modules\Xot\Enums\PaDesignColorEnum;
use Spatie\QueueableAction\QueueableAction;

/**
 * Colori del design system PA (verde istituzionale, blu istituzionale) e
 * palette Filament corrispondente.
 *
 * @example
 * $palette = app(PaDesignColorsAction::class)->execute();
 * $filamentColors = app(PaDesignColorsAction::class)->filamentPalette();
 */
final class PaDesignColorsAction
{
    use QueueableAction;

    public const string PRIMARY_HEX = PaDesignColorEnum::Primary->value;

    public const string INSTITUTIONAL_BLUE_HEX = PaDesignColorEnum::InstitutionalBlue->value;

    /**
     * @return array{primary: string, institutional_blue: string, danger: string, gray: string, info: string, success: string, warning: string}
     */
    public function execute(): array
    {
        return [
            'primary' => PaDesignColorEnum::Primary->value,
            'institutional_blue' => PaDesignColorEnum::InstitutionalBlue->value,
            'danger' => 'red',
            'gray' => 'zinc',
            'info' => 'blue',
            'success' => 'green',
            'warning' => 'orange',
        ];
    }

    /**
     * Colori Filament per il panel UI.
     *
     * @return array<string, array<int, string>>
     */
    public function filamentPalette(): array
    {
        return [
            'danger' => \Filament\Support\Colors\Color::Red,
            'gray' => \Filament\Support\Colors\Color::Zinc,
            'info' => \Filament\Support\Colors\Color::hex(self::INSTITUTIONAL_BLUE_HEX),
            'primary' => \Filament\Support\Colors\Color::hex(self::PRIMARY_HEX),
            'success' => \Filament\Support\Colors\Color::Green,
            'warning' => \Filament\Support\Colors\Color::Orange,
        ];
    }
}
