<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Activity;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Sigma\Models\Traits\SchedaTrait;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Log invio email scheda valutazione.
 *
 * Traccia ogni invio email (success/failure) con dati business-critical
 * per compliance, audit trail e analytics.
 *
 * @see \Modules\Ptv\docs\activity-log-email-tracking-implementation.md
 */
class LogSchedaEmailSentAction
{
    use QueueableAction;

    /**
     * Logga invio email scheda.
     *
     * @param  SchedaContract  $scheda  Record scheda inviata
     * @param  string  $recipient  Destinatario email
     * @param  string  $template  Template email utilizzato
     * @param  string  $pdfFilename  Nome file PDF allegato
     * @param  int  $pdfSizeBytes  Dimensione PDF in bytes
     * @param  bool  $success  Se invio è riuscito
     * @param  string|null  $error  Messaggio errore (se fallito)
     * @return Activity Activity record creato
     */
    public function execute(
        SchedaContract $scheda,
        string $recipient,
        string $template,
        string $pdfFilename,
        int $pdfSizeBytes,
        bool $success = true,
        ?string $error = null,
    ): Activity {
        // Valida parametri critici
        Assert::email($recipient, 'Recipient must be valid email');
        Assert::greaterThan($pdfSizeBytes, 0, 'PDF size must be greater than 0');

        // Cast scheda a Model per activity log
        // SchedaContract è sempre implementato da Model, ma PHPStan richiede cast esplicito
        Assert::isInstanceOf($scheda, Model::class, 'Scheda must be Eloquent Model');

        // Estrai dati scheda (safe, no accessor)
        $schedaData = $this->extractSchedaData($scheda);

        // Prepara metadati email
        $emailData = $this->prepareEmailMetadata(
            recipient: $recipient,
            template: $template,
            pdfFilename: $pdfFilename,
            pdfSizeBytes: $pdfSizeBytes,
        );

        // Prepara result data
        $resultData = [
            'success' => $success,
            'error' => $error,
        ];

        // Merge tutte le properties
        $properties = [
            'scheda' => $schedaData,
            'email' => $emailData,
            'result' => $resultData,
        ];

        // Crea activity log (cast necessario per performedOn)
        $activityLog = activity()
            ->performedOn($scheda) // OK dopo Assert::isInstanceOf
            ->causedBy(auth()->user())
            ->withProperties($properties)
            ->log($success
                ? 'Email scheda valutazione inviata con successo'
                : 'Tentativo invio email scheda fallito: '.$error
            );

        // activity() può restituire null, gestisci il caso
        Assert::isInstanceOf($activityLog, Activity::class, 'Activity log creation failed');

        return $activityLog;
    }

    /**
     * Estrae dati business-critical dalla scheda.
     *
     * IMPORTANTE: Usa getAttributes() per evitare accessor problematici.
     * SchedaTrait ha 48 accessor che chiamano save() causando Duplicate Entry.
     *
     * @return array<string, mixed>
     *
     * @see SchedaTrait
     * @see \Modules\Ptv\docs\performance\base-scheda-performance-bottleneck.md
     */
    private function extractSchedaData(SchedaContract $scheda): array
    {
        // Cast a Model per accesso a getAttributes()
        // SchedaContract è interfaccia, implementazioni concrete sono sempre Model
        if (! $scheda instanceof Model) {
            // Fallback: dati minimali se non è Model
            return [
                'id' => isset($scheda->id) ? $scheda->id : null,
                'note' => 'Scheda non è Model Eloquent, dati limitati',
            ];
        }

        // Usa getAttributes() per accesso diretto ai campi database
        // EVITA accessor che chiamano save() (problema SchedaTrait)
        $attributes = $scheda->getAttributes();

        // Valida che getAttributes() restituisca array
        Assert::isArray($attributes, 'getAttributes() must return array');

        // Dati identificativi
        $data = [
            'id' => $attributes['id'] ?? null,
            'anno' => $attributes['anno'] ?? null,
            'matr' => $attributes['matr'] ?? null,
            'cognome' => $attributes['cognome'] ?? null,
            'nome' => $attributes['nome'] ?? null,
        ];

        // Dati valutazione business-critical
        $data['valutatore_id'] = $attributes['valutatore_id'] ?? null;
        $data['stabi'] = $attributes['stabi'] ?? null;
        $data['coordinamento'] = $attributes['coordinamento'] ?? null;
        $data['responsabilita'] = $attributes['responsabilita'] ?? null;
        $data['gg_anno'] = $attributes['gg_anno'] ?? null;

        // Se valutatore è caricato, aggiungi nome (safe, è relazione)
        // $scheda è Model dopo Assert, relationLoaded() esiste sempre
        if ($scheda->relationLoaded('valutatore')) {
            /** @var mixed $valutatore */
            $valutatore = $scheda->getAttribute('valutatore');
            if (is_object($valutatore) && isset($valutatore->nome)) {
                $data['valutatore_nome'] = $valutatore->nome;
            }
        }

        return $data;
    }

    /**
     * Prepara metadati email per activity log.
     *
     * @return array<string, mixed>
     */
    private function prepareEmailMetadata(
        string $recipient,
        string $template,
        string $pdfFilename,
        int $pdfSizeBytes,
    ): array {
        $authUser = auth()->user();

        return [
            'recipient' => $recipient,
            'template' => $template,
            'pdf_filename' => $pdfFilename,
            'pdf_size_bytes' => $pdfSizeBytes,
            'pdf_size_kb' => round($pdfSizeBytes / 1024, 2),
            'sent_at' => now()->toDateTimeString(),
            'sent_by_user_id' => auth()->id(),
            'sent_by_user_name' => $authUser ? $authUser->name : 'System',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }
}
