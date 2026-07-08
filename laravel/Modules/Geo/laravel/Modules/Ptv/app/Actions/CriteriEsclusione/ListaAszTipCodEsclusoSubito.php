<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class ListaAszTipCodEsclusoSubito
{
    use QueueableAction;

    /**
     * Verifica se la scheda ha diritto in base alla lista ASZ tipo codice escluso subito.
     *
     * @param  SchedaContract  $scheda  La scheda da verificare
     * @param  string  $value  Valore del criterio (lista separata da virgole)
     * @param  Collection<string, mixed>  $option  Collezione delle opzioni del criterio
     * @return string Motivo di esclusione o stringa vuota se ha diritto
     */
    public function execute(SchedaContract $scheda, string $value, Collection $option): string
    {
        $dataPresenzaAl = $option->get('data_presenza_al');
        if (! $dataPresenzaAl instanceof Carbon) {
            return '';
        }

        $asz_al = (int) $dataPresenzaAl->format('Ymd');

        $minGgAszTipCodEsclusoSubito = $option->get('min_gg_asz_tip_cod_escluso_subito');
        if (! is_numeric($minGgAszTipCodEsclusoSubito)) {
            return '';
        }

        $asz_dal = (int) $dataPresenzaAl
            ->subDays((int) $minGgAszTipCodEsclusoSubito)
            ->format('Ymd');

        /** @var array<int, array<string, mixed>> $tmp */
        $tmp = $scheda->asz()
            ->ofRangeDate($asz_dal, $asz_al)
            ->select('asztip', 'aszcod')
            ->distinct()
            ->get()
            ->toArray();

        $valueList = collect(explode(',', $value))->filter()->values();
        $tmp1 = collect($tmp)
            ->map(static fn ($item): string => (string) $item['asztip'].'-'.(string) $item['aszcod'])
            ->filter()
            ->values()
            ->intersect($valueList)
            ->count();

        if (isset($scheda->matr) && $scheda->matr === 23698) {
            // debug hook per matricola nota
        }

        if ($tmp1 > 0) {
            return 'asz_tip_cod_escluso_subito';
        }

        return '';
    }
}
