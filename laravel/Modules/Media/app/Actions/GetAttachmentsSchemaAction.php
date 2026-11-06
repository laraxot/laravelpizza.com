<?php

declare(strict_types=1);

namespace Modules\Media\Actions;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Arr;
use Modules\Media\Datas\MediaConfigData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetAttachmentsSchemaAction
{
    use QueueableAction;

    /**
     * @param  array<array-key, string>  $attachments
     * @return list<FileUpload>
     */
    public function execute(array $attachments, string $disk = 'attachments'): array
    {
        $form = [];
        // Limiti dalla SettingPage di Media (prima scritti qui: 10 MB, pdf/doc/docx).
        $config = MediaConfigData::make();

        foreach ($attachments as $attachment) {
            $form[] = FileUpload::make($attachment)
                ->directory('temp')
                ->disk($disk)
                ->acceptedFileTypes($config->attachment_mime_types)
                ->maxSize($config->attachment_max_size_kb)
                ->visibility('public')
                ->preserveFilenames()
                ->required()
                ->previewable()
                ->downloadable()
                ->reorderable(false)
                ->multiple(false)
                /**
                 * `mixed $state` voluto: lo stato FileUpload e' eterogeneo
                 * (TemporaryUploadedFile|array|string|null) — Arr::wrap lo normalizza.
                 */
                ->afterStateUpdated(function (mixed $state, Set $set) use ($attachment): void {
                    if (! $state) {
                        return;
                    }
                    $state = Arr::wrap($state);

                    $sessionFiles = [];

                    foreach ($state as $file) {
                        $sessionFiles[] = $file;
                    }

                    Assert::string($attachment, 'Attachment must be string');
                    $set($attachment, $sessionFiles);
                });

        }

        return $form;
    }
}
