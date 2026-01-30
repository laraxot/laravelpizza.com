<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Datas\SendNotificationBulkResultData;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per inviare notifiche in bulk a più record utilizzando SendRecordNotificationAction.
 *
 * Questa action compone SendRecordNotificationAction per ogni record, seguendo il pattern DRY:
 * - Un'Action per un singolo record: SendRecordNotificationAction
 * - Un'Action per più record: SendRecordsNotificationBulkAction (questa)
 *
 * Pattern simile a SendMailByRecordsAction che compone SendMailByRecordAction.
 *
 * @example
 * ```php
 * // Utilizzo sincrono
 * $action = app(SendRecordsNotificationBulkAction::class);
 * $action->execute($records, 'template-slug', ['mail', 'sms', 'whatsapp']);
 *
 * // Utilizzo asincrono
 * $action->onQueue('notifications')->execute($records, 'template-slug', ['mail']);
 * ```
 */
class SendRecordsNotificationAction
{
    use QueueableAction;

    /**
     * Process notifications for selected records.
     *
     * @param  Collection<int, Model>  $records  Selected records (e.g., Clients).
     * @param  array<int, string>  $channels  I canali selezionati: 'mail', 'sms', 'whatsapp'
     * @return SendNotificationBulkResultData Risultato con successCount, errorCount, errors, totalProcessed
     */
    public function execute(
        Collection $records,
        string $templateSlug,
        array $channels,
    ): SendNotificationBulkResultData {
        $successCount = 0;
        $errorCount = 0;
        /** @var \Illuminate\Support\Collection<int, array{record: string, channel: string, error: string}> $errors */
        $errors = collect();
        /** @var SendRecordNotificationAction $singleRecordAction */
        $singleRecordAction = app(SendRecordNotificationAction::class);

        foreach ($records as $record) {
            try {
                // SendRecordNotificationAction::execute() now returns void
                // It handles errors internally via report(), so we assume success if no exception
                // Pass slug string, not MailTemplate instance - RecordNotification resolves it internally
                $singleRecordAction->execute($record, $templateSlug, $channels);
                $successCount += \count($channels);
            } catch (Exception $e) {
                // If exception is thrown, count all channels as failed for this record
                $errorCount += \count($channels);
                $recordName = $this->getRecordName($record);
                foreach ($channels as $channelItem) {
                    $errors->push([
                        'record' => $recordName,
                        'channel' => $channelItem,
                        'error' => $e->getMessage(),
                    ]);
                }
                /*
                logger()->error('Errore invio notifica bulk', [
                    'record' => $record::class,
                    'record_id' => $record->getKey(),
                    'channels' => array_map(fn (ChannelEnum $ce) => $ce->value, $channels),
                    'template_slug' => $templateSlug,
                    'error' => $e->getMessage(),
                ]);
                */
            }
        }

        return new SendNotificationBulkResultData(
            successCount: $successCount,
            errorCount: $errorCount,
            errors: $errors,
            totalProcessed: $records->count() * \count($channels),
        );
    }

    /**
     * Ottiene il nome identificativo del record per i messaggi di errore.
     */
    private function getRecordName(Model $record): string
    {
        $safeCast = app(SafeEloquentCastAction::class);
        $attributes = ['name', 'company_name', 'title'];

        foreach ($attributes as $attribute) {
            $value = $safeCast->getStringAttribute($record, $attribute, '');
            if ($value !== '') {
                return $value;
            }
        }

        return (string) $record->getKey();
    }
}
