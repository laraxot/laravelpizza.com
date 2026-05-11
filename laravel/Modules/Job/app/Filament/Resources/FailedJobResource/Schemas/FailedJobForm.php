<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedJobResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * FailedJobForm Schema.
 */
class FailedJobForm extends XotBaseResourceForm
{
    /**
     * Get the form schema.
     *
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'uuid' => TextInput::make('uuid')->disabled()->columnSpan(4),
            'failed_at' => TextInput::make('failed_at')->disabled(),
            'id' => TextInput::make('id')->disabled(),
            'connection' => TextInput::make('connection')->disabled(),
            'queue' => TextInput::make('queue')->disabled(),
            'exception' => Textarea::make('exception')
                ->disabled()
                ->columnSpan(4)
                ->extraInputAttributes(['style' => 'font-size: 80%;']),
            'payload' => Textarea::make('payload')
                ->disabled()
                ->columnSpan(4)
                ->extraInputAttributes(['style' => 'font-size: 80%;']),
        ];
    }
}
