<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Actions;

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\StabiDirigente;
use Modules\Sigma\Models\Rep00f;
use Spatie\QueueableAction\QueueableAction;

class Populate
{
    use QueueableAction;

    /**
     * Populate Indennita Responsabilita records for a given year.
     *
     * @param  array{anno?: int|string|null}  $data
     */
    public function execute(array $data): void
    {
        /** @var int|string|null $annoRaw */
        $annoRaw = $data['anno'] ?? null;
        if (! is_numeric($annoRaw)) {
            return;
        }
        /** @var int $anno */
        $anno = (int) $annoRaw;

        $rows = IndennitaResponsabilita::where('anno', $anno)
            // ->where('valutatore_id',null)
            ->get();

        /*
        $rows_no_valutatore = $rows->where('valutatore_id', null);

        foreach ($rows_no_valutatore as $row) {
            echo '['.$row->valutatore_id.']';
        }

        $valutatore_ids = StabiDirigente::where('anno', $data['anno'])->whereRaw('id=valutatore_id')->get()->modelKeys();
        $rows_invalid = $rows->whereNotIn('valutatore_id', $valutatore_ids);

        foreach ($rows_invalid as $row) {
            $valid = StabiDirigente::firstOrCreate(
                [
                    'anno'=>$data['anno'],
                    'stabi'=>$row->stabi,
                    'repar'=>$row->repar,
                ]);
            $valutatore_id=$valid->valutatore_id;
            if (null == $valutatore_id) {
                $valid_0 = StabiDirigente::firstOrCreate(
                    [
                        'anno'=>$data['anno'],
                        'stabi'=>$row->stabi,
                        'repar'=>0
                    ]);

                if($valid_0->valutatore_id==null){
                    dddx('check');
                }
                $valutatore_id=$valid_0->valutatore_id;

            }
            //dddx(['valid' => $valid->valutatore_id, 'invalid' => $row->valutatore_id]);
            $row->update(['valutatore_id'=>$valutatore_id]);
        }
        */
        $matrs = $rows->pluck('matr')->toArray();

        $rows = Rep00f::ofYear($anno)
            ->where('ente', 90)->get();

        $rows = $rows->filter(static fn ($item): bool => ! in_array($item->matr, $matrs));

        foreach ($rows as $row) {
            IndennitaResponsabilita::firstOrCreate(
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
