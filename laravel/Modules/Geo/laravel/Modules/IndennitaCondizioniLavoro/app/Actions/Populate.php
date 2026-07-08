<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Actions;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\Sigma\Models\Rep00f;
use Spatie\QueueableAction\QueueableAction;

class Populate
{
    use QueueableAction;

    /**
     * Popola il trimestre scelto con i dati provenienti da Rep00f.
     *
     * @param  array{anno:int|string, quadrimestre:int|string}  $data
     */
    public function execute(array $data): void
    {
        if (! isset($data['anno'], $data['quadrimestre'])) {
            throw new InvalidArgumentException('Parametri anno/quadrimestre mancanti.');
        }

        $anno = (int) $data['anno'];
        $quadrimestre = (int) $data['quadrimestre'];

        if ($quadrimestre <= 0 || $anno <= 0) {
            return;
        }

        $firstDay = Carbon::createFromDate($anno, 1, 1);
        $dal = $firstDay->copy()->addMonths(($quadrimestre - 1) * 4);
        $al = $firstDay->copy()->addMonths($quadrimestre * 4)->subDay();

        /** @var Collection<int, CondizioniLavoro> $existingRows */
        $existingRows = CondizioniLavoro::query()
            ->where('quadrimestre', $quadrimestre)
            ->where('anno', $anno)
            ->get();

        $matricoleEsistenti = $existingRows->pluck('matr')->all();

        /** @var Collection<int, Rep00f> $nuoveRighe */
        $nuoveRighe = Rep00f::ofRangeDate((int) $dal->format('Ymd'), (int) $al->format('Ymd'))
            ->where('ente', 90)
            ->get()
            ->reject(static fn (Rep00f $item): bool => in_array($item->matr, $matricoleEsistenti, true));

        foreach ($nuoveRighe as $row) {
            CondizioniLavoro::firstOrCreate(
                [
                    'ente' => $row->ente,
                    'matr' => $row->matr,
                    'stabi' => $row->repst1,
                    'repar' => $row->repre1,
                    'quadrimestre' => $quadrimestre,
                    'anno' => $anno,
                ],
                [
                    'dal' => $dal,
                    'al' => $al,
                ]
            );
        }
    }
}
