<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Export;

// use Modules\Xot\Services\ArrayService;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Xot\Exports\ViewExport;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Classe per l'esportazione di viste in formato Excel.
 */
class ExportXlsByView
{
    use QueueableAction;

    /**
     * Esporta una vista in Excel.
     *
     * @param  View  $view  La vista da esportare
     * @param  array<int, string>  $fields  Campi da includere nell'export
     * @param  string  $filename  Nome del file Excel
     * @param  string|null  $transKey  Chiave di traduzione per i campi
     */
    public function execute(
        View $view,
        array $fields,
        string $filename = 'test.xlsx',
        ?string $transKey = null,
    ): BinaryFileResponse {
        // Assicuriamo che $fields sia un array di stringhe
        $stringFields = array_map(strval(...), array_values($fields));

        $export = new ViewExport(
            view: $view,
            transKey: $transKey,
            fields: $stringFields,
        );

        return Excel::download($export, $filename);
    }
}
