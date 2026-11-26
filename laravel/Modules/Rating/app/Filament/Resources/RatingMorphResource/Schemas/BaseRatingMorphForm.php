<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingMorphResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form rating morph condiviso tra i moduli che estendono BaseRatingMorphResource.
 *
 * Stessa coppia Base/concrete di {@see BaseRatingForm}: la base porta lo schema,
 * i figli concreti nei moduli sono gusci vuoti e lo sovrascrivono solo se l'UI
 * differisce davvero.
 *
 * Le chiavi polimorfe (`model_type`/`model_id`, `user_id`) restano fuori: si
 * scrivono dal contesto che crea la valutazione, non a mano da un form.
 *
 * `percentage` e' fuori per lo stesso motivo: la colonna e' calcolata (vedi
 * `HasRating::getRatingsPercentageBy*`), non e' in `$fillable` e nessun codice la scrive,
 * quindi un input nel form veniva scartato in silenzio al salvataggio.
 *
 * @see Modules/Rating/docs/wiki/concepts/xotbase-table-columns-enforcement.md
 */
abstract class BaseRatingMorphForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     *
     * @see Modules/Rating/docs/wiki/concepts/xotbase-table-columns-enforcement.md
     */
    public function getFormSchema(): array
    {
        return [
            'rating_id' => Select::make('rating_id')
                ->relationship('rating', 'title')
                ->searchable(),
            'value' => TextInput::make('value')->numeric(),
            'note' => Textarea::make('note')->columnSpanFull(),
        ];
    }
}
