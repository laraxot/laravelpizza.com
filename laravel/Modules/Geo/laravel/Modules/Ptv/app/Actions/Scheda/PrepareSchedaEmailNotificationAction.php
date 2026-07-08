<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Prepara RecordNotification completa per invio scheda.
 *
 * Responsabilità:
 * - Creare RecordNotification con template
 * - Aggiungere dati custom per template
 * - Aggiungere allegato PDF binario
 *
 * @see \Modules\Ptv\docs\sendmail-refactoring-brutal-analysis.md
 */
class PrepareSchedaEmailNotificationAction
{
    use QueueableAction;

    /**
     * Prepara notification completa.
     *
     * @param  SchedaContract  $scheda  Record scheda
     * @param  string  $template  Template email slug
     * @param  string  $pdfContent  Contenuto binario PDF
     * @param  string  $pdfFilename  Nome file PDF
     * @return RecordNotification Notification pronta per invio
     */
    public function execute(
        SchedaContract $scheda,
        string $template,
        string $pdfContent,
        string $pdfFilename,
    ): RecordNotification {
        // Valida parametri
        Assert::stringNotEmpty($template, 'Template cannot be empty');
        Assert::stringNotEmpty($pdfContent, 'PDF content cannot be empty');
        Assert::stringNotEmpty($pdfFilename, 'PDF filename cannot be empty');

        // RecordNotification richiede Model, cast necessario
        // SchedaContract è sempre implementato da Model Eloquent
        Assert::isInstanceOf($scheda, Model::class, 'Scheda must be Eloquent Model');

        // Prepara dati custom per template email
        $customData = $this->prepareTemplateData($scheda);

        // Prepara allegato PDF binario
        $attachments = [
            [
                'data' => $pdfContent,
                'as' => $pdfFilename,
                'mime' => 'application/pdf',
            ],
        ];

        // Crea notification
        $notification = new RecordNotification($scheda, $template);
        $notification = $notification->mergeData($customData);
        $notification = $notification->addAttachments($attachments);

        return $notification;
    }

    /**
     * Prepara dati custom per template email.
     *
     * Dati extra disponibili in template Blade per personalizzazione.
     *
     * @return array<string, mixed>
     */
    private function prepareTemplateData(SchedaContract $scheda): array
    {
        // Dati extra per template email
        // Al momento vuoto, estendibile per personalizzazioni future
        // Esempio: link diretto scheda, messaggi custom, ecc.

        return [
            // 'link_scheda' => route('scheda.show', $scheda->id),
            // 'messaggio_custom' => 'Buona valutazione!',
        ];
    }
}
