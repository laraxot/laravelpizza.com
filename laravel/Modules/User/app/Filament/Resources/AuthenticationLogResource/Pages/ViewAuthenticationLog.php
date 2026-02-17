<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Filament\Resources\AuthenticationLogResource;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Models\AuthenticationLog;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

use function Safe\json_encode;

class ViewAuthenticationLog extends XotBaseViewRecord
{
    protected static string $resource = AuthenticationLogResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'authentication_details' => Section::make('Authentication Details')
                ->schema([
                    'details_grid_1' => Grid::make(2)
                        ->schema([
                            'id' => TextEntry::make('id'),
                            'authenticatable_type' => TextEntry::make('authenticatable_type')
                                ->formatStateUsing(fn (?string $state): string => null !== $state ? Str::afterLast($state, '\\') : ''),
                        ]),

                    'details_grid_2' => Grid::make(2)
                        ->schema([
                            'authenticatable_name' => TextEntry::make('authenticatable.name')
                                ->url(function (mixed $state, ?Model $record): ?string {
                                    if (! $record instanceof AuthenticationLog) {
                                        return null;
                                    }
                                    $authenticatable = $record->authenticatable;
                                    if (null !== $authenticatable && method_exists($authenticatable, 'exists') && $authenticatable->exists) {
                                        return UserResource::getUrl('view', ['record' => $authenticatable]);
                                    }

                                    return null;
                                }),
                            'ip_address' => TextEntry::make('ip_address')
                                ->copyable()
                                ->copyMessage('IP address copied'),
                        ]),
                ])->columns(1),

            'user_agent' => Section::make('User Agent')
                ->schema([
                    'user_agent' => TextEntry::make('user_agent')
                        ->columnSpanFull(),
                ])->collapsible(),

            'timestamps' => Section::make('Timestamps')
                ->schema([
                    'timestamps_grid' => Grid::make(3)
                        ->schema([
                            'login_at' => TextEntry::make('login_at')
                                ->dateTime(),
                            'logout_at' => TextEntry::make('logout_at')
                                ->dateTime(),
                            'created_at' => TextEntry::make('created_at')
                                ->dateTime(),
                        ]),
                ])->columns(1),

            'status' => Section::make('Status')
                ->schema([
                    'status_grid' => Grid::make(2)
                        ->schema([
                            'login_successful' => TextEntry::make('login_successful')
                                ->badge()
                                ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                                ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                            'cleared_by_user' => TextEntry::make('cleared_by_user')
                                ->badge()
                                ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                                ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                        ]),
                ])->columns(1),

            'location' => Section::make('Location')
                ->schema([
                    'location_data' => TextEntry::make('location')
                        ->formatStateUsing(function (mixed $state): string {
                            if (null === $state || [] === $state) {
                                return 'No location data';
                            }

                            /* @var array<string, mixed> $state */
                            return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        }),
                ])->collapsible(),
        ];
    }
}
