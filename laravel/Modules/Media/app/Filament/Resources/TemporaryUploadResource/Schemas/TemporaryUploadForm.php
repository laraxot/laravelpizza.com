<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TemporaryUploadForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'file' => FileUpload::make('file')
                ->required()
                // niente ->preserveFilenames(): il nome scelto dal client su un disco servito dal web permette di caricare un .php eseguibile (audit DCP-181, B-1)
                ->acceptedFileTypes(['image/*', 'application/pdf', 'application/msword'])
                ->maxSize(10240),
            'folder' => TextInput::make('folder')->required()->maxLength(255),
            'expires_at' => DateTimePicker::make('expires_at')->required(),
        ];

    }
}
