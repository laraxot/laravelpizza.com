<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Cessati;

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

/**
 * Action to get formatted preview of records to be deleted
 */
class GetCessatiRecordsPreview
{
    public function execute(?int $anno): string
    {
        if (! $anno) {
            return 'non ce anno';
        }

        $records = app(GetCessatiRecords::class)->execute($anno)
            ->take(20)
            ->map(function (IndennitaResponsabilita $record): string {
                return sprintf(
                    'Matr: %s | %s %s | Stab: %s-%s | Rep: %s-%s',
                    (string) ($record->matr ?? 'N/D'),
                    (string) ($record->cognome ?? ''),
                    (string) ($record->nome ?? ''),
                    (string) ($record->stabi ?? ''),
                    (string) ($record->stabi_txt ?? ''),
                    (string) ($record->repar ?? ''),
                    (string) ($record->repar_txt ?? '')
                );
            });

        if ($records->isEmpty()) {
            return 'Nessun record trovati';
        }

        $preview = $records->implode("\n");
        $total = app(GetCessatiRecordsCount::class)->execute($anno);

        if ($total > 20) {
            $preview .= "\n... e altri ".($total - 20).' record';
        }

        return $preview;
    }
}
