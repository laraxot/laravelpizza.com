<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

<<<<<<< HEAD
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
=======
<<<<<<< HEAD
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\Client;
use Modules\Xot\Filament\Resources\XotBaseResource;
=======
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Components\Grid;
use Filament\Support\Components\Component;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
>>>>>>> 9d7e4c81 (.)
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\Client;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection as Section; // This is actually a Schema Section, needs to be Forms Section for getFormSchema
use Filament\Forms\Components\Grid as FormsGrid; // Alias for Forms Grid
use Filament\Forms\Components\Section as FormsSection; // Alias for Forms Section
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Component as FormsComponent;
use Filament\Tables\Actions\BulkActionGroup as TablesBulkActionGroup;
use Filament\Tables\Filters\Filter;
>>>>>>> 939bd20e2 (.)

/**
 * Class OauthClientResource.
 */
<<<<<<< HEAD
class OauthClientResource extends XotBaseResource
=======
final class OauthClientResource extends XotBaseResource
>>>>>>> 939bd20e2 (.)
{
    protected static ?string $model = Client::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'OAuth Client';

    protected static ?string $pluralModelLabel = 'OAuth Clients';

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9d7e4c81 (.)
    // $navigationIcon gestito automaticamente da NavigationLabelTrait tramite traduzioni

    /**
     * Schema del form per la risorsa.
     */
    public static function getFormSchema(): array
<<<<<<< HEAD
=======
    {
        return [
            'client_info' => \Filament\Schemas\Components\Section::make('OAuth Client Information')
                ->schema([
                    \Filament\Schemas\Components\Grid::make(2)
                        ->schema([
                            'name' => TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            'user_id' => Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable(),
                        ]),
                    \Filament\Schemas\Components\Grid::make(2)
                        ->schema([
                            'redirect' => TextInput::make('redirect')
                                ->maxLength(2000),
                            'secret' => TextInput::make('secret')
                                ->password()
                                ->maxLength(100),
                        ]),
                    \Filament\Schemas\Components\Grid::make(3)
                        ->schema([
                            'provider' => Select::make('provider')
                                ->options([
                                    'users' => 'Users',
                                ]),
                            'personal_access_client' => TextInput::make('personal_access_client')
                                ->numeric(),
                            'password_client' => TextInput::make('password_client')
                                ->numeric(),
=======
    protected static \UnitEnum|string|null $navigationGroup = 'API';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-key';

    /**
     * @return array<string, FormsComponent>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'oauth_client' => FormsSection::make('OAuth Client Information') // Using FormsSection
                ->schema([
                    'grid_1' => FormsGrid::make(2) // Using FormsGrid
                        ->schema([
                            'name' => \Filament\Forms\Components\TextInput::make('name')
                                ->label('Client Name')
                                ->required()
                                ->maxLength(255),
                            'user_id' => \Filament\Forms\Components\Select::make('user_id')
                                ->label('User')
                                ->relationship('user', 'name')
                                ->searchable(),
                        ]),
                    'grid_2' => FormsGrid::make(2) // Using FormsGrid
                        ->schema([
                            'redirect' => \Filament\Forms\Components\TextInput::make('redirect')
                                ->label('Redirect URL')
                                ->maxLength(2000)
                                ->helperText('URL to redirect after authentication'),
                            'secret' => \Filament\Forms\Components\TextInput::make('secret')
                                ->label('Client Secret')
                                ->password()
                                ->maxLength(100),
                        ]),
                    'grid_3' => FormsGrid::make(3) // Using FormsGrid
                        ->schema([
                            'provider' => Select::make('provider')
                                ->label('Provider')
                                ->options([
                                    'users' => 'Users',
                                ])
                                ->helperText('Authentication provider'),
                            'personal_access_client' => \Filament\Forms\Components\TextInput::make(
                                'personal_access_client'
                            )
                                ->label('Personal Access')
                                ->numeric()
                                ->helperText('Is personal access client?'),
                            'password_client' => \Filament\Forms\Components\TextInput::make('password_client')
                                ->label('Password Client')
                                ->numeric()
                                ->helperText('Is password client?'),
>>>>>>> 939bd20e2 (.)
                        ]),
                ])
                ->columns(2),
        ];
    }

<<<<<<< HEAD
    // table() NON necessario - gestito dalla pagina ListOauthClients tramite getTableColumns()
    // getPages() NON necessario - gestito automaticamente da XotBaseResource
=======
    /**
     * Define the table for the resource.
     */
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns(self::getTableColumns())
            ->filters(self::getTableFilters())
            ->actions(
                /** @var array<string, Tables\Actions\Action|Tables\Actions\ActionGroup> */
                self::getTableActions()
            )
            ->bulkActions(
                /** @var array<string, TablesBulkActionGroup> */
                self::getTableBulkActions()
            )
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
            'name' => Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->description(fn (Client $record): string => (string) ($record->provider ?? ''))
                ->searchable()
                ->sortable(),
            'user' => Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->searchable()
                ->sortable(),
            'redirect' => Tables\Columns\TextColumn::make('redirect')
                ->label('Redirect')
                ->limit(50)
                ->tooltip(fn (Client $record): string => (string) ($record->getAttribute('redirect') ?? ''))
                ->searchable(isIndividual: true),
            'personal_access_client' => Tables\Columns\IconColumn::make('personal_access_client')
                ->label('Personal Access')
                ->boolean()
                ->sortable(),
            'password_client' => Tables\Columns\IconColumn::make('password_client')
                ->label('Password Client')
                ->boolean()
                ->sortable(),
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->label('Created')
                ->dateTime()
                ->sortable(),
        ];
    }

    /**
     * Get the table filters for the resource.
     *
     * @return array<string, Filter>
     */
    public static function getTableFilters(): array
    {
        return [
            'user_id' => SelectFilter::make('user_id')
                ->label('User')
                ->relationship('user', 'name'),
            'personal_access_client' => TernaryFilter::make('personal_access_client')
                ->label('Personal Access Client'),
            'password_client' => TernaryFilter::make('password_client')
                ->label('Password Client'),
        ];
    }

    /**
     * Get the table actions for the resource.
     *
     * @return array<string, \Filament\Tables\Actions\Action>
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
     * @return array<string, TablesBulkActionGroup>
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
     * Define the pages available for the resource.
     *
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
>>>>>>> 9d7e4c81 (.)
    {
        return [
            'client_info' => \Filament\Schemas\Components\Section::make('OAuth Client Information')
                ->schema([
                    \Filament\Schemas\Components\Grid::make(2)
                        ->schema([
                            'name' => TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            'user_id' => Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable(),
                        ]),
                    \Filament\Schemas\Components\Grid::make(2)
                        ->schema([
                            'redirect' => TextInput::make('redirect')
                                ->maxLength(2000),
                            'secret' => TextInput::make('secret')
                                ->password()
                                ->maxLength(100),
                        ]),
                    \Filament\Schemas\Components\Grid::make(3)
                        ->schema([
                            'provider' => Select::make('provider')
                                ->options([
                                    'users' => 'Users',
                                ]),
                            'personal_access_client' => TextInput::make('personal_access_client')
                                ->numeric(),
                            'password_client' => TextInput::make('password_client')
                                ->numeric(),
                        ]),
                ])
                ->columns(2),
        ];
    }
>>>>>>> 939bd20e2 (.)

    // table() NON necessario - gestito dalla pagina ListOauthClients tramite getTableColumns()
    // getPages() NON necessario - gestito automaticamente da XotBaseResource

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }
<<<<<<< HEAD
}
=======
<<<<<<< HEAD
}
=======
}
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)
