<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Cessati;

use Spatie\QueueableAction\QueueableAction;

/**
 * Action to get formatted preview of records that exist in indennitaResponsabilita but not in rep00f for given year
 *
 * This action provides a human-readable preview of the records to be deleted,
 * limited to first 20 records for performance reasons.
 */
class GetCessatiRecordsPreviewAction
{
    use QueueableAction;

    /**
     * Execute the action to get cessati records preview
     *
     * @param  int  $anno  The year to search for
     * @return string Formatted preview string
     */
    public function execute(int $anno): string
    {
        if (! $anno) {
            return '';
        }

        $records = app(GetCessatiRecordsAction::class)->execute($anno)
            ->take(20)
            ->map(static function ($record): string {
                return sprintf(
                    'Matr: %s | %s %s | Stab: %s-%s | Rep: %s-%s',
                    $record->matr ?? 'N/D',
                    $record->cognome ?? '',
                    $record->nome ?? '',
                    $record->stabi ?? '',
                    $record->stabi_txt ?? '',
                    $record->repar ?? '',
                    $record->repar_txt ?? ''
                );
            });

        if ($records->isEmpty()) {
            return 'Nessun record trovato';
        }

        $preview = $records->implode("\n");
        $total = app(GetCessatiRecordsCountAction::class)->execute($anno);

        if ($total > 20) {
            $preview .= "\n... e altri ".($total - 20).' record';
        }

        return $preview;
    }
}
