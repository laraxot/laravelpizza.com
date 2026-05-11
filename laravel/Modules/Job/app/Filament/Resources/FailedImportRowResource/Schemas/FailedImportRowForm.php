<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedImportRowResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class FailedImportRowForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'import_class' => TextInput::make('import_class')->required()->maxLength(255),
            'row_number' => TextInput::make('row_number')->numeric()->required(),
            'row_data' => Textarea::make('row_data')->required()->columnSpanFull(),
            'error_message' => Textarea::make('error_message')->required()->columnSpanFull(),
        ];

    }
}
