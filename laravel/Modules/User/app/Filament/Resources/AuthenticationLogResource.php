<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Components\Component;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Filament\Resources\AuthenticationLogResource\Pages\ListAuthenticationLogs;
use Modules\User\Filament\Resources\AuthenticationLogResource\Pages\ViewAuthenticationLog;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AuthenticationLogResource extends XotBaseResource
{
    protected static ?string $model = AuthenticationLog::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('authenticatable_type')
<<<<<<< HEAD
                    ->label('Authenticatable Type')
||||||| 6161e129d
                    ->label('Authenticatable Type')
                    ->formatStateUsing(fn (?string $state): string => $state !== null ? Str::afterLast($state, '\\') : '')
=======
>>>>>>> feature/ralph-loop-implementation
                    ->formatStateUsing(fn (?string $state): string => null !== $state ? Str::afterLast($state, '\\') : '')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('authenticatable.name')
                    ->searchable()
                    ->sortable()
                    ->url(function (AuthenticationLog $record): ?string {
                        $authenticatable = $record->authenticatable;
<<<<<<< HEAD
                        if (null !== $authenticatable && $authenticatable->exists) {
||||||| 6161e129d
                        if ($authenticatable !== null && $authenticatable->exists) {
=======
                        if ($authenticatable instanceof Model) {
>>>>>>> feature/ralph-loop-implementation
                            return UserResource::getUrl('view', ['record' => $authenticatable]);
                        }

                        return null;
                    }, shouldOpenInNewTab: true),

                TextColumn::make('ip_address')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('user_agent')
                    ->limit(50)
                    ->searchable(isIndividual: true),

                IconColumn::make('login_successful')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('login_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('logout_at')
                    ->dateTime()
                    ->sortable(),

                IconColumn::make('cleared_by_user')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                // Filter by login success
                Filter::make('login_successful')
                    ->query(fn (Builder $query): Builder => $query->where('login_successful', true)),

                // Filter by date range
                Filter::make('login_date')
                    ->schema([
                        DatePicker::make('login_from'),
                        DatePicker::make('login_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $loginFrom = $data['login_from'] ?? null;
                        $loginUntil = $data['login_until'] ?? null;

                        return $query
                            ->when(
                                $loginFrom,
                                function (Builder $q, mixed $date): Builder {
                                    if (! \is_string($date) && ! $date instanceof \DateTimeInterface) {
                                        return $q;
                                    }

                                    return $q->whereDate('login_at', '>=', $date);
                                }
                            )
                            ->when(
                                $loginUntil,
                                function (Builder $q, mixed $date): Builder {
                                    if (! \is_string($date) && ! $date instanceof \DateTimeInterface) {
                                        return $q;
                                    }

                                    return $q->whereDate('login_at', '<=', $date);
                                }
                            );
                    }),
            ])
            ->recordActions([
                Action::make('view_user')
                    ->icon('heroicon-o-user')
                    ->url(function (AuthenticationLog $record): ?string {
                        $authenticatable = $record->authenticatable;
<<<<<<< HEAD
                        if (null !== $authenticatable && $authenticatable->exists) {
||||||| 6161e129d
                        if ($authenticatable !== null && $authenticatable->exists) {
=======
                        if ($authenticatable instanceof Model) {
>>>>>>> feature/ralph-loop-implementation
                            return UserResource::getUrl('view', ['record' => $authenticatable]);
                        }

                        return null;
                    })
                    ->visible(function (AuthenticationLog $record): bool {
                        $authenticatable = $record->authenticatable;

<<<<<<< HEAD
                        return null !== $authenticatable && $authenticatable->exists;
||||||| 6161e129d
                        return $authenticatable !== null && $authenticatable->exists;
=======
                        return $authenticatable instanceof Model;
>>>>>>> feature/ralph-loop-implementation
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('login_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthenticationLogs::route('/'),
            'view' => ViewAuthenticationLog::route('/{record}'),
        ];
    }

    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'authentication_info_section' => Section::make('Authentication Information')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('authenticatable_type')
                                ->options([
                                    User::class => 'User',
                                    // Add other authenticatable types as needed
                                ])
                                ->required()
                                ->searchable(),

                            TextInput::make('authenticatable_id')
                                ->required()
                                ->numeric(),
                        ]),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('ip_address')
                                ->maxLength(45),

                            TextInput::make('user_agent')
                                ->maxLength(500),
                        ]),

                    Grid::make(3)
                        ->schema([
                            Toggle::make('login_successful')
                                ->inline(false),

                            TextInput::make('login_at'),

                            TextInput::make('logout_at'),
                        ]),

                    Toggle::make('cleared_by_user')
                        ->inline(false),
                ]),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['authenticatable']);
    }
}
