<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * JobForm Schema.
 */
class JobForm extends XotBaseResourceForm
{
    /**
     * Get the form schema.
     *
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'queue' => TextInput::make('queue')->required()->maxLength(255),
            'payload' => TextInput::make('payload')->required(),
            'attempts' => TextInput::make('attempts')->numeric()->required(),
            'available_at' => DateTimePicker::make('available_at')->required(),
            'created_at' => DateTimePicker::make('created_at')->required(),
        ];
    }
}
