<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class TrovaEsclusiByYearAction
{
    use QueueableAction;

    public function execute(string $modelClass, string $fieldName, int $year): void
    {
        if (! class_exists($modelClass)) {
            return;
        }

        /** @var class-string<Model> $validatedModelClass */
        $validatedModelClass = $modelClass;

        $query = $validatedModelClass::query()
            ->where($fieldName, $year)
            ->where('ha_diritto', null)
            ->inRandomOrder();

        $rows = $query->get();

        if (! is_iterable($rows)) {
            return;
        }

        $module_name = Str::between($modelClass, 'Modules\\', '\Models\\');
        if (! is_string($module_name) || $module_name === '') {
            return;
        }

        $criteri_esclusione_class = '\Modules\\'.$module_name.'\Models\CriteriEsclusione';
        $criteri_option_class = '\Modules\\'.$module_name.'\Models\CriteriOption';

        if (! class_exists($criteri_esclusione_class) || ! class_exists($criteri_option_class)) {
            return;
        }

        /** @var class-string<Model> $criteriEsclusioneClass */
        $criteriEsclusioneClass = $criteri_esclusione_class;

        /** @var class-string<Model> $criteriOptionClass */
        $criteriOptionClass = $criteri_option_class;

        $criteriEsclusioneQuery = $criteriEsclusioneClass::query()
            ->where($fieldName, $year)
            ->where('value', '!=', 0);

        $criteri_esclusione = $criteriEsclusioneQuery->get();

        $criteriOptionQuery = $criteriOptionClass::query()
            ->where($fieldName, $year);

        $criteri_option = $criteriOptionQuery->get()
            ->map(function (Model $item): Model {
                // Closure always returns Model, never null
                $value = '';
                $type = isset($item->type) && is_string($item->type) ? $item->type : '';

                switch ($type) {
                    case 'list':
                        $valueStr = isset($item->value) && is_string($item->value) ? $item->value : '';
                        $value = explode(',', $valueStr);
                        break;
                    case 'int':
                        $valueRaw = isset($item->value) ? $item->value : null;
                        $value = is_numeric($valueRaw) ? intval((string) $valueRaw) : 0;
                        break;
                    case 'date':
                        $valueRaw = isset($item->value) ? $item->value : null;
                        $value = $valueRaw;
                        if ($value !== null && is_string($value)) {
                            try {
                                $value = Carbon::parse($value);
                            } catch (Exception $e) {
                                $value = null;
                            }
                        }
                        break;
                    default:
                        // Skip unknown types
                        break;
                }
                // @phpstan-ignore-next-line property.notFound - value_real is set dynamically
                $item->value_real = $value;

                return $item;
            })
            ->filter()
            ->pluck('value_real', 'name');

        foreach ($rows as $row) {
            if (! $row instanceof SchedaContract) {
                continue;
            }

            if (! ($criteri_esclusione instanceof Collection)) {
                continue;
            }

            if (! ($criteri_option instanceof Collection)) {
                continue;
            }

            /** @var Collection<int, CriteriEsclusioneContract> $validatedCriteriEsclusione */
            $validatedCriteriEsclusione = $criteri_esclusione
                ->filter(static fn (mixed $criterio): bool => $criterio instanceof CriteriEsclusioneContract)
                ->values()
                ->toBase();

            /** @var Collection<string, mixed> $validatedCriteriOption */
            $validatedCriteriOption = $criteri_option->mapWithKeys(
                static fn (mixed $value, mixed $key): array => is_string($key) ? [$key => $value] : []
            );

            app(Check::class)->execute($row, $validatedCriteriEsclusione, $validatedCriteriOption);
        }
    }
}
