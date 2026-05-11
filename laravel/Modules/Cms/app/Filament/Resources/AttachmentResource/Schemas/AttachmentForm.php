<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Utilities\Get;
use Modules\Cms\Enums\AttachmentDiskEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class AttachmentForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')->required(),
            'slug' => TextInput::make('slug')->required(),
            'description' => Textarea::make('description'),
            'disk' => Select::make('disk')->options(AttachmentDiskEnum::class),
            'attachment' => FileUpload::make('attachment')
                ->directory('attachments')
                ->preserveFilenames()
                ->maxSize(10240)
                ->multiple(false)
                ->downloadable()
                ->openable()
                ->disk(fn (Get $get) => $get('disk')),
        ];
    }
}
