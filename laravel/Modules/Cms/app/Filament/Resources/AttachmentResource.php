<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Modules\Cms\Filament\Resources\AttachmentResource\Pages\CreateAttachment;
use Modules\Cms\Filament\Resources\AttachmentResource\Pages\EditAttachment;
use Modules\Cms\Filament\Resources\AttachmentResource\Pages\ListAttachments;
use Modules\Cms\Models\Attachment;
use Modules\Lang\Filament\Resources\LangBaseResource;

class AttachmentResource extends LangBaseResource
{
    protected static ?string $model = Attachment::class;

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttachments::route('/'),
            'create' => CreateAttachment::route('/create'),
            'edit' => EditAttachment::route('/{record}/edit'),
        ];
    }
}
