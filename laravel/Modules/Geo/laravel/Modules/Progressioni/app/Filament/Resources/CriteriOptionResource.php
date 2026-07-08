<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\CriteriOptionResource\Pages\CreateCriteriOption;
use Modules\Progressioni\Filament\Resources\CriteriOptionResource\Pages\EditCriteriOption;
use Modules\Progressioni\Filament\Resources\CriteriOptionResource\Pages\ListCriteriOptions;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class CriteriOptionResource extends XotBaseResource
{
    protected static ?string $model = CriteriOption::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'name' => TextInput::make('name')->required(),
            'value' => TextInput::make('value')->required(),
            'type' => Select::make('type')
                ->options([
                    'string' => 'Stringa',
                    'int' => 'Intero',
                    'date' => 'Data',
                    'list' => 'Lista',
                ])
                ->required(),
            'anno' => TextInput::make('anno')->numeric()->required(),
            'note' => Textarea::make('note')->rows(3),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriOptions::route('/'),
            'create' => CreateCriteriOption::route('/create'),
            'edit' => EditCriteriOption::route('/{record}/edit'),
        ];
    }
}
