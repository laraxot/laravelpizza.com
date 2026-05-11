<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Media\Filament\Resources\MediaResource;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MediaForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'file' => FileUpload::make('file')
                ->hint(MediaResource::trans('fields.file_hint'))
                ->storeFileNamesIn('original_file_name')
                ->visibility('private')
                ->required()
                ->columnSpanFull(),
            'attachment_type' => Radio::make('attachment_type'),
            'name' => TextInput::make('name')
                ->translateLabel()
                ->hint(MediaResource::trans('fields.name.hint'))
                ->autocomplete(false)
                ->maxLength(255)
                ->columnSpanFull(),
        ];

    }
}
