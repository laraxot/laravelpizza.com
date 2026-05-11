<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ConsentForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
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
