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
 */
abstract class BaseRatingMorphForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'rating_id' => Select::make('rating_id')
                ->relationship('rating', 'title')
                ->searchable(),
            'value' => TextInput::make('value')->numeric(),
            'percentage' => TextInput::make('percentage')->numeric(),
            'note' => Textarea::make('note')->columnSpanFull(),
        ];
    }
}
