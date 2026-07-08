<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Incentivi\Filament\Resources\WorkgroupResource\Pages\CreateWorkgroup;
use Modules\Incentivi\Filament\Resources\WorkgroupResource\Pages\EditWorkgroup;
use Modules\Incentivi\Filament\Resources\WorkgroupResource\Pages\ListWorkgroups;
use Modules\Incentivi\Filament\Resources\WorkgroupResource\RelationManagers\EmployeesRelationManager;
use Modules\Incentivi\Models\Workgroup;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class WorkgroupResource extends XotBaseResource
{
    protected static ?string $model = Workgroup::class;

    protected static ?int $navigationSort = 1;

    /**
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'informazioni' => Section::make('Informazioni')
                ->schema([
                    TextInput::make('denominazione')
                        ->required()
                        ->maxLength(255),
                ])->columnSpan(1),
        ];
        // )->columns(3);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            EmployeesRelationManager::class,
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListWorkgroups::route('/'),
            'create' => CreateWorkgroup::route('/create'),
            'edit' => EditWorkgroup::route('/{record}/edit'),
        ];
    }
}
