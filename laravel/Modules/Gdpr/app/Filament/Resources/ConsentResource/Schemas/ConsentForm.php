<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
<<<<<<< HEAD
use Filament\Schemas\Components\Component as SchemaComponent;
=======
>>>>>>> 40b96bcd6 (.)
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ConsentForm extends XotBaseResourceForm
{
    /**
<<<<<<< HEAD
     * @return array<int|string, SchemaComponent>
=======
     * @return array<int|string, \Filament\Schemas\Components\Component>
>>>>>>> 40b96bcd6 (.)
     */
    public static function getFormSchema(): array
    {
        return [
            'treatment_id' => Select::make('treatment_id')
                ->relationship('treatment', 'name')
                ->required(),
            'subject_id' => TextInput::make('subject_id')->required()->maxLength(191),
        ];
    }
}
