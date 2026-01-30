<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\PageRegistration;
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
     * @return array<string, Field>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255),
            'display_name' => TextInput::make('display_name')
                ->required()
                ->maxLength(255),
            'type' => Select::make('type')
                ->options([
                    'saml' => 'SAML',
                    'oidc' => 'OIDC',
                    'oauth' => 'OAuth',
                ])
                ->required(),
            'entity_id' => TextInput::make('entity_id')->maxLength(255),
            'client_id' => TextInput::make('client_id')->maxLength(255),
            'client_secret' => TextInput::make('client_secret')
                ->password()
                ->maxLength(255),
            'redirect_url' => TextInput::make('redirect_url')
                ->url()
                ->maxLength(255),
            'metadata_url' => TextInput::make('metadata_url')
                ->url()
                ->maxLength(255),
            'scopes' => Textarea::make('scopes')->rows(2),
            'settings' => KeyValue::make('settings'),
            'domain_whitelist' => KeyValue::make('domain_whitelist'),
            'role_mapping' => KeyValue::make('role_mapping'),
            'is_active' => Toggle::make('is_active'),
        ];
    }

    /**
     * @return array<string, TextColumn|IconColumn>
     */
    public static function getTableColumns(): array
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
     * @return array<string, class-string<\Filament\Resources\RelationManagers\RelationManager>>
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
