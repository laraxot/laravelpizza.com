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
    public function getFormSchema(): array
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
                        ->afterStateUpdated(function (callable $set, ?string $state): void {
                            if (is_string($state)) {
                                $set('slug', Str::slug($state));
                                $set('domain', Str::slug($state));
                            }
                        })
                        ->columnSpanFull()
                        ->placeholder('Tenant name')
                        ->helperText('Enter the tenant name'),
                    TextInput::make('slug')
                        ->required()
                        ->disabled(fn (string $context) => $context !== 'create')
                        ->unique(
                            table: 'tenants',
                            ignoreRecord: true,
                        )
                        ->helperText('The slug is generated automatically from the name'),
                    TextInput::make('domain')
                        ->required()
                        ->visible(fn (string $context) => $context === 'create')
                        ->unique(
                            table: 'domains',
                            ignoreRecord: true,
                        )
                        ->prefix('https://')
                        ->suffix('.'.request()->getHost())
                        ->placeholder('Domain')
                        ->helperText('The tenant domain'),
                    TextInput::make('email_address')
                        ->email()
                        ->placeholder('email@example.com')
                        ->helperText('The tenant email address'),
                    TextInput::make('phone')
                        ->tel()
                        ->placeholder('Phone')
                        ->helperText('The tenant phone number'),
                    TextInput::make('mobile')
                        ->tel()
                        ->placeholder('Mobile')
                        ->helperText('The tenant mobile number'),
                    TextInput::make('address')->placeholder('Address')->helperText('The tenant address'),
                    ColorPicker::make('primary_color')->helperText('The tenant primary color'),
                    ColorPicker::make('secondary_color')->helperText('The tenant secondary color'),
                ])
                ->columns(2),
        ];
    }
}
