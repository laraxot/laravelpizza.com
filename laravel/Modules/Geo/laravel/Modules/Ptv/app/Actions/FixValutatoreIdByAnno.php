<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueueableAction\QueueableAction;

class FixValutatoreIdByAnno
{
    use QueueableAction;

    public function execute(string $moduleName, string $modelName, string|int|null $anno): bool
    {
        $schedeClass = "\Modules\\".$moduleName."\Models\\".$modelName;
        $stabiDiriClass = "\Modules\\".$moduleName."\Models\StabiDirigente";

        if (! class_exists($schedeClass) || ! class_exists($stabiDiriClass)) {
            return false;
        }

        /** @var class-string<Model> $schedeModelClass */
        $schedeModelClass = $schedeClass;

        /** @var class-string<Model> $stabiDiriModelClass */
        $stabiDiriModelClass = $stabiDiriClass;

        $query = $schedeModelClass::query()
            ->where('anno', $anno);

        $rows = $query->get();

        if (! ($rows instanceof Collection)) {
            return false;
        }

        $stabiDiriQuery = $stabiDiriModelClass::query()
            ->where('anno', $anno)
            ->whereRaw('id=valutatore_id');

        $valutatoriCollection = $stabiDiriQuery->get();

        if (! ($valutatoriCollection instanceof Collection)) {
            return false;
        }

        $valutatore_ids = $valutatoriCollection->modelKeys();

        if (! is_array($valutatore_ids)) {
            return false;
        }

        // Usa getAttribute() per accedere al valore raw invece dell'accessor
        // per evitare che getValutatoreIdAttribute() triggeri update() che causa
        // errore "Attempt to read property 'attributeRawValues' on null" in LogsActivity
        $rows_invalid = $rows->filter(function (Model $row) use ($valutatore_ids): bool {
            // Usa getAttribute() per accedere al valore raw senza triggerare l'accessor
            $valutatoreId = $row->getAttribute('valutatore_id');

            return ! in_array($valutatoreId, $valutatore_ids, true);
        });

        foreach ($rows_invalid as $row) {
            if (! ($row instanceof Model)) {
                continue;
            }

            $stabi = isset($row->stabi) ? (is_string($row->stabi) || is_int($row->stabi) ? $row->stabi : null) : null;
            $repar = isset($row->repar) ? (is_string($row->repar) || is_int($row->repar) ? $row->repar : null) : null;

            if ($stabi === null || $repar === null) {
                continue;
            }

            // Disabilita temporaneamente LogsActivity durante firstOrCreate per evitare
            // errore "Attempt to read property 'attributeRawValues' on null"
            $valid = $stabiDiriModelClass::withoutEvents(function () use ($stabiDiriModelClass, $anno, $stabi, $repar) {
                return $stabiDiriModelClass::firstOrCreate(
                    [
                        'anno' => $anno,
                        'stabi' => $stabi,
                        'repar' => $repar,
                    ]
                );
            });

            if (! ($valid instanceof Model)) {
                continue;
            }

            $valutatore_id = isset($valid->valutatore_id) ? $valid->valutatore_id : null;
            if ($valutatore_id == null) {
                // Disabilita temporaneamente LogsActivity durante firstOrCreate per evitare
                // errore "Attempt to read property 'attributeRawValues' on null"
                $valid_0 = $stabiDiriModelClass::withoutEvents(function () use ($stabiDiriModelClass, $anno, $stabi) {
                    return $stabiDiriModelClass::firstOrCreate(
                        [
                            'anno' => $anno,
                            'stabi' => $stabi,
                            'repar' => 0,
                        ]
                    );
                });

                if (! ($valid_0 instanceof Model)) {
                    continue;
                }

                if (isset($valid_0->valutatore_id) && $valid_0->valutatore_id == null && isset($valid_0->id)) {
                    $valid_0->update(['valutatore_id' => $valid_0->id]);
                }

                $valutatore_id = isset($valid_0->valutatore_id) ? $valid_0->valutatore_id : null;
            }

            if ($valutatore_id !== null) {
                $row->update(['valutatore_id' => $valutatore_id]);
            }
        }

        return true;
    }
}
