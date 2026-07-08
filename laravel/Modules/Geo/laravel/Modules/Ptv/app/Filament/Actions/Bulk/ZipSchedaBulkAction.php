<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Bulk;

use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Ptv\Actions\Scheda\GetFilenameBySchedaAction;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use ZipArchive;

class ZipSchedaBulkAction extends BulkAction
{
    public static function getDefaultName(): ?string
    {
        return 'zip_scheda';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('')
            ->tooltip('Zip Scheda')
            ->icon('fas-file-zipper')
            ->action(function ($livewire, $action, $records) {
                /** @var object{tableFilters?: array<string, mixed>} $livewire */
                /** @var Collection<int, Model> $records */
                $zip = new ZipArchive;
                /** @var array<string, mixed> $filters */
                $filters = $livewire->tableFilters ?? [];
                $zip_file = class_basename((string) get_class($livewire)).'-'.collect($filters)->flatten()->implode('-').'.zip';
                $zip_file = Storage::disk('cache')->path($zip_file);
                if ($zip->open($zip_file, ZipArchive::CREATE) === true) {
                    foreach ($records as $record) {
                        /** @var Model&SchedaContract $record */
                        // Genera contenuto PDF binario
                        $value = app(GetPdfContentByRecordAction::class)->execute($record);

                        // Genera nome file utilizzando GetFilenameBySchedaAction
                        // per garantire coerenza con il resto del modulo
                        $filename = app(GetFilenameBySchedaAction::class)->execute($record);

                        // Aggiunge il PDF allo zip con nome file dinamico
                        $zip->addFromString($filename, $value);
                    }

                    $zip->close();
                }

                return response()->download($zip_file);
            });
    }
}
