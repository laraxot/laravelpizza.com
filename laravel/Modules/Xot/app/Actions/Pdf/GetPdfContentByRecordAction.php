<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Log;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Html2Pdf;
use Webmozart\Assert\Assert;

/**
 * Action to generate PDF content as binary data from a specific Eloquent record.
 *
 * This action generates PDF content from an Eloquent model using automatic view
 * convention discovery. It's designed for email attachments, storage operations,
 * and other use cases requiring binary PDF content.
 */
class GetPdfContentByRecordAction
{
    use QueueableAction;

    /**
     * PDF engine configuration.
     */
    public PdfEngineEnum $engine = PdfEngineEnum::SPIPU;

    /**
     * Genera contenuto PDF binario da un record Eloquent.
     *
     * @param  Model  $record  Record Eloquent da cui generare il PDF
     * @param  string|null  $filename  Nome file PDF personalizzato (opzionale)
     * @return string Contenuto binario del PDF
     *
     * @throws Exception Se la vista non esiste o si verificano errori di generazione
     */
    public function execute(Model $record, ?string $filename = null): string
    {
        // Generate view name following Laraxot conventions
        $viewName = $this->generateViewName($record);

        // Prepare view parameters
        $viewParams = $this->prepareViewParameters($record, $viewName);

        // Validate view existence
        if (! view()->exists($viewName)) {
            throw new Exception("View '{$viewName}' not found for model ".$record::class);
        }

        // Render view to HTML
        $html = view($viewName, $viewParams)->render();

        // Validate HTML content
        Assert::string($html, 'Generated HTML content must be a valid string');

        if (empty(trim($html))) {
            throw new Exception("Generated HTML content is empty for view '{$viewName}'");
        }

        // Generate filename if not provided
        if ($filename === null) {
            $filename = $this->generateFilename($record);
        }

        // Generate PDF using spipu/html2pdf
        return $this->generatePdfContent($html, $filename);
    }

    /**
     * Metodo di convenienza per generare PDF da record con nome file personalizzato.
     *
     * @param  Model  $record  Record Eloquent
     * @param  string  $filename  Nome file personalizzato
     * @return string Contenuto binario del PDF
     */
    public function fromRecord(Model $record, string $filename): string
    {
        return $this->execute($record, $filename);
    }

    /**
     * Genera il nome della vista seguendo le convenzioni Laraxot.
     *
     * @param  Model  $record  Record Eloquent
     * @return string Nome della vista nel formato {module}::{model-kebab}.show.pdf
     */
    protected function generateViewName(Model $record): string
    {
        $modelClass = $record::class;
        $modelName = class_basename($modelClass);
        $module = Str::between($modelClass, 'Modules\\', '\\Models');

        return mb_strtolower($module).'::'.Str::kebab($modelName).'.show.pdf';
    }

    /**
     * Prepara i parametri standard per la vista.
     *
     * @param  Model  $record  Record Eloquent
     * @param  string  $viewName  Nome della vista
     * @return array<string, mixed> Parametri per la vista
     */
    protected function prepareViewParameters(Model $record, string $viewName): array
    {
        $modelClass = $record::class;
        $modelName = class_basename($modelClass);
        $module = Str::between($modelClass, 'Modules\\', '\\Models');

        $params = [
            'view' => $viewName,
            'row' => $record,
            'transKey' => mb_strtolower($module).'::'.Str::plural(mb_strtolower($modelName)).'.fields',
        ];

        // Add specific relationship data if available
        if (
            method_exists($record, 'valutatore') &&
                $record->relationLoaded('valutatore') &&
                isset($record->valutatore)
        ) {
            $valutatore = $record->valutatore;
            if (is_object($valutatore) && isset($valutatore->nome_diri)) {
                $params['firma'] = $valutatore->nome_diri;
            }
        }

        return $params;
    }

    /**
     * Genera nome file automatico basato sul record.
     *
     * @param  Model  $record  Record Eloquent
     * @return string Nome file generato
     */
    protected function generateFilename(Model $record): string
    {
        $modelName = class_basename($record::class);
        $recordKey = $record->getKey();
        $baseFilename = mb_strtolower($modelName).'_'.(string) ($recordKey ?? 'unknown');

        // Enhanced filename for records with identification fields
        if (isset($record->matr, $record->cognome, $record->nome)) {
            $matr = is_string($record->matr) ? $record->matr : 'unknown';
            $cognome = is_string($record->cognome) ? $record->cognome : 'unknown';
            $nome = is_string($record->nome) ? $record->nome : 'unknown';

            return 'scheda_'.(string) ($recordKey ?? 'unknown').'_'.$matr.'_'.$cognome.'_'.$nome.'.pdf';
        }

        // Enhanced filename for records with name field
        if (isset($record->name) && is_string($record->name)) {
            return $baseFilename.'_'.Str::slug($record->name).'.pdf';
        }

        // Default filename pattern
        return $baseFilename.'.pdf';
    }

    /**
     * Genera contenuto PDF binario utilizzando spipu/html2pdf.
     *
     * @param  string  $html  Contenuto HTML da convertire
     * @param  string  $filename  Nome file per riferimento
     * @return string Contenuto binario del PDF
     *
     * @throws Exception Se si verificano errori durante la generazione PDF
     */
    protected function generatePdfContent(string $html, string $filename): string
    {
        try {
            // Create Html2Pdf instance with standard configuration
            $html2pdf = new Html2Pdf(
                orientation: 'P', // Portrait
                format: 'A4', // A4 format
                lang: 'it', // Italian language
                unicode: true, // Unicode support
                encoding: 'UTF-8', // UTF-8 encoding
                margins: [10, 10, 10, 10], // 10mm margins on all sides
            );

            // Configure additional settings
            $html2pdf->setTestTdInOnePage(false);

            // Write HTML content to PDF
            $html2pdf->writeHTML($html);

            // Generate and return PDF content as binary string
            return $html2pdf->output('', 'S'); // 'S' returns string content
        } catch (Exception $e) {
            Log::error('PDF generation failed in GetPdfContentByRecordAction', [
                'filename' => $filename,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new Exception('Failed to generate PDF content: '.$e->getMessage(), 0, $e);
        }
    }
}
