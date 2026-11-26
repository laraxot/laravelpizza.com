<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class TemporaryUploadForm extends XotBaseResourceForm
{
    /**
     * Campi reali di temporary_uploads con etichette italiane da lang/it/temporary_upload_form.php.
     *
     * @see Modules/Media/docs/manuals/manuale-utente.md
     *
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        // Campi reali della tabella temporary_uploads (create_temporary_uploads_table): prima il form chiedeva
        // "folder" ed "expires_at", colonne che non esistono.
        return [
            'file_name' => TextInput::make('file_name')->label(__('media::temporary_upload_form.fields.file_name.label'))->required()->maxLength(255),
            'mime_type' => TextInput::make('mime_type')->label(__('media::temporary_upload_form.fields.mime_type.label'))->maxLength(255),
            'file_size' => TextInput::make('file_size')->label(__('media::temporary_upload_form.fields.file_size.label'))->numeric()->minValue(0),
            'status' => TextInput::make('status')->label(__('media::temporary_upload_form.fields.status.label'))->required()->maxLength(32),
        ];
    }
}
