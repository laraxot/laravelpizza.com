<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Notify\Filament\Resources\ContactResource\Pages\CreateContact;
use Modules\Notify\Filament\Resources\ContactResource\Pages\EditContact;
use Modules\Notify\Filament\Resources\ContactResource\Pages\ListContacts;
use Modules\Notify\Models\Contact;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class ContactResource extends XotBaseResource
{
    protected static ?string $model = Contact::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->hint(static::trans('fields.name.hint'))
                ->required()
                ->maxLength(255),
            'email' => TextInput::make('email')
                ->hint(static::trans('fields.email.hint'))
                ->email()
                ->required()
                ->maxLength(255),
            'phone' => TextInput::make('phone')
                ->hint(static::trans('fields.phone.hint'))
                ->tel()
                ->maxLength(255),
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
            'index' => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }
}
