<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

class ViewOauthAccessToken extends XotBaseViewRecord
{
    protected static string $resource = OauthAccessTokenResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'token_information' => XotBaseSection::make('Token Information')
                ->schema([
                    'token_grid' => Grid::make(2)
                        ->schema([
                            'id' => TextEntry::make('id'),
                            'user' => TextEntry::make('user.name'),
                            'client' => TextEntry::make('client.name'),
                            'name' => TextEntry::make('name'),
                            'scopes' => TextEntry::make('scopes'),
                        ]),
                ])->columns(1),

            'status' => Section::make('Status')
                ->schema([
                    'status_grid' => Grid::make(2)
                        ->schema([
                            'revoked' => IconEntry::make('revoked')->boolean(),
                            'expires_at' => TextEntry::make('expires_at')->dateTime(),
                        ]),
                ])->columns(1),

            'timestamps' => Section::make('Timestamps')
                ->schema([
                    'timestamps_grid' => Grid::make(2)
                        ->schema([
                            'created_at' => TextEntry::make('created_at')->dateTime(),
                            'updated_at' => TextEntry::make('updated_at')->dateTime(),
                        ]),
                ])->columns(1),
        ];
    }
}
