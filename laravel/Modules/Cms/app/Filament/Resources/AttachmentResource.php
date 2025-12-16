<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Modules\Cms\Enums\AttachmentDiskEnum;
use Modules\Cms\Filament\Resources\AttachmentResource\Pages\CreateAttachment;
use Modules\Cms\Filament\Resources\AttachmentResource\Pages\EditAttachment;
use Modules\Cms\Filament\Resources\AttachmentResource\Pages\ListAttachments;
use Modules\Cms\Models\Attachment;
use Modules\Lang\Filament\Resources\LangBaseResource;

class AttachmentResource extends LangBaseResource
{
    protected static ?string $model = Attachment::class;

    /**
     * @return array<string, \Filament\Support\Components\Component>
     */
    #[\Override]
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

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListAttachments::route('/'),
            'create' => CreateAttachment::route('/create'),
            'edit' => EditAttachment::route('/{record}/edit'),
        ];
    }
}
