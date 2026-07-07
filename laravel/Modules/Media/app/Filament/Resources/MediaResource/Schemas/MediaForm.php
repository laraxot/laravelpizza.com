<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Schemas;

use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MediaForm extends XotBaseResourceForm
{
    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name'),
            'file_name' => TextInput::make('file_name'),
            'mime_type' => TextInput::make('mime_type'),
            'disk' => TextInput::make('disk'),
            'size' => TextInput::make('size')->numeric(),
            'collection_name' => TextInput::make('collection_name'),
        ];
    }
}
