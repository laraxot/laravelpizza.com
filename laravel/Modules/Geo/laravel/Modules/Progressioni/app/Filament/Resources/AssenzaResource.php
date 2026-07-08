<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Modules\Progressioni\Filament\Resources\AssenzaResource\Pages\CreateAssenza;
use Modules\Progressioni\Filament\Resources\AssenzaResource\Pages\EditAssenza;
use Modules\Progressioni\Filament\Resources\AssenzaResource\Pages\ListAssenzas;
use Modules\Progressioni\Models\Assenza;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class AssenzaResource extends XotBaseResource
{
    protected static ?string $model = Assenza::class;

    #[Override]
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'tipo' => TextInput::make('tipo')->numeric(),
            'codice' => TextInput::make('codice')->numeric(),
            'descr' => TextInput::make('descr')->maxLength(250),
            'anno' => TextInput::make('anno')->numeric(),
            'umi' => TextInput::make('umi')->maxLength(2),
            'dur' => TextInput::make('dur')->maxLength(50),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListAssenzas::route('/'),
            'create' => CreateAssenza::route('/create'),
            'edit' => EditAssenza::route('/{record}/edit'),
        ];
    }
}
