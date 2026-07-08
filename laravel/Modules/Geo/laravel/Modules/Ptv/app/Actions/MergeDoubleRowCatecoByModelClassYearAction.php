<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class MergeDoubleRowCatecoByModelClassYearAction
{
    use QueueableAction;

    public function execute(string $modelClass, string $fieldName, int $year): void
    {
        if (! class_exists($modelClass)) {
            return;
        }

        /** @var Builder<Model> $query */
        $query = $modelClass::where([$fieldName => $year]);
        $rows = $query->get();

        if (! ($rows instanceof Collection)) {
            return;
        }

        $grouped = $rows->groupBy(function ($item): string {
            $ente = isset($item->ente) ? (is_string($item->ente) || is_int($item->ente) ? (string) $item->ente : '') : '';
            $matr = isset($item->matr) ? (is_string($item->matr) || is_int($item->matr) ? (string) $item->matr : '') : '';
            $categoriaEco = isset($item->categoria_eco) && is_string($item->categoria_eco) ? $item->categoria_eco : '';
            $stabi = isset($item->stabi) ? (is_string($item->stabi) || is_int($item->stabi) ? (string) $item->stabi : '') : '';
            $repar = isset($item->repar) ? (is_string($item->repar) || is_int($item->repar) ? (string) $item->repar : '') : '';

            $key = [
                $ente,
                $matr,
                $categoriaEco,
                $stabi,
                $repar,
            ];

            return implode('-', $key);
        });

        foreach ($grouped as $group) {
            if (! ($group instanceof Collection)) {
                continue;
            }

            if ($group->count() > 1) {
                $a = $group->first();
                $b = $group->skip(1)->first();

                // Ensure models are not null before accessing properties
                if ($a === null || $b === null) {
                    continue;
                }

                // Type narrowing: ensure dal property exists on Model
                $aDalRaw = isset($a->dal) ? $a->dal : null;
                $aAlRaw = isset($a->al) ? $a->al : null;
                $bDalRaw = isset($b->dal) ? $b->dal : null;
                $aAl = is_string($aAlRaw) ? Carbon::createFromFormat('Ymd', $aAlRaw) : null;
                $bDal = is_string($bDalRaw) ? Carbon::createFromFormat('Ymd', $bDalRaw) : null;

                if ($aAl !== null && $bDal !== null) {
                    $aAlCopy = $aAl->copy();
                    if ($aAlCopy->addDay()->equalTo($bDal)) {
                        if ($aDalRaw !== null) {
                            $b->setAttribute('dal', $a->getAttribute('dal'));
                        }
                        $b->save();
                        $a->delete();
                    }
                }
            }
        }
    }
}
