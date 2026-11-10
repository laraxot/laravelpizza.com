<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\SponsorResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Usato anche dal form evento per creare un sponsor senza uscire dalla pagina (createOptionForm).
 */
class SponsorForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(191),
            'level' => Select::make('level')
                ->options([
                    'platinum' => __('meetup::sponsor_form.fields.level.options.platinum'),
                    'gold' => __('meetup::sponsor_form.fields.level.options.gold'),
                    'silver' => __('meetup::sponsor_form.fields.level.options.silver'),
                    'bronze' => __('meetup::sponsor_form.fields.level.options.bronze'),
                    'community' => __('meetup::sponsor_form.fields.level.options.community'),
                ])
                ->default('community'),
            'website' => TextInput::make('website')->url()->maxLength(191),
            'logo' => TextInput::make('logo')->url()->maxLength(191),
            'contact_name' => TextInput::make('contact_name')->maxLength(191),
            'contact_email' => TextInput::make('contact_email')->email()->maxLength(191),
            'order' => TextInput::make('order')->numeric()->integer()->default(0),
            'description' => Textarea::make('description')->rows(3)->columnSpanFull(),
        ];
    }
}
