<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Pages;

use Illuminate\Support\Str;
use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateAttachment extends LangBaseCreateRecord
{
    protected static string $resource = AttachmentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle translatable attachment field for FileUpload in create mode
        if (isset($data['attachment']) && is_string($data['attachment']) && ! empty($data['attachment'])) {
            $currentLocale = app()->getLocale();

            // Generate UUID for the file
            $uuid = (string) Str::uuid();

            // Extract filename from path if it's a full path
            $filename = basename($data['attachment']);

            // Set the structure: locale -> {uuid: filename}
            $data['attachment'] = [
                $currentLocale => [$uuid => $filename],
            ];
        }

        /* @phpstan-ignore-next-line */
        return parent::mutateFormDataBeforeSave($data);
    }
}
