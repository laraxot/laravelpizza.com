<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Export;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Xot\Actions\Model\GetTransKeyByModelClassAction;
// use Modules\Xot\Services\ArrayService;
use Modules\Xot\Exports\CollectionExport;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Webmozart\Assert\Assert;

class XlsByModelClassAction
{
    use QueueableAction;

    /**
     * Esporta i dati di un modello in Excel.
     *
     * @param  string  $modelClass  Classe del modello da esportare
     * @param  array<string, mixed>  $where  Condizioni where per la query
     * @param  array<int, string>  $includes  Relazioni o campi da includere
     * @param  array<int, string>  $excludes  Campi da escludere
     * @param  callable|null  $callback  Callback per manipolare i dati
     */
    public function execute(
        string $modelClass,
        array $where = [],
        array $includes = [],
        array $excludes = [],
        ?callable $callback = null,
    ): BinaryFileResponse {
        // Verifichiamo che la classe del modello esista
        Assert::classExists($modelClass);
        Assert::subclassOf($modelClass, Model::class);

        $with = $this->getWithByIncludes($includes);

        // Creiamo l'istanza del modello e costruiamo la query
        /** @var Model $model */
        $model = app($modelClass);
        $query = $model->query()->with($with);

        // Applichiamo le condizioni where
        foreach ($where as $key => $value) {
            $query->where($key, $value);
        }

        // Otteniamo i risultati
        /** @var Collection $rows */
        $rows = $query->get();

        // Filtriamo i campi se sono specificati gli includes
        if ($includes !== []) {
            $rows = $rows->map(static function ($item) use ($includes) {
                $data = [];
                foreach ($includes as $include) {
                    $data[$include] = data_get($item, $include);
                }

                return $data;
            });
        }

        // Nascondiamo i campi esclusi
        if ($excludes !== []) {
            $rows = $rows->map(function ($item) use ($excludes) {
                if (is_object($item) && method_exists($item, 'makeHidden')) {
                    /** @var Model $item */
                    return $item->makeHidden($excludes);
                }

                return $item;
            });
        }

        // Applichiamo il callback se fornito
        if ($callback !== null) {
            $rows = $rows->map($callback);
        }

        // Otteniamo la chiave di traduzione e creiamo l'export
        $transKey = app(GetTransKeyByModelClassAction::class)->execute($modelClass);
        $collectionExport = new CollectionExport($rows, $transKey);
        $filename = $this->getExportName($modelClass);

        return Excel::download($collectionExport, $filename);
    }

    /**
     * Ottiene le relazioni da caricare in base ai campi inclusi.
     *
     * @param  array<int, string>  $includes  Campi da includere
     * @return array<int, string>
     */
    private function getWithByIncludes(array $includes): array
    {
        $with = [];
        foreach ($includes as $include) {
            // Assicuriamo che $include sia una stringa
            $includeStr = is_string($include) ? $include : ((string) $include);

            // Verifichiamo se contiene un punto (indicatore di relazione)
            if (! Str::contains($includeStr, '.')) {
                continue;
            }

            // Estraiamo il nome della relazione (prima parte prima del punto)
            $parts = explode('.', $includeStr);
            if (! empty($parts[0])) {
                $with[] = $parts[0];
            }
        }

        return array_unique($with);
    }

    /**
     * Genera il nome del file di export.
     *
     * @param  string  $modelClass  Classe del modello
     */
    private function getExportName(string $modelClass): string
    {
        return sprintf('%s %s.xlsx', Str::slug(class_basename($modelClass)), Carbon::now()->format('d-m-Y His'));
    }
}
