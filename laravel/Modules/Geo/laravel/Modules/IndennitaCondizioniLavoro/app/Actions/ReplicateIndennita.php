<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Actions;

use Filament\Notifications\Notification;
use InvalidArgumentException;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Spatie\QueueableAction\QueueableAction;

class ReplicateIndennita
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>|null  $data
     */
    public function execute(?array $data): void
    {
        $input = $data['anno/valutatore'] ?? $data;
        if (! is_array($input)) {
            throw new InvalidArgumentException('Parametro filtri non valido.');
        }

        $anno = isset($input['anno']) ? (int) $input['anno'] : null;
        $quadrimestre = isset($input['quadrimestre']) ? (int) $input['quadrimestre'] : null;

        if ($anno === null || $quadrimestre === null) {
            throw new InvalidArgumentException('Anno o quadrimestre non impostati.');
        }

        $sourceAnno = $anno;
        $sourceQuadrimestre = $quadrimestre - 1;

        if ($sourceQuadrimestre < 1) {
            $sourceQuadrimestre = 3 - $sourceQuadrimestre;
            $sourceAnno = $anno - 1;
        }

        $filters = [
            'anno' => $sourceAnno,
            'quadrimestre' => $sourceQuadrimestre,
        ];

        $rows = CondizioniLavoro::query()
            ->where($filters)
            ->whereHas('indennitaTipoDettaglio')
            ->get();

        foreach ($rows as $row) {
            $ids = $row->indennitaTipoDettaglio->modelKeys();
            $next = $row->getNextQuadrimestre();

            if ($next === null) {
                continue;
            }

            if ($next->indennitaTipoDettaglio->isEmpty()) {
                $next->indennitaTipoDettaglio()->sync($ids);
            }
        }

        Notification::make()
            ->title('Replicate '.$rows->count().' record')
            ->success()
            ->send();
    }
}
