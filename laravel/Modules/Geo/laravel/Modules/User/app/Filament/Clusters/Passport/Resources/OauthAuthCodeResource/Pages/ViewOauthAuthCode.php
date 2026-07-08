<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource\Pages;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
use Modules\User\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

class ViewOauthAuthCode extends XotBaseViewRecord
{
    protected static string $resource = OauthAuthCodeResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'authorization_code_info' => XotBaseSection::make('Authorization Code Information')
                ->schema([
                    'code_grid' => Grid::make(2)
                        ->schema([
                            'id' => TextEntry::make('id')
                                ->formatStateUsing(fn (mixed $state): string => Str::limit((string) $state, 15, '...')),
                            'client_name' => TextEntry::make('client.name')
                                ->url(function (mixed $state, $record): ?string {
                                    if (! $record instanceof Model) {
                                        return null;
                                    }

                                    $client = $record->getRelationValue('client');
                                    if (($client instanceof Model) && $client->exists) {
                                        return OauthClientResource::getUrl('view', ['record' => $client]);
                                    }

                                    return null;
                                }),
                        ]),

                    'user_grid' => Grid::make(2)
                        ->schema([
                            'user_name' => TextEntry::make('user.name')
                                ->url(function (mixed $state, $record): ?string {
                                    if (! $record instanceof Model) {
                                        return null;
                                    }

                                    $user = $record->getRelationValue('user');
                                    if (($user instanceof Model) && $user->exists) {
                                        return UserResource::getUrl('view', ['record' => $user]);
                                    }

                                    return null;
                                }),
                        ]),
                ])->columns(1),

            'authorization_details' => Section::make('Authorization Details')
                ->schema([
                    'scopes' => TextEntry::make('scopes')
                        ->formatStateUsing(function (mixed $state): string {
                            if (is_array($state)) {
                                /* @var array<int|string, mixed> $state */
                                return implode(', ', array_map(fn (mixed $item): string => (string) $item, $state));
                            }

                            return (string) $state;
                        })
                        ->columnSpanFull(),
                ])->columns(1),

            'status' => Section::make('Status')
                ->schema([
                    'status_grid' => Grid::make(2)
                        ->schema([
                            'revoked' => IconEntry::make('revoked')->boolean(),
                        ]),
                ])->columns(1),

            'timestamps' => Section::make('Timestamps')
                ->schema([
                    'timestamps_grid' => Grid::make(2)
                        ->schema([
                            'expires_at' => TextEntry::make('expires_at')
                                ->dateTime(),
                            'created_at' => TextEntry::make('created_at')
                                ->dateTime(),
                        ]),
                ])->columns(1),
        ];
    }
}
