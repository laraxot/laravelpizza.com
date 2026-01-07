<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\User\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewClient extends XotBaseViewRecord
{
    protected static string $resource = ClientResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'credentials' => Section::make('Client Credentials')
                ->schema([
                    'id' => TextEntry::make('id'),
                    'secret' => TextEntry::make('secret'),
                ])->columns(2),
            'configuration' => Section::make('Configuration')
                ->schema([
                    'name' => TextEntry::make('name'),
                    'user_email' => TextEntry::make('user.email'),
                    'provider' => TextEntry::make('provider'),
                    'redirect' => TextEntry::make('redirect')
                        ->listWithLineBreaks(),
                ])->columns(2),
            'capabilities' => Section::make('Capabilities')
                ->schema([
                    'personal_access_client' => TextEntry::make('personal_access_client')
                        ->badge()
                        ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                        ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                    'password_client' => TextEntry::make('password_client')
                        ->badge()
                        ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                        ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                    'revoked' => TextEntry::make('revoked')
                        ->badge()
                        ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                        ->color(fn (bool $state): string => $state ? 'danger' : 'success'),
                ])->columns(3),
        ];
    }
}
