<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Data\EmailSentLogData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function activity;

/**
 * Action per registrare activity log di invio email riuscito.
 *
 * Questa action centralizza la logica di logging per invii email,
 * garantendo coerenza e riutilizzabilità in tutto il modulo.
 */
class LogEmailSentAction
{
    use QueueableAction;

    /**
     * Costruttore con dependency injection delle actions utilizzate.
     */
    public function __construct(
        private readonly PrepareEvaluationDataAction $prepareEvaluationDataAction,
    ) {}

    /**
     * Registra activity log per invio email riuscito.
     *
     * @param  EmailSentLogData  $data  Dati dell'invio email da loggare
     */
    public function execute(EmailSentLogData $data): void
    {
        // Verifica che il record sia un Model per activity log
        Assert::isInstanceOf($data->record, Model::class);

        // Prepara i dati di valutazione
        $evaluationData = $this->prepareEvaluationDataAction->execute($data->record);

        // Registra activity log
        activity()
            ->performedOn($data->record)
            ->causedBy($data->user)
            ->withProperties([
                'template' => $data->template,
                'recipient' => $data->recipient,
                'filename' => $data->filename,
                'evaluation_data' => $evaluationData,
                'pdf_size' => strlen($data->pdfContent),
            ])
            ->log('Email inviata per scheda');
    }
}
