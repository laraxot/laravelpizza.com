<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MediaForm extends XotBaseResourceForm
{
    /**
     * Campi del form Media con etichette italiane da lang/it/media_form.php.
     *
     * @see Modules/Media/docs/manuals/manuale-utente.md
     *
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->label(__('media::media_form.fields.name.label')),
            'file_name' => TextInput::make('file_name')->label(__('media::media_form.fields.file_name.label')),
            'mime_type' => TextInput::make('mime_type')->label(__('media::media_form.fields.mime_type.label')),
            'disk' => TextInput::make('disk')->label(__('media::media_form.fields.disk.label')),
            'size' => TextInput::make('size')->numeric()->label(__('media::media_form.fields.size.label')),
            'collection_name' => TextInput::make('collection_name')->label(__('media::media_form.fields.collection_name.label')),
        ];
    }
}
