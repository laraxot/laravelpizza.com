<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Schemas;

<<<<<<< HEAD
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
=======
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
>>>>>>> 40b96bcd6 (.)
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TreatmentForm extends XotBaseResourceForm
{
    /**
<<<<<<< HEAD
     * @return array<int|string, SchemaComponent>
=======
     * @return array<int|string, \Filament\Forms\Components\Component>
>>>>>>> 40b96bcd6 (.)
     */
    public static function getFormSchema(): array
    {
        return [
<<<<<<< HEAD
            'active' => Toggle::make('active')->required(),
            'required' => Toggle::make('required')->required(),
            'name' => TextInput::make('name')->required()->maxLength(191),
            'description' => Textarea::make('description')->required()->columnSpanFull(),
            'documentVersion' => TextInput::make('documentVersion')->maxLength(191)->default(null),
            'documentUrl' => TextInput::make('documentUrl')->maxLength(191)->default(null),
            'weight' => TextInput::make('weight')->required()->numeric(),
=======
            Section::make([
                'name' => TextInput::make('name'),
            ]),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
