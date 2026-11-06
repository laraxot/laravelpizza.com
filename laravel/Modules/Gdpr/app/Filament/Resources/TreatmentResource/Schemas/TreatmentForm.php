<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TreatmentForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            Section::make([
                'active' => Toggle::make('active')->required(),
                'required' => Toggle::make('required')->required(),
                'name' => TextInput::make('name')->required()->maxLength(191),
                'description' => Textarea::make('description')->required()->columnSpanFull(),
                'documentVersion' => TextInput::make('documentVersion')->maxLength(191)->default(null),
                'documentUrl' => TextInput::make('documentUrl')->maxLength(191)->default(null),
                'weight' => TextInput::make('weight')->required()->numeric(),
            ]),
        ];
    }
}
