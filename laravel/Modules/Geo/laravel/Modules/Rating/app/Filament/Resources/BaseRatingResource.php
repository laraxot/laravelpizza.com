<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Components\Component;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\Rating;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class BaseRatingResource extends XotBaseResource
{
    protected static ?string $model = Rating::class;

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
