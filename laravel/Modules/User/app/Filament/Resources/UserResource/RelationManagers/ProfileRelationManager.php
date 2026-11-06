<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class ProfileRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'profile';

    protected static ?string $recordTitleAttribute = 'first_name';

    protected static string|BackedEnum|null $icon = 'heroicon-o-identification';

    protected static bool $isBadgeDeferred = true;

    /**
     * Badge 1/0: segnala a colpo d'occhio se il profilo esiste (relazione hasOne).
     */
    #[\Override]
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        if (! $ownerRecord instanceof UserContract) {
            return null;
        }

        return (string) $ownerRecord->profile()->count();
    }

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

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id'),
            'ente' => TextColumn::make('ente'),
            'matr' => TextColumn::make('matr'),
            'first_name' => TextColumn::make('first_name'),
            'last_name' => TextColumn::make('last_name'),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[\Override]
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
