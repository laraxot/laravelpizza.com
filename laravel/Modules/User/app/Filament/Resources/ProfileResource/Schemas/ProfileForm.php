<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ProfileResource\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ProfileForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public function getFormSchema(): array
    {
        return [
            // Forms\Components\TextInput::make('user_id'),
            // Forms\Components\TextInput::make('user_id')->readonly(),
            'user_name' => TextInput::make('user.name'),
            // Stesse regole di `TeamInvitationForm` e `PasswordResetForm`: senza
            // `->email()` il campo accetta qualsiasi testo e il salvataggio fallisce
            // solo sul server, dove l'utente non vede piu' cosa correggere.
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            'first_name' => TextInput::make('first_name'),
            'last_name' => TextInput::make('last_name'),
            'photo_profile' => SpatieMediaLibraryFileUpload::make('photo_profile')
                // ->image()
                // ->maxSize(5000)
                // ->multiple()
                // ->enableReordering()
                ->openable()
                ->downloadable()
                ->columnSpanFull()
                // ->collection('avatars')
                // ->conversion('thumbnail')
                ->disk('uploads')
                ->directory('photos')
                ->collection('photo_profile'),
        ];
    }
}
