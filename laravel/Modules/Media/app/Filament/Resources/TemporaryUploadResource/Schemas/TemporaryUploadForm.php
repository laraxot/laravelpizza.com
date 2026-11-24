<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Schemas;

<<<<<<< HEAD
=======
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
        // Campi reali della tabella temporary_uploads (create_temporary_uploads_table): prima il form chiedeva
        // "folder" ed "expires_at", colonne che non esistono.
        return [
            'file_name' => TextInput::make('file_name')->required()->maxLength(255),
            'mime_type' => TextInput::make('mime_type')->maxLength(255),
            'file_size' => TextInput::make('file_size')->numeric()->minValue(0),
            'status' => TextInput::make('status')->required()->maxLength(32),
=======
        return [
            'file' => FileUpload::make('file')
                ->required()
                // niente ->preserveFilenames(): il nome scelto dal client su un disco servito dal web permette di caricare un .php eseguibile (audit DCP-181, B-1)
                ->acceptedFileTypes(['image/*', 'application/pdf', 'application/msword'])
                ->maxSize(10240),
            'folder' => TextInput::make('folder')->required()->maxLength(255),
            'expires_at' => DateTimePicker::make('expires_at')->required(),
>>>>>>> laraxot/dev
        ];

    }
}
