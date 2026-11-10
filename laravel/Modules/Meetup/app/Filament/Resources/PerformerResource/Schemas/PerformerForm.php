<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\PerformerResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Usato anche dal form evento per creare un performer senza uscire dalla pagina (createOptionForm).
 */
class PerformerForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required()->maxLength(191),
            'type' => Select::make('type')
                ->options([
                    'speaker' => __('meetup::performer_form.fields.type.options.speaker'),
                    'host' => __('meetup::performer_form.fields.type.options.host'),
                    'moderator' => __('meetup::performer_form.fields.type.options.moderator'),
                ])
                ->default('speaker'),
            'company' => TextInput::make('company')->maxLength(191),
            'email' => TextInput::make('email')->email()->maxLength(191),
            'website' => TextInput::make('website')->url()->maxLength(191),
            'github' => TextInput::make('github')->maxLength(191),
            'linkedin' => TextInput::make('linkedin')->url()->maxLength(191),
            'twitter' => TextInput::make('twitter')->maxLength(191),
            'bio' => Textarea::make('bio')->rows(4)->columnSpanFull(),
        ];
    }
}
