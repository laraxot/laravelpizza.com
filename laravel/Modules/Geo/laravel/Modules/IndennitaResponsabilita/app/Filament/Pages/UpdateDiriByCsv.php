<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\StabiDirigente;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Rep00f;
use RuntimeException;
use Throwable;

class UpdateDiriByCsv extends XotBasePage
{
    protected string $view = 'indennitaresponsabilita::filament.pages.import-csv';

    protected static string $icon = 'heroicon-o-upload'; // Add icon here

    protected static bool $shouldRegisterNavigation = false;

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('csvFile')
                ->label(__('indennitaresponsabilita::pages.update_diri_by_csv.fields.csvFile.label'))
                ->acceptedFileTypes(['text/csv', 'text/plain'])
                ->required()
                ->columnSpan('full'),
        ];
    }

    public function form(Schema $schema): Schema
    {
        /** @var array<int, Component> $components */
        $components = $this->getFormSchema();

        return $schema->components($components)
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->data;
        // dddx($data);

        if (! is_array($data) || ! isset($data['csvFile'])) {
            throw new RuntimeException(__('indennitaresponsabilita::pages.update_diri_by_csv.notifications.csv_not_provided'));
        }

        try {
            // $path = $this->handleFileUpload($data['csvFile']);
            /** @var string $csvFile */
            $csvFile = $data['csvFile'] ?? '';
            if ($csvFile === '') {
                throw new RuntimeException(__('indennitaresponsabilita::pages.update_diri_by_csv.notifications.path_not_provided'));
            }
            $path = Storage::disk('public')->path($csvFile);
            $records = $this->processCSV($path);

            // Call the updateDiri action with the CSV data
            $this->updateDiri($records);

            Notification::make()
                ->title(__('indennitaresponsabilita::pages.update_diri_by_csv.notifications.csv_processed'))
                ->success()
                ->send();
        } catch (Throwable $e) {
            // Handle errors and notify
            Notification::make()
                ->title(__('indennitaresponsabilita::pages.update_diri_by_csv.notifications.error'))
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function handleFileUpload(UploadedFile $file): string
    {
        $path = $file->storeAs('csv-uploads', $file->getClientOriginalName());
        if ($path === false) {
            throw new RuntimeException(__('indennitaresponsabilita::pages.update_diri_by_csv.notifications.failed_to_store'));
        }

        return $path;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function processCSV(string $path): array
    {
        $csv = Reader::createFromPath($path, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        /** @var list<array<string, mixed>> $rows */
        $rows = iterator_to_array($records);

        return $rows;
    }

    /**
     * @param  array<int, array<string, mixed>>  $data
     */
    public function updateDiri(array $data): void
    {
        $anno = 2024;
        $ente = 90;

        StabiDirigente::where('anno', $anno)
            ->where('matr', null)
            ->delete();

        $rows = [];

        // Example logic to process $data
        /** @var array<int, array<string, mixed>> $dataArray */
        $dataArray = $data;
        foreach ($dataArray as $record) {
            /** @var array<string, mixed> $record */
            // Process each record, example: map data to your models
            /** @var int|string|null $diri */
            $diri = $record['DIRI'] ?? null;
            if ($diri === null) {
                continue;
            }
            $where = [
                'anno' => $anno,
                'ente' => $ente,
                'matr' => $diri,
            ];

            $diris = StabiDirigente::where($where)->get();

            if ($diris->count() == 0) {
                $anag = Ana10f::firstWhere(Arr::only($where, ['ente', 'matr']));
                $rep = Rep00f::where(Arr::only($where, ['ente', 'matr']))
                    ->whereRaw('repann=""')
                    ->orderBy('rep2kd', 'desc')
                    ->first();

                if ($anag === null || $rep === null) {
                    continue; // Skip this record if anag or rep is not found
                }

                $data = $where;
                $data['nome_diri'] = $anag->conome.' '.$anag->nome;
                $data['stabi'] = $rep->repst1;
                $data['repar'] = $rep->repre1;
                StabiDirigente::create($data);
            }

            if ($diris->count() == 1) {
                $diri = $diris->first();
                if ($diri !== null) {
                    $diri->valutatore_id = $diri->id;
                    $diri->save();
                }
            }
            if ($diris->count() > 1) {
                dddx($diris);
            }

            $valutatore_id = $diris->where('valutatore_id', '!=', null)->first()?->id;
            if ($valutatore_id == null) {
                dddx('ERRORE');
            }
            /** @var int|string|null $matricola */
            $matricola = $record['Matricola'] ?? null;
            if ($matricola === null) {
                continue;
            }
            $where1 = [
                'anno' => $anno,
                'ente' => $ente,
                'matr' => $matricola,
            ];
            /** @var int $r */
            $r = IndennitaResponsabilita::where($where1)->update(['valutatore_id' => $valutatore_id]);
        }

        dddx($rows);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('submit')
                ->label(__('indennitaresponsabilita::pages.update_diri_by_csv.actions.submit'))
                ->action('submit'),
        ];
    }
}
