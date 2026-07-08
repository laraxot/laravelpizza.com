<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource\Pages\CreateCriteriPrecedenza;
use Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource\Pages\EditCriteriPrecedenza;
use Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource\Pages\ListCriteriPrecedenzas;
use Modules\Progressioni\Models\CriteriPrecedenza;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class CriteriPrecedenzaResource extends XotBaseResource
{
    protected static ?string $model = CriteriPrecedenza::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'parent_id' => TextInput::make('parent_id')->numeric(),
            'name' => TextInput::make('name')->required(),
            'order_direction' => Select::make('order_direction')
                ->options([
                    'asc' => 'Ascendente',
                    'desc' => 'Discendente',
                ])
                ->required(),
            'label' => TextInput::make('label'),
            'descr' => TextInput::make('descr'),
            'post_type' => TextInput::make('post_type'),
            'posizione' => TextInput::make('posizione')->numeric(),
            'anno' => TextInput::make('anno')->numeric(),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriPrecedenzas::route('/'),
            'create' => CreateCriteriPrecedenza::route('/create'),
            'edit' => EditCriteriPrecedenza::route('/{record}/edit'),
        ];
    }
}
