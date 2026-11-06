<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form della coda `jobs` (model JobsWaiting): solo colonne reali della tabella.
 * `reserved_at` e `available_at` sono timestamp unix (int), non datetime.
 */
class JobsWaitingForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'queue' => TextInput::make('queue')->required()->maxLength(255),
            'payload' => Textarea::make('payload')->required(),
            'attempts' => TextInput::make('attempts')->numeric()->required(),
            'reserved_at' => TextInput::make('reserved_at')->numeric(),
            'available_at' => TextInput::make('available_at')->numeric()->required(),
        ];
    }
}
