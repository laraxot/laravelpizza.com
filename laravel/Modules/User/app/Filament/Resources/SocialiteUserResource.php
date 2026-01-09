<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\SocialiteUserResource\Pages\EditSocialiteUser;
use Modules\User\Filament\Resources\SocialiteUserResource\Pages\ListSocialiteUsers;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class SocialiteUserResource.
 */
class SocialiteUserResource extends XotBaseResource
{
    protected static ?string $model = SocialiteUser::class;

    protected static ?string $recordTitleAttribute = 'provider';

    protected static ?string $modelLabel = 'Social Authentication';

    protected static ?string $pluralModelLabel = 'Social Authentications';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Select|TextInput>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'user_id' => Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
            'provider' => Select::make('provider')
                ->options([
                    'google' => 'Google',
                    'facebook' => 'Facebook',
                    'github' => 'GitHub',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn',
                    'apple' => 'Apple',
                    // Add other providers as needed
                ])
                ->searchable()
                ->required(),
            'provider_id' => TextInput::make('provider_id')
                ->required()
                ->maxLength(255),
            'provider_token' => TextInput::make('provider_token')
                ->maxLength(255)
                ->password(),
            'provider_refresh_token' => TextInput::make('provider_refresh_token')
                ->maxLength(255)
                ->password(),
            'provider_avatar' => TextInput::make('provider_avatar')
                ->maxLength(255),
        ];
    }

    /**
     * Configure the table for the resource.
     */
    #[\Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('provider')
                    ->label('Provider')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('provider_id')
                    ->label('Provider ID')
                    ->searchable(),
                TextColumn::make('provider_avatar')
                    ->label('Avatar')
                    ->formatStateUsing(function (mixed $state): string {
                        if ($state) {
                            /** @phpstan-var view-string $viewString */
                            $viewString = 'filament.components.avatar';

                            return view($viewString, ['url' => (string) $state])->render();
                        }

                        return 'No Avatar';
                    })
                    ->html(),
                TextColumn::make('created_at')
                    ->label('Connected At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Add filters for provider type
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Get the pages available for the resource.
     *
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSocialiteUsers::route('/'),
            'edit' => EditSocialiteUser::route('/{record}/edit'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }
}
