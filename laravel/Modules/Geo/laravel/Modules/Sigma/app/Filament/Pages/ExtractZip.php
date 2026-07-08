<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Xot\Filament\Pages\XotBasePage;
use ZipArchive;

class ExtractZip extends XotBasePage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-up';

    protected string $view = 'sigma::filament.pages.sql-upload';

    /** @var Schema */
    public $form;

    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'disk' => TextInput::make('disk')->default('cache')->required(),
            'path' => TextInput::make('path')->default('PTV_Asz00f.zip')->required(),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $storage = Storage::disk((string) $data['disk']);

        // Verifica se il file esiste
        if (! $storage->exists((string) $data['path'])) {
            FilamentNotification::make()
                ->title(__('sigma::extract_zip.messages.file_not_found.title'))
                ->body(__('sigma::extract_zip.messages.file_not_found.body', ['path' => (string) $data['path']]))
                ->danger()
                ->persistent()
                ->send();

            return;
        }

        $mime_type = $storage->mimeType((string) $data['path']);
        $path = $storage->path((string) $data['path']);
        pathinfo($path);

        if ($mime_type !== 'application/zip') {
            FilamentNotification::make()
                ->title(__('sigma::extract_zip.messages.invalid_zip.title'))
                ->body(__('sigma::extract_zip.messages.invalid_zip.body', ['path' => (string) $data['path']]))
                ->danger()
                ->persistent()
                ->send();

            return;
        }

        $zip = new ZipArchive;
        if ($zip->open($path) === true) {
            $extractPath = dirname($path);
            $zip->extractTo($extractPath);

            // Mostra informazioni sui file estratti
            $extractedFiles = [];
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                $extractedFiles[] = $filename;
            }

            $zip->close();

            // Notifica di successo con dettagli
            FilamentNotification::make()
                ->title(__('sigma::extract_zip.messages.extraction_success.title'))
                ->body(__('sigma::extract_zip.messages.extraction_success.body', ['path' => $extractPath]))
                ->success()
                ->persistent()
                ->send();

            // Debug: mostra la directory di estrazione
            dddx([
                'extract_path' => $extractPath,
                'total_files' => count($extractedFiles),
                'files' => $extractedFiles,
                'storage_disk' => (string) $data['disk'],
                'original_zip' => (string) $data['path'],
            ]);
        } else {
            FilamentNotification::make()
                ->title(__('sigma::extract_zip.messages.zip_open_error.title'))
                ->body(__('sigma::extract_zip.messages.zip_open_error.body'))
                ->danger()
                ->persistent()
                ->send();
        }
    }
}
