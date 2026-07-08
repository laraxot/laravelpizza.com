<?php

declare(strict_types=1);

namespace Modules\Progressioni\Actions;

use Modules\Progressioni\Models\Scheda;
use Modules\Sigma\Models\Rep00f;
use Spatie\QueueableAction\QueueableAction;

class Populate
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    /**
     * @param  array{anno: int}  $data
     */
    public function execute(array $data): void
    {
        $anno = $data['anno'];

        $rows = Scheda::where('anno', $anno)
            ->get();

        $matrs = $rows->pluck('matr')->toArray();

        $rows = Rep00f::ofYear($anno)
            ->where('ente', 90)->get();

        $rows = $rows->filter(static fn ($item): bool => ! in_array($item->matr, $matrs));

        foreach ($rows as $row) {
            Scheda::firstOrCreate(
                [
                    'ente' => $row->ente,
                    'matr' => $row->matr,
                    'stabi' => $row->repst1,
                    'repar' => $row->repre1,
                    'anno' => $anno,
                ],
                [
                    //    'dal' => $dal,
                    //    'al' => $al,
                ]
            );
        }
    }
}
