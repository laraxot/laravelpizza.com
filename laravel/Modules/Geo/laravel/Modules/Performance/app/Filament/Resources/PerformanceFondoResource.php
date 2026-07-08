<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages\CreatePerformanceFondo;
use Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages\EditPerformanceFondo;
use Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages\IndividualeMoney;
use Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages\ListPerformanceFondos;
use Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages\OrganizzativaMoney;
use Modules\Performance\Models\PerformanceFondo;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class PerformanceFondoResource extends XotBaseResource
{
    protected static ?string $model = PerformanceFondo::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'quota_individuale' => TextInput::make('quota_individuale')
                ->numeric(),
            'quota_organizzativa' => TextInput::make('quota_organizzativa')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),
            'note' => Textarea::make('note')
                ->columnSpanFull(),

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPerformanceFondos::route('/'),
            'create' => CreatePerformanceFondo::route('/create'),
            'edit' => EditPerformanceFondo::route('/{record}/edit'),
            'organizzativa-money' => OrganizzativaMoney::route('/{record}/organizzativa-money'),
            'individuale-money' => IndividualeMoney::route('/{record}/individuale-money'),
        ];
    }
}
