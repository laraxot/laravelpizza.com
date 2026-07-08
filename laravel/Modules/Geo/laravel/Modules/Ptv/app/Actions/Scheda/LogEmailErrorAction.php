<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function activity;

/**
 * Action per registrare activity log di errore invio email.
 *
 * Questa action centralizza la logica di logging per errori di invio email,
 * garantendo coerenza e riutilizzabilità in tutto il modulo.
 */
class LogEmailErrorAction
{
    use QueueableAction;

    /**
     * Registra activity log per errore invio email.
     *
     * @param  SchedaContract  $record  Record della scheda
     * @param  User  $user  Utente che ha tentato l'invio
     * @param  string  $template  Template email utilizzato
     * @param  string  $recipient  Destinatario email
     * @param  string  $filename  Nome file PDF allegato
     * @param  string  $pdfContent  Contenuto PDF binario (per calcolo dimensione)
     * @param  Exception  $exception  Eccezione catturata
     */
    public function execute(
        SchedaContract $record,
        User $user,
        string $template,
        string $recipient,
        string $filename,
        string $pdfContent,
        Exception $exception
    ): void {
        // Verifica che il record sia un Model per activity log
        Assert::isInstanceOf($record, Model::class);

        // Prepara i dati di valutazione
        $evaluationData = app(PrepareEvaluationDataAction::class)
            ->execute($record);

        // Registra activity log con dettagli errore
        activity()
            ->performedOn($record)
            ->causedBy($user)
            ->withProperties([
                'template' => $template,
                'recipient' => $recipient,
                'filename' => $filename,
                'evaluation_data' => $evaluationData,
                'pdf_size' => strlen($pdfContent),
                'error' => $exception->getMessage(),
                'error_class' => get_class($exception),
            ])
            ->log('Errore invio email per scheda');
    }
}
