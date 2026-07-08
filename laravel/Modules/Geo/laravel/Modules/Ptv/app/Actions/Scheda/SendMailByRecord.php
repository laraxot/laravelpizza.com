<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Ptv\Data\EmailSentLogData;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\User\Models\User;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Spatie\QueueableAction\QueueableAction;

class SendMailByRecord
{
    use QueueableAction;

    /**
     * Invia una mail relativa al record della scheda.
     *
     * Traccia automaticamente l'invio in activity log con dati scheda e metadati email.
     *
     * @param  SchedaContract  $record  Il record della scheda per cui inviare la mail
     * @param  string  $template  Template email da utilizzare
     * @return bool True se l'invio è andato a buon fine
     *
     * @throws AuthorizationException Se l'utente non ha i permessi
     * @throws Exception Se invio email fallisce
     */
    public function execute(SchedaContract $record, string $template = 'schede'): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->can('sendMail', $record)) {
            abort(403, 'Unauthorized action.');
        }

        // Verifica che il record sia un Model per compatibilità con GetPdfContentByRecordAction
        if (! ($record instanceof Model)) {
            throw new Exception('Record must be an instance of Model');
        }

        // Carica la relazione valutatore se esiste e non è già caricata
        if (
            method_exists($record, 'valutatore')
            && ! $record->relationLoaded('valutatore')
        ) {
            $record->load('valutatore');
        }

        // Genera il contenuto PDF binario utilizzando GetPdfContentByRecordAction
        // Questo action gestisce automaticamente:
        // - La ricerca della view PDF seguendo le convenzioni Laraxot
        // - La preparazione dei parametri per la view (incluso valutatore se caricato)
        // - La conversione HTML -> PDF utilizzando spipu/html2pdf
        // - Il ritorno del contenuto binario del PDF
        $pdfContent = app(GetPdfContentByRecordAction::class)
            ->execute($record);

        // Genera nome file dinamico utilizzando GetFilenameBySchedaAction
        // Questa action centralizza la logica di generazione del nome file,
        // garantendo coerenza e riutilizzabilità in tutto il modulo
        $filename = app(GetFilenameBySchedaAction::class)
            ->execute($record);

        // Prepara i dati aggiuntivi per il template email
        $data = [];

        // Prepara gli allegati con il contenuto PDF binario
        // Il formato supportato da SpatieEmail::addAttachments() è:
        // - 'path' => percorso al file (se il file esiste su filesystem)
        // - 'data' => contenuto binario del file (per file generati dinamicamente)
        // - 'as' => nome del file nell'email
        // - 'mime' => tipo MIME del file
        $attachments = [
            [
                'data' => $pdfContent, // Contenuto binario del PDF generato
                'as' => $filename, // Nome file dinamico basato sul record
                'mime' => 'application/pdf', // Tipo MIME per PDF
            ],
        ];

        // Crea la notifica e aggiunge dati e allegati
        $notify = new RecordNotification($record, $template);
        $notify = $notify->mergeData($data);
        $notify = $notify->addAttachments($attachments);

        // Invia la notifica
        // $recipient = 'marco.sottana@gmail.com';
        $recipient = isset($record->email) && is_string($record->email) ? $record->email : '';
        // $recipient='marco.sottana@gmail.com';
        if ($recipient === '') {
            return false;
        }

        // Invia la notifica (le eccezioni risalgono naturalmente se l'invio fallisce)
        Notification::route('mail', $recipient)
            // ->locale('it')
            ->notify($notify);

        // Registra activity log per invio riuscito
        // Se l'invio fallisce, l'eccezione risale e questa action non viene eseguita
        app(LogEmailSentAction::class)->execute(
            new EmailSentLogData(
                record: $record,
                user: $user,
                template: $template,
                recipient: $recipient,
                filename: $filename,
                pdfContent: $pdfContent,
            )
        );

        return true;
    }
}
