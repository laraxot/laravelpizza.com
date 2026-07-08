<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Storage;
use Modules\Xot\Actions\Import\ImportCsvAction;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * @property Schema $form
 */
class SqlUpload extends XotBasePage
{
    /**
     * Form data holder.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public string $disk = 'cache';

    protected string $view = 'sigma::filament.pages.sql-upload';

    public function mount(): void
    {
        // Form is initialized automatically by Filament
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('db')->default('generale')->required(),
            TextInput::make('tbl')->required(),
            FileUpload::make('attachment')
                // ->acceptedFileTypes(['application/pdf'])
                ->disk($this->disk)
                ->maxSize(5024000)
                ->preserveFilenames(),
            // TextInput::make('filename')
            //    ->required(),
        ])->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            /** @var array<string, mixed> $data */
            $data = $this->form->getState();
            /** @var string $filename */
            $filename = $data['attachment'] ?? '';
            if ($filename === '') {
                throw new \RuntimeException('Filename non specificato');
            }
            // $filename = $data['filename'];
            $storage = Storage::disk($this->disk);
            /** @var string $mimeType */
            $mimeType = $storage->mimeType($filename);
            /** @var string $path */
            $path = $storage->path($filename);
            /** @var array<string, string> $info */
            $info = pathinfo($path);
            if ($mimeType === 'application/zip') {
                $zip = new \ZipArchive;
                if ($zip->open($path) === true) {
                    $zip->extractTo(dirname($path));
                    $zip->close();
                } else {
                    dddx('failed');
                }
            }

            /** @var string $baseFilename */
            $baseFilename = $info['filename'] ?? '';
            $csvFilename = $baseFilename.'.csv';
            if (! $storage->exists($csvFilename)) {
                FilamentNotification::make()
                    ->title('Error')
                    ->body('File not found: '.$csvFilename)
                    ->danger()
                    ->persistent()
                    ->send();

                return;
            }
            /** @var string $db */
            $db = $data['db'] ?? '';
            /** @var string $tbl */
            $tbl = $data['tbl'] ?? '';
            app(ImportCsvAction::class)->execute($this->disk, $csvFilename, $db, $tbl);
        } catch (Halt $exception) {
            FilamentNotification::make()
                ->title('Error')
                ->body($exception->getMessage())
                ->danger()
                ->persistent()
                ->send();

            return;
        }
        FilamentNotification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
}
