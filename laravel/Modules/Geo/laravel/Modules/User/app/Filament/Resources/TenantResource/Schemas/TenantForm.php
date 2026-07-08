<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TenantForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'main' => Section::make()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->unique(
                            table: 'tenants',
                            ignoreRecord: true,
                        )
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (callable $set, $state): void {
                            if (is_string($state)) {
                                $set('slug', Str::slug($state));
                                $set('domain', Str::slug($state));
                            }
                        })
                        ->columnSpanFull()
                        ->placeholder('Nome del tenant')
                        ->helperText('Inserisci il nome del tenant'),
                    TextInput::make('slug')
                        ->required()
                        ->disabled(fn ($context) => 'create' !== $context)
                        ->unique(
                            table: 'tenants',
                            ignoreRecord: true,
                        )
                        ->helperText('Lo slug verrà generato automaticamente dal nome'),
                    TextInput::make('domain')
                        ->required()
                        ->visible(fn ($context) => 'create' === $context)
                        ->unique(
                            table: 'domains',
                            ignoreRecord: true,
                        )
                        ->prefix('https://')
                        ->suffix('.'.request()->getHost())
                        ->placeholder('dominio')
                        ->helperText('Il dominio del tenant'),
                    TextInput::make('email_address')
                        ->email()
                        ->placeholder('email@example.com')
                        ->helperText('Indirizzo email del tenant'),
                    TextInput::make('phone')
                        ->tel()
                        ->placeholder('Telefono')
                        ->helperText('Numero di telefono del tenant'),
                    TextInput::make('mobile')
                        ->tel()
                        ->placeholder('Cellulare')
                        ->helperText('Numero di cellulare del tenant'),
                    TextInput::make('address')->placeholder('Indirizzo')->helperText('Indirizzo del tenant'),
                    ColorPicker::make('primary_color')->helperText('Colore primario del tenant'),
                    ColorPicker::make('secondary_color')->helperText('Colore secondario del tenant'),
                ])
                ->columns(2),
        ];
    }
}
