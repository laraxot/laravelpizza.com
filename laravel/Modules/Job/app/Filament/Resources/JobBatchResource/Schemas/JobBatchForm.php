<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobBatchResource\Schemas;

<<<<<<< HEAD
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * JobBatchForm Schema.
 */
class JobBatchForm extends XotBaseResourceForm
{
    /**
     * Get the form schema.
     *
     * @return array<string, Component>
=======
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class JobBatchForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
>>>>>>> 40b96bcd6 (.)
     */
    public static function getFormSchema(): array
    {
        return [
<<<<<<< HEAD
            'id' => TextInput::make('id')->required()->maxLength(255),
            'name' => TextInput::make('name')->required()->maxLength(255),
            'total_jobs' => TextInput::make('total_jobs')->numeric()->required(),
            'pending_jobs' => TextInput::make('pending_jobs')->numeric()->required(),
            'failed_jobs' => TextInput::make('failed_jobs')->numeric()->required(),
            'failed' => Toggle::make('failed')->required(),
            'options' => Textarea::make('options')->maxLength(65535),
            'created_at' => DateTimePicker::make('created_at')->required(),
            'cancelled_at' => DateTimePicker::make('cancelled_at'),
            'finished_at' => DateTimePicker::make('finished_at'),
=======
            Section::make([
                'name' => TextInput::make('name'),
            ]),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
