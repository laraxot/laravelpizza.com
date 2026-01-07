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
use Modules\User\Filament\Resources\TeamUserResource\Pages;
use Modules\User\Models\TeamUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class TeamUserResource.
 */
final class TeamUserResource extends XotBaseResource
{
    protected static ?string $model = TeamUser::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Team User';

    protected static ?string $pluralModelLabel = 'Team Users';

    protected static \UnitEnum|string|null $navigationGroup = 'Teams';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'team_user' => Section::make('Team User Information')
                ->schema([
                    'team_id' => Select::make('team_id')
                        ->label('Team')
                        ->relationship('team', 'name')
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
                            'member' => 'Member',
                            'viewer' => 'Viewer',
                        ])
                        ->required()
                        ->searchable()
                        ->helperText('Role of the user in the team'),
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
            'team' => Tables\Columns\TextColumn::make('team.name')
                ->label('Team')
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
                    'member' => 'primary',
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
            'team_id' => Tables\Filters\SelectFilter::make('team_id')
                ->label('Team')
                ->relationship('team', 'name'),
            'user_id' => Tables\Filters\SelectFilter::make('user_id')
                ->label('User')
                ->relationship('user', 'name'),
            'role' => Tables\Filters\SelectFilter::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'member' => 'Member',
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
            'index' => Pages\ListTeamUsers::route('/'),
            'create' => Pages\CreateTeamUser::route('/create'),
            'view' => Pages\ViewTeamUser::route('/{record}'),
            'edit' => Pages\EditTeamUser::route('/{record}/edit'),
        ];
    }

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['team', 'user']);
    }
}
