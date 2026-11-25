<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\InformationSchemaTable;

/**
 * Contatori persistiti di {@see InformationSchemaTable} (uso da Action).
 *
 * @phpstan-require-extends InformationSchemaTable
 */
trait InformationSchemaTableCounters
{
    /**
     * Aggiorna il numero di record memorizzato per un modello.
     *
     * @param  class-string<Model>  $modelClass
     */
    public static function updateModelCount(string $modelClass, int $total): void
    {
        $model = self::resolveModelInstance($modelClass);

        static::updateOrCreate(self::modelLookupAttributes($model, $modelClass), [
            'table_rows' => $total,
        ]);
    }

    /**
     * Restituisce il numero di record per un modello.
     *
     * @param  class-string<Model>  $modelClass
     */
    public static function getModelCount(string $modelClass): int
    {
        $model = self::resolveModelInstance($modelClass);

        $record = static::firstOrCreate(self::modelLookupAttributes($model, $modelClass));

        if ($record->table_rows === null) {
            $record->update(['table_rows' => $model->count()]);
        }

        return (int) $record->table_rows;
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @return array{table_schema: string, model_class: string, table_name: string}
     */
    private static function modelLookupAttributes(Model $model, string $modelClass): array
    {
        return [
            'table_schema' => $model->getConnection()->getDatabaseName(),
            'model_class' => $modelClass,
            'table_name' => $model->getTable(),
        ];
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    private static function resolveModelInstance(string $modelClass): Model
    {
        if (! class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model class [{$modelClass}] does not exist");
        }

        $model = app($modelClass);
        if (! $model instanceof Model) {
            throw new \InvalidArgumentException("Class [{$modelClass}] must be an instance of ".Model::class);
        }

        return $model;
    }
}
