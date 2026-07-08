<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthPersonalAccessClientResource\Pages\CreateOauthPersonalAccessClient;
use Modules\User\Filament\Clusters\Passport\Resources\OauthPersonalAccessClientResource\Pages\EditOauthPersonalAccessClient;
use Modules\User\Filament\Clusters\Passport\Resources\OauthPersonalAccessClientResource\Pages\ListOauthPersonalAccessClients;
use Modules\User\Filament\Clusters\Passport\Resources\OauthPersonalAccessClientResource\Pages\ViewOauthPersonalAccessClient;
use Modules\User\Models\OauthPersonalAccessClient;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class OauthPersonalAccessClientResource.
 */
final class OauthPersonalAccessClientResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    protected static ?string $model = OauthPersonalAccessClient::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'oauth_personal_access_client' => Section::make('OAuth Personal Access Client Information')
                ->schema([
                    Select::make('client_id')
                        ->label('Client')
                        ->relationship('client', 'name')
                        ->required()
                        ->searchable()
                        ->helperText('Associated OAuth client'),
                ])
                ->columns(2),
        ];
    }

    /**
     * Define the table for the resource.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->filters(self::getTableFilters())
            ->actions(self::getTableActions())
            ->bulkActions(self::getTableBulkActions())
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Get the table columns for the resource.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->searchable(),
            'client' => Tables\Columns\TextColumn::make('client.name')
                ->label('Client')
                ->sortable()
                ->searchable(),
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                ->sortable(),
            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime()
                ->sortable(),
        ];
    }

    /**
     * Get the table filters for the resource.
     *
     * @return array<string, Tables\Filters\BaseFilter>
     */
    public static function getTableFilters(): array
    {
        return [
            'client_id' => Tables\Filters\SelectFilter::make('client_id')
                ->label('Client')
                ->relationship('client', 'name'),
        ];
    }

    /**
     * Get the table actions for the resource.
     *
     * @return array<string, \Filament\Actions\Action>
     */
    public static function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * Get the table bulk actions for the resource.
     *
     * @return array<string, \Filament\Actions\Action|\Filament\Actions\ActionGroup>
     */
    public static function getTableBulkActions(): array
    {
        return [
            'delete' => BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOauthPersonalAccessClients::route('/'),
            'create' => CreateOauthPersonalAccessClient::route('/create'),
            'edit' => EditOauthPersonalAccessClient::route('/{record}/edit'),
            'view' => ViewOauthPersonalAccessClient::route('/{record}'),
        ];
    }

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['client']);
    }
}
