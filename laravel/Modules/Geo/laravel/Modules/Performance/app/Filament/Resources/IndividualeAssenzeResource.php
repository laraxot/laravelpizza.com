<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Pages\CreateIndividualeAssenze;
use Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Pages\EditIndividualeAssenze;
use Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Pages\ListIndividualeAssenzes;
use Modules\Performance\Models\IndividualeAssenze;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class IndividualeAssenzeResource extends XotBaseResource
{
    protected static ?string $model = IndividualeAssenze::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'tipo' => TextInput::make('tipo')
                ->numeric(),
            'codice' => TextInput::make('codice')
                ->numeric(),
            'descr' => Textarea::make('descr')
                ->columnSpanFull(),
            'anno' => TextInput::make('anno')
                ->numeric()
                ->default(date('Y')),
            'created_by' => TextInput::make('created_by')
                ->maxLength(255)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),
            'updated_by' => TextInput::make('updated_by')
                ->maxLength(255)
                ->disabled()
                ->dehydrated(false),
            'deleted_by' => TextInput::make('deleted_by')
                ->maxLength(255)
                ->disabled()
                ->dehydrated(false),

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListIndividualeAssenzes::route('/'),
            'create' => CreateIndividualeAssenze::route('/create'),
            'edit' => EditIndividualeAssenze::route('/{record}/edit'),
        ];
    }
}
