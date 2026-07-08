<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthRefreshTokenResource\Pages;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Resources\OauthAccessTokenResource;
use Modules\User\Filament\Resources\OauthRefreshTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewOauthRefreshToken extends XotBaseViewRecord
{
    protected static string $resource = OauthRefreshTokenResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'token_information' => Section::make('Token Information')
                ->schema([
                    'token_grid' => Grid::make(2)
                        ->schema([
                            'id' => TextEntry::make('id'),
                            'access_token_id' => TextEntry::make('accessToken.id')
                                ->url(function (mixed $_state, $record): ?string {
                                    if (! $record instanceof Model) {
                                        return null;
                                    }

                                    $accessToken = $record->getRelationValue('accessToken');
                                    if (($accessToken instanceof Model) && $accessToken->exists) {
                                        return OauthAccessTokenResource::getUrl('view', ['record' => $accessToken]);
                                    }

                                    return null;
                                }),
                        ]),
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
