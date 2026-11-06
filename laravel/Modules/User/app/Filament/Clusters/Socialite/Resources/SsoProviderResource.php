<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\User\Filament\Clusters\Socialite;
use Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource\Pages;
use Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource\RelationManagers\UsersRelationManager;
use Modules\User\Models\SsoProvider;
use Modules\Xot\Filament\Resources\XotBaseResource;

class SsoProviderResource extends XotBaseResource
{
    protected static ?string $cluster = Socialite::class;

    protected static ?string $model = SsoProvider::class;

    /**
     * @return array<string, TextColumn|IconColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'display_name' => TextColumn::make('display_name')
                ->searchable()
                ->sortable(),
            'type' => TextColumn::make('type')
                ->searchable()
                ->sortable(),
            'is_active' => IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    /**
     * @return array<string, EditAction|DeleteAction>
     */
    public static function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, BulkActionGroup>
     */
    public static function getTableBulkActions(): array
    {
        return [
            'group' => BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * @return array<string, class-string<RelationManager>>
     */
    #[\Override]
    public static function getRelations(): array
    {
        return [
            'users' => UsersRelationManager::class,
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSsoProviders::route('/'),
            'create' => Pages\CreateSsoProvider::route('/create'),
            'view' => Pages\ViewSsoProvider::route('/{record}'),
            'edit' => Pages\EditSsoProvider::route('/{record}/edit'),
        ];
    }
}
