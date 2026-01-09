<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\TenantUserResource\Pages;
use Modules\User\Models\TenantUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class TenantUserResource.
 */
final class TenantUserResource extends XotBaseResource
{
    protected static ?string $model = TenantUser::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'tenant_user' => Section::make('Tenant User Information')
                ->schema([
                    'tenant_id' => Select::make('tenant_id')
                        ->label('Tenant')
                        ->relationship('tenant', 'name')
                        ->required()
                        ->searchable(),
                    'user_id' => Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable(),
                    'role' => Select::make('role')
                        ->label('Role')
                        ->options([
                            'admin' => 'Admin',
                            'manager' => 'Manager',
                            'user' => 'User',
                            'viewer' => 'Viewer',
                        ])
                        ->required()
                        ->searchable()
                        ->helperText('Role of the user in the tenant'),
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
            'tenant' => Tables\Columns\TextColumn::make('tenant.name')
                ->label('Tenant')
                ->sortable()
                ->searchable(),
            'user' => Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->sortable()
                ->searchable(),
            'role' => Tables\Columns\TextColumn::make('role')
                ->label('Role')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'admin' => 'warning',
                    'manager' => 'primary',
                    'user' => 'info',
                    'viewer' => 'gray',
                    default => 'secondary',
                })
                ->sortable(),
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
            'tenant_id' => Tables\Filters\SelectFilter::make('tenant_id')
                ->label('Tenant')
                ->relationship('tenant', 'name'),
            'user_id' => Tables\Filters\SelectFilter::make('user_id')
                ->label('User')
                ->relationship('user', 'name'),
            'role' => Tables\Filters\SelectFilter::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'manager' => 'Manager',
                    'user' => 'User',
                    'viewer' => 'Viewer',
                ]),
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
            'view' => ViewAction::make(),
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
     * Define the pages available for the resource.
     *
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenantUsers::route('/'),
            'create' => Pages\CreateTenantUser::route('/create'),
            'view' => Pages\ViewTenantUser::route('/{record}'),
            'edit' => Pages\EditTenantUser::route('/{record}/edit'),
        ];
    }

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['tenant', 'user']);
    }
}
