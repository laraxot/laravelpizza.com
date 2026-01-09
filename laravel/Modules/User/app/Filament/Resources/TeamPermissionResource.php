<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\User\Models\TeamPermission;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TeamPermissionResource extends XotBaseResource
{
    protected static ?string $model = TeamPermission::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Gestione Utenti';

    protected static ?int $navigationSort = 15;

    public static function getNavigationLabel(): string
    {
        return __('user::team_permission.navigation.label');
    }

    public static function getPluralLabel(): string
    {
        return __('user::team_permission.navigation.plural');
    }

    public static function getModelLabel(): string
    {
        return __('user::team_permission.navigation.name');
    }

    /**
     * Get the form schema for the resource (XotBaseResource pattern).
     *
     * @return array<string, Field|Section>
     */
    public static function getFormSchema(): array
    {
        return [
            'section01' => Section::make([
                'team_id' => Select::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                'user_id' => Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                'permission' => TextInput::make('permission')
                    ->required()
                    ->maxLength(255),
            ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                'id' => TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                'team' => TextColumn::make('team.name')
                    ->searchable()
                    ->sortable()
                    ->url(function (mixed $record): ?string {
                        if (! $record instanceof TeamPermission) {
                            return null;
                        }
                        $team = $record->team;
                        if (null !== $team && method_exists($team, 'exists') && $team->exists) {
                            return TeamResource::getUrl('view', ['record' => $team]);
                        }

                        return null;
                    })
                    ->openUrlInNewTab(),

                'user' => TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->url(function (mixed $record): ?string {
                        if (! $record instanceof TeamPermission) {
                            return null;
                        }
                        $user = $record->user;
                        if (null !== $user && method_exists($user, 'exists') && $user->exists) {
                            return UserResource::getUrl('view', ['record' => $user]);
                        }

                        return null;
                    })
                    ->openUrlInNewTab(),

                'permission' => TextColumn::make('permission')
                    ->searchable()
                    ->sortable(),

                'created_at' => TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                'updated_at' => TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Filters can be added here if needed
            ])
            ->actions([
                'edit' => EditAction::make(),
                'delete' => DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
