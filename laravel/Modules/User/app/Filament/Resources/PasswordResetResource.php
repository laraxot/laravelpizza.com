<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\PasswordResetResource\Pages\ListPasswordResets;
use Modules\User\Filament\Resources\PasswordResetResource\Pages\ViewPasswordReset;
use Modules\User\Models\PasswordReset; // Added
use Modules\Xot\Filament\Resources\XotBaseResource;

class PasswordResetResource extends XotBaseResource
{
    protected static ?string $model = PasswordReset::class;





    public static function getNavigationLabel(): string
    {
        return __('Password Resets');
    }

    public static function getPluralLabel(): string
    {
        return __('Password Resets');
    }

    public static function getModelLabel(): string
    {
        return __('Password Reset');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied'),

                TextColumn::make('token')
                    ->searchable()
                    ->limit(20)
                    ->tooltip(fn (PasswordReset $record): string => $record->token)
                    ->copyable()
                    ->copyMessage('Token copied'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Filter by date range
                Filter::make('created_date')
                    ->schema([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                function (Builder $q, mixed $date): Builder {
                                    if (is_string($date) || $date instanceof \DateTimeInterface) {
                                        return $q->whereDate('created_at', '>=', $date);
                                    }

                                    return $q;
                                }
                            )
                            ->when(
                                $data['created_until'],
                                function (Builder $q, mixed $date): Builder {
                                    if (is_string($date) || $date instanceof \DateTimeInterface) {
                                        return $q->whereDate('created_at', '<=', $date);
                                    }

                                    return $q;
                                }
                            );
                    }),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPasswordResets::route('/'),
            'view' => ViewPasswordReset::route('/{record}'),
        ];
    }

    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'password_reset_info' => Section::make('Password Reset Information')
                ->schema([
                    'email' => TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    'token' => TextInput::make('token')
                        ->required()
                        ->maxLength(255),
                ]),
        ];
    }
}
