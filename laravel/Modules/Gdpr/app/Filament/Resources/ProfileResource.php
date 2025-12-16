<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\Gdpr\Filament\Resources\ProfileResource\Pages\CreateProfile;
use Modules\Gdpr\Filament\Resources\ProfileResource\Pages\EditProfile;
use Modules\Gdpr\Filament\Resources\ProfileResource\Pages\ListProfiles;
use Modules\Gdpr\Models\Profile;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class ProfileResource extends XotBaseResource
{
    protected static ?string $model = Profile::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'type' => TextInput::make('type')->maxLength(255)->default(null),
            'first_name' => TextInput::make('first_name')->maxLength(191)->default(null),
            'last_name' => TextInput::make('last_name')->maxLength(191)->default(null),
            'full_name' => TextInput::make('full_name')->maxLength(191)->default(null),
            'email' => TextInput::make('email')
                ->email()
                ->maxLength(191)
                ->default(null),
            'user_id' => TextInput::make('user_id')->maxLength(36)->default(null),
            'updated_by' => TextInput::make('updated_by')->maxLength(36)->default(null),
            'created_by' => TextInput::make('created_by')->maxLength(36)->default(null),
            'deleted_by' => TextInput::make('deleted_by')->maxLength(36)->default(null),
            'is_active' => Toggle::make('is_active')->required(),
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListProfiles::route('/'),
            'create' => CreateProfile::route('/create'),
            'edit' => EditProfile::route('/{record}/edit'),
        ];
    }
}
