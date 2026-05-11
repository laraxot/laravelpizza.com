<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\EventResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class EventForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'treatment_id' => TextInput::make('treatment_id')->maxLength(36)->default(null),
            'consent_id' => Select::make('consent_id')->relationship('consent', 'id'),
            'subject_id' => TextInput::make('subject_id')->required()->maxLength(191),
            'ip' => TextInput::make('ip')->required()->maxLength(191),
            'action' => TextInput::make('action')->required()->maxLength(191),
            'payload' => Textarea::make('payload')->required()->columnSpanFull(),
        ];
    }
}
