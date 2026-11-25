<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Concerns;

use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Modules\Rating\Contracts\RatingsFormCallerContract;
use Modules\Rating\Datas\RatingData;
use Modules\Rating\Models\Contracts\RatingContract;
use Modules\Rating\Models\Traits\HasRatingsTrait;

/**
 * Decorazione **standard** dei campi rating costruiti da {@see HasRatingsTrait}.
 *
 * Per page Filament che implementano {@see RatingsFormCallerContract}:
 * applica l'etichetta condivisa ({@see RatingData::formFieldLabel()}) a `Fieldset`
 * (criteri con figli) e a `Field` (input singoli). Non gestisce TextEntry/money né
 * ricalcoli — quelli restano dominio dell'host (story Rating/5.149, D-1 / 5.92).
 */
trait DecoratesRatingFormFields
{
    /**
     * Label + layout di default. L'host chiama questo dopo i rami particolari
     * (es. TextEntry denaro), oppure come corpo intero di `decorateRatingField` se
     * non ha eccezioni.
     */
    protected function applyDefaultRatingFieldDecoration(RatingContract $rating, Component $component): Component
    {
        $label = RatingData::formFieldLabel($rating);

        if ($component instanceof Fieldset) {
            return $component->label($label);
        }

        if ($component instanceof Field) {
            return $component
                ->label($label)
                ->columns(2)
                ->helperText('');
        }

        return $component;
    }
}
