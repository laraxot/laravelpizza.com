<?php

declare(strict_types=1);

namespace Modules\Media\Actions;

use Webmozart\Assert\Assert;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GetAttachmentsSchemaAction
{
    public function execute(array $attachments, string $disk = 'attachments'): array
    {
        $form = [];
        $sessionId = session()->getId();
        $prefix = Config::string('media-library.prefix');

        $sessionDir = "session-uploads/{$sessionId}";
        if ($prefix !== '') {
            $sessionDir = $prefix.'/'.$sessionDir;
        }
        foreach ($attachments as $attachment) {
            $attachmentStr = (string) $attachment;
            $form[$attachmentStr] = FileUpload::make($attachmentStr)
                // $form[$attachment]=SpatieMediaLibraryFileUpload::make($attachment)
                ->directory($sessionDir)
                ->disk($disk)
                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                ->maxSize(5120 * 2)
                ->preserveFilenames()
                ->required()
                ->previewable(false)
                // ->saveUploadedFiles()
                ->afterStateUpdated(function ($state, Set $set) use ($attachment, $sessionDir, $disk): void {
                    if (! $state) {
                        return;
                    }
                    $state = Arr::wrap($state);

                    $sessionFiles = [];

                    foreach ($state as $file) {
                        if ($file instanceof TemporaryUploadedFile) {
                            // Salva direttamente nella directory di sessione
                            $fileName = time().'_'.$file->getClientOriginalName();
                            $sessionPath = $file->storeAs($sessionDir, $fileName, $disk);
                            $sessionFiles[] = $sessionPath;
                        } else {
                            // È già un percorso salvato
                            $sessionFiles[] = $file;
                        }
                    }

                    // Set expects Component|string, pass attachment as string
                    Assert::string($attachment, 'Attachment must be string');
                    $set($attachment, $sessionFiles);
                });
        }

        return $form;
    }
}
