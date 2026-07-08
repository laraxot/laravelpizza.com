<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Components\Component;
use Modules\Ptv\Models\Option;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

abstract class BaseOptionResource extends XotBaseResource
{
    protected static ?string $model = Option::class;

    /**
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'option_type' => TextInput::make('option_type')
                ->maxLength(191),
            'option_id' => TextInput::make('option_id')
                ->numeric(),
            'parent_id' => TextInput::make('parent_id')
                ->numeric(),
            'pos' => TextInput::make('pos')
                ->numeric(),
            'name' => Textarea::make('name')
                ->columnSpanFull(),
            'value' => Textarea::make('value')
                ->columnSpanFull(),
            'txt' => Textarea::make('txt')
                ->columnSpanFull(),
            'txt1' => Textarea::make('txt1')
                ->columnSpanFull(),
            'year' => TextInput::make('year')
                ->numeric(),
        ];
    }
}
