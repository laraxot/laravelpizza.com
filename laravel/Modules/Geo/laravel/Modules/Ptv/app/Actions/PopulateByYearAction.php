<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Ptv\Datas\RepQuaYearData;
use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class PopulateByYearAction
{
    use QueueableAction;

    /**
     *  ---.
     */
    public function execute(string $modelClass, string $fieldName, int $year): void
    {
        if (! class_exists($modelClass)) {
            return;
        }

        /** @var class-string<Model> $validatedModelClass */
        $validatedModelClass = $modelClass;

        $workers = app(GetWorkersByYear::class)->execute((string) $year);

        $firstWorker = $workers->first();
        if ($firstWorker === null || ! ($firstWorker instanceof RepQuaYearData)) {
            return;
        }

        $firstWorkerArray = $firstWorker->toArray();
        // Type narrowing: toArray() always returns array - removed redundant is_array() check
        /** @var array<string, mixed> $firstWorkerArrayTyped */
        $firstWorkerArrayTyped = $firstWorkerArray;
        $fields = array_keys($firstWorkerArrayTyped);

        $query = $validatedModelClass::query()
            ->where($fieldName, $year)
            ->select($fields);

        $schede = $query->get();

        if (! ($schede instanceof Collection)) {
            return;
        }

        $schedeArray = [];
        foreach ($schede as $scheda) {
            if ($scheda instanceof Model) {
                $schedaArray = $scheda->toArray();
                if (is_array($schedaArray)) {
                    $schedeArray[] = $schedaArray;
                }
            }
        }

        $schede_data = RepQuaYearData::collection($schedeArray);

        $workersArray = $workers->toArray();
        $schedeDataArray = $schede_data->toArray();

        // Type narrowing: toArray() always returns array - removed redundant is_array() checks
        /** @var array<int|string, array<string, mixed>> $workersArrayTyped */
        $workersArrayTyped = $workersArray;
        /** @var array<int|string, array<string, mixed>> $schedeDataArrayTyped */
        $schedeDataArrayTyped = $schedeDataArray;
        // Custom function to find differences in multidimensional arrays
        $adds = [];
        foreach ($workersArrayTyped as $key => $value) {
            $existing = $schedeDataArrayTyped[$key] ?? [];
            if (! is_array($existing)) {
                $existing = [];
            }
            if (! array_key_exists($key, $schedeDataArrayTyped) || $this->hasArrayDiff($value, $existing)) {
                $adds[$key] = $value;
            }
        }

        $subs = [];
        foreach ($schedeDataArrayTyped as $key => $value) {
            $existing = $workersArrayTyped[$key] ?? [];
            if (! is_array($existing)) {
                $existing = [];
            }
            if (! array_key_exists($key, $workersArrayTyped) || $this->hasArrayDiff($value, $existing)) {
                $subs[$key] = $value;
            }
        }

        Notification::make()
            ->title('Added ['.count($adds).'] Subbed ['.count($subs).']')
            ->success()
            ->send();

        foreach ($adds as $add) {
            if (! is_array($add)) {
                continue;
            }
            /** @var array<string, mixed> $addData */
            $addData = $add;
            $addData[$fieldName] = $year;

            // Disabilita temporaneamente LogsActivity durante firstOrCreate per evitare
            // errore "Attempt to read property 'attributeRawValues' on null"
            // Il trait LogsActivity cerca di accedere a attributeRawValues che è null
            // durante la creazione di un nuovo modello con firstOrCreate()
            $validatedModelClass::withoutEvents(function () use ($validatedModelClass, $addData): void {
                $validatedModelClass::firstOrCreate($addData);
            });
        }

        foreach ($subs as $sub) {
            if (! is_array($sub)) {
                continue;
            }
            $sub[$fieldName] = $year;
            $query = $validatedModelClass::query()->where($sub);
            $query->delete();
        }

        /*
        dddx([
            'adds' => $adds,
            'subs' => $subs,
        ]);
        */
    }

    /**
     * @param  array<string, mixed>  $left
     * @param  array<string, mixed>  $right
     */
    private function hasArrayDiff(array $left, array $right): bool
    {
        foreach ($left as $key => $value) {
            if (! array_key_exists($key, $right)) {
                return true;
            }

            $rightValue = $right[$key];
            if (is_scalar($value) && is_scalar($rightValue)) {
                if ((string) $value !== (string) $rightValue) {
                    return true;
                }

                continue;
            }

            if ($value !== $rightValue) {
                return true;
            }
        }

        return false;
    }
}
