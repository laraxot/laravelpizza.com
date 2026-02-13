<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Export;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Xot\Exports\CollectionExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Classe per l'esportazione di collezioni in formato Excel.
 */
class ExportXlsByCollection
{
    use QueueableAction;

    /**
     * Esporta una collezione in Excel.
     *
     * @param  Collection<int|string, mixed>|EloquentCollection<int, Model>  $collection  La collezione da esportare
     * @param  string  $filename  Nome del file Excel
     * @param  string|null  $transKey  Chiave di traduzione per i campi
     * @param  array<int, string>  $fields  Campi da includere nell'export
     */
    public function execute(
        Collection|EloquentCollection $collection,
        string $filename = 'test.xlsx',
        ?string $transKey = null,
        array $fields = [],
    ): BinaryFileResponse {
        // Assicuriamo che $fields sia un array di stringhe
        $stringFields = array_map(fn (mixed $field): string => (string) $field, array_values($fields));

        $export = new CollectionExport(
            collection: $collection,
            transKey: $transKey,
            fields: $stringFields,
        );

        return Excel::download($export, $filename);
    }

    /**
     * Esporta una collezione in Excel utilizzando PhpSpreadsheet direttamente.
     *
     * @param  Collection<int|string, mixed>|EloquentCollection<int, Model>  $rows  La collezione da esportare
     * @param  array<int, string>  $fields  Campi da includere nell'export
     * @param  string  $filename  Nome del file Excel
     * @return string Il percorso del file generato
     */
    public function executeWithSpreadsheet(Collection|EloquentCollection $rows, array $fields, string $filename): string
    {
        // Converte EloquentCollection in Support\Collection se necessario
        if ($rows instanceof EloquentCollection) {
            $rows = Collection::make($rows->toArray());
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->writeHeader($sheet, $fields);
        $this->writeRows($sheet, $rows, $fields);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }

    /**
     * Scrive l'intestazione nel foglio Excel.
     *
     * @param  Worksheet  $sheet  Il foglio Excel
     * @param  array<int, string>  $fields  I campi da utilizzare come intestazioni
     */
    protected function writeHeader(Worksheet $sheet, array $fields): void
    {
        foreach ($fields as $col => $field) {
            $sheet->setCellValueByColumnAndRow($col + 1, 1, $field);
        }
    }

    /**
     * Scrive le righe nel foglio di lavoro.
     *
     * @param  Worksheet  $sheet  Il foglio di lavoro
     * @param  Collection<int|string, mixed>  $rows  I dati da scrivere
     * @param  array<int, string>  $fields  I campi da utilizzare per le colonne
     */
    protected function writeRows(Worksheet $sheet, Collection $rows, array $fields): void
    {
        $row = 2;
        foreach ($rows as $data) {
            foreach ($fields as $col => $field) {
                $value = $this->extractValue($data, $field);
                $sheet->setCellValueByColumnAndRow($col + 1, $row, $value);
            }
            $row++;
        }
    }

    /**
     * Estrae il valore da un oggetto o array usando il campo specificato.
     *
     * @param  mixed  $data  I dati da cui estrarre il valore
     * @param  string  $field  Il campo da estrarre
     * @return mixed Il valore estratto
     */
    protected function extractValue(mixed $data, string $field): mixed
    {
        // Usa data_get di Laravel per accesso sicuro ai dati nidificati
        return data_get($data, $field, '');
    }

    /**
     * Converte EloquentCollection in Support\Collection mantenendo i dati.
     *
     * @param  EloquentCollection<int, Model>  $eloquentCollection
     * @return Collection<int, mixed>
     */
    protected function convertToSupportCollection(EloquentCollection $eloquentCollection): Collection
    {
        return Collection::make($eloquentCollection->toArray());
    }
}
