<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Schemas;

<<<<<<< HEAD
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Media\Filament\Resources\MediaResource;
=======
use Filament\Forms\Components\TextInput;
>>>>>>> 40b96bcd6 (.)
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MediaForm extends XotBaseResourceForm
{
    /**
<<<<<<< HEAD
     * @return array<int|string, SchemaComponent>
=======
     * @return array<string, \Filament\Schemas\Components\Component>
>>>>>>> 40b96bcd6 (.)
     */
    public static function getFormSchema(): array
    {
        return [
<<<<<<< HEAD
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

=======
            'name' => TextInput::make('name'),
            'file_name' => TextInput::make('file_name'),
            'mime_type' => TextInput::make('mime_type'),
            'disk' => TextInput::make('disk'),
            'size' => TextInput::make('size')->numeric(),
            'collection_name' => TextInput::make('collection_name'),
        ];
>>>>>>> 40b96bcd6 (.)
    }
}
