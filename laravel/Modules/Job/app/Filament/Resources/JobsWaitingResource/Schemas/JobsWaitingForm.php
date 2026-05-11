<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class JobsWaitingForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'job_id' => TextInput::make('job_id')->required()->maxLength(255),
            'name' => TextInput::make('name')->maxLength(255),
            'queue' => TextInput::make('queue')->maxLength(255),
            'started_at' => DateTimePicker::make('started_at'),
            'finished_at' => DateTimePicker::make('finished_at'),
            'failed' => Toggle::make('failed')->required(),
            'attempt' => TextInput::make('attempt')->required(),
            'exception_message' => Textarea::make('exception_message')->maxLength(65535),
        ];

    }
}
