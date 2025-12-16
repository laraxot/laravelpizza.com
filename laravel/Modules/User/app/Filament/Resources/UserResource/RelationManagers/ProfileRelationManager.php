<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class ProfileRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'profile';

    protected static ?string $recordTitleAttribute = 'first_name';

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'ente' => TextInput::make('ente'),
            'matr' => TextInput::make('matr'),
            'first_name' => TextInput::make('first_name')->required()->maxLength(255),
            'last_name' => TextInput::make('last_name'),
        ];
    }

    #[\Override]
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('ente'),
                TextColumn::make('matr'),
                TextColumn::make('first_name'),
                TextColumn::make('last_name'),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
