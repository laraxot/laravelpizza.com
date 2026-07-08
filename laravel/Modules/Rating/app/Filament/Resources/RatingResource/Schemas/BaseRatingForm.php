<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Rating\Enums\RuleEnum;
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
    public static function getFormSchema(): array
    {
        return [
            'extra_attributes.type' => TextInput::make('extra_attributes.type'),
            'extra_attributes.anno' => TextInput::make('extra_attributes.anno'),
            'title' => TextInput::make('title')->autofocus()->required(),
            'color' => ColorPicker::make('color'),
            'rule' => Radio::make('rule')->options(RuleEnum::class),
            'flags' => Section::make()
                ->schema([
                    Toggle::make('is_disabled'),
                    Toggle::make('is_readonly'),
                ]),
            'txt' => RichEditor::make('txt')->columnSpanFull(),
        ];
    }
}
