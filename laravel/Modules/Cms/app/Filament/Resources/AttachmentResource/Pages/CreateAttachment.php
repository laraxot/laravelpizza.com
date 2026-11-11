<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Pages;

use Illuminate\Support\Str;
use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreateAttachment extends LangBaseCreateRecord
{
    public static string $resource = AttachmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle translatable attachment field for FileUpload in create mode
        if (isset($data['attachment']) && is_string($data['attachment']) && $data['attachment'] !== '') {
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

        return parent::mutateFormDataBeforeCreate($data);
    }
}
