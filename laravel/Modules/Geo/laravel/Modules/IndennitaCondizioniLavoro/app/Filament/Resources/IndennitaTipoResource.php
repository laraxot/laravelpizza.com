<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\Pages\CreateIndennitaTipo;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\Pages\EditIndennitaTipo;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\Pages\ListIndennitaTipos;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\RelationManagers\DettaglioRelationManager;
use Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class IndennitaTipoResource extends XotBaseResource
{
    protected static ?string $model = IndennitaTipo::class;

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'nome' => TextInput::make('nome'),
            'svocfi' => TextInput::make('svocfi'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('nome')->searchable(),
                TextColumn::make('svocfi')->searchable(),
            ])
            ->filters([
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            DettaglioRelationManager::class,
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListIndennitaTipos::route('/'),
            'create' => CreateIndennitaTipo::route('/create'),
            'edit' => EditIndennitaTipo::route('/{record}/edit'),
        ];
    }
}
