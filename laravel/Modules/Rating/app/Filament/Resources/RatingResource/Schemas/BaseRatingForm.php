<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Rating\Enums\RuleEnum;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form rating condiviso tra moduli che estendono BaseRatingResource.
 *
 * Le classi concrete nei moduli figli estendono questa base e sovrascrivono
 * getFormSchema() quando l'UI differisce.
 */
abstract class BaseRatingForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            // 'extra_attributes.type' => TextInput::make('extra_attributes.type'),
            // 'extra_attributes.anno' => TextInput::make('extra_attributes.anno'),
            'title' => TextInput::make('title')->autofocus()->required(),
            'color' => ColorPicker::make('color'),
            'rule' => Radio::make('rule')->options(RuleEnum::class),
            // Nessun ->label(): la traduzione arriva dalle chiavi del modulo.
            //
            // La query esclude il record stesso e i suoi discendenti. Serve: la cycle
            // detection del pacchetto NON impedisce di creare un anello — aggiunge una
            // colonna ai RISULTATI delle query ricorsive, cioe' diagnostica un ciclo che
            // esiste gia'. L'unico punto dove si previene e' qui.
            'parent_id' => Select::make('parent_id')
                ->relationship(
                    'parent',
                    'title',
                    function (Builder $query, ?Model $record): Builder {
                        if (! $record instanceof Model) {
                            return $query;
                        }

                        if (! $record instanceof HasRecursiveRelationshipsContract) {
                            return $query->whereKeyNot($record->getKey());
                        }

                        return $query->whereNotIn('id', $record->descendantsAndSelf()->pluck('id'));
                    }
                )
                ->searchable()
                ->preload()
                ->nullable(),
            'flags' => Section::make()
                ->schema([
                    Toggle::make('is_disabled'),
                    Toggle::make('is_readonly'),
                ]),
            'txt' => RichEditor::make('txt')->columnSpanFull(),
        ];
    }
}
