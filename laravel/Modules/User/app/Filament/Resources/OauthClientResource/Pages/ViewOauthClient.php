<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Pages;

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9d7e4c81 (.)
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\User\Filament\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;
<<<<<<< HEAD
=======
=======
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)

/**
 * Class ViewOauthClient.
 */
class ViewOauthClient extends XotBaseViewRecord
{
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9d7e4c81 (.)
    protected static string $resource = OauthClientResource::class;

    /**
     * Schema dell'infolist per la visualizzazione dei dettagli.
     *
     * @return array<string, Component>
     */
    /**
     * Schema dell'infolist per la visualizzazione dei dettagli.
     *
<<<<<<< HEAD
=======
=======
    protected static string $resource = \Modules\User\Filament\Resources\OauthClientResource::class;

    /**
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return [
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9d7e4c81 (.)
            'oauth_info' => XotBaseSection::make('OAuth Client Information')
                ->schema([
                    'name' => TextEntry::make('name'),
                    'user' => TextEntry::make('user.name'),
                    'redirect' => TextEntry::make('redirect'),
                    'provider' => TextEntry::make('provider'),
                    'personal_access_client' => IconEntry::make('personal_access_client')
                        ->boolean(),
                    'password_client' => IconEntry::make('password_client')
                        ->boolean(),
                    'created_at' => TextEntry::make('created_at')
                        ->dateTime(),
                ]),
<<<<<<< HEAD
=======
=======
            'oauth_client' => Section::make()->schema([
                'id' => TextEntry::make('id'),
                'name' => TextEntry::make('name'),
                'redirect' => TextEntry::make('redirect'),
                'provider' => TextEntry::make('provider'),
                'personal_access_client' => TextEntry::make('personal_access_client'),
                'password_client' => TextEntry::make('password_client'),
                'created_at' => TextEntry::make('created_at')->dateTime(),
                'updated_at' => TextEntry::make('updated_at')->dateTime(),
            ]),
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)
        ];
    }
}
